<div class="WikiaPhotoGalleryPreview">
<?php
	$extraClass = ' WikiaPhotoGalleryPreviewDraggable';
	// render images
	foreach ($slider['images'] as $i => $image) {
			
?>
	<span class="WikiaPhotoGalleryPreviewItem<?= $extraClass ?>" imageid="<?= $i ?>" style="width: <?= $width?>px; height: <?= ( $height + 100 ) ?>px">

		<span class="WikiaPhotoGalleryPreviewItemMenu color1">
			<a href="#"><?= wfMsg('WikiaPhotoGallery-preview-hover-modify') ?></a>
			<a href="#"><?= wfMsg('WikiaPhotoGallery-preview-hover-delete')?></a>
		</span>

		<span class="WikiaPhotoGallerySliderItemNumber<?=( $i >= 4 ) ? 'Warning' : ''; ?>">
			<div><?php
				if ( $i < 4 ){
					echo '#'.( $i+1 );
				} else {
					echo wfMsg('wikiaPhotoGallery-not-displayed');
				}
			?></div>
		</span>

		<span style="display:block;<? if ( !empty( $image[ 'thumbnailBg' ] ) ): ?>background-image: url(<?= $image['thumbnailBg'] ?>);<? endif; ?> width: <?= $width?>px; height: <?= $height ?>px">
			
		 </span>
<?php
		if (!empty($image['image'])) {
?>
		<img data-src="<?= htmlspecialchars($image['image']) ?>" alt="" />
<?php
		} else if (empty($image['thumbnailBg'])) {
?>
			<a class="image broken-image new" style="line-height: <?= $height ?>px;"><?= $image['pageTitle']; ?></a>
<?php
		}
		// link icon
			if ($image['link'] != '') {
				$linkMsg = htmlspecialchars($image['link']);
			} else {
				$linkMsg = wfMsg('wikiaPhotoGallery-preview-add-link');
			}
		// image caption
			if ($image['caption'] != '') {
				$caption = $image['caption'];
			} else {
				$caption = wfMsg('wikiaPhotoGallery-preview-add-caption');
			}

		// image description
			if ($image['linktext'] != '') {
				$linktext = $image['linktext'];
			} else {
				$linktext = wfMsg('wikiaPhotoGallery-preview-add-description');
			}
?>
		<span class="WikiaPhotoGalleryPreviewSliderCaptionWrapper">
			<p class="WikiaPhotoGalleryPreviewSliderCaption WikiaPhotoGalleryPreviewItemCaption SliderTitle"><?= $caption ?></p>
			<p class="WikiaPhotoGalleryPreviewSliderCaption WikiaPhotoGalleryPreviewItemCaption SliderDescription"><?= $linktext ?></p>
			<p class="WikiaPhotoGalleryPreviewSliderCaption WikiaPhotoGalleryPreviewItemCaption SliderLink"><?= $linkMsg ?></p>
		</span>
	</span>
<?php
			
	}
	
?>
</div>