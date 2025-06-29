<?php

declare(strict_types=1);

/**
 * @var array $collected
 */
?>
<table><tbody><?php foreach ($collected as $name => $count):
    printf("<tr><td>%s</td><td>%d</td></tr>", $name, $count);
endforeach; ?></tbody></table>
