<div class="WikiaPhotoGalleryPreview">
	<div class="wikiaPhotoGallery-slider-body" id="wikiaPhotoGallery-slider-body-<?= $sliderId ?>" style="display: none">
		<div class="<?= $sliderClass ?>" >
			<ul>
			<?php
			$readMore = wfMsg('galery-slider-read-more');

			foreach ( $images as $key => $val ) {
				?><li class="wikiaPhotoGallery-slider-<?=$key; ?>" id="wikiaPhotoGallery-slider-<?=$sliderId; ?>-<?= $key ?>"><?php
					if ( !empty( $val['imageLink'] ) ){
						echo "<a href='{$val['imageLink']}'>";
					}?>
					<img width='<?= $imagesDimensions['w']; ?>' height='<?= $imagesDimensions['h'] ?>'  src='<?=$val['imageUrl']?>' class='wikiaPhotoGallery-slider'>
					<?php
						if (!empty( $val['imageLink'] )){
							echo '</a>';
						}
					?>
					<div class="description-background"></div>
					<div class="description">
					<h2><?= $val['imageTitle'] ?></h2>
					<p><?= $val['imageDescription'] ?></p>
					<?php
						if (!empty( $val['imageLink'] )){ ?>
							<a href='<?= $val['imageLink'] ?>' class='wikia-button secondary'>
								<span><?= $readMore ?></span>
							</a>
						<?php } ?>
					</div>
					<p class='nav'>
						<img width='<?= $thumbDimensions['w'] ?>' height='<?= $thumbDimensions['h'] ?>' src='<?= $val['imageThumbnail'] ?>'>
					</p>
				</li>
			<?php } ?>
			</ul>
		</div>
	</div>
</div>