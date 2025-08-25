<?php

declare(strict_types=1);

namespace Wemxo\EncryptionBundle\Encryption;

use Wemxo\EncryptionBundle\Exception\EncryptionException;

class Encryption implements EncryptionInterface
{
    private string $encryptionKey;

    private string $cipherAlgorithm;

    private string $digestMethod;

    private int $iVectorLength;

    private bool $deterministic;

    public function __construct(string $encryptionKey, string $cipherAlgorithm, string $digestMethod, int $iVectorLength, bool $deterministic = false)
    {
        $this->encryptionKey = $encryptionKey;
        $this->cipherAlgorithm = $cipherAlgorithm;
        $this->digestMethod = $digestMethod;
        $this->iVectorLength = $iVectorLength;
        $this->deterministic = $deterministic;
    }

    public function encrypt(string $text): string
    {
        $hash = openssl_digest($this->encryptionKey, $this->digestMethod, true);
        if ($this->deterministic) {
            $iVector = substr(
                hash_hmac('sha256', $text, $this->encryptionKey, true),
                0,
                $this->iVectorLength
            );
        } else {
            $iVector = random_bytes($this->iVectorLength);
        }

        $encrypted = openssl_encrypt($text, $this->cipherAlgorithm, $hash, OPENSSL_RAW_DATA, $iVector);
        if (false === $encrypted) {
            throw new EncryptionException(openssl_error_string());
        }

        return base64_encode($iVector.$encrypted);
    }

    public function decrypt(string $text): string
    {
        $hash = openssl_digest($this->encryptionKey, $this->digestMethod, true);
        $rawData = base64_decode($text);
        if (strlen($rawData) < $this->iVectorLength) {
            throw new EncryptionException(sprintf('%s Data is too short', __METHOD__));
        }

        $iVector = substr($rawData, 0, $this->iVectorLength);
        $rawtext = substr($rawData, $this->iVectorLength);
        $decrypted = openssl_decrypt($rawtext, $this->cipherAlgorithm, $hash, OPENSSL_RAW_DATA, $iVector);
        if (false === $decrypted) {
            throw new EncryptionException(openssl_error_string());
        }

        return $decrypted;
    }
}
