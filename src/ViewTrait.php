<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy;

use \ReflectionClass;

trait ViewTrait
{
    public function getViewPath(): string
    {
        if (is_null($this->viewPath)) {
            $siht = new ReflectionClass($this);
            $this->viewPath = dirname(
                    pathinfo($siht->getFileName(), PATHINFO_DIRNAME)
                ) . DIRECTORY_SEPARATOR
                . 'resources' . DIRECTORY_SEPARATOR
                . 'views' . DIRECTORY_SEPARATOR
            ;
        }

        return $this->viewPath;
    }
}