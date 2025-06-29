<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final class ProxyContainer implements ContainerInterface
{
    public const BYPASS = '*';

    private array $services = [];

    public function __construct(private ContainerInterface $container)
    {
    }

    public function add(string $id, $proxy)
    {
        $this->services[$id] = $proxy;
    }

    /**
     * @param string $id ID of container item. Prefix with self::BYPASS to bypass the proxy container
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function get(string $id): mixed
    {
        if (str_starts_with($id, self::BYPASS)) {
            $bypass = true;
            $id = substr($id, strlen(self::BYPASS));
        } else {
            $bypass = false;
        }

        if (!$bypass && array_key_exists($id, $this->services)) {
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