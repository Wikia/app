<div class="title-wrapper">
	<h2><?= $headline ?></h2>
	<? if (!F::app()->checkSkin('wikiamobile')): ?>
		<button id="suggest-popularvideos" class="wikia-button secondary">
			<?= wfMsg('wikiahubs-suggest-video-submit-button'); ?>
		</button>
	<? endif; ?>
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
					<?= $app->renderView( 'SpecialWikiaHubsV2', 'renderCaruselElement', array_merge(F::app()->wg->request->getValues(),array('video' => $video)) ); ?>
				</li>
				<? endforeach; ?>
			</ul>
		</div>
	</div>
	<? endif; ?>
</section>