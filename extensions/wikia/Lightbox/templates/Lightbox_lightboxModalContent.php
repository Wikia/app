<div class="WikiaLightbox">
	<header class="LightboxHeader hidden">
	</header>

	<div class="lightbox-arrows">
		<span id="LightboxNext" class="next"></span>
		<span id="LightboxPrevious" class="previous"></span>
	</div>
	
	<div class="media">
	</div>
	
	<div id="LightboxCarousel" class="LightboxCarousel hidden">
	</div>
	
	<div class="infobox">
	</div>

	<script id="LightboxPhotoTemplate" class="template" type="text/template">
		<img src="{{imageUrl}}" height="{{imageHeight}}" >
	</script>
	
	<script id="LightboxVideoTemplate" class="template" type="text/template">
		{{{videoEmbedCode}}}
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
			<?= wfMsg('lightbox-header-added-by', '<a href="{{userPageUrl}}">{{userName}}</a>') ?>
			<span class="posted-in">
				<?= wfMsg('lightbox-header-posted-in', '{{#articles}}<span class="posted-in-article"><a href="{{articleUrl}}">{{articleTitle}}</a></span>{{/articles}}') ?>
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
	
	<script id="LightboxInfoboxTemplate" type="text/template">
		<button class="more-info-close"><?= wfMsg('lightbox-infobox-back-button') ?></button>
		<div class="infobox-spacer"></div>
		<div class="infobox-details">
			<h1><a href="">{{fileTitle}}</a></h1>
			<div class="user-details">
				<img class="avatar" src="{{userThumbUrl}}">
				<?= wfMsg('lightbox-header-added-by', '<a href="{{userPageUrl}}">{{userName}}</a>') ?>
				<span class="posted-in">
					<?= wfMsg('lightbox-header-posted-in', '<a href="{{articles.articleUrl}}">Miss Piggy</a>') ?>
				</span>
			</div>
			{{#caption}}
				<h2><?= wfMsg('lightbox-infobox-caption-heading') ?></h2>
				<p>{{caption}}</p>
			{{/caption}}
			{{#description}}
				<h2><?= wfMsg('lightbox-infobox-description-heading') ?></h2>
				<p class="infobox-description">{{description}}</p>
			{{/description}}
			<h2><?= wfMsg('lightbox-infobox-filelinks-heading') ?></h2>
			<ul>
			{{#articles}}
				<li><a href="{{articleUrl}}">{{articleTitle}}</a></li>
			{{/articles}}
			</ul>
		</div>
		<div class="infobox-hero">
			<img src="{{imageUrl}}">
		</div>
	</script>

</div>