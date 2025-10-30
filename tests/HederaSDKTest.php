<?php

namespace HederaSdk\Tests;

use PHPUnit\Framework\TestCase;
use HederaSdk\Client;
use Proto\ResponseCodeEnum;

/**
 * HederaSDK Test Suite
 *
 * Tests for Hedera Hashgraph SDK functionality
 *
 * @package HederaSdk\Tests
 * @author Zircon Tech
 * @license MIT
 */
class HederaSDKTest extends TestCase
{
    private $testConfig = [
        'network' => 'testnet',
        'mirrorNodeUrl' => 'testnet.mirrornode.hedera.com',
        'mainNodeUrl' => '50.18.132.211:50211',
        'mainNodeNum' => 3,
        'accountNum' => 7153058,
        'privateKey' => '302e020100300506032b657004220420'
            . '84657f891c87139bed6464f645718b3406f4c7619e421c202e8c96c0502a7971',
        'fee' => 20000000
    ];

    /**
     * Test HCS (Hedera Consensus Service) topic creation
     *
     * @group integration
     * @group hcs
     */
    public function testCreateTopic()
    {
        $client = new Client(
            $this->testConfig['mirrorNodeUrl'],
            $this->testConfig['mainNodeUrl'],
            $this->testConfig['mainNodeNum'],
            $this->testConfig['privateKey'],
            $this->testConfig['accountNum']
        );

        $transactionId = $client->createTopic($this->testConfig['fee']);

        // Sleep to avoid saturating the network
        sleep(2);

        $this->assertNotNull($transactionId, 'Transaction ID should not be null');
        $this->assertInstanceOf(
            \Proto\TransactionID::class,
            $transactionId,
            'Transaction ID should be a TransactionID object'
        );
    }

    /**
     * Test transaction receipt retrieval
     *
     * @group integration
     * @group receipts
     */
    public function testGetTransactionReceipts()
    {
        $client = new Client(
            $this->testConfig['mirrorNodeUrl'],
            $this->testConfig['mainNodeUrl'],
            $this->testConfig['mainNodeNum'],
            $this->testConfig['privateKey'],
            $this->testConfig['accountNum']
        );

        // First create a topic to get a transaction ID
        $transactionId = $client->createTopic($this->testConfig['fee']);

        // Wait a bit for the transaction to be processed
        sleep(2);

        $receipt = $client->getTransactionReceipts($transactionId);

        // Sleep to avoid saturating the network
        sleep(2);

        $this->assertNotNull($receipt, 'Receipt should not be null');
        $this->assertInstanceOf(
            'Proto\TransactionReceipt',
            $receipt,
            'Receipt should be a TransactionReceipt instance'
        );

        $status = $receipt->getStatus();
        $this->assertEquals(ResponseCodeEnum::SUCCESS, $status, 'Transaction should be successful');

        $topicId = $receipt->getTopicID();
        $this->assertNotNull($topicId, 'Topic ID should not be null');
    }

    /**
     * Test complete HCS workflow
     *
     * @group integration
     * @group hcs
     * @group workflow
     */
    public function testHCSWorkflow()
    {
        $client = new Client(
            $this->testConfig['mirrorNodeUrl'],
            $this->testConfig['mainNodeUrl'],
            $this->testConfig['mainNodeNum'],
            $this->testConfig['privateKey'],
            $this->testConfig['accountNum']
        );

        // Step 1: Create topic
        $transactionId = $client->createTopic($this->testConfig['fee']);
        $this->assertNotNull($transactionId, 'Transaction ID should not be null');

        // Step 2: Wait for transaction processing
        sleep(2);

        // Step 3: Get receipt
        $receipt = $client->getTransactionReceipts($transactionId);
        $this->assertNotNull($receipt, 'Receipt should not be null');

        // Sleep to avoid saturating the network
        sleep(2);

        // Step 4: Verify success
        $status = $receipt->getStatus();
        $this->assertEquals(ResponseCodeEnum::SUCCESS, $status, 'Transaction should be successful');

        // Step 5: Get topic ID
        $topicId = $receipt->getTopicID();
        $this->assertNotNull($topicId, 'Topic ID should not be null');

        // Additional assertions for topic ID structure
        $this->assertIsObject($topicId, 'Topic ID should be an object');
    }

