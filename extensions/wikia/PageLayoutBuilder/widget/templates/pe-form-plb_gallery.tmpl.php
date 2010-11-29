<h1><?php echo wfMsg('plb-widget-name-plb_gallery'); ?></h1>
<div class="label"><?php echo wfMsg('plb-property-editor-caption'); ?>
<span class="helpicon"><span class="helpicon-text"><?php echo wfMsg('plb-property-editor-help-caption'); ?></span></span>
</div>
<div class="input"><input name="caption" /></div>
<div class="label"><?php echo wfMsg('plb-property-editor-instructions'); ?>
<span class="helpicon"><span class="helpicon-text"><?php echo wfMsg('plb-property-editor-help-instructions'); ?></span></span>
</div>
<div class="input"><textarea name="instructions"></textarea></div>
<div class="input">
<label><input type="checkbox" name="required" value="on" /><?php echo wfMsg('plb-property-editor-required')?>
<span class="helpicon"><span class="helpicon-text"><?php echo wfMsg('plb-property-editor-help-required'); ?></span></span>
</label>
</div>

<div class="plb-pe-left-column">
	<div class="label">
		<?php echo wfMsg('plb-property-editor-alignment'); ?>
		<span class="helpicon">
			<span class="helpicon-text"><?php echo wfMsg('plb-property-editor-help-alignment'); ?></span>
		</span>
	</div>
	<div class="input">
		<select name="align">
			<option value="left"><?php echo wfMsg('plb-property-editor-alignment-left')?></option>
			<option value="center"><?php echo wfMsg('plb-property-editor-alignment-center')?></option>
			<option value="right"><?php echo wfMsg('plb-property-editor-alignment-right')?></option>
		</select>
	</div>
</div>

<div class="plb-pe-right-column">
	<div class="label">
		<?php echo wfMsg('plb-property-editor-spacing'); ?>
		<span class="helpicon">
			<span class="helpicon-text"><?php echo wfMsg('plb-property-editor-help-spacing'); ?></span>
		</span>
	</div>
	<div class="input">
		<select name="spacing">
			<option value="small"><?php echo wfMsg('plb-property-editor-spacing-small')?></option>
			<option value="medium"><?php echo wfMsg('plb-property-editor-spacing-medium')?></option>
			<option value="large"><?php echo wfMsg('plb-property-editor-spacing-large')?></option>
		</select>
	</div>
</div>

<div class="label">
	<?php echo wfMsg('plb-property-editor-width'); ?>
	<span class="helpicon">
		<span class="helpicon-text"><?php echo wfMsg('plb-property-editor-help-maximum-width'); ?></span>
	</span>
</div>
<div class="input">
	<input name="size" />
</div>