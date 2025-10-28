<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// *
// # Token Service
// gRPC definitions for token service transactions.
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
 * Transactions and queries for the Token Service
 */
class TokenServiceClient extends \Grpc\BaseStub {

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
     * Create a new token.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function createToken(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/createToken',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Update a token.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function updateToken(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/updateToken',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Mint one or more tokens to the treasury account.
     * <p>
     * This MAY specify a quantity of fungible/common tokens or
     * a list of specific non-fungible/unique tokes, but
     * MUST NOT specify both.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function mintToken(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/mintToken',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Burn one or more tokens from the treasury account.
     * <p>
     * This MAY specify a quantity of fungible/common tokens or
     * a list of specific non-fungible/unique tokes, but
     * MUST NOT specify both.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function burnToken(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/burnToken',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Delete a token.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function deleteToken(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/deleteToken',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Wipe one or more tokens from an identified Account.
     * <p>
     * This MAY specify a quantity of fungible/common tokens or
     * a list of specific non-fungible/unique tokes, but
     * MUST NOT specify both.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function wipeTokenAccount(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/wipeTokenAccount',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Freeze the transfer of tokens to or from an identified Account.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function freezeTokenAccount(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/freezeTokenAccount',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Unfreeze the transfer of tokens to or from an identified Account.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function unfreezeTokenAccount(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/unfreezeTokenAccount',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Assert that KYC requirements are met for a specific account with
     * respect to a specific token.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function grantKycToTokenAccount(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/grantKycToTokenAccount',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Assert that KYC requirements are _not_ met for a specific account with
     * respect to a specific token.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function revokeKycFromTokenAccount(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/revokeKycFromTokenAccount',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Associate one or more tokens to an account.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function associateTokens(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/associateTokens',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Dissociate one or more tokens from an account.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function dissociateTokens(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/dissociateTokens',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Update the custom fee schedule for a token.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function updateTokenFeeSchedule(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/updateTokenFeeSchedule',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Retrieve the detail characteristics for a token.
     * <p>
     * This query SHALL return information for the token type as a whole.<br/>
     * This query SHALL NOT return information for individual tokens.
     * @param \Proto\Query $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\Response>
     */
    public function getTokenInfo(\Proto\Query $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/getTokenInfo',
        $argument,
        ['\Proto\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Retrieve the metadata for a specific non-fungible/unique token.<br/>
     * The NFT to query is identified by token identifier and serial number.
     * <p>
     * This query SHALL return token metadata and, if an allowance is defined,
     * the designated "spender" account for the queried NFT.
     * @param \Proto\Query $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\Response>
     */
    public function getTokenNftInfo(\Proto\Query $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/getTokenNftInfo',
        $argument,
        ['\Proto\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Pause a token.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function pauseToken(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/pauseToken',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Unpause (resume) a token.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function unpauseToken(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/unpauseToken',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Update multiple non-fungible/unique tokens (NFTs) in a collection.<br/>
     * The NFTs are identified by token identifier and one or more
     * serial numbers.
     * <p>
     * This transaction SHALL update NFT metadata only.<br/>
     * This transaction MUST be signed by the token `metadata_key`.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function updateNfts(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/updateNfts',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Reject one or more tokens.
     * <p>
     * This transaction SHALL transfer the full balance of one or more tokens
     * from the requesting account to the treasury for each token.<br/>
     * This transfer SHALL NOT charge any custom fee or royalty defined for
     * the token(s) to be rejected.<br/>
     * ### Effects on success
     * <ul>
     *   <li>If the rejected token is fungible/common, the requesting account
     *       SHALL have a balance of 0 for the rejected token.<br/>
     *       The treasury balance SHALL increase by the amount that the
     *       requesting account decreased.</li>
     *   <li>If the rejected token is non-fungible/unique the requesting
     *       account SHALL NOT hold the specific serialized token that
     *       is rejected.<br/>
     *       The treasury account SHALL hold each specific serialized token
     *       that was rejected.</li>
     * </li>
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function rejectToken(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/rejectToken',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Airdrop one or more tokens to one or more accounts.
     * <p>
     * This transaction SHALL distribute tokens from the balance of one or
     * more sending account(s) to the balance of one or more
     * recipient accounts.<br/>
     * Accounts SHALL receive the tokens in one of four ways.
     * <ul>
     *   <li>An account already associated to the token to be distributed
     *       SHALL receive the airdropped tokens immediately to the
     *       recipient account balance.</li>
     *   <li>An account with available automatic association slots SHALL
     *       be automatically associated to the token, and SHALL
     *       immediately receive the airdropped tokens to the recipient
     *       account balance.</li>
     *   <li>An account with "receiver signature required" set SHALL have
     *       a "Pending Airdrop" created and MUST claim that airdrop with
     *       a `claimAirdrop` transaction.</li>
     *   <li>An account with no available automatic association slots SHALL
     *       have a "Pending Airdrop" created and MUST claim that airdrop
     *       with a `claimAirdrop` transaction. </li>
     * </ul>
     * Any airdrop that completes immediately SHALL be irreversible.<br/>
     * Any airdrop that results in a "Pending Airdrop" MAY be canceled via
     * a `cancelAirdrop` transaction.<br/>
     * All transfer fees (including custom fees and royalties), as well as
     * the rent cost for the first auto-renewal period for any
     * automatic-association slot occupied by the airdropped tokens,
     * SHALL be charged to the account submitting this transaction.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function airdropTokens(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/airdropTokens',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Cancel one or more pending airdrops.
     * <p>
     * This transaction MUST be signed by _each_ account *sending* an
     * airdrop to be canceled.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function cancelAirdrop(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/cancelAirdrop',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * *
     * Claim one or more pending airdrops.
     * <p>
     * This transaction MUST be signed by _each_ account **receiving**
     * an airdrop to be claimed.<br>
     * If a "Sender" lacks sufficient balance to fulfill the airdrop at
     * the time the claim is made, that claim SHALL fail.
     * @param \Proto\Transaction $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Proto\TransactionResponse>
     */
    public function claimAirdrop(\Proto\Transaction $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/proto.TokenService/claimAirdrop',
        $argument,
        ['\Proto\TransactionResponse', 'decode'],
        $metadata, $options);
    }

}
