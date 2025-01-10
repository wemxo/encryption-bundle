<?php

declare(strict_types=1);

namespace Wemxo\EncryptionBundle\Tests\Utils\Helper;

use PHPUnit\Framework\TestCase;
use Wemxo\EncryptionBundle\Utils\Helper\StringHelper;

class StringHelperTest extends TestCase
{
    public function testToCamelCase(): void
    {
        $this->assertSame('myOutputResult', StringHelper::toCamelCase('my_output_result'));
    }
}
