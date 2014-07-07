<?php
	global $wgBlankImgUrl;
?>
<div class="clearfix accent wikia-slideshow-popout-caption-wrapper">
	<a href="#" class="wikia-button secondary wikia-slideshow-popout-add-image" data-hash="<?= $slideshow['hash'] ?>"><?= wfMsg('wikiaPhotoGallery-slideshow-view-addphoto') ?></a>
	<div class="wikia-slideshow-popout-caption"></div>
</div>

<div class="wikia-slideshow-popout-images-wrapper" style="height: <?= $height ?>px; width: <?= $width ?>px">
	<ul class="wikia-slideshow-popout-images">
<?php
	foreach($slideshow['images'] as $image) {
?>
		<li<?php if ( !empty( $image[ 'big' ] ) ) { ?> style="background-image: url('<?= $image['big'] ?>')"<? } ?> caption="<?= htmlspecialchars($image['caption']) ?>">
			<?php if (!empty($image['image'])) { ?>
				<img data-src="<?= htmlspecialchars($image['image']) ?>" alt="" />
			<?php } else if ( empty( $image[ 'big' ] ) ) { ?>
				<a class="image broken-image new" style="line-height: <?= $height; ?>px"><?= $image[ 'pageTitle' ]; ?></a>
			<?php } ?>
<?php
		if (isset($image['url'])) {
			$linkText = ($image['linktext'] != '') ? $image['linktext'] : $image['link'];
			$linkOverlay = wfMsg('wikiaPhotoGallery-slideshow-view-link-overlay', $linkText);
?>
			<a href="<?= htmlspecialchars($image['url']) ?>" title="<?= htmlspecialchars($image['link']) ?>" class="wikia-slideshow-image-link" style="width: <?= $width - 160 ?>px"></a>

			<span class="wikia-slideshow-popout-link-overlay"><?= $linkOverlay ?></span>
<?php
		}
?>
			<a href="<?= htmlspecialchars($image['imagePage']) ?>" title="<?= wfMsg('wikiaPhotoGallery-slideshow-view-details-tooltip') ?>" class="wikia-slideshow-details-link">
				<img src="<?= $wgBlankImgUrl ?>" class="sprite details" alt="" width="16" height="16" />
			</a>
		</li>
<?php
	}
?>
	</ul>

	<div class="wikia-slideshow-popout-prev-next">
		<a class="wikia-slideshow-prev" title="<?= wfMsg('wikiaPhotoGallery-slideshow-view-prev-tooltip') ?>" style="top: <?= ($height >> 1) - 36 ?>px">
			<span>
				<img class="chevron" src="<?= $wgBlankImgUrl ?>">
			</span>
		</a>
		<a class="wikia-slideshow-next" title="<?= wfMsg('wikiaPhotoGallery-slideshow-view-next-tooltip') ?>" style="top: <?= ($height >> 1) - 36 ?>px">
			<span>
				<img class="chevron" src="<?= $wgBlankImgUrl ?>">
			</span>
		</a>
	</div>
</div>

<div class="wikia-slideshow-popout-toolbar accent">
	<div class="wikia-slideshow-popout-counter" value="<?= wfMsg('wikiaPhotoGallery-slideshow-view-number', '$1', count($slideshow['images'])) ?>">&nbsp;</div>

	<div class="wikia-slideshow-popout-carousel">
		<ul class="clearfix">
			<li></li>
			<li></li>
			<li class="wikia-slideshow-popout-carousel-current"></li>
			<li></li>
			<li></li>
		</ul>
	</div>

	<div class="wikia-slideshow-popout-start-stop">
		<a class="wikia-slideshow-popout-start-slideshow accent">
			<img class="wikia-slideshow-sprite" src="<?= $wgBlankImgUrl ?>" height="16" width="16" alt="" />
			<?= wfMsg('wikiaPhotoGallery-slideshow-view-startslideshow') ?>
		</a>

		<a class="wikia-slideshow-popout-stop-slideshow accent">
			<img class="wikia-slideshow-sprite" src="<?= $wgBlankImgUrl ?>" height="16" width="16" alt="" />
			<?= wfMsg('wikiaPhotoGallery-slideshow-view-stopslideshow') ?>
		</a>
	</div>
</div>
