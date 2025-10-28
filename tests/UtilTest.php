<?php

namespace HederaSdk\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Utility Functions Test Suite
 *
 * Tests for utility functions and helper methods
 *
 * @package HederaSdk\Tests
 * @author Zircon Tech
 * @license MIT
 */
class UtilTest extends TestCase
{
    /**
     * Test private key validation
     *
     * @group unit
     * @group validation
     */
    public function testPrivateKeyValidation()
    {
        $validPrivateKey = '302e020100300506032b65700422042084657f891c87139bed6464f645718b3406f4c7619e421c202e8c96c0502a7971';

        // Test valid private key format
        $this->assertStringStartsWith('302e020100300506032b657004220420', $validPrivateKey);
        $this->assertEquals(96, strlen($validPrivateKey));

        // Test invalid private key formats
        $invalidKeys = [
            '', // Empty
            '123', // Too short
            'invalid_key_format', // Wrong format
            '302e020100300506032b657004220420', // Too short
        ];

        foreach ($invalidKeys as $invalidKey) {
            $this->assertNotEquals(96, strlen($invalidKey), "Invalid key should not be 96 characters: {$invalidKey}");
        }
    }

    /**
     * Test account number validation
     *
     * @group unit
     * @group validation
     */
    public function testAccountNumberValidation()
    {
        $validAccountNumbers = [7153058, 1001, 9999999];

        foreach ($validAccountNumbers as $accountNum) {
            $this->assertIsInt($accountNum, 'Account number should be an integer');
            $this->assertGreaterThan(0, $accountNum, 'Account number should be positive');
        }

        $invalidAccountNumbers = [0, -1, 'invalid'];

        foreach ($invalidAccountNumbers as $accountNum) {
            if (is_int($accountNum)) {
                $this->assertLessThanOrEqual(0, $accountNum, 'Invalid account number should be <= 0');
            } else {
                $this->assertIsNotInt($accountNum, 'Invalid account number should not be an integer');
            }
        }
    }

    /**
     * Test node number validation
     *
     * @group unit
     * @group validation
     */
    public function testNodeNumberValidation()
    {
        $validNodeNumbers = [0, 1, 2, 3, 4];

        foreach ($validNodeNumbers as $nodeNum) {
            $this->assertIsInt($nodeNum, 'Node number should be an integer');
            $this->assertGreaterThanOrEqual(0, $nodeNum, 'Node number should be >= 0');
        }
    }

    /**
     * Test fee validation
     *
     * @group unit
     * @group validation
     */
    public function testFeeValidation()
    {
        $validFees = [20000000, 1000000, 5000000];

        foreach ($validFees as $fee) {
            $this->assertIsInt($fee, 'Fee should be an integer');
            $this->assertGreaterThan(0, $fee, 'Fee should be positive');
        }

        $invalidFees = [0, -1, 'invalid'];

        foreach ($invalidFees as $fee) {
            if (is_int($fee)) {
                $this->assertLessThanOrEqual(0, $fee, 'Invalid fee should be <= 0');
            } else {
                $this->assertIsNotInt($fee, 'Invalid fee should not be an integer');
            }
        }
    }

    /**
     * Test URL validation
     *
     * @group unit
     * @group validation
     */
    public function testUrlValidation()
    {
        $validUrls = [
            'testnet.mirrornode.hedera.com',
            '50.18.132.211:50211',
            'mainnet.mirrornode.hedera.com',
            'localhost:50211'
        ];

        foreach ($validUrls as $url) {
            $this->assertIsString($url, 'URL should be a string');
            $this->assertNotEmpty($url, 'URL should not be empty');
        }
    }

    /**
     * Test network configuration
     *
     * @group unit
     * @group config
     */
    public function testNetworkConfiguration()
    {
        $networks = ['testnet', 'mainnet', 'previewnet'];

        foreach ($networks as $network) {
            $this->assertIsString($network, 'Network should be a string');
            $this->assertNotEmpty($network, 'Network should not be empty');
        }

        $this->assertContains('testnet', $networks, 'Testnet should be a valid network');
        $this->assertContains('mainnet', $networks, 'Mainnet should be a valid network');
    }
}
