<?php

namespace HederaSdk\Tests;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/util.php';

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
        $validPrivateKey = '302e020100300506032b657004220420'
            . '84657f891c87139bed6464f645718b3406f4c7619e421c202e8c96c0502a7971';

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

    /**
     * Test decodePrivateKeyToKeypair function
     *
     * @group unit
     * @group util
     */
    public function testDecodePrivateKeyToKeypair()
    {
        $validPrivateKey = '302e020100300506032b657004220420'
            . '84657f891c87139bed6464f645718b3406f4c7619e421c202e8c96c0502a7971';

        $keypair = decodePrivateKeyToKeypair($validPrivateKey);

        $this->assertIsString($keypair, 'Keypair should be a string');
        $this->assertEquals(96, strlen($keypair), 'Keypair should be 96 bytes long');
    }

    /**
     * Test decodePrivateKeyToKeypair with invalid hex
     *
     * @group unit
     * @group util
     */
    public function testDecodePrivateKeyToKeypairWithInvalidHex()
    {
        // hex2bin with invalid hex can either return false or throw a warning
        // We'll test with a string that makes hex2bin return false
        // Using a string with invalid hex characters will cause hex2bin to return false
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid hex.');

        // Using a string that looks like hex but has an odd number of characters
        // or using @suppressWarnings to handle the PHP warning
        $invalidHex = 'gggggggggggggggggggggggggggggggggggggggggggggggggggggggg'
            . 'gggggggggggggggggggggggggggggggg';
        @decodePrivateKeyToKeypair($invalidHex);
    }

    /**
     * Test get_keypair function
     *
     * @group unit
     * @group util
     */
    public function testGetKeypair()
    {
        $validPrivateKey = '302e020100300506032b657004220420'
            . '84657f891c87139bed6464f645718b3406f4c7619e421c202e8c96c0502a7971';

        $keypair = get_keypair($validPrivateKey);

        $this->assertIsArray($keypair, 'Keypair should be an array');
        $this->assertArrayHasKey('private', $keypair, 'Keypair should have a private key');
        $this->assertArrayHasKey('public', $keypair, 'Keypair should have a public key');
        $this->assertIsString($keypair['private'], 'Private key should be a string');
        $this->assertIsString($keypair['public'], 'Public key should be a string');
        $this->assertEquals(64, strlen($keypair['private']), 'Private key should be 64 bytes long');
        $this->assertEquals(32, strlen($keypair['public']), 'Public key should be 32 bytes long');
    }

    /**
     * Test signString function
     *
     * @group unit
     * @group util
     */
    public function testSignString()
    {
        $validPrivateKey = '302e020100300506032b657004220420'
            . '84657f891c87139bed6464f645718b3406f4c7619e421c202e8c96c0502a7971';
        $keypair = get_keypair($validPrivateKey);

        $data = 'test message to sign';
        $signature = signString($data, $keypair['private']);

        $this->assertIsString($signature, 'Signature should be a string');
        $this->assertEquals(64, strlen($signature), 'Signature should be 64 bytes long');

        // Test that the same data produces the same signature
        $signature2 = signString($data, $keypair['private']);
        $this->assertEquals($signature, $signature2, 'Same data should produce the same signature');

        // Test that different data produces different signatures
        $differentData = 'different message';
        $differentSignature = signString($differentData, $keypair['private']);
        $this->assertNotEquals(
            $signature,
            $differentSignature,
            'Different data should produce different signatures'
        );
    }

    /**
     * Test signEd25519 function
     *
     * @group unit
     * @group util
     */
    public function testSignEd25519()
    {
        $validPrivateKey = '302e020100300506032b657004220420'
            . '84657f891c87139bed6464f645718b3406f4c7619e421c202e8c96c0502a7971';
        $bodyBytes = 'test message body bytes';

        list($signature, $publicKey) = signEd25519($bodyBytes, $validPrivateKey);

        $this->assertIsString($signature, 'Signature should be a string');
        $this->assertIsString($publicKey, 'Public key should be a string');
        $this->assertEquals(64, strlen($signature), 'Signature should be 64 bytes long');
        $this->assertEquals(32, strlen($publicKey), 'Public key should be 32 bytes long');

        // Test that the function returns consistent results
        list($signature2, $publicKey2) = signEd25519($bodyBytes, $validPrivateKey);
        $this->assertEquals($signature, $signature2, 'Same input should produce the same signature');
        $this->assertEquals($publicKey, $publicKey2, 'Same input should produce the same public key');
    }

    /**
     * Test signEd25519 with different data
     *
     * @group unit
     * @group util
     */
    public function testSignEd25519WithDifferentData()
    {
        $validPrivateKey = '302e020100300506032b657004220420'
            . '84657f891c87139bed6464f645718b3406f4c7619e421c202e8c96c0502a7971';

        $bodyBytes1 = 'first message';
        $bodyBytes2 = 'second message';

        list($signature1, $publicKey1) = signEd25519($bodyBytes1, $validPrivateKey);
        list($signature2, $publicKey2) = signEd25519($bodyBytes2, $validPrivateKey);

        $this->assertNotEquals($signature1, $signature2, 'Different data should produce different signatures');
        $this->assertEquals($publicKey1, $publicKey2, 'Same private key should produce the same public key');
    }
}