    /**
     * Test SDK instantiation with valid parameters
     *
     * @group unit
     */
    public function testSDKInstantiation()
    {
        $client = new Client(
            $this->testConfig['mirrorNodeUrl'],
            $this->testConfig['mainNodeUrl'],
            $this->testConfig['mainNodeNum'],
            $this->testConfig['privateKey'],
            $this->testConfig['accountNum']
        );

        $this->assertInstanceOf(Client::class, $client, 'Client should be an instance of Client');
    }

    /**
     * Test SDK instantiation with invalid parameters
     *
     * @group unit
     */
    public function testSDKInstantiationWithInvalidParameters()
    {
        // Test empty mirror node URL
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Mirror node URL cannot be empty');
        new Client(
            '',
            $this->testConfig['mainNodeUrl'],
            $this->testConfig['mainNodeNum'],
            $this->testConfig['privateKey'],
            $this->testConfig['accountNum']
        );
    }

    /**
     * Test SDK instantiation with invalid main node URL
     *
     * @group unit
     */
    public function testSDKInstantiationWithInvalidMainNodeUrl()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Main node URL cannot be empty');
        new Client(
            $this->testConfig['mirrorNodeUrl'],
            '',
            $this->testConfig['mainNodeNum'],
            $this->testConfig['privateKey'],
            $this->testConfig['accountNum']
        );
    }

    /**
     * Test SDK instantiation with invalid node number
     *
     * @group unit
     */
    public function testSDKInstantiationWithInvalidNodeNumber()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Node number must be greater than or equal to 0');
        new Client(
            $this->testConfig['mirrorNodeUrl'],
            $this->testConfig['mainNodeUrl'],
            -1,
            $this->testConfig['privateKey'],
            $this->testConfig['accountNum']
        );
    }

    /**
     * Test SDK instantiation with invalid private key
     *
     * @group unit
     */
    public function testSDKInstantiationWithInvalidPrivateKey()
    {
        // Test empty private key
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Private key cannot be empty');
        new Client(
            $this->testConfig['mirrorNodeUrl'],
            $this->testConfig['mainNodeUrl'],
            $this->testConfig['mainNodeNum'],
            '',
            $this->testConfig['accountNum']
        );
    }

    /**
     * Test SDK instantiation with invalid private key format
     *
     * @group unit
     */
    public function testSDKInstantiationWithInvalidPrivateKeyFormat()
    {
        // Test private key with wrong format
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Private key must be an Ed25519 key in DER format');
        new Client(
            $this->testConfig['mirrorNodeUrl'],
            $this->testConfig['mainNodeUrl'],
            $this->testConfig['mainNodeNum'],
            'invalid_key_format',
            $this->testConfig['accountNum']
        );
    }

    /**
     * Test SDK instantiation with invalid private key length
     *
     * @group unit
     */
    public function testSDKInstantiationWithInvalidPrivateKeyLength()
    {
        // Test private key with wrong length (should be 96 characters)
        $invalidKey = '302e020100300506032b657004220420'
            . '0d42398827feef4c4b2373636d64508f98c1b7f177d68bc16c4123366b153a7'; // 94 chars
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Ed25519 private key in DER format must be exactly 96 hex characters');
        new Client(
            $this->testConfig['mirrorNodeUrl'],
            $this->testConfig['mainNodeUrl'],
            $this->testConfig['mainNodeNum'],
            $invalidKey,
            $this->testConfig['accountNum']
        );
    }

    /**
     * Test SDK instantiation with invalid account number
     *
     * @group unit
     */
    public function testSDKInstantiationWithInvalidAccountNumber()
    {
        // Test zero account number
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Account number must be greater than 0');
        new Client(
            $this->testConfig['mirrorNodeUrl'],
            $this->testConfig['mainNodeUrl'],
            $this->testConfig['mainNodeNum'],
            $this->testConfig['privateKey'],
            0
        );
    }

    /**
     * Test configuration values
     *
     * @group unit
     */
    public function testConfigurationValues()
    {
        $this->assertEquals('testnet', $this->testConfig['network']);
        $this->assertEquals('testnet.mirrornode.hedera.com', $this->testConfig['mirrorNodeUrl']);
        $this->assertEquals('50.18.132.211:50211', $this->testConfig['mainNodeUrl']);
        $this->assertEquals(3, $this->testConfig['mainNodeNum']);
        $this->assertEquals(7153058, $this->testConfig['accountNum']);
        $this->assertEquals(20000000, $this->testConfig['fee']);

        // Validate private key format (DER encoded)
        $this->assertStringStartsWith('302e020100300506032b657004220420', $this->testConfig['privateKey']);
        $this->assertEquals(
            96,
            strlen($this->testConfig['privateKey']),
            'Private key should be 96 characters long'
        );
    }

    /**
     * Test SDK instantiation with whitespace-only mirror node URL
     *
     * @group unit
     */
    public function testSDKInstantiationWithWhitespaceMirrorNodeUrl()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Mirror node URL cannot be empty');
        new Client(
            '   ',
            $this->testConfig['mainNodeUrl'],
            $this->testConfig['mainNodeNum'],
            $this->testConfig['privateKey'],
            $this->testConfig['accountNum']
        );
    }

    /**
     * Test SDK instantiation with whitespace-only main node URL
     *
     * @group unit
     */
    public function testSDKInstantiationWithWhitespaceMainNodeUrl()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Main node URL cannot be empty');
        new Client(
            $this->testConfig['mirrorNodeUrl'],
            '   ',
            $this->testConfig['mainNodeNum'],
            $this->testConfig['privateKey'],
            $this->testConfig['accountNum']
        );
    }

    /**
     * Test SDK instantiation with whitespace-only private key
     *
     * @group unit
     */
    public function testSDKInstantiationWithWhitespacePrivateKey()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Private key cannot be empty');
        new Client(
            $this->testConfig['mirrorNodeUrl'],
            $this->testConfig['mainNodeUrl'],
            $this->testConfig['mainNodeNum'],
            '   ',
            $this->testConfig['accountNum']
        );
    }

    /**
     * Test SDK instantiation with negative account number
     *
     * @group unit
     */
    public function testSDKInstantiationWithNegativeAccountNumber()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Account number must be greater than 0');
        new Client(
            $this->testConfig['mirrorNodeUrl'],
            $this->testConfig['mainNodeUrl'],
            $this->testConfig['mainNodeNum'],
            $this->testConfig['privateKey'],
            -1
        );
    }

    /**
     * Test SDK instantiation with node number zero (valid)
     *
     * @group unit
     */
    public function testSDKInstantiationWithNodeNumberZero()
    {
        $client = new Client(
            $this->testConfig['mirrorNodeUrl'],
            $this->testConfig['mainNodeUrl'],
            0, // Node number zero should be valid
            $this->testConfig['privateKey'],
            $this->testConfig['accountNum']
        );

        $this->assertInstanceOf(Client::class, $client, 'Client should be an instance of Client');
        $this->assertEquals(0, $client->mainNodeNum, 'Node number should be 0');
    }

    /**
     * Test client properties are set correctly
     *
     * @group unit
     */
    public function testClientProperties()
    {
        $client = new Client(
            $this->testConfig['mirrorNodeUrl'],
            $this->testConfig['mainNodeUrl'],
            $this->testConfig['mainNodeNum'],
            $this->testConfig['privateKey'],
            $this->testConfig['accountNum']
        );

        $this->assertEquals($this->testConfig['mirrorNodeUrl'], $client->mirrorNodeUrl);
        $this->assertEquals($this->testConfig['mainNodeUrl'], $client->mainNodeUrl);
        $this->assertEquals($this->testConfig['mainNodeNum'], $client->mainNodeNum);
        $this->assertEquals($this->testConfig['privateKey'], $client->privateKey);
        $this->assertEquals($this->testConfig['accountNum'], $client->accountNum);
        $this->assertNotNull($client->mainNetworkClient);
        $this->assertNotNull($client->mainCryptoClient);
        $this->assertNotNull($client->mainConsensusClient);
        $this->assertNotNull($client->mirrorConsensusClient);
        $this->assertNotNull($client->mirrorNetworkClient);
    }

    /**
     * Test checkAccountBalance method structure
     *
     * @group integration
     * @group balance
     */
    public function testCheckAccountBalance()
    {
        $client = new Client(
            $this->testConfig['mirrorNodeUrl'],
            $this->testConfig['mainNodeUrl'],
            $this->testConfig['mainNodeNum'],
            $this->testConfig['privateKey'],
            $this->testConfig['accountNum']
        );

        $balance = $client->checkAccountBalance($this->testConfig['accountNum']);

        // Sleep to avoid saturating the network
        sleep(2);

        $this->assertIsFloat($balance, 'Balance should be a float');
        $this->assertGreaterThanOrEqual(0, $balance, 'Balance should be non-negative');
    }

    /**
     * Test getVersionInfoWithPayment method structure
     *
     * @group integration
     * @group version
     */
    public function testGetVersionInfoWithPayment()
    {
        $client = new Client(
            $this->testConfig['mirrorNodeUrl'],
            $this->testConfig['mainNodeUrl'],
            $this->testConfig['mainNodeNum'],
            $this->testConfig['privateKey'],
            $this->testConfig['accountNum']
        );

        $versionInfo = $client->getVersionInfoWithPayment($this->testConfig['fee']);

        // Sleep to avoid saturating the network
        sleep(2);

        $this->assertInstanceOf(
            \Proto\NetworkGetVersionInfoResponse::class,
            $versionInfo,
            'Version info should be a NetworkGetVersionInfoResponse'
        );
    }

    /**
     * Test submitMessage method structure
     *
     * @group integration
     * @group hcs
     */
    public function testSubmitMessage()
    {
        $client = new Client(
            $this->testConfig['mirrorNodeUrl'],
            $this->testConfig['mainNodeUrl'],
            $this->testConfig['mainNodeNum'],
            $this->testConfig['privateKey'],
            $this->testConfig['accountNum']
        );

        // First create a topic
        $transactionId = $client->createTopic($this->testConfig['fee']);
        sleep(2);
        $receipt = $client->getTransactionReceipts($transactionId);
        $topicId = $receipt->getTopicID();

        // Submit a message
        $messageTransactionId = $client->submitMessage(
            $this->testConfig['fee'],
            $topicId->getTopicNum(),
            'Test message'
        );

        // Sleep to avoid saturating the network
        sleep(2);

        $this->assertNotNull($messageTransactionId, 'Message transaction ID should not be null');
        $this->assertInstanceOf(
            \Proto\TransactionID::class,
            $messageTransactionId,
            'Message transaction ID should be a TransactionID object'
        );
    }

    /**
     * Test submitMessage with empty message
     *
     * @group integration
     * @group hcs
     */
    public function testSubmitMessageWithEmptyMessage()
    {
        $client = new Client(
            $this->testConfig['mirrorNodeUrl'],
            $this->testConfig['mainNodeUrl'],
            $this->testConfig['mainNodeNum'],
            $this->testConfig['privateKey'],
            $this->testConfig['accountNum']
        );

        // First create a topic
        $transactionId = $client->createTopic($this->testConfig['fee']);
        sleep(2);
        $receipt = $client->getTransactionReceipts($transactionId);
        $topicId = $receipt->getTopicID();

        // Submit an empty message - this may fail with precheck error (code 158)
        // Empty messages might not be allowed by the network
        try {
            $messageTransactionId = $client->submitMessage(
                $this->testConfig['fee'],
                $topicId->getTopicNum(),
                ''
            );

            // Sleep to avoid saturating the network
            sleep(2);

            $this->assertNotNull($messageTransactionId, 'Message transaction ID should not be null');
        } catch (\Exception $e) {
            // Sleep to avoid saturating the network
            sleep(2);

            // If empty messages are not allowed, that's acceptable
            $this->assertStringContainsString(
                'Precheck code',
                $e->getMessage(),
                'Should get a precheck error for empty message'
            );
        }
    }

    /**
     * Test subscribeTopic method structure
     *
     * @group integration
     * @group hcs
     */
    public function testSubscribeTopic()
    {
        $client = new Client(
            $this->testConfig['mirrorNodeUrl'],
            $this->testConfig['mainNodeUrl'],
            $this->testConfig['mainNodeNum'],
            $this->testConfig['privateKey'],
            $this->testConfig['accountNum']
        );

        // First create a topic and submit a message
        $transactionId = $client->createTopic($this->testConfig['fee']);
        sleep(2);
        $receipt = $client->getTransactionReceipts($transactionId);
        $topicId = $receipt->getTopicID();

        $client->submitMessage(
            $this->testConfig['fee'],
            $topicId->getTopicNum(),
            'Test message for subscription'
        );

        // Sleep to avoid saturating the network
        sleep(2);

        sleep(3); // Wait a bit more for message to be processed

        $messages = $client->subscribeTopic($topicId->getTopicNum());

        // Sleep to avoid saturating the network
        sleep(2);

        $this->assertIsArray($messages, 'Messages should be an array');
        // Messages array might be empty if no messages were found in the time window
        // But we successfully called subscribeTopic without errors
    }
}
