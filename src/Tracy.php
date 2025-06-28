<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy;

use BeastBytes\Yii\Tracy\Panel\CollectorPanelInterface;
use BeastBytes\Yii\Tracy\Panel\Panel;
use BeastBytes\Yii\Tracy\Panel\ServiceCollectorPanel;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Tracy\Bar;
use Tracy\Debugger;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\Factory;
use Yiisoft\Factory\NotFoundException;

class Tracy
{
    /**
     * @param array $config
     * @psalm-param array{
     *     mode: null|bool|string|string[], //
     *     dumpTheme: string, //
     *     keysToHide: string[], //
     *     maxDepth: int, //
     *     maxLength: int, //
     *     maxItems: int, //
     *     scream: bool, //
     *     showLocation: ?bool, //
     *     strictMode: bool, //
     *     enabled: bool, //
     *     showBar: bool, //
     *     editor: string, //
     *     editorMapping: array<string, string>, //
     *     email: null|array|string, //
     *     emailSnooze: ?string, //
     *     logDirectory: string, //
     *     logSeverity: int, //
     *     panels: array<string, array>, // panelId => panelDefinition
     * } $config
     * @param ContainerInterface $container
     */
    public function __construct(private array $config, private readonly ContainerInterface $container)
    {
    }

    /**
     * Enables the debugger.
     * Called as an ApplicationStartup event handler
     * @throws NotFoundExceptionInterface
     * @throws InvalidConfigException
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws NotInstantiableException
     * @throws CircularReferenceException
     */
    public function start(): void
    {
        Debugger::$dumpTheme = $this->config['dumpTheme'];
        Debugger::$editor = $this->config['editor'];
        Debugger::$editorMapping = $this->config['editorMapping'];
        Debugger::$keysToHide = $this->config['keysToHide'];
        Debugger::$maxDepth = $this->config['maxDepth'];
        Debugger::$maxLength = $this->config['maxLength'];
        Debugger::$maxItems = $this->config['maxItems'];
        Debugger::$scream = $this->config['scream'];
        Debugger::$showLocation = $this->config['showLocation'];
        Debugger::$strictMode = $this->config['strictMode'];
        Debugger::$time = array_key_exists('REQUEST_TIME_FLOAT', $_SERVER)
            ? $_SERVER['REQUEST_TIME_FLOAT']
            : microtime(true)
        ;

        Debugger::enable(
            mode: $this->config['mode'],
            logDirectory: $this
                ->container
                ->get('Yiisoft\Aliases\Aliases')
                ->get($this->config['logDirectory'])
            ,
            email: $this->config['email']
        );

        if (!is_null($this->config['emailSnooze'])) {
            Debugger::getLogger()->emailSnooze = $this->config['emailSnooze'];
        }

        $this->addPanels($this->config['panels'], Debugger::getBar());
    }

    /**
     * Shutsdown panel collectors. Called as an AfterEmit event handler. 
     */
    public function stop(): void
    {
        $bar = Debugger::getBar();
        
        foreach (array_keys($this->config['panels']) as $id) {
            $panel = $bar->getPanel($id);
            
            if ($panel instanceof CollectorPanelInterface) {
                $panel->getCollector()->shutdown();
            }
        }
    }

    /**
     * Add panels to the bar
     *
     * @param array $panels
     * @psalm-param array<string, array> $panels
     * @param Bar $bar
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     * @throws CircularReferenceException
     */
    private function addPanels(array $panels, Bar $bar): void
    {
        $factory = new Factory($this->container);

        foreach ($panels as $id => $config) {
            /** @var Panel $panel */
            $panel = $factory->create($config)
                ->withContainer($this->container)
            ;

            if ($panel instanceof CollectorPanelInterface) {
                $panel->start();
            }

            $bar->addPanel($panel, $id);
        }
    }
}