<div class="WikiaPhotoGalleryPreview" style='height:270px;overflow:hidden'>
	<div class="wikiaPhotoGallery-slider-body" id="wikiaPhotoGallery-slider-body-<?= $sliderId ?>">
		<ul>
		<?php
		foreach ( $images as $key => $val ) {
			?><li class="wikiaPhotoGallery-slider-<?=$key; ?>" id="wikiaPhotoGallery-slider-<?= $sliderId; ?>-<?= $key ?>"><?php
				if ( !empty( $val['imageLink'] ) ){
					echo "<a href='{$val['imageLink']}'>";
				}?>
				<?php
					echo "<img class=wikiaPhotoGallery-slider data-src={$val['imageUrl']} src=../../skins/wikiamobile/images/loading_big.gif>";
				?>
				<?php
					if (!empty( $val['imageLink'] )){
						echo '</a>';
					}
				?>
				<div class="description">
				<h2><?= $val['imageTitle'] ?></h2>
				<p><?= $val['imageDescription'] ?></p>
				</div>
				<p class='nav'>
					<img src='<?= $val['imageThumbnail'] ?>'>
				</p>
			</li>
		<?php } ?>
		</ul>
	</div>
</div>