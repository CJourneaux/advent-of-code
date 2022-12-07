<?php

require 'Day.php';

class Day07 implements Day
{
    // - / (dir)
    //   - a (dir)
    //     - e (dir)
    //       - i (file, size=584)
    //     - f (file, size=29116)
    //     - g (file, size=2557)
    //     - h.lst (file, size=62596)
    //   - b.txt (file, size=14848514)
    //   - c.dat (file, size=8504156)
    //   - d (dir)
    //     - j (file, size=4060174)
    //     - d.log (file, size=8033020)
    //     - d.ext (file, size=5626152)
    //     - k (file, size=7214296)


    private static function initFileSystem($inputFile)
    {
        $fileSystem = [];
        $cwd = [];

        $PATTERNS = [
            'MOVE' => "/\\$ cd (?'destination'.+)/",
            "DIR" => "/dir (?'dirName'.+)/",
            'FILE' => "/(?'size'\d+) (?'fileName'.+)/",
        ];

        foreach ($inputFile as $key => $line) {
            if (!empty($line)) {
                $data = [];
                if (preg_match($PATTERNS['MOVE'], $line, $data)) {
                    self::changeWorkingDirectory($cwd, $data['destination']);
                } else if (preg_match($PATTERNS['DIR'], $line, $data)) {
                    self::makeDirectory($fileSystem, $cwd, $data['dirName']);
                } else if (preg_match($PATTERNS['FILE'], $line, $data)) {
                    self::makeFile($fileSystem, $cwd, $data['fileName'], $data['size']);
                }
            }
        }

        return $fileSystem;
    }

    private static function changeWorkingDirectory(&$current, $destination)
    {
        switch ($destination) {
            case "/":
                $current = [];
                break;
            case "..":
                array_pop($current);
                break;
            default:
                array_push($current, $destination);
                break;
        }
    }

    private static function makeDirectory(&$fileSystem, $path, $newDir)
    {
        $cwd = &$fileSystem;
        foreach ($path as $dir) {
            $cwd = &$cwd[$dir];
        }
        $cwd[$newDir] = [];
    }

    private static function makeFile(&$fileSystem, $path, $newFile, $fileSize)
    {
        $cwd = &$fileSystem;
        foreach ($path as $dir) {
            $cwd = &$cwd[$dir];
        }
        $cwd[$newFile] = (int)$fileSize;
    }

    private static function getSize($currentPath)
    {
        $totalSize = 0;
        if (is_array($currentPath)) {
            foreach ($currentPath as $subElement) {
                $totalSize += self::getSize($subElement);
            }
        } else {
            $totalSize = $currentPath;
        }
        // echo "  Computed size $totalSize\n";
        return $totalSize;
    }

    public static function firstChallenge($inputFile)
    {
        $fileName = $inputFile->getBaseName('.txt');
        echo "Solving the first challenge : $fileName\n";

        $fileSystem = self::initFileSystem($inputFile);

        $fileSizesUnderLimit = [];
        $isDirUnderSizeLimit = function ($dir, $maxSizeLimit) use (&$fileSizesUnderLimit, &$isDirUnderSizeLimit) {
            foreach ($dir as $name => $currentDirContent) {
                if (is_array($currentDirContent)) {
                    $size = self::getSize($currentDirContent);
                    // echo "**** Obtained size $size\n";
                    if ($size <= $maxSizeLimit) {
                        $fileSizesUnderLimit[] = $size;
                    }
                    $isDirUnderSizeLimit($currentDirContent, $maxSizeLimit);
                }
            }
        };
        $isDirUnderSizeLimit($fileSystem, 100000);

        return array_sum($fileSizesUnderLimit);
    }

    public static function secondChallenge($inputFile)
    {
        $fileName = $inputFile->getBaseName('.txt');
        echo "Solving the second challenge : $fileName\n";

        $fileSystem = self::initFileSystem($inputFile);

        $totalSystemSize = self::getSize($fileSystem);
        $minFreeSpace = 30000000;

        $isDirUnderSizeLimit = function ($dir, $maxSizeLimit, &$fileSizesUnderLimit = []) use (&$isDirUnderSizeLimit) {
            foreach ($dir as $name => $currentDirContent) {
                if (is_array($currentDirContent)) {
                    $size = self::getSize($currentDirContent);
                    // echo "**** Obtained size $size\n";
                    if ($size <= $maxSizeLimit) {
                        $fileSizesUnderLimit[] = $size;
                    }
                    $isDirUnderSizeLimit($currentDirContent, $maxSizeLimit, $fileSizesUnderLimit);
                }
            }
            return $fileSizesUnderLimit;
        };
        // echo "Total size : $totalSystemSize\n";

        $minSpaceToDelete = $totalSystemSize - (70000000 - $minFreeSpace);

        $fileSizesUnderLimit = $isDirUnderSizeLimit($fileSystem, $minFreeSpace);
        sort($fileSizesUnderLimit);

        // echo "Min space to free : $minSpaceToDelete\n";

        foreach ($fileSizesUnderLimit as $dirSize) {
            if ($dirSize >= $minSpaceToDelete) {
                return $dirSize;
            }
        }

        echo "No directory matching criteria found\n";
        return -1;
    }
}
