<?php

const MINIMUM_COVERAGE = 30;
const COVERAGE_FILE = __DIR__ . '/../coverage/clover.xml';

if (!file_exists(COVERAGE_FILE)) {
    echo "ERROR: Coverage file not found: " . COVERAGE_FILE . "\n";
    echo "Run first: composer run-script test-coverage\n";
    exit(1);
}

$xml = simplexml_load_file(COVERAGE_FILE);
if ($xml === false) {
    echo "ERROR: Could not read coverage XML file.\n";
    exit(1);
}

// Calculate coverage from Clover XML
$metrics = $xml->project->metrics[0];
$statements = (int)$metrics['statements'];
$coveredStatements = (int)$metrics['coveredstatements'];

if ($statements === 0) {
    echo "ERROR: No statements to measure coverage.\n";
    exit(1);
}

$coverage = ($coveredStatements / $statements) * 100;

echo sprintf(
    "Coverage: %.2f%% (%d/%d statements)\n",
    $coverage,
    $coveredStatements,
    $statements
);

echo sprintf("Minimum threshold required: %.2f%%\n", MINIMUM_COVERAGE);

if ($coverage < MINIMUM_COVERAGE) {
    echo sprintf(
        "ERROR: Coverage (%.2f%%) is below the minimum threshold (%.2f%%)\n",
        $coverage,
        MINIMUM_COVERAGE
    );
    exit(1);
}

echo "✓ Coverage meets the minimum threshold.\n";
exit(0);

