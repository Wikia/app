<div class="WikiaLightbox">
	<div class="lightbox-arrows">
		<span id="LightboxNext" class="next"></span>
		<span id="LightboxPrevious" class="previous"></span>
	</div>
	<?php if($initialFileDetail['mediaType'] == 'image'): // needed for image preload ?>
		<div id="LightboxPreload">
			<img src="<?=$initialFileDetail['imageUrl'] ?>" />
		</div>
	<?php endif; ?>

	<script id="LightboxPhotoTemplate" type="text/template">
		<div class="media">
			<img src="{{imageSrc}}" height="{{imageHeight}}" />
		</div>
	</script>
	
	<script id="LightboxVideoTemplate" type="text/template">
		<div class="media video-media">
			{{{embed}}}
		</div>
	</script>

	<script>
		var LightboxVar = <?= json_encode($initialFileDetail) ?>;
	</script>
</div>