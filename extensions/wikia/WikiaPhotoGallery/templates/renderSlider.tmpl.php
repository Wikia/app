<div class="WikiaPhotoGalleryPreview">
	<div class="wikiaPhotoGallery-slider-body" id="wikiaPhotoGallery-slider-body-<?=$sliderId; ?>" style='display: none; overflow: hidden; width:673px; height: 410px;'>
		<div class="<?=$sliderClass ?>" >
			<ul>
			<?php
			foreach ( $images as $key => $val ) {
				wfLoadExtensionMessages('WikiaPhotoGallery');
				$msg = wfMsg( 'galery-slider-read-more' );

				?><li class="wikiaPhotoGallery-slider-<?=$key; ?>" id="wikiaPhotoGallery-slider-<?=$sliderId; ?>-<?=$key; ?>"><?;
					if ( !empty( $val['imageLink'] ) ){
						echo "<a href='{$val['imageLink']}'>";
					}?>
					<img width='<?=WikiaPhotoGalleryHelper::STRICT_IMG_WIDTH; ?>' height='<?=WikiaPhotoGalleryHelper::STRICT_IMG_HEIGHT; ?>' src='<?=$val['imageUrl']?>' class='wikiaPhotoGallery-slider'>
					<?
						if (!empty( $val['imageLink'] )){
							echo '</a>';
						}
					?>
					<div class="description-background"></div>
					<div class="description">
					<h2><?=$val['imageTitle']; ?></h2>
					<p><?=$val['imageDescription']; ?></p>
					<?
						if (!empty( $val['imageLink'] )){ ?>
							<a href='<?=$val['imageLink']; ?>' class='wikia-button secondary'>
								<span><?=$msg; ?></span>
							</a>
						<? } ?>
					</div>
					<p class='nav'>
						<img width='<?=$thumbDimensions['w']; ?>' height='<?=$thumbDimensions['h']; ?>' alt='' src='<?=$val['imageThumbnail']; ?>'>
					</p>
				</li>
			<? } ?>
			</ul>
		</div>
	</div>
</div>