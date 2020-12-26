<?php

namespace Differ\parsers;

use Symfony\Component\Yaml\Yaml;

function selectParser($content, $path)
{
    switch ($path) {
        case 'json':
            return json_decode($content, true, JSON_THROW_ON_ERROR);
        case 'yaml':
        case 'yml':
            $data = Yaml::parse($content, Yaml::PARSE_OBJECT_FOR_MAP);
            return (array) $data;
        default:
            throw new \Exception("Unsupported {$path} expansion format");
    }
}
