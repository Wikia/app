<div class="WikiaLightbox">
	<header class="hidden">
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
		<button class="more-info-button secondary"><?= wfMsg('lightbox-header-more-info-button') ?></button>
		<h1><a href="{{fileUrl}}">{{fileTitle}}</a></h1>
		<a href="{{rawImageUrl}}" class="see-full-size-link"><?= wfMsg('lightbox-header-see-full-size-image') ?></a>
		<div class="caption">Caption goes here</div>
		<div class="user-details">
			<img class="avatar" src="{{userThumbUrl}}">
			<?= wfMsg('lightbox-header-added-by', '{{userName}}') ?>
			<span class="posted-in">
				<?= wfMsg('lightbox-header-posted-in', '<a href="{{articles.articleUrl}}">Miss Piggy</a>') ?>
			</span>
		</div>
	</script>

	<script type="text/javascript">
		var initialFileDetail = <?= json_encode($initialFileDetail) ?>;
		var mediaThumbs = <?= json_encode($mediaThumbs) ?>;
	</script>
	
	<div id="LightboxCaoursel" class="LightboxCaoursel">
	</div>
</div>