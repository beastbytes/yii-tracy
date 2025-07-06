<?php

declare(strict_types=1);

/**
 * @var array $collected
 */


use BeastBytes\Yii\Tracy\Helper;

$rows = [];
foreach ($collected as $name => $count) {
    $rows[] = [$name, $count];
}

echo Helper::table($rows);
