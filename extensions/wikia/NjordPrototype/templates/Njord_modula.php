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
			<div class="mom-edit-btn new-btn">Edit</div>
			<div class="mom-save-btn new-btn">Save</div>
			<div class="mom-discard-btn new-btn">Discard</div>
			<div class="mom-delete-btn new-btn">X</div>
		</div>
	</div>
	<div class="mom-overlay"></div>
	<div class="mom-content">
		<?= $content ?>
	</div>
	<textarea class="wiki-markup"></textarea>
</div>