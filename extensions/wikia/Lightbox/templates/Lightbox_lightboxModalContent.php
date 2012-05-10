<div class="WikiaLightbox">
	<header>
		
	</header>
	
	<div class="lightbox-arrows">
		<span id="LightboxNext" class="next"></span>
		<span id="LightboxPrevious" class="previous"></span>
	</div>

	<script id="LightboxPhotoTemplate" type="text/template">
		<div class="media">
			<img src="{{imageUrl}}" height="{{imageHeight}}" />
		</div>
	</script>
	
	<script id="LightboxVideoTemplate" type="text/template">
		<div class="media video-media">
			{{{embed}}}
		</div>
	</script>
	
	<script id="LightboxHeaderTemplate" type="text/template">
		
	</script>

	<script type="text/javascript">
		var initialFileDetail = <?= json_encode($initialFileDetail) ?>;
		var mediaThumbs = <?= json_encode($mediaThumbs) ?>;
	</script>
</div>