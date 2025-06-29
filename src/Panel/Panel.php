<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Panel;

use Psr\Container\ContainerInterface;
use Tracy\IBarPanel;
use Yiisoft\View\View;
use Yiisoft\View\ViewContextInterface;

abstract class Panel implements IBarPanel, ViewContextInterface
{
    protected ?ContainerInterface $container = null;
    protected ?string $viewPath = null;

    abstract public function getViewPath(): string;
    abstract protected function panelParameters(): array;
    abstract protected function panelTitle(): string;
    abstract protected function tabIcon(array $parameters): string;
    abstract protected function tabParameters(): array;
    abstract protected function tabTitle(): string;
    
    public function getPanel()
    {
        return $this->render('panel', $this->panelParameters());
    }

    public function getTab(): string
    {
        return $this->render('tab', $this->tabParameters());
    }

    public function withContainer(ContainerInterface $container): self
    {
        $new = clone $this;
        $new->container = $container;
        return $new;
    }

    protected function render(string $view, array $parameters): string
    {
        $renderer = $this
            ->container
            ->get(View::class)
            ->withBasePath(dirname(__DIR__, 2))
            ->withContext($this)
        ;
        
        $content = $renderer->render($view, $parameters);
        
        if ($view === 'panel') {
            $parameters['title'] = $this->panelTitle();
        } else {
            $parameters['icon'] = $this->tabIcon($parameters);
            $parameters['title'] = $this->tabTitle();
        }
        
        $parameters['content'] = $content;
        
        return $renderer->render("//resources/layouts/$view.php", $parameters);
    }
}