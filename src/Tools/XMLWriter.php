<?php

namespace BumpVersion\Tools;

use Mtownsend\XmlToArray\XmlToArray as XML;
use RuntimeException;
use XMLParser\XMLParser;

class XMLWriter
{
    public static function write(string $version, string $content): string
    {
        $data = XML::convert(xml: $content, outputRoot: true);
        $rootElementName = data_get(target: $data, key: '@root');

        // Set new version in array
        $data = data_set(target: $data,
                         key: config(key: 'bump-version.version_key'),
                         value: $version);

        // We need to remove the @root key to avoid duplication
        unset($data['@root']);

        // Re-convert array to XML
        $xml = XMLParser::encode(data: $data, root: $rootElementName);

        $result = $xml->asXML();

        if ($result === false) {
            throw new RuntimeException(message: 'Failed to serialize XML version data.');
        }

        return $result;
    }
}
