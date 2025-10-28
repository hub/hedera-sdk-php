<?php

namespace HederaSdk;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/util.php';

use Com\Hedera\Mirror\Api\Proto\ConsensusServiceClient as MirrorConsensusServiceClient;
use Com\Hedera\Mirror\Api\Proto\NetworkServiceClient as MirrorNetworkServiceClient;
use Com\Hedera\Mirror\Api\Proto\ConsensusTopicQuery;
use Com\Hedera\Mirror\Api\Proto\ConsensusTopicResponse;
use Com\Hedera\Mirror\Api\Proto\AddressBookQuery;
use Proto\NetworkServiceClient;
use Proto\CryptoServiceClient;
use Proto\ConsensusServiceClient;
use Grpc\ChannelCredentials;

class Client
{
    /**
      * @var int
      */
    private $tinybarToHbarRatio = 100000000;
    /**
      * @var string
      */
    public $mirrorNodeUrl;
    /**
      * @var string
      */
    public $mainNodeUrl;
    /**
      * @var int
      */
    public $mainNodeNum;
    /**
      * @var NetworkServiceClient
      */
    public $mainNetworkClient;
    /**
      * @var CryptoServiceClient
      */
    public $mainCryptoClient;
    /**
      * @var ConsensusServiceClient
      */
    public $mainConsensusClient;
    /**
      * @var MirrorConsensusServiceClient
      */
    public $mirrorConsensusClient;
    /**
      * @var MirrorNetworkServiceClient
      */
    public $mirrorNetworkClient;
    /**
      * @var string
      */
    public $privateKey;
    /**
      * @var int
      */
    public $accountNum;

    public function __construct(string $mirrorNodeUrl, string $mainNodeUrl, int $mainNodeNum, string $privateKey, int $accountNum)
    {
        // Validate mirror node URL
        if (empty(trim($mirrorNodeUrl))) {
            throw new \InvalidArgumentException('Mirror node URL cannot be empty');
        }

        // Validate main node URL
        if (empty(trim($mainNodeUrl))) {
            throw new \InvalidArgumentException('Main node URL cannot be empty');
        }

        // Validate node number (should be >= 0)
        if ($mainNodeNum < 0) {
            throw new \InvalidArgumentException('Node number must be greater than or equal to 0');
        }

        // Validate private key
        if (empty(trim($privateKey))) {
            throw new \InvalidArgumentException('Private key cannot be empty');
        }

        // Validate private key format (Ed25519 DER encoded)
        // Ed25519 private keys in DER format start with this specific prefix:
        // 30 2e - SEQUENCE (46 bytes)
        // 02 01 - INTEGER (1 byte) - version (00)
        // 30 05 - SEQUENCE (5 bytes) - AlgorithmIdentifier
        // 06 03 - OBJECT IDENTIFIER (3 bytes) - 1.3.101.112 (Ed25519)
        // 2b 65 70 - OID bytes for Ed25519
        // 04 22 - OCTET STRING (34 bytes)
        // 04 20 - OCTET STRING (32 bytes) - the actual private key
        $ed25519DerPrefix = '302e020100300506032b657004220420';
        if (strpos($privateKey, $ed25519DerPrefix) !== 0) {
            throw new \InvalidArgumentException('Private key must be an Ed25519 key in DER format (hex). Expected prefix: ' . $ed25519DerPrefix . '. Note: Currently only Ed25519 keys are supported.');
        }
        if (strlen($privateKey) !== 96) {
            throw new \InvalidArgumentException('Ed25519 private key in DER format must be exactly 96 hex characters (48 bytes) long');
        }

        // Validate account number (should be > 0)
        if ($accountNum <= 0) {
            throw new \InvalidArgumentException('Account number must be greater than 0');
        }

        $this->privateKey = $privateKey;
        $this->accountNum = $accountNum;
        $this->mirrorNodeUrl = $mirrorNodeUrl;
        $this->mainNodeUrl = $mainNodeUrl;
        $this->mainNodeNum = $mainNodeNum;

        $this->mirrorConsensusClient = new MirrorConsensusServiceClient($this->mirrorNodeUrl, [
            'credentials' => ChannelCredentials::createInsecure(),
        ]);
        $this->mirrorNetworkClient = new MirrorNetworkServiceClient($this->mirrorNodeUrl, [
            'credentials' => ChannelCredentials::createInsecure(),
        ]);

        $this->mainCryptoClient = new CryptoServiceClient($this->mainNodeUrl, [
            'credentials' => ChannelCredentials::createInsecure(),
        ]);
        $this->mainNetworkClient = new NetworkServiceClient($this->mainNodeUrl, [
            'credentials' => ChannelCredentials::createInsecure(),
        ]);
        $this->mainConsensusClient = new ConsensusServiceClient($this->mainNodeUrl, [
            'credentials' => ChannelCredentials::createInsecure(),
        ]);
    }

