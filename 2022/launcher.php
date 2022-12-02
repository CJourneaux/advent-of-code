#!/usr/bin/env php

<?php

// Define options
$longopts  = array(
    "day:",     // Required value
    "challenge::",   // Optpnal value   
    "test",     // No value
);
$shortopts  = "d:c::t";


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

// Launch the appropriate puzzle solver
include "solutions/day$day.php";
$solver= "Day$day";
$function = $challenge == 'two' ? 'secondChallenge' :'firstChallenge';
$inputFile = $testMode ? "day-$day-test.txt" : "day-$day-part-1.txt" ;

$result = ($solver::$function($inputFile));

echo "The solution is : $result\n";

exit(0);