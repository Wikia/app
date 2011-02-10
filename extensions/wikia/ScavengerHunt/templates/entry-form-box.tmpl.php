<div class="scavengerhunt-entry-form">
	<h1><?= $title ?></h1>
	<p class="text"><?= $text ?></p>
	<form>
		<label>
			<span class="question"><?= $question ?></span>
			<textarea name="answer"></textarea>
		</label>
		<label>
			<?= wfMsg('scavengerhunt-entry-form-name') ?>
			<input type="text" name="name" />
		</label>
		<label>
			<?= wfMsg('scavengerhunt-entry-form-email') ?>
			<input type="text" name="email" />
		</label>
		<input type="button" class="wikia-button" value="<?= wfMsg('scavengerhunt-entry-form-submit') ?>"/>
	</form>

	<img src="<?= htmlspecialchars($image) ?>" class="scavengerhunt-image" style="<?= $imageStyle ?>" />
</div>