    private function handlePrecheckCode(int $ccode)
    {
        if ($ccode !== \Proto\ResponseCodeEnum::OK) {
            throw new \Exception("Precheck code: " . $ccode, $ccode);
        }
    }

    private function buildExecutionPaymentTransaction(
        int $amount,
        int $feeAmount
    ) {
        $accountId = new \Proto\AccountID();
        $accountId->setAccountNum($this->accountNum);

        $transactionId = new \Proto\TransactionID();
        $transactionId->setAccountID($accountId);

        $validStart = new \Proto\Timestamp();
        $nowUTC = gmdate('U');
        $validStart->setSeconds($nowUTC);
        $validStart->setNanos(0);

        $transactionId->setTransactionValidStart($validStart);

        // Payment recipient node
        $nodeAccountId = new \Proto\AccountID();
        $nodeAccountId->setAccountNum($this->mainNodeNum);

        $payerAmount = new \Proto\AccountAmount();
        $payerAmount->setAccountID($accountId);
        $payerAmount->setAmount(-abs($amount));

        $nodeAmount = new \Proto\AccountAmount();
        $nodeAmount->setAccountID($nodeAccountId);
        $nodeAmount->setAmount(abs($amount));

        $transferList = new \Proto\TransferList();
        $transferList->setAccountAmounts([$payerAmount, $nodeAmount]);

        $cryptoTransfer = new \Proto\CryptoTransferTransactionBody();
        $cryptoTransfer->setTransfers($transferList);

        // Configure TransactionBody
        $transactionBody = new \Proto\TransactionBody();
        $transactionBody->setTransactionID($transactionId);
        $transactionBody->setNodeAccountID($nodeAccountId);
        $transactionBody->setCryptoTransfer($cryptoTransfer);
        $transactionBody->setTransactionFee($feeAmount);
        $validDuration = new \Proto\Duration();
        $validDuration->setSeconds(120);
        $transactionBody->setTransactionValidDuration($validDuration);

        // 1) TransactionBody bodyBytes
        $bodyBytes = $transactionBody->serializeToString();

        // 2) Sign with Ed25519
        list($signature, $publicKey) = signEd25519($bodyBytes, $this->privateKey);

        // 3) SignatureMap
        $sigPair = new \Proto\SignaturePair();
        $sigPair->setPubKeyPrefix($publicKey);
        $sigPair->setEd25519($signature);
        // $sigPair->setECDSAsecp256k1($signature); // If it were an EVM key
        $sigMap = new \Proto\SignatureMap();
        $sigMap->setSigPair([$sigPair]);

        // 4) SignedTransaction
        $signedTx = new \Proto\SignedTransaction();
        $signedTx->setBodyBytes($bodyBytes);
        $signedTx->setSigMap($sigMap);
        $signedBytes = $signedTx->serializeToString();

        $transaction = new \Proto\Transaction();
        $transaction->setSignedTransactionBytes($signedBytes);

        return [$transaction, $signedBytes];
    }

