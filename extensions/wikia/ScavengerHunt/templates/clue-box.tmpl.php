<div class="scavengerhunt-clue-box">
<?php if (!empty($title)) {?>
	<div class="title"><?= $title ?></div>
<?php } ?>
<?php if (!empty($text)) { ?>
	<p class="text"><?= $text ?></p>
<?php } ?>
	<a class="wikia-button button clue-button" href="<?= htmlspecialchars($buttonTarget) ?>"><?= $buttonText ?></a>
	<img src="<?= htmlspecialchars($image) ?>" class="image" style="<?= $imageStyle ?>" />
</div>