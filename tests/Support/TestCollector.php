<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Tests\Support;

use Yiisoft\Yii\Debug\Collector\CollectorTrait;
use Yiisoft\Yii\Debug\Collector\SummaryCollectorInterface;

class TestCollector implements SummaryCollectorInterface
{
    use CollectorTrait;

    /**
     * @psalm-var non-empty-array<string, int>
     */
    private array $collected = [
        'Bashful' => 0,
        'Doc' => 0,
        'Dopey' => 0,
        'Grumpy' => 0,
        'Happy' => 0,
        'Sleepy' => 0,
        'Sneezy' => 0,
    ];

    public function collect(string $name): void
    {
        $this->collected[$name]++;
    }

    public function getCollected(): array
    {
        return $this->collected;
    }

    public function getSummary(): array
    {
        return [
            'count' => array_reduce($this->collected, fn(int $carry, int $item): int => $carry + $item , 0)
        ];
    }

    public function reset(): void
    {
        array_walk($this->collected, fn(int &$value) => $value = 0);
    }
}