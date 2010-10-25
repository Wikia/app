<h1><?php echo wfMsg('plb-widget-name-plb_image'); ?></h1>
<div class="label"><?php echo wfMsg('plb-property-editor-caption'); ?></div>
<div class="input"><input name="caption" /></div>
<div class="label"><?php echo wfMsg('plb-property-editor-instructions'); ?></div>
<div class="input"><textarea name="instructions"></textarea></div>
<div class="input">
<label><input type="checkbox" name="required" value="on" /><?php echo wfMsg('plb-property-editor-required')?></label>
</div>
<div class="plb-pe-left-column">
<div class="label"><?php echo wfMsg('plb-property-editor-alignment'); ?></div>
<div class="input"><select name="align">
	<option value="left"><?php echo wfMsg('plb-property-editor-alignment-left')?></option>
	<option value="center"><?php echo wfMsg('plb-property-editor-alignment-center')?></option>
	<option value="right"><?php echo wfMsg('plb-property-editor-alignment-right')?></option>
</select></div>
</div><div class="plb-pe-right-column">
<div class="label"><?php echo wfMsg('plb-property-editor-maximum-width'); ?></div>
<div class="input"><input name="size" /></div>
</div>
<div class="input">
<label><input type="checkbox" name="x-type" value="on" /><?php echo wfMsg('plb-property-editor-thumbnail')?></label>
</div>
