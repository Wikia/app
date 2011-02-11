<form method="post" class="scavenger-form">
<?php if (!empty($errors)) { ?>
	<div class="form-errorbox" >
		<strong><?php echo wfMsg('scavengerhunt-form-error'); ?></strong>
		<ul>
			<?php foreach ($errors as $value) { ?>
				<li><?= $value ?></li>
			<?php } ?>
		</ul>
	</div>
<?php } ?>
	<fieldset class="scavenger-general">
		<legend><?= wfMsg('scavengerhunt-label-general')?></legend>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-name') ?>
				<br>
				<input type="text" id="gameName" name="name" value="<?= $name; ?>">
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-landing-title') ?>
				<br>
				<input type="text" name="landingTitle" value="<?= $landingTitle ?>">
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-landing-button-text') ?>
				<br>
				<input type="text" name="landingButtonText" value="<?= $landingButtonText ?>">
			</label>
		</div>
	</fieldset>
	<fieldset class="scavenger-starting">
		<legend><?= wfMsg('scavengerhunt-label-starting-clue')?></legend>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-starting-clue-title') ?>
				<br>
				<input type="text" name="startingClueTitle" value="<?= $startingClueTitle ?>">
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-starting-clue-text') ?>
				<br>
				<textarea name="startingClueText"><?= $startingClueText ?></textarea>
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-starting-clue-image') ?>
				<a href="#" class="scavenger-dialog-check"><?= wfMsg('scavengerhunt-label-dialog-check') ?></a>
				<br>
				<input class="scavenger-image" type="text" name="startingClueImage" value="<?= $startingClueImage ?>">
			</label>
			<input class="scavenger-image-offset" type="text" name="startingClueImageTopOffset" value="<?= $startingClueImageTopOffset ?>">
			<input class="scavenger-image-offset" type="text" name="startingClueImageLeftOffset" value="<?= $startingClueImageLeftOffset ?>">
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-starting-clue-button-text') ?>
				<br>
				<input type="text" name="startingClueButtonText" value="<?= $startingClueButtonText ?>">
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-starting-clue-button-target') ?>
				<br>
				<input type="text" name="startingClueButtonTarget" value="<?= $startingClueButtonTarget ?>">
			</label>
		</div>
	</fieldset>
<?php foreach ($articles as $n => $article) { ?>
	<fieldset class="scavenger-article">
		<legend><?= wfMsg('scavengerhunt-label-article') ?></legend>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-article-title') ?>
				<br>
				<input type="text" name="articleTitle[]" class="scavenger-page-title" value="<?= $article['title'] ?>">
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-article-hidden-image') ?>
				<br>
				<input type="text" name="articleHiddenImage[]" value="<?= $article['hiddenImage'] ?>">
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-article-clue-title') ?>
				<br>
				<input type="text" name="articleClueTitle[]" value="<?= $article['clueTitle'] ?>">
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-article-clue-text') ?>
				<br>
				<textarea name="articleClueText[]"><?= $article['clueText'] ?></textarea>
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-article-clue-image') ?>
				<a href="#" class="scavenger-dialog-check"><?= wfMsg('scavengerhunt-label-dialog-check') ?></a>
				<br>
				<input class="scavenger-image" type="text" name="articleClueImage[]" value="<?= $article['clueImage'] ?>">
			</label>
			<input class="scavenger-image-offset" type="text" name="articleClueImageTopOffset[]" value="<?= $article['clueImageTopOffset'] ?>">
			<input class="scavenger-image-offset" type="text" name="articleClueImageLeftOffset[]" value="<?= $article['clueImageLeftOffset'] ?>">
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-article-clue-button-text') ?>
				<br>
				<input type="text" name="articleClueButtonText[]" value="<?= $article['clueButtonText'] ?>">
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-article-clue-button-target') ?>
				<br>
				<input type="text" name="articleClueButtonTarget[]" value="<?= $article['clueButtonTarget'] ?>">
			</label>
		</div>
	</fieldset>
<?php } ?>
	<fieldset class="scavenger-entry">
		<legend><?= wfMsg('scavengerhunt-label-entry-form') ?></legend>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-entry-form-title') ?>
				<br>
				<input type="text" name="entryFormTitle" value="<?= $entryFormTitle ?>">
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-entry-form-text') ?>
				<br>
				<textarea name="entryFormText"><?= $entryFormText ?></textarea>
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-entry-form-image') ?>
				<a href="#" class="scavenger-dialog-check"><?= wfMsg('scavengerhunt-label-dialog-check') ?></a>
				<br>
				<input class="scavenger-image" type="text" name="entryFormImage" value="<?= $entryFormImage ?>">
			</label>
			<input class="scavenger-image-offset" type="text" name="entryFormImageTopOffset" value="<?= $entryFormImageTopOffset ?>">
			<input class="scavenger-image-offset" type="text" name="entryFormImageLeftOffset" value="<?= $entryFormImageLeftOffset ?>">
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-entry-form-question') ?>
				<br>
				<textarea name="entryFormQuestion"><?= $entryFormQuestion ?></textarea>
			</label>
		</div>
	</fieldset>
	<fieldset class="scavenger-goodbye">
		<legend><?= wfMsg('scavengerhunt-label-goodbye') ?></legend>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-goodbye-title') ?>
				<br>
				<input type="text" name="goodbyeTitle" value="<?= $goodbyeTitle ?>">
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-goodbye-text') ?>
				<br>
				<textarea name="goodbyeText"><?= $goodbyeText ?></textarea>
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-goodbye-image') ?>
				<a href="#" class="scavenger-dialog-check"><?= wfMsg('scavengerhunt-label-dialog-check') ?></a>
				<br>
				<input class="scavenger-image" type="text" name="goodbyeImage" value="<?= $goodbyeImage ?>">
				<input class="scavenger-image-offset" type="text" name="goodbyeImageTopOffset" value="<?= $goodbyeImageTopOffset ?>">
				<input class="scavenger-image-offset" type="text" name="goodbyeImageLeftOffset" value="<?= $goodbyeImageLeftOffset ?>">
			</label>
		</div>
	</fieldset>
	<div>
		<input type="submit" name="save" value="<?= wfMsg('scavengerhunt-button-save') ?>">
		<?php
		if ($gameId) {
		?>
		<input type="submit" name="enable" value="<?= $enabled ? wfMsg('scavengerhunt-button-disable') : wfMsg('scavengerhunt-button-enable') ?>">
		<input type="submit" name="delete" value="<?= wfMsg('scavengerhunt-button-delete') ?>">
		<input type="submit" name="export" value="<?= wfMsg('scavengerhunt-button-export') ?>">
		<input type="hidden" name="prevEnabled" value="<?= (int)$enabled ?>">
		<?php
		}
		?>
		<input type="hidden" name="gameId" value="<?= $gameId ?>">
	</div>
</form>