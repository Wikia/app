<form method="post" class="scavenger-form">
	<div>
		<label>
			<?= wfMsg('scavengerhunt-label-landing') ?>
			<br>
			<input type="text" id="landing" name="landing">
		</label>
	</div>
	<div>
		<label>
			<?= wfMsg('scavengerhunt-label-starting-clue') ?>
			<br>
			<textarea name="startingClue"></textarea>
		</label>
	</div>
	<div class="scavenger-entry">
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-page-title') ?>
				<br>
				<input type="text" name="pageTitle[]">
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-hidden-image') ?>
				<br>
				<input type="text" name="hiddenImage[]">
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-clue-image') ?>
				<br>
				<input type="text" name="clueImage[]">
			</label>
		</div>
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-clue') ?>
				<br>
				<textarea name="clue[]"></textarea>
			</label>
		</div>
	</div>
	<div>
		<label>
			<?= wfMsg('scavengerhunt-label-entry-form') ?>
			<br>
			<textarea name="entryForm"></textarea>
		</label>
	</div>
	<div>
		<label>
			<?= wfMsg('scavengerhunt-label-final-question') ?>
			<br>
			<textarea name="finalQuestion"></textarea>
		</label>
	</div>
	<div>
		<label>
			<?= wfMsg('scavengerhunt-label-goodbye-msg') ?>
			<br>
			<textarea name="goodbyeMsg"></textarea>
		</label>
	</div>
	<div>
		<input type="submit" name="save" value="<?= wfMsg('scavengerhunt-button-save') ?>">
		<input type="submit" name="enable" value="<?= $enabled ? wfMsg('scavengerhunt-button-disable') : wfMsg('scavengerhunt-button-enable') ?>">
		<input type="submit" name="delete" value="<?= wfMsg('scavengerhunt-button-delete') ?>">
		<input type="submit" name="export" value="<?= wfMsg('scavengerhunt-button-export') ?>">
		<input type="hidden" name="gameId" value="<?= $gameId ?>">
	</div>
</form>