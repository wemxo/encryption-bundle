# Encryption

> The encryption bundle is a symfony bundle that allow you to encrypt and decrypt sensitive data based on a given encryption key, sipher algorithm and digest method.

#### Usage

1- Configuration

```
# /config/packages/encryption.yaml
encryption:
    password:
        encryption_key: hO!}098iKko_hf
    email:
        encryption_key: '%my_key_parameter%'
        cypher_algorithm: aes128
        digest_method: md5
```

> With this configuration, you will have access to a private service (instance of `Wemxo\EncryptionBundle\Encryption\EncryptionInterface`) in container named `@wemxo.encryption.password` with an alias `$passwordEncryption`.

2- Example

```
<?php

namespace App;

classe MyService {
    
    public function __construct(private EncryptionInterface $passwordEncryption, private EncryptionInterface $emailEncryption)
    {
    }
    
    public function testEncryptPassword(string $text): string
    {
        return $this->passwordEncryption->encrypt($text);
    }
    
    public function testDecryptPassword(string $text): string
    {
        return $this->passwordEncryption->decrypt($text);
    }
}
```
