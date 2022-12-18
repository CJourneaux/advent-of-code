<?php

require 'Day.php';

class Day04 implements Day
{

    public static $INSTRUCTIONS_PATTERN = "/(?'Astart'\d+)-(?'Aend'\d+),(?'Bstart'\d+)-(?'Bend'\d+)/i";

    public static function firstChallenge($inputFile)
    {
        $fileName = $inputFile->getBaseName('.txt');
        echo "Solving the first challenge : $fileName\n";

        $counter = 0;

        $contains = function ($Astart, $Aend, $Bstart, $Bend) {
            return ($Astart <= $Bstart && $Bend <= $Aend)
                || ($Bstart <= $Astart && $Aend <= $Bend);
        };

        foreach ($inputFile as $key => $line) {
            $ranges = [];
            if (preg_match(self::$INSTRUCTIONS_PATTERN, $line, $ranges)) {
                if ($contains($ranges['Astart'], $ranges['Aend'], $ranges['Bstart'], $ranges['Bend'])) {
                    $counter++;
                }
            }
        }

        return $counter;
    }

    public static function secondChallenge($inputFile)
    {
        $fileName = $inputFile->getBaseName('.txt');
        echo "Solving the second challenge : $fileName\n";

        $counter = 0;

        $overlap = function ($Astart, $Aend, $Bstart, $Bend) {
            return ($Astart <= $Bstart && $Aend >= $Bstart)
                || ($Bstart <= $Astart && $Bend >= $Astart);
        };

        foreach ($inputFile as $key => $line) {
            $ranges = [];
            if (preg_match(self::$INSTRUCTIONS_PATTERN, $line, $ranges)) {
                if ($overlap($ranges['Astart'], $ranges['Aend'], $ranges['Bstart'], $ranges['Bend'])) {
                    $counter++;
                }
            }
        }

        return $counter;
    }
}