    public function getTransactionReceipts(\Proto\TransactionID $transactionId)
    {
        $transactionGetReceiptQuery = new \Proto\TransactionGetReceiptQuery();
        $transactionGetReceiptQuery->setIncludeChildReceipts(true);
        $transactionGetReceiptQuery->setIncludeDuplicates(true);
        $transactionGetReceiptQuery->setTransactionID($transactionId);

        $queryHeader = new \Proto\QueryHeader();
        $queryHeader->setResponseType(\Proto\ResponseType::ANSWER_ONLY);
        $transactionGetReceiptQuery->setHeader($queryHeader);

        $query = new \Proto\Query();
        $query->setTransactionGetReceipt($transactionGetReceiptQuery);
        list($response, $status) = $this->mainCryptoClient->getTransactionReceipts($query)->wait();
        if ($status->code !== \Grpc\STATUS_OK) {
            throw new \Exception($status->code . " - " . $status->details);
        }
        assert($response instanceof \Proto\Response);
        return $response->getTransactionGetReceipt()->getReceipt();
    }

    public function subscribeTopic(int $topicNum)
    {
        $request = new ConsensusTopicQuery();
        $topicId = new \Proto\TopicID();
        $topicId->setShardNum(0);
        $topicId->setRealmNum(0);
        $topicId->setTopicNum($topicNum);
        $request->setTopicID($topicId);
        $start = new \Proto\Timestamp();
        $nowUTC = gmdate('U');
        $start->setSeconds(intval($nowUTC) - 180);
        $start->setNanos(0);
        $request->setConsensusStartTime($start);
        $end = new \Proto\Timestamp();
        $end->setSeconds(intval($nowUTC) + 180);
        $end->setNanos(0);
        $request->setConsensusEndTime($end);
        $request->setLimit(100);
        $call = $this->mirrorConsensusClient->subscribeTopic($request);
        $messages = [];
        foreach ($call->responses() as $response) {
            assert($response instanceof ConsensusTopicResponse);
            $message = $response->getMessage();
            $chunkInfo = $response->getChunkInfo();
            $total = $chunkInfo->getTotal();
            $number = $chunkInfo->getNumber();
            $initialTransactionID = $chunkInfo->getInitialTransactionID()->serializeToString();
            $sequenceNumber = $response->getSequenceNumber();
            $runningHashVersion = $response->getRunningHashVersion();
            $runningHash = $response->getRunningHash();
            $consensusTimestamp = $response->getConsensusTimestamp();
            // $message = json_decode($message, true);
            $messages[] = [
                'message' => $message,
                'chunkInfo' => [
                    'total' => $total,
                    'number' => $number,
                    'initialTransactionID' => $initialTransactionID,
                ],
                'sequenceNumber' => $sequenceNumber,
                'runningHashVersion' => $runningHashVersion,
                'runningHash' => $runningHash,
                'consensusTimestamp' => $consensusTimestamp,
            ];
        }
        return $messages;
    }

    public function getVersionInfoWithPayment(
        int $fee
    ) {
        $request = new \Proto\Query();
        $networkQuery = new \Proto\NetworkGetVersionInfoQuery();

        $header = new \Proto\QueryHeader();
        $header->setResponseType(\Proto\ResponseType::ANSWER_ONLY);

        // Create Transaction with signed payment
        [$payment, $signedTransactionBytes] = $this->buildExecutionPaymentTransaction(intval(round(0.1 * $this->tinybarToHbarRatio, 0, PHP_ROUND_HALF_UP)), $fee);
        $payment->setSignedTransactionBytes($signedTransactionBytes);
        $header->setPayment($payment);

        $networkQuery->setHeader($header);
        $request->setNetworkGetVersionInfo($networkQuery);

        list($response, $status) = $this->mainNetworkClient->getVersionInfo($request)->wait();

        if ($status->code !== \Grpc\STATUS_OK) {
            throw new \Exception($status->code . " - " . $status->details);
        }
        assert($response instanceof \Proto\Response);

        $versionResponse = $response->getNetworkGetVersionInfo();
        $this->handlePrecheckCode($versionResponse->getHeader()->getNodeTransactionPrecheckCode());
        assert($versionResponse instanceof \Proto\NetworkGetVersionInfoResponse);
        return $versionResponse;
    }

