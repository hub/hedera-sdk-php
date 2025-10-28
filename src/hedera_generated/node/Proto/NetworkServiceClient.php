<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// *
// # Network Service
// This service offers some basic "network information" queries.
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
 * Basic "network information" queries.
 *
 * This service supports queries for the active services and API versions,
 * and a query for account details.
 */
class NetworkServiceClient extends \Grpc\BaseStub {

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
     * Retrieve the active versions of Hedera Services and API messages.
     * @param \Proto\Query $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\Response>
     */
    public function getVersionInfo(\Proto\Query $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.NetworkService/getVersionInfo',
        $argument,
        ['\Proto\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Request detail information about an account.
     * <p>
     * The returned information SHALL include balance and allowances.<br/>
     * The returned information SHALL NOT include a list of account records.
     * @param \Proto\Query $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\Response>
     */
    public function getAccountDetails(\Proto\Query $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.NetworkService/getAccountDetails',
        $argument,
        ['\Proto\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * @deprecated
     * *
     * Retrieve the time, in nanoseconds, spent in direct processing for one or
     * more recent transactions.
     * <p>
     * For each transaction identifier provided, if that transaction is
     * sufficiently recent (that is, it is within the range of the
     * configuration value `stats.executionTimesToTrack`), the node SHALL
     * return the time, in nanoseconds, spent to directly process that
     * transaction (that is, excluding time to reach consensus).<br/>
     * Note that because each node processes every transaction for the Hedera
     * network, this query MAY be sent to any node.
     * <p>
     * <blockquote>Important<blockquote>
     * This query is obsolete, not supported, and SHALL fail with a pre-check
     * result of `NOT_SUPPORTED`.</blockquote></blockquote>
     * @param \Proto\Query $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\Response>
     */
    public function getExecutionTime(\Proto\Query $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.NetworkService/getExecutionTime',
        $argument,
        ['\Proto\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * @deprecated
     * *
     * Submit a transaction that wraps another transaction which will
     * skip most validation.
     * <p>
     * <blockquote>Important<blockquote>
     * This query is obsolete, not supported, and SHALL fail with a pre-check
     * result of `NOT_SUPPORTED`.
     * </blockquote></blockquote>
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function uncheckedSubmit(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.NetworkService/uncheckedSubmit',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

}
