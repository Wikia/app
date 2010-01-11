<div id="CreatePageDialog" title="<?= wfMsg( 'createpage-dialog-title' ) ?>" >
	<div id="CreatePageContainer">
		<div id="CreatePageDialogHeader">
			<?= wfMsg( 'createpage-dialog-message1' ) ?>
		</div>
		<div id="CreatePageDialogSub">
			<?= wfMsg( 'createpage-dialog-message2' ) ?>
		</div>
		<input id="wpCreatepageDialogTitle" name="wpCreatepageDialogTitle" type="text" />
		<div>
		</div>
		<div id="CreatePageDialogChoose">
			<?= wfMsg( 'createpage-dialog-choose' ) ?>
		</div>
		<div id="CreatePageDialogChoices">
			<div id="CreatePageDialogFormatContainer">
				<input type="radio" name="wpCreatePageChoices" id="CreatePageDialogFormat" value="format" selected="selected" />
				<label for="CreatePageDialogFormat"><?= wfMsg( 'createpage-dialog-format' ) ?>
				<img src="/extensions/wikia/CreatePage/images/plc.png" /></label>
			</div>
			<div id="CreatePageDialogBlankContainer">
				<input type="radio" name="wpCreatePageChoices" id="CreatePageDialogBlank" value="format" />
				<label for="CreatePageDialogBlank"><?= wfMsg( 'createpage-dialog-blank' ) ?>
				<img src="/extensions/wikia/CreatePage/images/plc.png" /></label>
			</div>
		</div>
	</div>
	<div class="modalToolbar neutral">
                <a id="wpLoginattempt" class="wikia_button" href="#"><span><?= wfMsg("createpage-dialog-title") ?></span></a>
        </div>
</div>
