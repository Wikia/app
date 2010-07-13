<?php
if(in_array($borderColor, array('accent', 'color1'))) {
	$borderColorClass = " {$borderColor}";
}
else {
	$borderColorCSS = " border-color: {$borderColor};";

	if($captionsPosition == 'within') $captionsBackgroundColor = $borderColor;
}
?>
<div class="wikia-gallery clearfix wikia-gallery-position-<?= $position ;?> wikia-gallery-spacing-<?= $spacing ;?> wikia-gallery-border-<?= $borderSize ;?> wikia-gallery-captions-<?= $captionsAlign ;?> wikia-gallery-caption-size-<?= $captionsSize ;?> WikiaPhotoGalleryPreview">
	<?foreach($gallery['images'] as $index => $image):?>

		<?if($perRow != 'dynamic' && ($index % $perRow) == 0):?>
			<div class="wikia-gallery-row">
		<?endif;?>

		<span class="wikia-gallery-item WikiaPhotoGalleryPreviewItem<?= ($image['placeholder']) ? ' WikiaPhotoGalleryPreviewItemPlaceholder' : ' WikiaPhotoGalleryPreviewDraggable' ;?>" style="width: <?= $width ;?>px;" imageid="<?= $index ;?>">
			<div class="thumb" style="height: <?= $maxHeight ;?>px;">
				<div class="gallery-image-wrapper<?= (!empty($borderColorClass)) ? $borderColorClass : null;?>" style="position: relative; height: <?= $image['height'] ;?>px; width:<?= $image['width'] ;?>px;<?= (!empty($image['heightCompensation'])) ? " top:{$image['heightCompensation']}px;" : null ;?><?= (!empty($image['widthCompensation'])) ? " left:{$image['widthCompensation']}px;" : null ;?><?= (!empty($borderColorCSS)) ? $borderColorCSS : null;?>">
					<a class="image<?= (!$image['thumbnail']) ? ' broken-image accent new' : null ;?>"
						style="<?= ($image['thumbnail']) ? " background-image: url({$image['thumbnail']});" : null ;?>; line-height:<?= $image['height'] ;?>px; height:<?= $image['height'] ;?>px; width:<?= $image['width'] ;?>px;"
						title="<?= ($image['placeholder']) ? wfMsg('wikiaPhotoGallery-preview-add-photo') : null ;?>">
						<?= (!empty($image['titleText'])) ? $image['titleText'] : null ;?>
						<?if(!empty($image['link'])):?>
							<?
							$msg = htmlspecialchars(wfMsg('wikiaPhotoGallery-preview-link-tooltip', $image['link']));
							?>
							<span class="WikiaPhotoGalleryPreviewItemLink" title="<?= $msg ?>"></span>
						<?endif;?>
					</a>
		<?if($captionsPosition == 'below'):?>
				</div>
			</div>
		<?endif;?>

					<span class="<?= ($image['placeholder']) ? 'WikiaPhotoGalleryPreviewPlaceholderCaption' : 'WikiaPhotoGalleryPreviewItemCaption' ;?><?= (empty($image['caption'])) ? ' WikiaPhotoGalleryPreviewItemAddCaption' : null ;?><?= (!empty($borderColorClass) && $captionsPosition == 'within') ? $borderColorClass : null ;?> lightbox-caption"
					     style="<?if($captionsPosition == 'below'):?>width: <?= $width ;?>px;<?endif;?><?= (!empty($captionsColor)) ? " color: {$captionsColor};" : null ;?><?if(!empty($captionsBackgroundColor)):?> background-color:<?= $captionsBackgroundColor ;?>;<?endif;?>">
						<?if(!empty($image['caption'])):?>
							<?= $image['caption'] ;?>
						<?else:?>
							<span class="WikiaPhotoGalleryPreviewItemAddCaption"><?= wfMsg('wikiaPhotoGallery-preview-add-caption') ?></span>
						<?endif;?>
					</span>

		<?if($captionsPosition == 'within'):?>
				</div>
			</div>
		<?endif;?>

			<?if(!$image['placeholder']):?>
				<span class="WikiaPhotoGalleryPreviewItemMenu color1">
					<a href="#"><?= wfMsg('WikiaPhotoGallery-preview-hover-modify') ?></a>
					<a href="#"><?= wfMsg('WikiaPhotoGallery-preview-hover-delete')?></a>
				</span>
			<?endif;?>
		</span>

		<?if($perRow != 'dynamic' && (($index % $perRow) == ($perRow - 1) || $index == (count($gallery['images']) - 1))):?>
			</div>
		<?endif;?>
	<?endforeach;?>
</div>