    public function checkAccountBalance(
        int $accountNum
    ) {
        $request = new \Proto\Query();
        $cryptoQuery = new \Proto\CryptoGetAccountBalanceQuery();

        $header = new \Proto\QueryHeader();
        $header->setResponseType(\Proto\ResponseType::COST_ANSWER);

        $cryptoQuery->setHeader($header);
        $accountId = new \Proto\AccountID();
        $accountId->setAccountNum($accountNum);
        $cryptoQuery->setAccountID($accountId);

        $request->setCryptoGetAccountBalance($cryptoQuery);

        list($response, $status) = $this->mainCryptoClient->cryptoGetBalance($request)->wait();
        if ($status->code !== \Grpc\STATUS_OK) {
            throw new \Exception($status->code . " - " . $status->details);
        }
        assert($response instanceof \Proto\Response);

        $getAccountBalance = $response->getCryptogetAccountBalance();
        $this->handlePrecheckCode($getAccountBalance->getHeader()->getNodeTransactionPrecheckCode());
        assert($getAccountBalance instanceof \Proto\CryptoGetAccountBalanceResponse);

        $balance = $getAccountBalance->getBalance();
        return $balance / $this->tinybarToHbarRatio;
    }

    public function createTopic(
        int $fee
    ) {
        $accountId = new \Proto\AccountID();
        $accountId->setAccountNum($this->accountNum);

        $transactionId = new \Proto\TransactionID();
        $transactionId->setAccountID($accountId);

        $validStart = new \Proto\Timestamp();
        $nowUTC = gmdate('U');
        $validStart->setSeconds($nowUTC);
        $validStart->setNanos(0);

        $transactionId->setTransactionValidStart($validStart);

        // Payment recipient node
        $nodeAccountId = new \Proto\AccountID();
        $nodeAccountId->setAccountNum($this->mainNodeNum);

        $consensusCreateTopicTransactionBody = new \Proto\ConsensusCreateTopicTransactionBody();
        $consensusCreateTopicTransactionBody->setMemo("foo");
        // $consensusCreateTopicTransactionBody->setAdminKey(new \Proto\Key());
        // $consensusCreateTopicTransactionBody->setSubmitKey(new \Proto\Key());
        $autoRenewPeriod = new \Proto\Duration();
        $autoRenewPeriod->setSeconds(90 * 24 * 60 * 60);
        $consensusCreateTopicTransactionBody->setAutoRenewPeriod($autoRenewPeriod);
        // $consensusCreateTopicTransactionBody->setAutoRenewAccount($accountId);
        // $consensusCreateTopicTransactionBody->setFeeScheduleKey(new \Proto\Key());
        // $consensusCreateTopicTransactionBody->setFeeExemptKeyList(new \Proto\KeyList());
        // $consensusCreateTopicTransactionBody->setCustomFees(new \Proto\FixedCustomFee());

        // Configure TransactionBody
        $transactionBody = new \Proto\TransactionBody();
        $transactionBody->setTransactionID($transactionId);
        $transactionBody->setNodeAccountID($nodeAccountId);
        $transactionBody->setConsensusCreateTopic($consensusCreateTopicTransactionBody);
        $transactionBody->setTransactionFee($fee);
        $validDuration = new \Proto\Duration();
        $validDuration->setSeconds(120);
        $transactionBody->setTransactionValidDuration($validDuration);

        // 1) TransactionBody bodyBytes
        $bodyBytes = $transactionBody->serializeToString();

        // 2) Sign with Ed25519
        list($signature, $publicKey) = signEd25519($bodyBytes, $this->privateKey);

        // 3) SignatureMap
        $sigPair = new \Proto\SignaturePair();
        $sigPair->setPubKeyPrefix($publicKey);
        $sigPair->setEd25519($signature);
        // $sigPair->setECDSAsecp256k1($signature); // If it were an EVM key
        $sigMap = new \Proto\SignatureMap();
        $sigMap->setSigPair([$sigPair]);

        // 4) SignedTransaction
        $signedTx = new \Proto\SignedTransaction();
        $signedTx->setBodyBytes($bodyBytes);
        $signedTx->setSigMap($sigMap);
        $signedBytes = $signedTx->serializeToString();

        $transaction = new \Proto\Transaction();
        $transaction->setSignedTransactionBytes($signedBytes);

        list($response, $status) = $this->mainConsensusClient->createTopic($transaction)->wait();

        if ($status->code !== \Grpc\STATUS_OK) {
            throw new \Exception($status->code . " - " . $status->details);
        }
        assert($response instanceof \Proto\TransactionResponse);

        $this->handlePrecheckCode($response->getNodeTransactionPrecheckCode());
        return $transactionId;
    }

