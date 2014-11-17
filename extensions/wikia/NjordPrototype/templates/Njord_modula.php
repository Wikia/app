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
		<div class="mom-bar-info"></div>
		<div class="btn-group-right">
			<div class="mom-edit-btn new-btn">Edit</div>
			<div class="mom-delete-btn new-btn">X</div>
			<div class="mom-discard-btn new-btn">Discard</div>
			<div class="mom-save-btn new-btn">Publish</div>
		</div>
	</div>
	<div class="mom-overlay"></div>
	<div class="mom-content">
		<?= $content ?>
	</div>
	<div class="mom-wiki-markup"><textarea class="wiki-markup"></textarea></div>
</div>