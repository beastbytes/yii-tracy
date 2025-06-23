<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Panel\Database;

use BeastBytes\Yii\Tracy\Panel\Panel;
use Yiisoft\Db\Debug\DatabaseCollector;

class Database extends Panel
{
    public function __construct(private DatabaseCollector $collector)
    {
    }

    /**
     * @inheritDoc
     */
    function getTab(): string
    {
        return $this->render(
            'tab',
            []
        );
    }

    /**
     * @inheritDoc
     */
    function getPanel(): string
    {
        return $this->render(
            'panel',
            []
        );
    }
}