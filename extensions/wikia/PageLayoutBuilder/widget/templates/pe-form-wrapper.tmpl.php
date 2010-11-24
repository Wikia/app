<div class="plb-pe-window plb-pe-<?php echo $widgetName; ?>">
	<form>
		<div class="plb-pe-main">
			<?php echo $this->render("pe-form-$widgetName"); ?>
		</div>
		<div class="plb-pe-buttons">
			<input class="plb-pe-button-save" type="submit" value="<?php echo wfMsg('plb-property-editor-save'); ?>">
			<input class="plb-pe-button-cancel" type="button" value="<?php echo wfMsg('plb-property-editor-cancel'); ?>">
		</div>
	</form>
	
	<h2>
		<?php echo wfMsg('plb-editor-preview'); ?>
	</h2>
		
	<div class="plb-pe-window-preview WikiaArticle" >
		<?php echo $preview; ?>
	</div>
</div>