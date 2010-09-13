<?php ?>
<div id="image-browser-dialog">
	<img src="http://www.multichannel.com/photo/253/253991-Glee.jpg" class="selected" />
	<ul class="SuggestedPictures">
		<? foreach( $images as $img ) :?>
			<li>
				<img src="<?= $img[ 'url' ] ;?>" alt="<?= $img[ 'name' ] ;?>" />
			</li>
		<? endforeach ;?>
		<li>
			<div class="NoPicture"><?= wfMsg( 'toplits-image-browser-no-picture' ) ;?></div>
		</li>
	</ul>
</div>