<div class="WikiaPhotoGalleryPreview">
	<div class="wikiaPhotoGallery-slider-body" id="wikiaPhotoGallery-slider-body-<?= $sliderId ?>" style="display: none">
		<div class="<?= $sliderClass ?>">
			<ul>
			<? $readMore = wfMsg('galery-slider-read-more');

			foreach( $files as $key => $val ): ?>
				<li class="wikiaPhotoGallery-slider-<?=$key; ?>" id="wikiaPhotoGallery-slider-<?=$sliderId; ?>-<?= $key ?>">

					<? if( !empty( $val['videoHtml'] ) ): ?>
						<? // video html ?>
						<?= $val['videoHtml'] ?>
					<? else: ?>
						<? // image html ?>
						<? if ( !empty( $val['imageLink'] ) ): ?>
							<a href='<?= $val['imageLink'] ?>'>
						<? endif; ?>
						<img width='<?= $val['adjWidth']; ?>' height='<?= $val['adjHeight'] ?>'  src='<?=$val['imageUrl']?>' class='wikiaPhotoGallery-slider' data-image-key="<?= urlencode(htmlspecialchars($val['imageKey'])) ?>" data-image-name="<?= htmlspecialchars($val['imageName']) ?>" style="top: <?= $val['centerTop'] ?>px; margin-left: <?= $val['centerLeft'] ?>px;">
						<? if (!empty( $val['imageLink'] ) ): ?>
							</a>
						<? endif; ?>
					<? endif; ?>

					<div class="description-background"></div>

					<div class="description">
						<h2><?= $val['imageTitle'] ?></h2>
						<p><?= $val['imageDescription'] ?></p>
						<? if( !empty( $val['imageLink'] ) ): ?>
							<a href='<?= $val['imageLink'] ?>' class='wikia-button secondary'>
								<span><?= $readMore ?></span>
							</a>
						<? endif; ?>
					</div>

					<div class='nav <?= $val['navClass'] ?>'>
						<? if( !empty( $val['videoPlayButton'] ) ): ?>
							<?= $val['videoPlayButton'] ?>
						<? endif; ?>
						<img width='<?= $thumbDimensions['w'] ?>' height='<?= $thumbDimensions['h'] ?>' src='<?= $val['imageThumbnail'] ?>'>
					</div>
				</li>
			<? endforeach; ?>
			</ul>
		</div>
	</div>
</div>