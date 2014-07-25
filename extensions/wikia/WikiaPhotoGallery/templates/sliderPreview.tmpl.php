<div class="WikiaPhotoGalleryPreview">
<?php
	/** @var array $slider */
	$extraClass = '';
	// render images
	foreach ( $slider['images'] as $i => $image ) {
		if ( $image['videoPlayButton'] ) {
			$extraClass = 'video-thumbnail';
		}
?>
	<span class="WikiaPhotoGalleryPreviewItem WikiaPhotoGalleryPreviewDraggable <?= $extraClass ?>" imageid="<?= $i ?>" style="width: <?= $width?>px; ">

		<span class="WikiaPhotoGalleryPreviewItemMenu color1">
			<a href="#"><?= wfMsg( 'WikiaPhotoGallery-preview-hover-modify' ) ?></a>
			<a href="#"><?= wfMsg( 'WikiaPhotoGallery-preview-hover-delete' )?></a>
		</span>

		<? $notDisplayed = ( $i >= 4 && $slider['params']['orientation'] !== 'mosaic' ); ?>
		<span class="WikiaPhotoGallerySliderItemNumber<?= $notDisplayed ? 'Warning' : ''; ?>">
			<div><?php
				if ( $notDisplayed ){
					echo wfMsg( 'wikiaPhotoGallery-not-displayed' );
				} else {
					echo '#'.( $i+1 );
				}
			?></div>
		</span>

		<? if( $image['videoPlayButton'] ) : ?>
			<?= $image['videoPlayButton'] ?>
		<? endif; ?>
		<span style="display:block;<? if ( !empty( $image[ 'thumbnailBg' ] ) ): ?>background-image: url(<?= $image['thumbnailBg'] ?>);<? endif; ?> width: <?= $width?>px; height: <?= $height ?>px">

		 </span>
<?php
		if ( !empty( $image['image'] ) ) {
?>
		<img data-src="<?= htmlspecialchars( $image['image'] ) ?>" alt="" />
<?php
		} else if ( empty( $image['thumbnailBg'] ) ) {
?>
			<a class="image broken-image new" style="line-height: <?= $height ?>px;"><?= $image['pageTitle']; ?></a>
<?php
		}
		// link icon
			if ( $image['link'] != '' ) {
				$linkMsg = htmlspecialchars( $image['link'] );
			} else {
				$linkMsg = wfMsg( 'wikiaPhotoGallery-preview-add-link' );
			}
		// image caption
			if ( $image['caption'] != '' ) {
				$caption = Sanitizer::removeHTMLtags( $image['caption'] );
			} else {
				$caption = wfMsg( 'wikiaPhotoGallery-preview-add-caption' );
			}

		// image description
			if ( $image['linktext'] != '' ) {
				$linktext = Sanitizer::removeHTMLtags( $image['linktext'] );
			} else {
				$linktext = wfMsg( 'wikiaPhotoGallery-preview-add-description' );
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
