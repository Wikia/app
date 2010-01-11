<div id="CreatePageDialog" title="<?= wfMsg( 'createpage-dialog-title' ) ?>" >
	<div id="CreatePageContainer">
		<div id="CreatePageDialogHeader">
			<?= wfMsg( 'createpage-dialog-message1' ) ?>
		</div>
		<div id="CreatePageDialogSub">
			<?= wfMsg( 'createpage-dialog-message2' ) ?>
		</div>
		<input id="wpCreatePageDialogTitle" name="wpCreatepageDialogTitle" type="text" />
		<div>
		</div>
		<div id="CreatePageDialogChoose">
			<?= wfMsg( 'createpage-dialog-choose' ) ?>
		</div>
		<div id="CreatePageDialogChoices">
			<div id="CreatePageDialogFormatContainer" class="chooser chosen">
				<div>
					<input type="radio" name="wpCreatePageChoices" id="CreatePageDialogFormat" value="format" checked="checked" />
					<label for="CreatePageDialogFormat"><?= wfMsg( 'createpage-dialog-format' ) ?>
					<img src="/extensions/wikia/CreatePage/images/plc.png" /></label>
				</div>
			</div>
			<div id="CreatePageDialogBlankContainer" class="chooser">
				<div>
					<input type="radio" name="wpCreatePageChoices" id="CreatePageDialogBlank" value="format" />
					<label for="CreatePageDialogBlank"><?= wfMsg( 'createpage-dialog-blank' ) ?>
					<img src="/extensions/wikia/CreatePage/images/plc.png" /></label>
				</div>
			</div>
		</div>
	</div>
	<div id="CreatePageDialogButton" class="modalToolbar neutral">
                <a id="wpLoginattempt" class="wikia_button" href="#"><span><?= wfMsg("createpage-dialog-title") ?></span></a>
        </div>
</div>
