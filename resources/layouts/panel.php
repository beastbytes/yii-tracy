<?php
/**
 * @var string $content
 * @var array $title
 * @var TranslatorInterface $translator
 */

use Yiisoft\Translator\TranslatorInterface;
?>
<h1><?= $translator->translate($title['id'], category: $title['category']) ?></h1>
<div class="tracy-inner"><div class="tracy-inner-container"><?= $content ?></div></div>