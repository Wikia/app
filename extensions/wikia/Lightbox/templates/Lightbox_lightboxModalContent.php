<div class="WikiaLightbox">
	<header class="LightboxHeader hidden">
	</header>

	<div class="lightbox-arrows">
		<span id="LightboxNext" class="next"></span>
		<span id="LightboxPrevious" class="previous"></span>
	</div>
	
	<div id="LightboxCarousel" class="LightboxCarousel hidden">
	</div>

	<script id="LightboxPhotoTemplate" class="template" type="text/template">
		<div class="media">
			<img src="{{imageUrl}}" height="{{imageHeight}}" />
		</div>
	</script>
	
	<script id="LightboxVideoTemplate" class="template" type="text/template">
		<div class="media video-media">
			{{{embed}}}
		</div>
	</script>
	
	<script id="LightboxHeaderTemplate" class="template" type="text/template">
		<button class="more-info-button secondary"><?= wfMsg('lightbox-header-more-info-button') ?></button>
		<h1><a href="{{fileUrl}}">{{fileTitle}}</a></h1>
		<a href="{{rawImageUrl}}" class="see-full-size-link"><?= wfMsg('lightbox-header-see-full-size-image') ?></a>
		{{#caption}}
			<div class="caption">{{caption}}</div>
		{{/caption}}
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
	
	<script id="LightboxCarouselTemplate" class="template" type="text/template">
		<div class="ad"></div>
		<div class="content">
			<ul class="toolbar">
				<li><!-- pin icon --></li>
				<li><!-- full screen icon --></li>
			</ul>
			<p class="progress">{{progress}}</p>
			<span class="carousel-arrow next"></span>
			<span class="carousel-arrow previous"></span>
 			<div id="LightboxCarouselContainer" class="LightboxCarouselContainer">
 				<div>
 					<ul class="carousel">{{#thumbs}}<li><img src="{{thumbUrl}}" /></li>{{/thumbs}}</ul>
 				</div>
 			</div>
		</div>
	</script>

</div>