<div class="WikiaLightbox">
	<?php if($initialFileDetail['mediaType'] == 'image'): // needed for image preload ?>
		<div id="LightboxPreload">
			<img src="<?=$initialFileDetail['imageUrl'] ?>" />
		</div>
	<?php endif; ?>

	<div class="media">
		<script id="LightboxPhotoTemplate" type="text/template">
			<img src="{{imageSrc}}" height="{{imageHeight}}" />
		</script>
	
		<script id="LightboxVideoTemplate" type="text/template">
			{{{embed}}}
		</script>
	</div>

	<script>
		var LightboxVar = <?= json_encode($initialFileDetail) ?>;
	</script>
</div>