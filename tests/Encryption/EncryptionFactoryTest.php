<?php

declare(strict_types=1);

namespace Wemxo\EncryptionBundle\Tests\Encryption;

use PHPUnit\Framework\TestCase;
use Wemxo\EncryptionBundle\Encryption\EncryptionFactory;
use Wemxo\EncryptionBundle\Encryption\EncryptionInterface;
use Wemxo\EncryptionBundle\Exception\EncryptionException;

class EncryptionFactoryTest extends TestCase
{
    /**
     * @dataProvider createFailDataProvider
     */
    public function testCreateFail(string $key, string $algorithm, string $method, string $expectedError): void
    {
        $this->expectException(EncryptionException::class);
        $this->expectExceptionMessage($expectedError);

        EncryptionFactory::create($key, $algorithm, $method);
    }

    /**
     * @dataProvider createSuccessDataProvider
     */
    public function testCreateSuccess(string $key, string $algorithm, string $method): void
    {
        $encryption = EncryptionFactory::create($key, $algorithm, $method);
        $this->assertInstanceOf(EncryptionInterface::class, $encryption);
        $reflection = new \ReflectionClass($encryption);
        $encryptionKeyProperty = $reflection->getProperty('encryptionKey');
        $encryptionKeyProperty->setAccessible(true);
        $cipherAlgorithmProperty = $reflection->getProperty('cipherAlgorithm');
        $cipherAlgorithmProperty->setAccessible(true);
        $digestMethodProperty = $reflection->getProperty('digestMethod');
        $digestMethodProperty->setAccessible(true);
        $this->assertSame($key, $encryptionKeyProperty->getValue($encryption));
        $this->assertSame($algorithm, $cipherAlgorithmProperty->getValue($encryption));
        $this->assertSame($method, $digestMethodProperty->getValue($encryption));
    }

    public function createFailDataProvider(): \Generator
    {
        yield ['key_1', 'fail', 'sha256', 'Invalid CIPHER ALGORITHM given [fail]'];

        yield ['key_1', 'aes256', 'fail', 'Invalid DIGEST METHOD given [fail]'];
    }

    public function createSuccessDataProvider(): \Generator
    {
        yield ['key_1', 'aes256', 'sha256'];

        yield ['key_1', 'aes128', 'sha256'];

        yield ['key_1', 'des', 'sha256'];

        yield ['key_1', 'aes256', 'sha512'];

        yield ['key_1', 'aes128', 'sha512'];

        yield ['key_1', 'des', 'sha512'];

        yield ['key_1', 'aes256', 'md5'];

        yield ['key_1', 'aes128', 'md5'];

        yield ['key_1', 'des', 'md5'];
    }
}
