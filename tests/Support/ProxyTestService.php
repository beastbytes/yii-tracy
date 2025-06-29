<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Tests\Support;

class ProxyTestService
{
    public function __construct(
        private readonly TestService $decorated,
        private readonly TestCollector $collector
    ) {
    }

    public function greet(string $name): void
    {
        $this->decorated->greet($name);
        $this->collector->collect($name);
    }
}