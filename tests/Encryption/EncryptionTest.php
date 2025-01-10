<?php

declare(strict_types=1);

namespace Wemxo\EncryptionBundle\Tests\Encryption;

use PHPUnit\Framework\TestCase;
use Wemxo\EncryptionBundle\Encryption\EncryptionFactory;

class EncryptionTest extends TestCase
{
    public function test(): void
    {
        $plainValue = 'some plain value';
        $encryption = EncryptionFactory::create('secret_key', 'aes256', 'md5');
        $encryptValue = $encryption->encrypt($plainValue);
        $this->assertSame($plainValue, $encryption->decrypt($encryptValue));
        $this->assertNotSame('fault value', $encryption->decrypt($encryptValue));
    }
}
