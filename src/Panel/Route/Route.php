<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Panel\Route;

use BeastBytes\Yii\Tracy\Panel\Panel;
use Tracy\IBarPanel;
use Yiisoft\Router\UrlMatcherInterface;

class Route extends Panel implements IBarPanel
{
    public function __construct(UrlMatcherInterface $urlMatcher)
    {
        $this->viewPath = __DIR__ . DIRECTORY_SEPARATOR
            . 'resources' . DIRECTORY_SEPARATOR
            . 'views' . DIRECTORY_SEPARATOR
            . '.php'
        ;
    }

    public function getTab(): string
    {
        return $this->render('tab');
    }

    public function getPanel(): string
    {
        return $this->render('panel');
    }

    protected function getViewParameters(): array
    {
        if (is_null($this->viewParameters)) {
            $currentRoute = $this->container->get('currentRoute');
            $this->viewParameters = [
                'rows' => [
                    'name' => $currentRoute->getName(),
                    'uri' => (string)$currentRoute->getUri(),
                    'pattern' => $currentRoute->getPattern(),
                ],
            ];
        }

        return $this->viewParameters;
    }
}