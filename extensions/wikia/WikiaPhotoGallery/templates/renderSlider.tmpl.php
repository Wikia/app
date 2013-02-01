<div class="WikiaPhotoGalleryPreview">
	<div class="wikiaPhotoGallery-slider-body" id="wikiaPhotoGallery-slider-body-<?= $sliderId ?>" style="display: none">
		<div class="<?= $sliderClass ?>">
			<ul>
			<? $readMore = wfMsg('galery-slider-read-more');

			foreach( $files as $key => $val ): ?>
				<li class="wikiaPhotoGallery-slider-<?=$key; ?>" id="wikiaPhotoGallery-slider-<?=$sliderId; ?>-<?= $key ?>">

					<? if( !empty( $val['videoHtml'] ) ): ?>
						<?= $val['videoHtml'] ?>
					<? else: ?>
						<? if ( !empty( $val['imageLink'] ) ): ?>
							<a href='<?= $val['imageLink'] ?>'>";
						<? endif; ?>
						<img width='<?= $val['adjWidth']; ?>' height='<?= $val['adjHeight'] ?>'  src='<?=$val['imageUrl']?>' class='wikiaPhotoGallery-slider' style="top: <?= $val['centerTop'] ?>px; margin-left: <?= $val['centerLeft'] ?>px;">
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

					<p class='nav'>
						<img width='<?= $thumbDimensions['w'] ?>' height='<?= $thumbDimensions['h'] ?>' src='<?= $val['imageThumbnail'] ?>'>
					</p>
				</li>
			<? endforeach; ?>
			</ul>
		</div>
	</div>
</div>