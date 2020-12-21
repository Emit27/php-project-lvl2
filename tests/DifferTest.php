<?php

namespace Differ\Test;

use PHPUnit\Framework\TestCase;

use function Differ\genDiff\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiffJson()
    {
        $firstFile = __DIR__ . '/fixtures/file1.json';
        $secondFile = __DIR__ . '/fixtures/file2.json';
        $expected = file_get_contents(__DIR__ . '/fixtures/resultJson.txt');
        $result = genDiff($firstFile, $secondFile);
        $this->assertEquals($expected, $result);
    }
}
