<?php

require 'Day.php';

class Day03 implements Day
{


    public static function firstChallenge($inputFile)
    {
        $fileName = $inputFile->getBaseName('.txt');
        echo "Solving the first challenge : $fileName\n";

        $result = 0;

        foreach ($inputFile as $line) {
            if (!empty($line)) {
                $compartmentSize = strlen($line) / 2;
                $compartments = str_split($line, $compartmentSize);
                $duplicateItem = array_values(array_intersect(
                    str_split($compartments[0]),
                    str_split($compartments[1])
                ));
                // echo "Common item is " . $duplicateItem[0] . "\n";
                $result += Day03::getPriority($duplicateItem[0]);
            }
        }
        return $result;
    }

    public static function secondChallenge($inputFile)
    {
        $fileName = $inputFile->getBaseName('.txt');
        echo "Solving the second challenge : $fileName\n";

        $result = 0;
        $group = [];
        $groupSize = 3;
        $STAGE_GROUP_START = 0;
        $STAGE_GROUP_COMPLETE = $groupSize - 1;

        foreach ($inputFile as $key => $line) {
            $progress = $key % $groupSize;

            if ($progress == $STAGE_GROUP_START) {
                echo "==== Group change !\n";
                $group = [$line];
            } else {
                $group[] = $line;
                if ($progress == $STAGE_GROUP_COMPLETE) {
                    $badge = array_values(array_intersect(
                        str_split($group[0]),
                        str_split($group[1]),
                        str_split($group[2])
                    ));
                    echo "Badge is " . $badge[0] . "\n";
                    $result += Day03::getPriority($badge[0]);
                }
            }
        }
        return $result;
    }

    private static function getPriority($char)
    {
        $ASCII_OFFSET_LOWERCASE = 96;
        $ASCII_OFFSET_UPPERCASE = 64 - 26;
        return (ord($char) > $ASCII_OFFSET_LOWERCASE)
            ? ord($char) - $ASCII_OFFSET_LOWERCASE
            : ord($char) - $ASCII_OFFSET_UPPERCASE;
    }
}
