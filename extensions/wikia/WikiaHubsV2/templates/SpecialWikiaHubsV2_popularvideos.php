<div class="title-wrapper">
	<h2>Popular video from template</h2>
	<button id="suggestVideo" class="wikia-button secondary">Suggest a Video</button>
</div>

<section class="WikiaMediaCarousel">
	<a href="#" class="button secondary right next">
		<img src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" class="chevron" />
	</a>
	<a href="#" class="button secondary left previous">
		<img src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" class="chevron" />
	</a>
	<? if (is_array($videos)): ?>
		<div id="carouselContainer" class="carouselContainer">
			<div>
				<ul class="carousel" style="">
					<? foreach($videos as $video): ?>
						<li class="thumbs active">
							<?= $app->renderView( 'RelatedHubsVideos', 'getCaruselElement', array( 'video' => $video, 'preloaded' => 1 ) ) ?>
						</li>
					<? endforeach; ?>
				</ul>
			</div>
		</div>
	<? endif; ?>
</section>
