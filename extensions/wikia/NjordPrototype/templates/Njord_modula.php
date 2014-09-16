<?php
/**
 * @var Mixed $content
 * @var string $align
 */
?>

<div class="mom-module mom-module-<?= $align ?>" data-title="<?= $ctitle ?>">
	<div class="mom-bar">
		<div class="mom-bar-content">bar</div>
		<div class="btn-group-right">
			<div class="mom-delete-btn new-btn">X</div>
		</div>
	</div>
	<div class="mom-overlay"></div>
	<div class="mom-content">
		<?= $content ?>
	</div>
</div>