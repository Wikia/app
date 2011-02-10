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
	<fieldset>
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
	<fieldset>
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
				<br>
				<input type="text" name="startingClueImage" value="<?= $startingClueImage ?>">
			</label>
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
	<fieldset class="scavenger-entry">
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
				<br>
				<input type="text" name="articleClueImage[]" value="<?= $article['clueImage'] ?>">
			</label>
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
	<fieldset>
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
				<br>
				<input type="text" name="entryFormImage" value="<?= $entryFormImage ?>">
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-entry-form-question') ?>
				<br>
				<textarea name="entryFormQuestion"><?= $entryFormQuestion ?></textarea>
			</label>
		</div>
	</fieldset>
	<fieldset>
		<legend><?= wfMsg('scavengerhunt-label-goodbye') ?></legend>
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
				<br>
				<input type="text" name="goodbyeImage" value="<?= $goodbyeImage ?>">
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