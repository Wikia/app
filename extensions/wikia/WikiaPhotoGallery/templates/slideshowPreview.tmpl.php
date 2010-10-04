<div class="WikiaPhotoGalleryPreview">
<?php
	if (!count($slideshow['images'])) {
		echo wfMsg('wikiaPhotoGallery-preview-no-images');
	} else {
		$extraClass = empty($fromFeed) ? ' WikiaPhotoGalleryPreviewDraggable' : ' WikiaPhotoGalleryPreviewFeed';
		// render images
		foreach ($slideshow['images'] as $i => $image) {
			if (empty($image['recentlyUploaded'])) {
?>
	<span class="WikiaPhotoGalleryPreviewItem<?= $extraClass ?>" imageid="<?= $i ?>" style="<? if ( !empty( $image[ 'thumbnailBg' ] ) ): ?>background-image: url(<?= $image['thumbnailBg'] ?>);<? endif; ?> width: <?= $width?>px; height: <?= $height ?>px">
<?php
		if (empty($fromFeed)) {
?>
		<span class="WikiaPhotoGalleryPreviewItemMenu color1">
			<a href="#"><?= wfMsg('WikiaPhotoGallery-preview-hover-modify') ?></a>
			<a href="#"><?= wfMsg('WikiaPhotoGallery-preview-hover-delete')?></a>
		</span>
<?php
		}

		if (!empty($image['image'])) {
?>
		<img data-src="<?= htmlspecialchars($image['image']) ?>" alt="" />
<?php
		}
		else if (empty($image['thumbnailBg'])) {
?>
			<a class="image broken-image new" style="line-height: <?= $height ?>px;"><?= $image['pageTitle']; ?></a>
<?php
		}
		// link icon
			if ($image['link'] != '') {
				$msg = htmlspecialchars(wfMsg('wikiaPhotoGallery-preview-link-tooltip', $image['link']));
?>
		<a href="#" class="WikiaPhotoGalleryPreviewItemLink" title="<?= $msg ?>"></a>
<?php
			}

			// image caption
			if ($image['caption'] != '') {
				$caption = $image['caption'];
			} else {
				$caption = '<em>' . wfMsg('wikiaPhotoGallery-preview-add-caption') . '</em>';
			}
?>
		<span class="WikiaPhotoGalleryPreviewSlideshowCaptionWrapper">
			<span class="WikiaPhotoGalleryPreviewSlideshowCaption WikiaPhotoGalleryPreviewItemCaption"><?= $caption ?></span>
		</span>
	</span>
<?php
			} else {
			// recently uploaded images: render 50% transparent, non-interactable (no moving, no menu).
?>
	<span class="WikiaPhotoGalleryPreviewItem WikiaPhotoGalleryPreviewRecentlyUploaded" imageid="<?= $i ?>" style="background-image: url(<?= $image['thumbnailBg'] ?>); width: <?= $width?>px; height: <?= $height ?>px">
	</span>
<?php
			}
		}
	}
?>
</div>