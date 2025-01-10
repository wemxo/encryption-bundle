<?php

declare(strict_types=1);

namespace Wemxo\EncryptionBundle\Utils\Helper;

class StringHelper
{
    public static function toCamelCase(string $string): string
    {
        return lcfirst(str_replace(' ', '', ucwords(preg_replace('/[^a-zA-Z0-9]+/', ' ', $string))));
    }
}
