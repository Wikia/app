<div class="scavenger-clue-text">
	<?= $text ?>
</div>
<?php if (!empty($buttonTarget)) { ?>
<div class="scavenger-clue-button">
	<a class="button" href="<?= $buttonTarget ?>"><?= $buttonText ?></a>
</div>
<?php } ?>
<img class="scavenger-clue-image" src="<?= $imageSrc ?>" style="top:<?= $imageOffset['top'] ?>px; left:<?= $imageOffset['left'] ?>px">