<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Tests\Support;

class TestService
{
    public function greet(string $name): void
    {
        // Empty - all the action is the proxy
    }
}