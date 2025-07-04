<?php
/**
 * @var string $content
 * @var string $icon
 * @var array $title
 * @var TranslatorInterface $translator
 */

use Yiisoft\Translator\TranslatorInterface;

?>
<span title="<?= $translator->translate($title['id'], category: $title['category']) ?>">
    <?= $icon ?>
    <span class="tracy-label">
        <?= $content ?>
    </span>
</span>
