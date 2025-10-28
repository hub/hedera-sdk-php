# HederaSDK Test Suite

This directory contains the test suite for the Hedera Hashgraph SDK for PHP.

## Test Structure

### Unit Tests
- **HederaSDKTest**: Main SDK functionality tests
- **UtilTest**: Utility functions and validation tests

### Test Groups

#### Unit Tests (`@group unit`)
- Fast, isolated tests that don't require network access
- Test individual methods and validation logic
- Can be run frequently during development

#### Integration Tests (`@group integration`)
- Tests that require network access to Hedera testnet
- Test complete workflows and real API interactions
- Require valid credentials and network connectivity

#### Specific Feature Groups
- `@group hcs`: Hedera Consensus Service tests
- `@group receipts`: Transaction receipt tests
- `@group workflow`: Complete workflow tests
- `@group validation`: Input validation tests
- `@group config`: Configuration tests

## Running Tests

### Run All Tests
```bash
composer test
```

### Run Only Unit Tests
```bash
vendor/bin/phpunit --group unit
```

### Run Only Integration Tests
```bash
vendor/bin/phpunit --group integration
```

### Run Specific Test Group
```bash
vendor/bin/phpunit --group hcs
vendor/bin/phpunit --group validation
```

### Run with Coverage
```bash
composer test-coverage
```

## Test Configuration

### Integration Test Setup
Integration tests are marked as skipped by default because they require:
- Network access to Hedera testnet
- Valid account credentials
- Private key for signing transactions

To enable integration tests:
1. Update the test configuration in `HederaSDKTest.php`
2. Remove or comment out the `markTestSkipped()` calls
3. Ensure you have valid testnet credentials

### Test Data
Test data is configured in the `$testConfig` array in `HederaSDKTest.php`:
- Network: testnet
- Mirror Node: testnet.mirrornode.hedera.com
- Main Node: 50.18.132.211:50211
- Node Number: 3
- Account Number: 7153058
- Fee: 20000000 tinybars

## Test Coverage

The test suite aims to cover:
- SDK instantiation and configuration
- Input validation and error handling
- Core Hedera functionality (HCS, transactions)
- Utility functions and helpers
- Complete workflows and integration scenarios

## Contributing

When adding new tests:
1. Follow the existing naming conventions
2. Use appropriate test groups (`@group`)
3. Add proper documentation
4. Include both positive and negative test cases
5. Mark integration tests appropriately
