#!/usr/bin/env php

<?php

// Define options
$longopts  = array(
    "day:",         // Required value
    "challenge:",   // Optional value   
    "test",         // No value
    "init",         // No value
);
$shortopts  = "d:c:ti";


// Read parameters from the command line and validate them
$options = getopt($shortopts, $longopts);

$testMode = isset($options['test']) || isset($options['t']);

$rawDay = $options['day'] ?? $options['d'] ?? null;
if (!isset($rawDay)) {
    echo "Failed to provide an appropriate day";
    exit(1);
}
$day = sprintf('%02d', (int)$rawDay);

$challenge = $options['challenge'] ?? $options['c'] ?? null;

// Set-up files for working on a challenge
$initMode = isset($options['init']) || isset($options['i']);
if ($initMode) {
    $solverFileName = "solutions/day$day.php";
    if (!file_exists($solverFileName)) {
        touch("inputs/day-$day-data.txt");
        touch("inputs/day-$day-test.txt");
        copy("solutions/day00.php", $solverFileName);
        echo "Successfully created input and solver files\n";
        echo "==== Don't forget to change the class name ! ====\n";
        exit(0);
    } else {
        echo "There's already some files set-up for the challenge of day $day !\n";
        exit(1);
    }
}

// Launch the appropriate puzzle solver
include "solutions/day$day.php";
$solver = "Day$day";
$function = $challenge == 'two' ? 'secondChallenge' : 'firstChallenge';
$inputFileName = $testMode ? "day-$day-test" : "day-$day-data";
$inputFile = new SplFileObject("inputs/$inputFileName.txt", "r");
$inputFile->setFlags(SplFileObject::DROP_NEW_LINE);

$result = ($solver::$function($inputFile));

echo "The solution is : $result\n";

exit(0);
