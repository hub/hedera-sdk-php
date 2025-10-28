<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// *
// # Crypto Service
// A service defining transactions and queries related to accounts.
//
// This includes transactions for HBAR transfers and balance queries as well as
// transactions to manage "allowances" which permit a third party to spend a
// portion of the HBAR balance in an account.<br/>
// Basic account, record, and receipt queries are also defined in this service.
//
// Transactions and queries relating to tokens _other than HBAR_ are defined
// in the Token Service.
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
 * Transactions and queries for the Hedera Crypto Service.
 */
class CryptoServiceClient extends \Grpc\BaseStub {

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
     * Create a new account by submitting the transaction
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function createAccount(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.CryptoService/createAccount',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Update an account by submitting the transaction
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function updateAccount(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.CryptoService/updateAccount',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Initiate a transfer by submitting the transaction
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function cryptoTransfer(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.CryptoService/cryptoTransfer',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Delete an account by submitting the transaction
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function cryptoDelete(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.CryptoService/cryptoDelete',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Add one or more approved allowances for spenders to transfer the paying
     * account's hbar or tokens.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function approveAllowances(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.CryptoService/approveAllowances',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Delete one or more of the specific approved NFT serial numbers on an
     * owner account.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function deleteAllowances(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.CryptoService/deleteAllowances',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @deprecated
     * *
     * Add a livehash
     * <blockquote>Important<blockquote>
     * This transaction is obsolete, not supported, and SHALL fail with a
     * pre-check result of `NOT_SUPPORTED`.</blockquote></blockquote>
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function addLiveHash(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.CryptoService/addLiveHash',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @deprecated
     * *
     * Delete a livehash
     * <blockquote>Important<blockquote>
     * This transaction is obsolete, not supported, and SHALL fail with a
     * pre-check result of `NOT_SUPPORTED`.</blockquote></blockquote>
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function deleteLiveHash(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.CryptoService/deleteLiveHash',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @deprecated
     * *
     * Retrieve a livehash for an account
     * <blockquote>Important<blockquote>
     * This query is obsolete, not supported, and SHALL fail with a pre-check
     * result of `NOT_SUPPORTED`.</blockquote></blockquote>
     * @param \Proto\Query $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\Response>
     */
    public function getLiveHash(\Proto\Query $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.CryptoService/getLiveHash',
        $argument,
        ['\Proto\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Return all transactions in the last 180s of consensus time for which
     * the given account was the effective payer **and** network property
     * `ledger.keepRecordsInState` was `true`.
     * @param \Proto\Query $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\Response>
     */
    public function getAccountRecords(\Proto\Query $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.CryptoService/getAccountRecords',
        $argument,
        ['\Proto\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Retrieve the balance of an account
     * @param \Proto\Query $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\Response>
     */
    public function cryptoGetBalance(\Proto\Query $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.CryptoService/cryptoGetBalance',
        $argument,
        ['\Proto\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Retrieve the metadata of an account
     * @param \Proto\Query $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\Response>
     */
    public function getAccountInfo(\Proto\Query $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.CryptoService/getAccountInfo',
        $argument,
        ['\Proto\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Retrieve the latest receipt for a transaction that is either awaiting
     * consensus, or reached consensus in the last 180 seconds
     * @param \Proto\Query $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\Response>
     */
    public function getTransactionReceipts(\Proto\Query $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.CryptoService/getTransactionReceipts',
        $argument,
        ['\Proto\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Retrieve the record of a transaction that is either awaiting consensus,
     * or reached consensus in the last 180 seconds
     * @param \Proto\Query $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\Response>
     */
    public function getTxRecordByTxID(\Proto\Query $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.CryptoService/getTxRecordByTxID',
        $argument,
        ['\Proto\Response', 'decode'],
        $metadata, $options);
    }

}
