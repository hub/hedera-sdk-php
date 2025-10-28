<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// *
// # Smart Contract Service
// gRPC service definitions for calls to the Hedera EVM-compatible
// Smart Contract service.
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
 * The Hedera Smart Contract Service (HSCS) provides an interface to an EVM
 * compatible environment to create, store, manage, and execute smart contract
 * calls. Smart Contracts implement useful and often highly complex
 * interactions between individuals, systems, and the distributed ledger.
 */
class SmartContractServiceClient extends \Grpc\BaseStub {

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
     * Create a new smart contract.
     * <p>
     * If this transaction succeeds, the `ContractID` for the new smart
     * contract SHALL be set in the transaction receipt.<br/>
     * The contract is defined by the initial bytecode (or `initcode`).
     * The `initcode` SHALL be provided either in a previously created file,
     * or in the transaction body itself for very small contracts.<br/>
     * As part of contract creation, the constructor defined for the new
     * smart contract SHALL run with the parameters provided in
     * the `constructorParameters` field.<br/>
     * The gas to "power" that constructor MUST be provided via the `gas`
     * field, and SHALL be charged to the payer for this transaction.<br/>
     * If the contract _constructor_ stores information, it is charged gas for
     * that storage. There is a separate fee in HBAR to maintain that storage
     * until the expiration, and that fee SHALL be added to this transaction
     * as part of the _transaction fee_, rather than gas.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function createContract(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.SmartContractService/createContract',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Modify a smart contract.<br/>
     * Any change other than updating the expiration time requires that the
     * contract be modifiable (has a valid `adminKey`) and that the
     * transaction be signed by the `adminKey`
     * <p>
     * Fields _not set_ on the request SHALL NOT be modified.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function updateContract(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.SmartContractService/updateContract',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Call a function of a given smart contract, providing function parameter
     * inputs as needed.
     * <p>
     * Resource ("gas") charges SHALL include all relevant fees incurred by
     * the contract execution, including any storage required.<br/>
     * The total transaction fee SHALL incorporate all of the "gas" actually
     * consumed as well as the standard fees for transaction handling,
     * data transfers, signature verification, etc...
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function contractCallMethod(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.SmartContractService/contractCallMethod',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Call a query function of a given smart contract, providing
     * function parameter inputs as needed.<br/>
     * This is performed locally on the particular node that the client is
     * communicating with. Executing the call locally is faster and less
     * costly, but imposes certain restrictions.
     * <p>
     * The call MUST NOT change the state of the contract instance. This also
     * precludes any expenditure or transfer of HBAR or other tokens.<br/>
     * The call SHALL NOT have a separate consensus timestamp.<br/>
     * The call SHALL NOT generate a record nor a receipt.<br/>
     * The response SHALL contain the output returned by the function call.<br/>
     * <p>
     * This is generally useful for calling accessor functions which read
     * (query) state without changes or side effects. Any contract call that
     * would use the `STATICCALL` opcode MAY be called via contract call local
     * with performance and cost benefits.
     * <p>
     * Unlike a ContractCall transaction, the node SHALL always consume the
     * _entire_ amount of offered "gas" in determining the fee for this query,
     * so accurate gas estimation is important.
     * @param \Proto\Query $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\Response>
     */
    public function contractCallLocalMethod(\Proto\Query $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.SmartContractService/contractCallLocalMethod',
        $argument,
        ['\Proto\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * A standard query to obtain detailed information for a smart contract.
     * @param \Proto\Query $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\Response>
     */
    public function getContractInfo(\Proto\Query $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.SmartContractService/getContractInfo',
        $argument,
        ['\Proto\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * A standard query to read the current bytecode for a smart contract.
     * @param \Proto\Query $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\Response>
     */
    public function ContractGetBytecode(\Proto\Query $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.SmartContractService/ContractGetBytecode',
        $argument,
        ['\Proto\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * @deprecated
     * *
     * A standard query to obtain account and contract identifiers for a smart
     * contract, given the Solidity identifier for that contract.
     * @param \Proto\Query $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\Response>
     */
    public function getBySolidityID(\Proto\Query $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.SmartContractService/getBySolidityID',
        $argument,
        ['\Proto\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * @deprecated
     * *
     * <blockquote>This query is no longer supported.</blockquote>
     * This query always returned an empty record list.
     * @param \Proto\Query $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\Response>
     */
    public function getTxRecordByContractID(\Proto\Query $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.SmartContractService/getTxRecordByContractID',
        $argument,
        ['\Proto\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Delete a smart contract, and transfer any remaining HBAR balance
     * to a designated account.
     * <p>
     * If this call succeeds then all subsequent calls to that smart
     * contract SHALL fail.<br/>
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function deleteContract(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.SmartContractService/deleteContract',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @deprecated
     * *
     * Delete a smart contract, as a system-initiated deletion, this
     * SHALL NOT transfer balances.
     * <blockquote>
     * This call is an administrative function of the Hedera network, and
     * SHALL require network administration authorization.<br/>
     * This transaction MUST be signed by one of the network administration
     * accounts (typically `0.0.2` through `0.0.59`, as defined in the
     * `api-permission.properties` file).
     * </blockquote>
     * If this call succeeds then all subsequent calls to that smart
     * contract SHALL fail.<br/>
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function systemDelete(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.SmartContractService/systemDelete',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @deprecated
     * *
     * Un-Delete a smart contract, returning it (mostly) to its state
     * prior to deletion.
     * <p>
     * The contract to be restored MUST have been deleted via `systemDelete`.
     * If the contract was deleted via `deleteContract`, it
     * SHALL NOT be recoverable.
     * <blockquote>
     * This call is an administrative function of the Hedera network, and
     * SHALL require network administration authorization.<br/>
     * This transaction MUST be signed by one of the network administration
     * accounts (typically `0.0.2` through `0.0.59`, as defined in the
     * `api-permission.properties` file).
     * </blockquote>
     * If this call succeeds then subsequent calls to that smart
     * contract MAY succeed.<br/>
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function systemUndelete(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.SmartContractService/systemUndelete',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Make an Ethereum transaction "call" with all data in Ethereum formats,
     * including the contract alias.
     * <p>
     * Call data MAY be in the transaction, or stored within a "File".<br/>
     * The caller MAY offer additional gas above what is offered in the call
     * data, but MAY be charged up to 80% of that value if the amount required
     * is less than this "floor" amount.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function callEthereum(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.SmartContractService/callEthereum',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

}
