<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// *
// # Freeze Service
// A service to manage network freeze events.
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
 * A service to manage network "freeze" events.
 *
 * This service provides a facility to prepare for network upgrades, halt network processing,
 * perform network software upgrades, and automatically restart the network following an upgrade.
 */
class FreezeServiceClient extends \Grpc\BaseStub {

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
     * Freeze, cancel, or prepare a freeze.
     * This single transaction performs all of the functions supported
     * by the network freeze service. These functions include actions to
     * prepare an upgrade, prepare a telemetry upgrade, freeze the network,
     * freeze the network for upgrade, or abort a scheduled freeze.
     * <p>
     * The actual freeze action SHALL be determined by the `freeze_type` field
     * of the `FreezeTransactionBody`.<br/>
     * The transaction body MUST be a `FreezeTransactionBody`.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function freeze(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.FreezeService/freeze',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

}
