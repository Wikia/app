<?php $initialSlider = rand( 0, 3 ); ?>
<div class="WikiaPhotoGalleryPreview" style='height:270px;overflow:hidden'>
	<div class="wikiaPhotoGallery-slider-body" id="wikiaPhotoGallery-slider-body-<?= $sliderId ?>" data-initialslider="<?= $initialSlider; ?>">
		<ul>
		<?php
		$readMore = wfMsg('galery-slider-read-more');

		foreach ( $images as $key => $val ) {
			?><li class="wikiaPhotoGallery-slider-<?=$key; ?>" id="wikiaPhotoGallery-slider-<?= $sliderId; ?>-<?= $key ?>"><?php
				if ( !empty( $val['imageLink'] ) ){
					echo "<a href='{$val['imageLink']}'>";
				}?>
				<img <?= ($key)?'data-':'' ?>src='<?=$val['imageUrl']?>' <?= ($key)?"src='../../skins/wikiamobile/images/loading_big.gif'":''; ?> class='wikiaPhotoGallery-slider'>
				<?php
					if (!empty( $val['imageLink'] )){
						echo '</a>';
					}
				?>
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
					<img src='<?= $val['imageThumbnail'] ?>'>
				</p>
			</li>
		<?php } ?>
		</ul>
	</div>
</div>