<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Panel;

interface CollectorPanelInterface
{
    public function getCollected(): array;

    public function getName(): string;

    public function getSummary(): array;

    public function shutdown(): void;

    public function startup(): void;
}