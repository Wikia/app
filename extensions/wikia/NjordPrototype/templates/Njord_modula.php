<?php
/**
 * @var Mixed $content
 * @var string $align
 * @var string $ctitle
 * @var string $title
 */
?>

<div class="mom-module mom-module-<?= $align ?>" data-title="<?= $ctitle ?>">
	<div class="mom-bar">
		<div class="mom-bar-content"><?= $title ?></div>
		<div class="btn-group-right">
			<div class="mom-delete-btn new-btn">X</div>
		</div>
	</div>
	<div class="mom-overlay"></div>
	<div class="mom-content">
		<?= $content ?>
	</div>
</div>