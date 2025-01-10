<?php

declare(strict_types=1);

namespace Wemxo\EncryptionBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Wemxo\EncryptionBundle\Encryption\EncryptionFactory;
use Wemxo\EncryptionBundle\Encryption\EncryptionInterface;
use Wemxo\EncryptionBundle\Utils\Helper\StringHelper;

class EncryptionExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configs = $this->processConfiguration(new Configuration(), $configs);
        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../../config')
        );
        $loader->load('services.xml');
        $this->processEncryptionConfig($configs, $container);
    }

    private function processEncryptionConfig(array $configs, ContainerBuilder $container): void
    {
        if (empty($configs)) {
            return;
        }

        foreach ($configs as $encryptionName => $encryptionConfig) {
            $serviceId = sprintf('wemxo.encryption.%s', $encryptionName);
            $container
                ->register($serviceId, EncryptionInterface::class)
                ->setFactory([EncryptionFactory::class, 'create'])
                ->setArguments([
                    $encryptionConfig['encryption_key'],
                    $encryptionConfig['cypher_algorithm'],
                    $encryptionConfig['digest_method'],
                ])
                ->setPublic(false)
            ;
            $alias = sprintf('%s $%sEncryption', EncryptionInterface::class, StringHelper::toCamelCase($encryptionName));
            $container->setAlias($alias, $serviceId);
        }
    }
}
