<?php if($data['align'] == "tnone"): ?>
	<div class="center">
<?php endif; ?>
		<div id="imageboxmaindiv_<?php echo $data['id'] ?>" class="<?php echo $data['align'] ?> thumbinner" style="padding: 0;<?php echo $data['error']; ?>">
			<a class="image" href="#">
				<img border="0" width="<?php echo $data['width'] ?>" height="<?php echo $data['height'] ?>" class="thumbimage" src="<?php echo $data['img'] ?>" />
			</a>
		</div>
<?php if($data['align'] == "tnone"): ?>
	</div>
<?php endif; ?>