<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy;

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
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(array $config, private readonly ContainerInterface $container)
    {
        Debugger::$dumpTheme = $config['dumpTheme'];
        Debugger::$editor = $config['editor'];
        Debugger::$editorMapping = $config['editorMapping'];
        Debugger::$keysToHide = $config['keysToHide'];
        Debugger::$maxDepth = $config['maxDepth'];
        Debugger::$maxLength = $config['maxLength'];
        Debugger::$maxItems = $config['maxItems'];
        Debugger::$scream = $config['scream'];
        Debugger::$showLocation = $config['showLocation'];
        Debugger::$strictMode = $config['strictMode'];
        Debugger::$time = array_key_exists('REQUEST_TIME_FLOAT', $_SERVER)
            ? $_SERVER['REQUEST_TIME_FLOAT']
            : microtime(true)
        ;

        Debugger::enable(
            mode: $config['mode'],
            logDirectory: $container->get('Yiisoft\Aliases\Aliases')->get($config['logDirectory']),
            email: $config['email']
        );


        if (!is_null($config['emailSnooze'])) {
            Debugger::getLogger()->emailSnooze = $config['emailSnooze'];
        }

        $this->addPanels($config['panels'], Debugger::getBar());
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
            $bar->addPanel(
                $factory
                    ->create($config)
                    ->setContainer($this->container)
                ,
                $id
            );
        }
    }
}