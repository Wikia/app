<?php if($ispreview): ?>
	<div class="plb-preview-div">
		<?php echo $previewdata; ?>
	</div>
	<div class="plb-article-form-space separator" ></div>
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
	<input type="text" class="plb-editor-title" id="wgTitle" name="wgTitle" size="60" maxlength="255" value="<?php echo $data['title'] ?>" /> <br>
<?php endif; ?>


<p class="plb-form-caption-p"><?php echo wfMsg("plb-form-desc") ?></p>
<textarea class="plb-editor-desc" type="text" id="wgDesc" name="wgDesc" size="60" maxlength="255"><?php echo $data['desc'] ?></textarea>

<br/>

