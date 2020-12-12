<?php

namespace Differ\cli;

use function Differ\genDiff\genDiff;

function run()
{
    $doc = <<<'DOCOPT'
    Generate diff

    Usage:
        gendiff (-h|--help)
        gendiff (-v|--version)
        gendiff [--format <fmt>] <firstFile> <secondFile>

    Options:
        -h --help                     Show this screen
        -v --version                  Show version
        --format <fmt>                Report format [default: pretty]

    DOCOPT;

    $params = [
        'argv' => array_slice($_SERVER['argv'], 1),
        'help' => true,
        'version' => 'version 1.0.cr2',
        'optionsFirst' => false,
    ];
    $arguments = \Docopt::handle($doc, $params)->args;
}
