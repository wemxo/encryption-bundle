<?php

declare(strict_types=1);

namespace Wemxo\EncryptionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('encryption');

        $treeBuilder->getRootNode()
            ->useAttributeAsKey('name')
            ->arrayPrototype()
                ->children()
                    ->scalarNode('encryption_key')
                        ->isRequired()
                        ->cannotBeEmpty()
                        ->info('Encryption key used for this configuration')
                    ->end()
                    ->scalarNode('cypher_algorithm')
                        ->defaultValue('aes256')
                        ->info('Cypher algorithm used for encryption')
                    ->end()
                    ->scalarNode('digest_method')
                        ->defaultValue('sha512')
                        ->info('Digest method used for encryption')
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
