<?php /** @var \Yiisoft\Router\CurrentRoute $currentRoute */ ?>
<table>
    <tbody>
    <tr>
        <th>Name</th>
        <td><?= $currentRoute->getName() ?></td>
    </tr>
    <tr>
        <th>URI</th>
        <td><?= $currentRoute->getUri() ?></td>
    </tr>
    <tr>
        <th>Pattern</th>
        <td><?= $currentRoute->getPattern() ?></td>
    </tr>
    </tbody>
</table>