<?php

namespace BumpVersion\Tools;

use Mtownsend\XmlToArray\XmlToArray as XML;

class XMLReader
{
    public static function read(string $content): string
    {
        return data_get(target: XML::convert(xml: $content),
                        key: config(key: 'bump-version.version_key'));
    }
}
