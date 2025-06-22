<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Panel;

use Psr\Container\ContainerInterface;

abstract class Panel
{
    protected ContainerInterface $container;
    protected ?array $viewParameters = null;
    protected ?string $viewPath = null;

    abstract protected function getViewParameters(): array;

    public function setContainer(ContainerInterface $container): self
    {
        $this->container = $container;
        return $this;
    }

    protected function render(string $view): string
    {
        extract($this->getViewParameters());

        ob_start();
        require $view;

        return ob_get_clean();
    }

    private function getViewPath(): string
    {
        if (is_null($this->viewPath)) {
            $this->viewPath = __DIR__ . DIRECTORY_SEPARATOR
                . ucfirst(get_class()) . DIRECTORY_SEPARATOR
                . 'resources' . DIRECTORY_SEPARATOR
                . 'views' . DIRECTORY_SEPARATOR
                . '.php'
            ;
        }

        return $this->viewPath;
    }
}