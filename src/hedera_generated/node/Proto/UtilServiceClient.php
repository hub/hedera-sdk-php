<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// *
// # Utility Service
// This service provides a transaction to generate a deterministic
// pseudo-random value, either a 32-bit integer within a requested range
// or a 384-bit byte array.
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
 * The Utility Service provides a pseudo-random number generator.
 *
 * The single gRPC call defined for this service simply reports a single
 * pseudo-random number in the transaction record. That value may either
 * be a 32-bit integer within a requested range, or a 384-bit byte array.
 *
 * ### Block Stream Effects
 * The requested value is reported exclusively in a `UtilPrngOutput` message.
 */
class UtilServiceClient extends \Grpc\BaseStub {

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
     * Generate a pseudo-random value.
     * <p>
     * The request body MUST be a
     * [UtilPrngTransactionBody](#proto.UtilPrngTransactionBody)
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function prng(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.UtilService/prng',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Execute a batch of transactions atomically.
     * <p>
     * All transactions in the batch will be executed in order, and if any
     * transaction fails, the entire batch will fail.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function atomicBatch(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.UtilService/atomicBatch',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

}
