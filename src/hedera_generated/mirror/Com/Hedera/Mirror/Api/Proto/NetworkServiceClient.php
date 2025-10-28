<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// -
// ‌
// Hedera Mirror Node
// ​
// Copyright (C) 2019-2022 Hedera Hashgraph, LLC
// ​
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
// ‍
//
namespace Com\Hedera\Mirror\Api\Proto;

/**
 * *
 * Provides cross network APIs like address book queries
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
     *
     * Query for an address book and return its nodes. The nodes are returned in ascending order by node ID. The
     * response is not guaranteed to be a byte-for-byte equivalent to the NodeAddress in the Hedera file on
     * the network since it is reconstructed from a normalized database table.
     * @param \Com\Hedera\Mirror\Api\Proto\AddressBookQuery $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function getNodes(\Com\Hedera\Mirror\Api\Proto\AddressBookQuery $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/com.hedera.mirror.api.proto.NetworkService/getNodes',
        $argument,
        ['\Proto\NodeAddress', 'decode'],
        $metadata, $options);
    }

}
