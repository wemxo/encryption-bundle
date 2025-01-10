<?php

declare(strict_types=1);

namespace Wemxo\EncryptionBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Wemxo\EncryptionBundle\DependencyInjection\CompilerPass\EncryptionCompilerPass;

class EncryptionBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new EncryptionCompilerPass());
    }
}
