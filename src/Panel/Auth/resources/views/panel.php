<?php /** @var \Yiisoft\Userr\CurrentUser $currentUser */ ?>
<table>
    <tbody>
    <tr>
        <th>ID</th>
        <td><?= $currentUser->isGuest() ? 'Guest' : $currentUser->getId() ?></td>
    </tr>
    </tbody>
</table>