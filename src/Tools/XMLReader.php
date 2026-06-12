<?php

namespace BumpVersion\Tools;

use Illuminate\Support\Facades\Log;
use Mtownsend\XmlToArray\XmlToArray as XML;
use Throwable;

class XMLReader
{
    public static function read(string $content): ?string
    {
        try {
            return data_get(target: XML::convert(xml: $content),
                            key: config(key: 'bump-version.version_key'));
        } catch (Throwable $exception) {
            // Generate logs adding the exception and content information
            Log::error(message: 'XML convert fails',
                       context: ['exception' => $exception, 'content' => $content]);

            // Return null when the XML cannot be parsed, so the caller can use its fallback.
            return null;
        }
    }
}
