<?php /** @var \Yiisoft\Userr\CurrentUser $currentUser */ ?>
User: <?= $currentUser->isGuest() ? 'Guest' : $currentUser->getId() ?>
