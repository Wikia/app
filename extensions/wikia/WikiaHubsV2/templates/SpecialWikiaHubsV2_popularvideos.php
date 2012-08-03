<div class="title-wrapper">
	<h2>Popular video from template</h2>
	<button id="suggestVideo" class="wikia-button secondary">Suggest a Video</button>
</div>

<section class="WikiaMediaCarousel">
	<a href="#" class="button secondary left next">
		<img src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" class="chevron">
	</a>
	<a href="#" class="button secondary right previous">
		<img src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" class="chevron">
	</a>
	<div id="carouselContainer" class="carouselContainer">
		<div>
			<ul class="carousel" style="">
				<li class="thumbs active">
					<?= $app->renderView( 'RelatedHubsVideos', 'getCaruselElement', array( 'video' => $videos[0], 'preloaded' => 1 ) ) ?>
				</li>
				<li class="thumbs active">
					<?= $app->renderView( 'RelatedHubsVideos', 'getCaruselElement', array( 'video' => $videos[0], 'preloaded' => 1 ) ) ?>
				</li>
				<li class="thumbs active">
					<?= $app->renderView( 'RelatedHubsVideos', 'getCaruselElement', array( 'video' => $videos[0], 'preloaded' => 1 ) ) ?>
				</li>
				<li class="thumbs active">
					<?= $app->renderView( 'RelatedHubsVideos', 'getCaruselElement', array( 'video' => $videos[0], 'preloaded' => 1 ) ) ?>
				</li>
				<li class="thumbs active">
					<?= $app->renderView( 'RelatedHubsVideos', 'getCaruselElement', array( 'video' => $videos[0], 'preloaded' => 1 ) ) ?>
				</li>
			</ul>
		</div>
	</div>
</section>
