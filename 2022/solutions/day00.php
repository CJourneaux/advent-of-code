<?php

require 'Day.php';

class Day00 implements Day
{
    public static function firstChallenge($inputFile)
    {
        $fileName = $inputFile->getBaseName('.txt');
        echo "Solving the first challenge : $fileName\n";
    }

    public static function secondChallenge($inputFile)
    {
        $fileName = $inputFile->getBaseName('.txt');
        echo "Solving the second challenge : $fileName\n";
    }
}
