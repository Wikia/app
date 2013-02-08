<div class="WikiaMosaicSlider" style="display:none">
	<div class="wikia-mosaic-slider-region">
		<a href="" class="wikia-mosaic-link">
			<div class="wikia-mosaic-slider-panorama">
			</div>
			<div class="wikia-mosaic-slider-description-mask">
			</div>
			<div class="wikia-mosaic-slider-description">
			</div>
		</a>
	</div>
	<ul class="wikia-mosaic-thumb-region">
	<?
		$index = 0;
		foreach ( $files as $key => $val ) {
			$index++;
	?>
		<li class="wikia-mosaic-slide<?= $index === 5 ? ' last' : ''?>">
			<? if ( !empty( $val['imageLink'] ) ): ?>
					<a href='<?= htmlspecialchars($val['imageLink'],ENT_QUOTES); ?>' class='wikia-mosaic-link'>
			<? endif; ?>

			<? if( !empty( $val['videoHtml'] ) ): ?>
				<?= $val['videoHtml'] ?>
			<? else: ?>
				<img width='<?= $imagesDimensions['w']; ?>' height='<?= $imagesDimensions['h'] ?>' src='<?=$val['imageUrl']?>' class="wikia-mosaic-hero-image">
			<? endif; ?>
			
			<img width='<?= $thumbDimensions['w'] ?>' height='<?= $thumbDimensions['h'] ?>' src='<?= $val['imageThumbnail'] ?>' class="wikia-mosaic-thumb-image">

			<span class="wikia-mosaic-description-mask">
			</span>
			<span class="wikia-mosaic-description">
				<span class="image-description"><?= $val['imageTitle'] ?></span>
				<span class="wikia-mosaic-short-title"><?= $val['imageShortTitle'] ?></span>
				<span class="description-more"><?= $val['imageDescription'] ?></span>
			</span>
			<? if ( !empty( $val['imageLink'] ) ): ?>
					</a>
			<? endif; ?>
		</li>
	<? } ?>
	</ul>
</div>