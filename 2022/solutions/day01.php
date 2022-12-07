<?php

class Day01 implements Day
{

    public static function firstChallenge($inputFile)
    {
        $fileName = $inputFile->getBaseName('.txt');
        echo "Solving the first challenge : $fileName\n";

        $mostCaloriesCount = 0;
        $currentElfCount = 0;

        $compareCalories = function ($countA, $countB) {
            return $countA > $countB ? $countA : $countB;
        };

        foreach ($inputFile as $key => $line) {
            if (empty($line)) {
                // echo "==== Changing elf\n";
                $mostCaloriesCount = $compareCalories($currentElfCount, $mostCaloriesCount);
                $currentElfCount = 0;
            } else {
                $currentElfCount += (int)$line;
                // echo "Keeping the same elf $currentElfCount\n";
            }
        }
        $mostCaloriesCount = $compareCalories($currentElfCount, $mostCaloriesCount);

        return $mostCaloriesCount;
    }

    public static function secondChallenge($inputFile)
    {
        $fileName = $inputFile->getBaseName('.txt');
        echo "Solving the second challenge : $fileName\n";

        $mostCaloriesCount = [0, 0, 0];
        $currentElfCount = 0;

        $compareCalories = function ($newCount, $maxCount) {
            $minCount = $maxCount[0];
            if ($newCount > $minCount) {
                $maxCount[0] = $newCount;
                sort($maxCount);
                // echo "**** Changing best elves\n";
            }
            return $maxCount;
        };

        foreach ($inputFile as $key => $line) {
            if (empty($line)) {
                // echo "==== Changing elf\n";
                $mostCaloriesCount = $compareCalories($currentElfCount, $mostCaloriesCount);
                $currentElfCount = 0;
            } else {
                $currentElfCount += (int)$line;
                // echo "Keeping the same elf $currentElfCount\n";
            }
        }
        $mostCaloriesCount = $compareCalories($currentElfCount, $mostCaloriesCount);

        return array_sum($mostCaloriesCount);
    }
}
