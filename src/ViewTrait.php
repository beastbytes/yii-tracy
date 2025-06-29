<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy;

trait ViewTrait
{
    public function getViewPath(): string
    {
        if (is_null($this->viewPath)) {
            $this->viewPath = dirname(__DIR__) . DIRECTORY_SEPARATOR
                . 'resources' . DIRECTORY_SEPARATOR
                . 'views' . DIRECTORY_SEPARATOR
            ;
        }

        return $this->viewPath;
    }
}