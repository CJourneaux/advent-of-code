<?php

class Day02 implements Day
{
    const VALUES = [
        "rock" => 1,
        "paper" => 2,
        "scissor" => 3,
    ];

    /** 
     * rock < paper 
     * paper < scissor
     * scissor < rock

     * ABC - XYZ       = WIN
     * scissor - rock  = 3 - 1 =  2
     * rock - paper    = 1 - 2 = -1
     * paper - scissor = 2 - 3 = -1
     * 
     * ABC - XYZ       = LOSS
     * paper - rock    = 2 - 1 =  1
     * scissor - paper = 3 - 2 =  1
     * rock - scissor  = 1 - 3 = -2

     * ABC - XYZ       = DRAW
     * rock - rock         = 1 - 1 = 0
     * paper - paper       = 2 - 2 = 0
     * scissor - scissor   = 3 - 3 = 0
     * 
     */
    public static function firstChallenge($inputFile)
    {
        $fileName = $inputFile->getBaseName('.txt');
        echo "Solving the first challenge : $fileName\n";

        $POINTS = [
            "A" => self::VALUES['rock'],
            "X" => self::VALUES['rock'],
            "B" => self::VALUES['paper'],
            "Y" => self::VALUES['paper'],
            "C" => self::VALUES['scissor'],
            "Z" => self::VALUES['scissor'],
        ];

        $getResultsPoints = function ($playerA, $playerB) {
            $roundResult = $playerA - $playerB;
            // echo "==== ROUND : $playerA - $playerB\n";
            switch ($roundResult) {
                case 0:
                    // echo "DRAW : $playerB + 3\n";
                    return $playerB + 3;
                case -1:
                case 2:
                    // echo "WIN : $playerB + 6\n";
                    return $playerB + 6;
                case 1:
                case -2:
                    // echo "LOSS : $playerB + 0\n";
                    return $playerB + 0;
            };
        };

        $totalPoints = 0;
        foreach ($inputFile as $key => $line) {
            if (!empty($line)) {
                $round = str_split($line);
                $playerA = $round[0];
                $playerB = $round[2];
                // echo "$playerA VS $playerB\n";
                $totalPoints += $getResultsPoints($POINTS[$playerA], $POINTS[$playerB]);
            }
        }
        return $totalPoints;
    }

    /** 
     * rock < paper 
     * paper < scissor
     * scissor < rock

     * ABC - XYZ       = WIN
     * scissor  -> rock     = 3 -> 1 =  2
     * rock     -> paper    = 1 -> 2 = -1
     * paper    -> scissor  = 2 -> 3 = -1
     * 
     * ABC - XYZ       = LOSS
     * paper - rock    = 2 - 1 =  1
     * scissor - paper = 3 - 2 =  1
     * rock - scissor  = 1 - 3 = -2

     * ABC - XYZ       = DRAW
     * rock - rock         = 1 - 1 = 0
     * paper - paper       = 2 - 2 = 0
     * scissor - scissor   = 3 - 3 = 0
     * 
     */
    public static function secondChallenge($inputFile)
    {
        $fileName = $inputFile->getBaseName('.txt');
        echo "Solving the second challenge : $fileName\n";

        $getResultsPoints = function ($playerA, $roundResult) {
            $WIN_POINTS = [
                "A" => self::VALUES['paper'],   // rock     -> paper
                "B" => self::VALUES['scissor'], // paper    -> scissor
                "C" => self::VALUES['rock'],    // scissor  -> rock
            ];
            $LOSS_POINTS = [
                "A" => self::VALUES['scissor'], // rock     -> scissor
                "B" => self::VALUES['rock'],    // paper    -> rock
                "C" => self::VALUES['paper'],   // scissor  -> paper
            ];
            $DRAW_POINTS = [
                "A" => self::VALUES['rock'],    // rock     -> rock
                "B" => self::VALUES['paper'],   // paper    -> paper
                "C" => self::VALUES['scissor'], // scissor  -> scissor
            ];
            switch ($roundResult) {
                case "X":
                    // echo "LOSS : [$playerA] + 0\n";
                    return $LOSS_POINTS[$playerA] + 0;
                case "Y":
                    // echo "DRAW : [$playerA] + 3\n";
                    return $DRAW_POINTS[$playerA] + 3;
                case "Z":
                    // echo "WIN : [$playerA] + 6\n";
                    return $WIN_POINTS[$playerA] + 6;
            };
        };

        $totalPoints = 0;
        foreach ($inputFile as $key => $line) {
            if (!empty($line)) {
                $round = str_split($line);
                $playerA = $round[0];
                $expectedResult = $round[2];
                // echo "$playerA => $expectedResult\n";
                $totalPoints += $getResultsPoints($playerA, $expectedResult);
            }
        }
        return $totalPoints;
    }
}
