<div id="CreatePageDialog" title="<?= wfMsg( 'createpage-dialog-title' ) ?>" >
	<form name="CreatePageForm" id="CreatePageForm" onsubmit="CreatePage.submitDialog(true); return false;">
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
				<ul id="CreatePageDialogChoices">
					<? foreach( $options as $name => $params ) :?>
						<li id="CreatePageDialog<?= ucfirst( $name ) ;?>Container" class="chooser">
							<div>
								<input type="radio" name="wpCreatePageChoices" id="CreatePageDialog<?= ucfirst( $name ) ;?>" value="<?= $name ;?>" />
								<label for="CreatePageDialog<?= ucfirst( $name ) ;?>">
									<?= $params[ 'label' ] ;?>
									<img src="<?= $params[ 'icon' ] ;?>" />
								</label>
							</div>
						</li>
						<script type="text/javascript">CreatePage.options['<?= $name ;?>'] = <?= json_encode( $params ) ;?>;</script>
					<? endforeach ;?>
				</ul>
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
	CreatePage.setPageLayout( '<?php echo $defaultPageLayout; ?>' );
/*]]>*/</script>
