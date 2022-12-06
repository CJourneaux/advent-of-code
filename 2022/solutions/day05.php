<?php

class Day05 implements Day
{
    public static function firstChallenge($inputFile)
    {
        echo "Solving the first challenge : $inputFile\n";

        // $STACKS = [
        //     '1' => ['Z', 'N'],
        //     '2' => ['M', 'C', 'D'],
        //     '3' => ['P']
        // ];

        $STACKS = [
            '1' => ['S', 'C', 'V', 'N'],
            '2' => ['Z', 'M',  'J', 'H', 'N', 'S'],
            '3' => ['M', 'C', 'T', 'G', 'J', 'N', 'D'],
            '4' => ['T', 'D', 'F', 'J', 'W', 'R', 'M'],
            '5' => ['P', 'F', 'H'],
            '6' => ['C', 'T', 'Z', 'H', 'J'],
            '7' => ['D', 'P', 'R', 'Q', 'F', 'S', 'L', 'Z'],
            '8' => ['C', 'S', 'L', 'H', 'D', 'F', 'P', 'W'],
            '9' => ['D', 'S', 'M', 'P', 'F', 'N', 'G', 'Z'],
        ];


        // echo "1 : " . implode('-', $STACKS['1']) . "\n";
        // echo "2 : " . implode('-', $STACKS['2']) . "\n";
        // echo "3 : " . implode('-', $STACKS['3']) . "\n";

        $STACKS_PATTERN = "/(?'crate'(?'empty'\s{4}|(?'full'\[(?'content'[A-Z])\]\s?)))/";
        $INSTRUCTIONS_PATTERN = "/move (?'move'\d+) from (?'from'\d+) to (?'to'\d+)/i";

        foreach ($inputFile as $key => $line) {
            $instructions = [];
            // if (preg_match($STACKS_PATTERN, $line, $instructions)) {
            //     var_dump($instructions);
            //     die();
            // } else            
            if (preg_match($INSTRUCTIONS_PATTERN, $line, $instructions)) {
                echo "==== $line\n";
                foreach (range(1, (int)$instructions['move']) as $number) {
                    $origin = &$STACKS[$instructions['from']];
                    if (!empty($origin)) {
                        $crate = array_pop($origin);
                        array_push($STACKS[$instructions['to']], $crate);
                    }
                }
                // echo "1 : " . implode('-', $STACKS['1']) . "\n";
                // echo "2 : " . implode('-', $STACKS['2']) . "\n";
                // echo "3 : " . implode('-', $STACKS['3']) . "\n";
            }
        }
        $result = "";
        foreach (array_keys($STACKS) as $key) {
            $result .= end($STACKS[$key]);
        }
        return $result;
    }

    public static function secondChallenge($inputFile)
    {
        echo "Solving the second challenge : $inputFile\n";


        // $STACKS = [
        //     '1' => ['Z', 'N'],
        //     '2' => ['M', 'C', 'D'],
        //     '3' => ['P']
        // ];

        $STACKS = [
            '1' => ['S', 'C', 'V', 'N'],
            '2' => ['Z', 'M',  'J', 'H', 'N', 'S'],
            '3' => ['M', 'C', 'T', 'G', 'J', 'N', 'D'],
            '4' => ['T', 'D', 'F', 'J', 'W', 'R', 'M'],
            '5' => ['P', 'F', 'H'],
            '6' => ['C', 'T', 'Z', 'H', 'J'],
            '7' => ['D', 'P', 'R', 'Q', 'F', 'S', 'L', 'Z'],
            '8' => ['C', 'S', 'L', 'H', 'D', 'F', 'P', 'W'],
            '9' => ['D', 'S', 'M', 'P', 'F', 'N', 'G', 'Z'],
        ];

        $INSTRUCTIONS_PATTERN = "/move (?'move'\d+) from (?'from'\d+) to (?'to'\d+)/i";
        foreach ($inputFile as $key => $line) {
            $instructions = [];
            if (preg_match($INSTRUCTIONS_PATTERN, $line, $instructions)) {
                $crane = [];
                foreach (range(1, (int)$instructions['move']) as $number) {
                    $origin = &$STACKS[$instructions['from']];
                    if (!empty($origin)) {
                        $crate = array_pop($origin);
                        array_push($crane, $crate);
                    }
                }
                foreach ($crane as $crate) {
                    $crate = array_pop($crane);
                    array_push($STACKS[$instructions['to']], $crate);
                }
            }
        }
        $result = "";
        foreach (array_keys($STACKS) as $key) {
            $result .= end($STACKS[$key]);
        }
        return $result;
    }
}
