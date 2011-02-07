<?php if($ispreview): ?>
	<div class="WikiaPageHeader editbox" id="WikiaEditBoxHeader">
		<h1>
			<?php echo $title2 ?>
		</h1>
	</div>
		
<?php endif; ?>

<?php if($iserror): ?>
	<div class="plb-form-errorbox" >
		<strong><?php echo wfMsg('plb-special-form-error-info'); ?></strong>
		<ul>
			<?php foreach ($errors as $value): ?>
				<li><?php echo $value; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>


<input type="hidden" name="wpPlbId" id="wpPlbId" value="<?php echo $data['plbId'] ?>" />

<?php if($showtitle): ?>
	<p class="plb-form-caption-p"><?php echo wfMsg("plb-form-title") ?></p>
	<input data-instructions="<?php echo wfMsg("plb-form-title-instructions"); ?>" type="text" class="plb-editor-title <?php if($data['emptytitle']) { ?>  plb-empty-input <?php }?>" id="wgTitle" name="wgTitle" size="60" maxlength="255" value="<?php echo $data['title'] ?>" /> <br>
<?php endif; ?>


<p class="plb-form-caption-p"><?php echo wfMsg("plb-form-desc") ?></p>
<textarea data-instructions="<?php echo wfMsg("plb-form-desc-instructions"); ?>" class="plb-editor-desc  <?php if($data['emptydesc']) { ?>  plb-empty-input <?php }?>" type="text" id="wgDesc" name="wgDesc" size="60" maxlength="255"><?php echo $data['desc'] ?></textarea>

<br/>
<?php global $wgBlankImgUrl; ?>
<ul id="sourceModeInsertElement" style="display:none" class="plb-add-element wikia-menu-button wikia-menu-button-no-auto">
	<li>
		<span>
		<img height="16" width="22" src="<?php echo $wgBlankImgUrl; ?>" class="osprite icon-edit" alt="">
		<?php echo wfMsg('plb-editor-add-element'); ?></span>
		<img src="<?php echo $wgBlankImgUrl; ?>" class="chevron">
		<ul>
		</ul>
	</li>
</ul>