<?php if($data['align'] == "tnone"): ?>
	<div class="center">
<?php endif; ?>
	<div style="width: <?php echo $data['width']; ?>px;<?php echo $data['error']; ?>" id="imageboxdiv_<?php echo $data['id'] ?>" class="thumbinner <?php echo $data['align']; ?>">
			<?php if($data['isform']): ?>
				<div id="imagediv_<?php echo $data['id'] ?>" class="gallerybox" style="background:url('<?php echo $data['img'] ?>');background-position:center; width: <?php echo $data['width']; ?>px;line-height: <?php echo $data['height']; ?>px">
					<p style="margin: 0px">
						<?php if(!$data['isempty']): ?>
							<button onclick="PageLayoutBuilder.uploadImage(<?php echo $data['width'] ?>, '<?php echo $data['id'] ?>'); return false;" id="addimage_<?php echo $data['id'] ?>" ><?php echo wfMsg('plb-parser-preview-image-add'); ?></button>
						<?php else: ?>
							<a class="wikia-button" href="<?php echo $data['editurl'] ?>"><?php echo wfMsg('plb-parser-empty-value-image'); ?></a>
						<?php endif; ?>
					</p>
				</div>
			<?php else: ?>
				<a class="image" href="#">
					<img border="0" width="<?php echo $data['width'] ?>" height="<?php echo $data['height'] ?>" class="thumbimage" src="<?php echo $data['img'] ?>"/>
				</a>
			<?php endif; ?>
		<div class="thumbcaption">
			<?php echo $data['caption'] ?>
		</div>
		<div class="picture-attribution">
			<?php echo wfMsg('plb-parser-preview-image-user', array('$1' => $data['username'] )); ?>
		</div>
	</div>
<?php if($data['align'] == "tnone"): ?>
	</div>
<?php endif; ?>

<?php if($data['isform']): ?>
	<span class="plb-empty-input" ><?php echo $data['instructions']; ?> </span>
<?php endif; ?>