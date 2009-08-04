<?php if(count($formErrors)): ?>
	<div style="color:red; font-weight:700;">
		<?php foreach($formErrors as $error): ?>
			<?php echo $error; ?><br />
		<?php endforeach; ?>
	</div>
<?php endif; ?>
<div id="createpage_messenger" style=\"display:none; color:red \" ></div>
<b><?=wfMsg ('createpage_title_caption');?></b>
<br/>
<input name="postTitle" id="postTitle" value="<?=isset($formData['postTitle'])?$formData['postTitle']:"";?>" size="100" /><br/><br/>
<b><?=wfMsg ('createpage_enter_text');?></b>
