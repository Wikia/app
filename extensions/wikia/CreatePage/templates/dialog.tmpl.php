<div id="CreatePageDialog" title="<?= wfMsg( 'createpage-dialog-title' ) ?>" >
	<form name="CreatePageForm" id="CreatePageForm" onsubmit="CreatePage.submitDialog(true); return false">
		<div id="CreatePageContainer">
			<div id="CreatePageDialogHeader">
				<?= wfMsg( 'createpage-dialog-message1' ) ?>
			</div>
			<div id="CreatePageDialogSub">
				<?= wfMsg( 'createpage-dialog-message2' ) ?>
			</div>
			<input id="wpCreatePageDialogTitle" name="wpCreatepageDialogTitle" type="text" />
			<div id="CreatePageDialogTitleErrorMsg" class="CreatePageError hiddenStructure"></div>
				<?php if( !$useFormatOnly ): ?>
				<div id="CreatePageDialogChoose">
					<?= wfMsg( 'createpage-dialog-choose' ) ?>
				</div>
				<div id="CreatePageDialogChoices">
					<div id="CreatePageDialogFormatContainer" class="chooser">
						<div>
							<input type="radio" name="wpCreatePageChoices" id="CreatePageDialogFormat" value="format" />
							<label for="CreatePageDialogFormat"><?= wfMsg( 'createpage-dialog-format' ) ?>
							<img src="/extensions/wikia/CreatePage/images/thumbnail_format.png" /></label>
						</div>
					</div>
					<div id="CreatePageDialogBlankContainer" class="chooser">
						<div>
							<input type="radio" name="wpCreatePageChoices" id="CreatePageDialogBlank" value="blank" />
							<label for="CreatePageDialogBlank"><?= wfMsg( 'createpage-dialog-blank' ) ?>
							<img src="/extensions/wikia/CreatePage/images/thumbnail_blank.png" /></label>
						</div>
					</div>
				</div>
		</div>
		<?php else: ?>
			<br />
			<input type="hidden" name="wpCreatePageChoices" value="format" />
		<?php endif; ?>
		<input id="hiddenCreatePageDialogButton" type="submit" style="display: none;" name="hiddenCreatePageDialogButton" value="<?= wfMsg("createpage-dialog-title") ?>" />
		<div id="CreatePageDialogButton" class="modalToolbar neutral">
			<input type="submit" id="wpCreatePageDialogButton" onclick="CreatePage.submitDialog(false);" value="<?= wfMsg("createpage-dialog-title") ?>" />
		</div>
	</form>
</div>
<script type="text/javascript">/*<![CDATA[*/
	$( '#CreatePageDialogFormatContainer' ).click( function() { CreatePage.setPageLayout('format'); });
	$( '#CreatePageDialogBlankContainer' ).click( function() { CreatePage.setPageLayout('blank'); });
	CreatePage.setPageLayout( '<?php echo $defaultPageLayout; ?>' );
/*]]>*/</script>
