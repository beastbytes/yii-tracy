<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy;

use Psr\Container\ContainerInterface;
use Yiisoft\Di\ServiceProviderInterface;

final class ContainerServiceProvider implements ServiceProviderInterface
{
    public function getDefinitions(): array
    {
        return [
            ContainerInterface::class => ProxyContainer::class
        ];
    }

    public function getExtensions(): array
    {
        return [];
    }
}
