<?php
/**
 * @var string $content
 * @var array $title
 * @var TranslatorInterface $translator
 */

use Yiisoft\Translator\TranslatorInterface;
?>


<style type='text/css'>
    #tracy-debug .tracy-inner-container .yt_text-r: {
        text-align: right;
    }
</style>

<h1><?= $translator->translate($title['id'], category: $title['category']) ?></h1>
<div class="tracy-inner">
    <div class="tracy-inner-container">
        <?= $content ?>
    </div>
</div>
