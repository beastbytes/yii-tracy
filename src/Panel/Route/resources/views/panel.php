<?php /** @var array{string: string} $rows */ ?>
<h1>Route</h1>
<div class='tracy-inner'>
    <div class='tracy-inner-container'>
        <table>
            <tbody>
                <?php foreach ($rows as $key => $value): ?>
                <th><?= $key ?></th><td><?= $value ?></td>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>