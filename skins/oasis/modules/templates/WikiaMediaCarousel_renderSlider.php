<section class="WikiaMediaCarousel">
	<?php
		$class = "";
		if ($enableScroll == false) {
			$class = " hidden";
		}
	?>
	<a href="#" class="previous<?= $class ?>"><img src="<?= Sanitizer::encodeAttribute( $wg->BlankImgUrl ); ?>" class="latest-images-left" height="0" width="0"></a>
	<a href="#" class="next<?= $class ?>"><img src="<?= Sanitizer::encodeAttribute( $wg->BlankImgUrl ); ?>" class="latest-images-right" height="0" width="0"></a>
	<div id="carouselContainer" class="carouselContainer">
		<div>
			<ul class="carousel">
				<? foreach ($thumbUrls as $i => $url): ?>
					<li class="thumbs">
						<img src="<?= Sanitizer::encodeAttribute( $url["thumb_url"] ); ?>" data-bigimage="<?= Sanitizer::encodeAttribute( $url["image_url"] ); ?>" />
					</li>
				<? endforeach; ?>
			</ul>
		</div>
	</div>
</section>
