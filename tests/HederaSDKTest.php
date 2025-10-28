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
        'privateKey' => '302e020100300506032b65700422042084657f891c87139bed6464f645718b3406f4c7619e421c202e8c96c0502a7971',
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

        $this->assertNotNull($transactionId, 'Transaction ID should not be null');
        $this->assertInstanceOf(\Proto\TransactionID::class, $transactionId, 'Transaction ID should be a TransactionID object');
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

        $this->assertNotNull($receipt, 'Receipt should not be null');
        $this->assertInstanceOf('Proto\TransactionReceipt', $receipt, 'Receipt should be a TransactionReceipt instance');

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
        new Client('', $this->testConfig['mainNodeUrl'], $this->testConfig['mainNodeNum'], $this->testConfig['privateKey'], $this->testConfig['accountNum']);
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
        new Client($this->testConfig['mirrorNodeUrl'], '', $this->testConfig['mainNodeNum'], $this->testConfig['privateKey'], $this->testConfig['accountNum']);
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
        new Client($this->testConfig['mirrorNodeUrl'], $this->testConfig['mainNodeUrl'], -1, $this->testConfig['privateKey'], $this->testConfig['accountNum']);
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
        new Client($this->testConfig['mirrorNodeUrl'], $this->testConfig['mainNodeUrl'], $this->testConfig['mainNodeNum'], '', $this->testConfig['accountNum']);
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
        new Client($this->testConfig['mirrorNodeUrl'], $this->testConfig['mainNodeUrl'], $this->testConfig['mainNodeNum'], 'invalid_key_format', $this->testConfig['accountNum']);
    }

    /**
     * Test SDK instantiation with invalid private key length
     *
     * @group unit
     */
    public function testSDKInstantiationWithInvalidPrivateKeyLength()
    {
        // Test private key with wrong length (should be 96 characters)
        $invalidKey = '302e020100300506032b6570042204200d42398827feef4c4b2373636d64508f98c1b7f177d68bc16c4123366b153a7'; // 94 chars
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Ed25519 private key in DER format must be exactly 96 hex characters');
        new Client($this->testConfig['mirrorNodeUrl'], $this->testConfig['mainNodeUrl'], $this->testConfig['mainNodeNum'], $invalidKey, $this->testConfig['accountNum']);
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
        new Client($this->testConfig['mirrorNodeUrl'], $this->testConfig['mainNodeUrl'], $this->testConfig['mainNodeNum'], $this->testConfig['privateKey'], 0);
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
        $this->assertEquals(96, strlen($this->testConfig['privateKey']), 'Private key should be 96 characters long');
    }
}
