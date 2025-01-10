<?php

declare(strict_types=1);

namespace Wemxo\EncryptionBundle\Encryption;

use Wemxo\EncryptionBundle\Exception\EncryptionException;

interface EncryptionInterface
{
    /**
     * Encrypt the given text based on the injected algorithm and digest.
     *
     * @throws EncryptionException
     */
    public function encrypt(string $text): string;

    /**
     * Decrypt the given text based on the injected algorithm and digest.
     *
     * @throws EncryptionException
     */
    public function decrypt(string $text): string;
}
