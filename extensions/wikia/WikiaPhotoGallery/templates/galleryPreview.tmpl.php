<?php
if (in_array($borderColor, array('accent', 'color1'))) {
	$borderColorClass = " {$borderColor}";
} else {
	$borderColorCSS = " border-color: {$borderColor};";
	if ($captionsPosition == 'within') $captionsBackgroundColor = $borderColor;
}
$extraClass = empty($fromFeed) ? ' WikiaPhotoGalleryPreviewDraggable' : ' WikiaPhotoGalleryPreviewFeed';
?>
<div class="wikia-gallery clearfix wikia-gallery-position-<?= $position ;?> wikia-gallery-spacing-<?= $spacing ;?> wikia-gallery-border-<?= $borderSize ;?> wikia-gallery-captions-<?= $captionsAlign ;?> wikia-gallery-caption-size-<?= $captionsSize ;?> WikiaPhotoGalleryPreview">
	<?php
	if (!count($gallery['images'])) {
		echo wfMsg('wikiaPhotoGallery-preview-no-images');
	} else {
		foreach ($gallery['images'] as $index => $image) { ?>

			<?php if ($perRow != 'dynamic' && ($index % $perRow) == 0) { ?>
				<div class="wikia-gallery-row">
			<?php } ?>

			<span class="wikia-gallery-item WikiaPhotoGalleryPreviewItem<?= $image['placeholder'] ? ' WikiaPhotoGalleryPreviewItemPlaceholder' : $extraClass ;?>" style="width: <?= $width ;?>px;" imageid="<?= $index ;?>">
				<div class="thumb" style="height: <?= $maxHeight ;?>px;">
					<div class="gallery-image-wrapper<?= !empty($borderColorClass) ? $borderColorClass : null;?>"
						 style="position: relative; height: <?= $image['height'] ;?>px; width:<?= $image['width'] ;?>px;<?= (!empty($image['heightCompensation'])) ? " top:{$image['heightCompensation']}px;" : null ;?><?= !empty($borderColorCSS) ? $borderColorCSS : null;?>">
						<a class="image<?= (!$image['thumbnail']) ? ' broken-image accent new' : null ;?>"
							style="<?= ($image['thumbnail']) ? " background-image: url({$image['thumbnail']});" : null ;?>; line-height:<?= $image['height'] ;?>px; height:<?= $image['height'] ;?>px; width:<?= $image['width'] ;?>px;"
							title="<?= ($image['placeholder']) ? wfMsg('wikiaPhotoGallery-preview-add-photo') : null ;?>">
							<?= (!empty($image['titleText'])) ? $image['titleText'] : null ;?>
							<?php if (!empty($image['link'])) { ?>
								<?php
								$msg = htmlspecialchars(wfMsg('wikiaPhotoGallery-preview-link-tooltip', $image['link']));
								?>
								<span class="WikiaPhotoGalleryPreviewItemLink" title="<?= $msg ?>"></span>
							<?php }
								if (!empty($image['image'])) { ?>
								<img data-src="<?= htmlspecialchars($image['image']) ?>" alt="" />
							<?php
								}
							?>
						</a>
			<?php if ($captionsPosition == 'below') { ?>
					</div>
				</div>
			<?php } ?>
						<span class="<?= $image['placeholder'] ? 'WikiaPhotoGalleryPreviewPlaceholderCaption' : 'WikiaPhotoGalleryPreviewItemCaption' ;?><?= empty($image['caption']) ? ' WikiaPhotoGalleryPreviewItemAddCaption' : null ;?><?= !empty($borderColorClass) && $captionsPosition == 'within' ? $borderColorClass : null ;?> lightbox-caption"
							 style="<?php if ($captionsPosition == 'below') { ?>width: <?= $width ;?>px;<?php } ?><?= !empty($captionsColor) ? " color: {$captionsColor};" : null ;?><?php if (!empty($captionsBackgroundColor)) { ?> background-color:<?= $captionsBackgroundColor ;?>;<?php } ?>">
							<?php if (!empty($image['caption'])) { ?>
								<?= $image['caption'] ;?>
							<?php } else { ?>
								<span class="WikiaPhotoGalleryPreviewItemAddCaption"><?= wfMsg('wikiaPhotoGallery-preview-add-caption') ?></span>
							<?php } ?>
						</span>

			<?php if ($captionsPosition == 'within') { ?>
					</div>
				</div>
			<?php } ?>

				<?php if (empty($fromFeed) && !$image['placeholder']) { ?>
					<span class="WikiaPhotoGalleryPreviewItemMenu color1">
						<a href="#"><?= wfMsg('WikiaPhotoGallery-preview-hover-modify') ?></a>
						<a href="#"><?= wfMsg('WikiaPhotoGallery-preview-hover-delete')?></a>
					</span>
				<?php } ?>
			</span>

			<?php if ($perRow != 'dynamic' && (($index % $perRow) == ($perRow - 1) || $index == (count($gallery['images']) - 1))) { ?>
				</div>
			<?php }
		}	//foreach
	}	//no images ?>
</div>