<?php

declare(strict_types=1);

use BeastBytes\Yii\Tracy\Tracy;
use Psr\Container\ContainerInterface;

/** @var array $params */

return [
    static function (ContainerInterface $container) use ($params) {
        return new Tracy($params['beastbytes/yii-tracy'], $container);
    }
];