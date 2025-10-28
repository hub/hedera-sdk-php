<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// *
// # Consensus Service API
// GRPC service definitions for the Hedera Consensus Service (HCS).
//
// ### Keywords
// The key words "MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL NOT",
// "SHOULD", "SHOULD NOT", "RECOMMENDED", "MAY", and "OPTIONAL" in this
// document are to be interpreted as described in
// [RFC2119](https://www.ietf.org/rfc/rfc2119) and clarified in
// [RFC8174](https://www.ietf.org/rfc/rfc8174).
namespace Proto;

/**
 * *
 * The Hedera Consensus Service (HCS) provides the ability for a Hashgraph to
 * provide aBFT consensus as to the order and validity of messages submitted to
 * a *topic*, as well as a *consensus timestamp* for those messages.
 *
 */
class ConsensusServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * *
     * Create an HCS topic.
     * <p>
     * On success, the resulting TransactionReceipt SHALL contain the newly
     * created TopicId.<br/>
     * If the `adminKey` is set on the topic, this transaction MUST be signed
     * by that key.<br/>
     * If the `adminKey` is _not_ set on the topic, this transaction MUST NOT
     * set an `autoRenewAccount`. The new topic will be immutable and must be
     * renewed manually.<br/>
     * If the `autoRenewAccount` is set on the topic, this transaction MUST be
     * signed by that account.<br/>
     * <p>
     * The request body MUST be a
     * [ConsensusCreateTopicTransactionBody](#proto.ConsensusCreateTopicTransactionBody)
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function createTopic(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.ConsensusService/createTopic',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Update an HCS topic.
     * <p>
     * If the `adminKey` is not set on the topic, this transaction MUST extend
     * the `expirationTime` and MUST NOT modify any other field.<br/>
     * If the `adminKey` is set on the topic, this transaction MUST be signed
     * by that key.<br/>
     * If this transaction sets a new `adminKey`, this transaction MUST be
     * signed by <strong>_both_</strong> keys, the pre-update `adminKey` and
     * the post-update `adminKey`.<br/>
     * If this transaction sets a new, non-null, `autoRenewAccount`, the newly
     * set account MUST sign this transaction.<br/>
     * <p>
     * The request body MUST be a
     * [ConsensusUpdateTopicTransactionBody](#proto.ConsensusUpdateTopicTransactionBody)
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function updateTopic(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.ConsensusService/updateTopic',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Delete an HCS topic.
     * <p>
     * If this transaction succeeds, all subsequent transactions referencing
     * the deleted topic SHALL fail.<br/>
     * The `adminKey` MUST be set on the topic and this transaction MUST be
     * signed by that key.<br/>
     * If the `adminKey` is not set on the topic, this transaction SHALL fail
     * with a response code of `UNAUTHORIZED`. A topic without an `adminKey`
     * cannot be deleted, but MAY expire.<br/>
     * <p>
     * The request body MUST be a
     * [ConsensusDeleteTopicTransactionBody](#proto.ConsensusDeleteTopicTransactionBody)
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function deleteTopic(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.ConsensusService/deleteTopic',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Submit a message to an HCS topic.
     * <p>
     * Valid and authorized messages on valid topics will be ordered by the
     * consensus service, published in the block stream, and available to all
     * subscribers on this topic via the mirror nodes.<br/>
     * If this transaction succeeds the resulting TransactionReceipt SHALL
     * contain the latest topicSequenceNumber and topicRunningHash for the
     * topic.<br/>
     * If the topic has a `submitKey` then that key MUST sign this
     * transaction.<br/>
     * <p>
     * The request body MUST be a
     * [ConsensusSubmitMessageTransactionBody](#proto.ConsensusSubmitMessageTransactionBody)
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function submitMessage(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.ConsensusService/submitMessage',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Retrieve the latest state of a topic. This method is unrestricted and
     * allowed on any topic by any payer account.
     * <p>
     * The request body MUST be a
     * [ConsensusGetTopicInfoQuery](#proto.ConsensusGetTopicInfoQuery)<br/>
     * The response body SHALL be a
     * [ConsensusGetTopicInfoResponse](#proto.ConsensusGetTopicInfoResponse)
     * @param \Proto\Query $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\Response>
     */
    public function getTopicInfo(\Proto\Query $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.ConsensusService/getTopicInfo',
        $argument,
        ['\Proto\Response', 'decode'],
        $metadata, $options);
    }

}
