<?php

declare(strict_types=1);

namespace Wemxo\EncryptionBundle\Encryption;

use Wemxo\EncryptionBundle\Exception\EncryptionException;

class EncryptionFactory
{
    /**
     * Create an instance of Encryption class by injecting given config.
     *
     * @throws EncryptionException
     */
    public static function create(string $encryptionKey, string $cipherAlgorithm, string $digestMethod, bool $deterministic = false): EncryptionInterface
    {
        if (!in_array($cipherAlgorithm, openssl_get_cipher_methods(true))) {
            throw new EncryptionException(sprintf('Invalid CIPHER ALGORITHM given [%s]', $cipherAlgorithm));
        }

        if (!in_array($digestMethod, openssl_get_md_methods(true))) {
            throw new EncryptionException(sprintf('Invalid DIGEST METHOD given [%s]', $digestMethod));
        }

        $vectorLength = openssl_cipher_iv_length($cipherAlgorithm);

        return new Encryption(
            $encryptionKey,
            $cipherAlgorithm,
            $digestMethod,
            $vectorLength,
            $deterministic
        );
    }
}
