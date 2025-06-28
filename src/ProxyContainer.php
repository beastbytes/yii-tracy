<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy;

use Psr\Container\ContainerInterface;

class ProxyContainer implements ContainerInterface
{
    private array $services = [];

    public function __construct(private ContainerInterface $container)
    {
    }

    public function add(string $id, $proxy)
    {
        $this->services[$id] = $proxy;
    }

    public function get(string $id): mixed
    {
        if (array_key_exists($id, $this->services)) {
            return $this->services[$id];
        }

        return $this
            ->container
            ->get($id)
        ;
    }

    public function has(string $id): bool
    {
        if (!array_key_exists($id, $this->services)) {
            return $this
                ->container
                ->has($id)
            ;
        }

        return true;
    }
}