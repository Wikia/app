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
	<div>
		<label>
			<?= wfMsg('scavengerhunt-label-game-name') ?>
			<br>
			<input type="text" id="gameName" name="gameName" value="<?= $gameName; ?>">
		</label>
	</div>
	<div>
		<label>
			<?= wfMsg('scavengerhunt-label-landing') ?>
			<br>
			<input type="text" name="landing" value="<?= $landing ?>">
		</label>
	</div>
	<div>
		<label>
			<?= wfMsg('scavengerhunt-label-starting-clue') ?>
			<br>
			<textarea name="startingClue"><?= $startingClue ?></textarea>
		</label>
	</div>
	<div>
		<label>
			<?= wfMsg('scavengerhunt-label-starting-image') ?>
			<br>
			<input type="text" name="startingImage" value="<?= $startingImage ?>">
		</label>
	</div>
<?php foreach ($pageTitle as $n => $unused) { ?>
	<div class="scavenger-entry">
		<div class="scavenger-entry-info">
			<?= wfMsg('scavengerhunt-label-entry-info') ?>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-page-title') ?>
				<br>
				<input type="text" name="pageTitle[]" class="scavenger-page-title" value="<?= $pageTitle[$n] ?>">
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-hidden-image') ?>
				<br>
				<input type="text" name="hiddenImage[]" value="<?= $hiddenImage[$n] ?>">
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-clue-image') ?>
				<br>
				<input type="text" name="clueImage[]" value="<?= $clueImage[$n] ?>">
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-clue') ?>
				<br>
				<textarea name="clue[]"><?= $clue[$n] ?></textarea>
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-clue-link') ?>
				<br>
				<input type="text" name="clueLink[]" value="<?= $clueLink[$n] ?>">
			</label>
		</div>
	</div>
<?php } ?>
	<div>
		<label>
			<?= wfMsg('scavengerhunt-label-entry-form') ?>
			<br>
			<textarea name="entryForm"><?= $entryForm ?></textarea>
		</label>
	</div>
	<div>
		<label>
			<?= wfMsg('scavengerhunt-label-final-question') ?>
			<br>
			<textarea name="finalQuestion"><?= $finalQuestion ?></textarea>
		</label>
	</div>
	<div>
		<label>
			<?= wfMsg('scavengerhunt-label-goodbye-msg') ?>
			<br>
			<textarea name="goodbyeMsg"><?= $goodbyeMsg ?></textarea>
		</label>
	</div>
	<div>
		<label>
			<?= wfMsg('scavengerhunt-label-goodbye-image') ?>
			<br>
			<input type="text" name="goodbyeImage" value="<?= $goodbyeImage ?>">
		</label>
	</div>
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