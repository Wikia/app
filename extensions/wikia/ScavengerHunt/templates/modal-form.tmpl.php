<div class="scavenger-clue-text">
	<?= $text ?>
</div>
<div class="scavenger-clue-question">
	<?= $question ?>
</div>
<form class="scavenger-entry-form">
	<textarea name="answer"></textarea>
	<label for="name"><?= wfMsg('scavengerhunt-entry-form-name') ?></label>
	<input type="text" name="name" />
	<label for="email"><?= wfMsg('scavengerhunt-entry-form-email') ?></label>
	<input type="text" name="email" />
	<div class="scavenger-clue-button">
		<input type="submit" class="wikia-button" value="<?= wfMsg('scavengerhunt-entry-form-submit') ?>"/>
	</div>
</form>
<img class="scavenger-clue-image" src="<?= $imageSrc ?>" style="top:<?= $imageOffset['top'] ?>px; left:<?= $imageOffset['left'] ?>px">