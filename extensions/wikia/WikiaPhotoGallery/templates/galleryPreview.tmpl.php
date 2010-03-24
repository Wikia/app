<?php
	// handle parameters
	$perRow = !empty($gallery['params']['perrow']) ? intval($gallery['params']['perrow']): false;

	$captionsAlign = !empty($gallery['params']['captionalign']) ? $gallery['params']['captionalign'] : 'left';

	if (in_array($captionsAlign, array('center', 'right'))) {
		$galleryClass = ' WikiaPhotoGalleryPreviewCaptions' . ucfirst($captionsAlign);
	}
	else {
		$galleryClass = '';
	}

	// style attributes
	$imageStyleAttrib = ' style="height: ' . ($thumbSize + 30) . 'px; width: ' . ($thumbSize + 30) . 'px"';

?>
<div class="WikiaPhotoGalleryPreview<?= $galleryClass ?>">
<?php
	// render caption
	if (isset($gallery['params']['caption'])) {
?>
	<div class="WikiaPhotoGalleryPreviewCaption"><?= $gallery['params']['caption'] /* HTML encoding done by MW Parser */ ?></div>
<?
	}
?>
<?php
	// render images
	foreach($gallery['images'] as $i => $image) {
?>
	<span class="WikiaPhotoGalleryPreviewItem WikiaPhotoGalleryPreviewDraggable" imageid="<?= $i ?>">
		<table class="WikiaPhotoGalleryPreviewItemImage"><tr><td class="WikiaPhotoGalleryPreviewItemImageCell"<?= $imageStyleAttrib ?>>
			<?= $image['thumbnail'] ?>
<?php
	if ($image['link'] != '') {
		$msg = htmlspecialchars(wfMsg('wikiaPhotoGallery-preview-link-tooltip', $image['link']));
?>
			<a href="#" class="WikiaPhotoGalleryPreviewItemLink" title="<?= $msg ?>" style="top: <?= intval($thumbSize + 17) ?>px"></a>
<?php
	}
?>
		</td></tr></table>
		<span class="WikiaPhotoGalleryPreviewItemCaption<?= ($image['caption'] == '') ? ' WikiaPhotoGalleryPreviewItemAddCaption' : ''  ?>" style="width: <?= ($thumbSize + 30) ?>px"><?php

	if ($image['caption'] != '') {
		echo $image['caption'];
	}
	else {
?>
			<a href="#" class="WikiaPhotoGalleryPreviewItemAddCaption"><?= wfMsg('wikiaPhotoGallery-preview-add-caption') ?></a>
<?php
	}

?></span>

		<span class="WikiaPhotoGalleryPreviewItemMenu color1">
			<a href="#"><?= wfMsg('WikiaPhotoGallery-preview-hover-modify') ?></a>
			<a href="#"><?= wfMsg('WikiaPhotoGallery-preview-hover-delete')?></a>
		</span>
	</span>
<?php
		if ($perRow) {
			if ($i % $perRow == $perRow-1) {
				echo '<br />';
			}
		}
	}

	// show at least four items:
 	// - if we don't have enough images - show "Add a picture" placeholders
	// - if we have four and more images - show just one "Add a picture" placeholder
	$placeholdersCount = max(4-count($gallery['images']), 1);

	for ($p=0; $p < $placeholdersCount; $p++) {
?>
		<span class="WikiaPhotoGalleryPreviewItem WikiaPhotoGalleryPreviewItemPlaceholder">
			<a class="WikiaPhotoGalleryPreviewItemImage"<?= $imageStyleAttrib ?> title="<?= wfMsg('wikiaPhotoGallery-preview-add-photo') ?>" href="#"></a>
		</span>
<?php
	}
?>
</div>
