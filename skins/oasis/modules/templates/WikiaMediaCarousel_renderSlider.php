<section class="WikiaMediaCarousel">
	<?php
		$class = "";
		if ($enableScroll == false) {
			$class = " hidden";
		}
	?>
	<a href="#" class="previous<?= $class ?>"><img src="<?= $wg->BlankImgUrl; ?>" class="latest-images-left" height="0" width="0"></a>
	<a href="#" class="next<?= $class ?>"><img src="<?= $wg->BlankImgUrl; ?>" class="latest-images-right" height="0" width="0"></a>
	<div id="carouselContainer" class="carouselContainer">
		<div>
			<ul class="carousel">
				<? foreach ($thumbUrls as $i => $url): ?>
					<li class="thumbs">
						<img src="<?= $url["thumb_url"] ?>" data-bigimage="<?= $url["image_url"] ?>" />
					</li>
				<? endforeach; ?>
			</ul>
		</div>
	</div>
</section>