    public function submitMessage(
        int $fee,
        int $topicNum,
        string $message
    ) {
        $accountId = new \Proto\AccountID();
        $accountId->setAccountNum($this->accountNum);

        $transactionId = new \Proto\TransactionID();
        $transactionId->setAccountID($accountId);

        $validStart = new \Proto\Timestamp();
        $nowUTC = gmdate('U');
        $validStart->setSeconds($nowUTC);
        $validStart->setNanos(0);

        $transactionId->setTransactionValidStart($validStart);

        // Payment recipient node
        $nodeAccountId = new \Proto\AccountID();
        $nodeAccountId->setAccountNum($this->mainNodeNum);

        $consensusSubmitMessageTransactionBody = new \Proto\ConsensusSubmitMessageTransactionBody();
        $topicId = new \Proto\TopicID();
        $topicId->setShardNum(0);
        $topicId->setRealmNum(0);
        $topicId->setTopicNum($topicNum);
        $consensusSubmitMessageTransactionBody->setTopicId($topicId);
        $consensusSubmitMessageTransactionBody->setMessage($message);

        // Configure TransactionBody
        $transactionBody = new \Proto\TransactionBody();
        $transactionBody->setTransactionID($transactionId);
        $transactionBody->setNodeAccountID($nodeAccountId);
        $transactionBody->setConsensusSubmitMessage($consensusSubmitMessageTransactionBody);
        $transactionBody->setTransactionFee($fee);
        $validDuration = new \Proto\Duration();
        $validDuration->setSeconds(120);
        $transactionBody->setTransactionValidDuration($validDuration);

        // 1) TransactionBody bodyBytes
        $bodyBytes = $transactionBody->serializeToString();

        // 2) Sign with Ed25519
        list($signature, $publicKey) = signEd25519($bodyBytes, $this->privateKey);

        // 3) SignatureMap
        $sigPair = new \Proto\SignaturePair();
        $sigPair->setPubKeyPrefix($publicKey);
        $sigPair->setEd25519($signature);
        // $sigPair->setECDSAsecp256k1($signature); // If it were an EVM key
        $sigMap = new \Proto\SignatureMap();
        $sigMap->setSigPair([$sigPair]);

        // 4) SignedTransaction
        $signedTx = new \Proto\SignedTransaction();
        $signedTx->setBodyBytes($bodyBytes);
        $signedTx->setSigMap($sigMap);
        $signedBytes = $signedTx->serializeToString();

        $transaction = new \Proto\Transaction();
        $transaction->setSignedTransactionBytes($signedBytes);

        list($response, $status) = $this->mainConsensusClient->submitMessage($transaction)->wait();
        assert($response instanceof \Proto\TransactionResponse);

        if ($status->code !== \Grpc\STATUS_OK) {
            throw new \Exception($status->code . " - " . $status->details);
        }
        $this->handlePrecheckCode($response->getNodeTransactionPrecheckCode());
        return $transactionId;
    }
}
