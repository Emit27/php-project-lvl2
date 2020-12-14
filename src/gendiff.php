<?php

namespace Differ\genDiff;

use function funct\Collection\union;

function getFileContent($path)
{
    $pathToFile = realpath($path);

    if ($pathToFile === false) {
        throw new \Exception("the file cannot be read along the given path'{$path}'");
    }

    $fileContent = file_get_contents($pathToFile);
    $data = json_decode($fileContent, true);
    ksort($data);
    $result = array_reduce(array_keys($data), function ($acc, $key) use ($data) {
        if (is_bool($data[$key])) {
            $acc[$key] = boolval($data[$key]) ? 'true' : 'false';
        } else {
            $acc[$key] = $data[$key];
        }
        return $acc;
    }, []);
    return $result;
}

function compareData(array $file1, array $file2)
{
    $filesUnion = union(array_keys($file1), array_keys($file2));

    $result = array_reduce(
        $filesUnion,
        function ($acc, $item) use ($file1, $file2) {
            if (!isset($file1[$item])) {
                $acc[] = " + $item: {$file2[$item]}";
            } elseif (!isset($file2[$item])) {
                $acc[] = " - $item: {$file1[$item]}";
            } elseif ($file1[$item] === $file2[$item]) {
                $acc[] = "   $item: {$file2[$item]}";
            } else {
                $acc[] = " - $item: {$file1[$item]}";
                $acc[] = " + $item: {$file2[$item]}";
            }
            return $acc;
        },
        []
    );
    return $result;
}

function genDiff($pathToFile1, $pathToFile2)
{
    try {
        $firstFile = getFileContent($pathToFile1);
        $secondFile = getFileContent($pathToFile2);
    } catch (\Exception $e) {
        echo $e;
        exit();
    }

    $data = compareData($firstFile, $secondFile);
    $result = implode(PHP_EOL, $data);
    return "{\r\n$result\r\n}";
}
