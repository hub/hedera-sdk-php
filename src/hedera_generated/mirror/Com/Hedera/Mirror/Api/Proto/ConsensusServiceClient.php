<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// -
// ‌
// Hedera Mirror Node
// ​
// Copyright (C) 2019 Hedera Hashgraph, LLC
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
 * The Mirror Service provides the ability to query a stream of Hedera Consensus Service (HCS)
 * messages for an HCS Topic via a specific (possibly open-ended) time range.
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
     * @param \Com\Hedera\Mirror\Api\Proto\ConsensusTopicQuery $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function subscribeTopic(\Com\Hedera\Mirror\Api\Proto\ConsensusTopicQuery $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/com.hedera.mirror.api.proto.ConsensusService/subscribeTopic',
        $argument,
        ['\Com\Hedera\Mirror\Api\Proto\ConsensusTopicResponse', 'decode'],
        $metadata, $options);
    }

}
