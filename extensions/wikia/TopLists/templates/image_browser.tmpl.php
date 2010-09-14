<?php ?>
<div id="image-browser-dialog">
	<img src="http://www.multichannel.com/photo/253/253991-Glee.jpg" class="selected" />
	<img class="shadow-mask" src="http://images1.wikia.nocookie.net/__cb21710/common/skins/common/blank.gif">
	<ul class="SuggestedPictures">
		<? foreach( $images as $img ) :?>
			<li>
				<img src="<?= $img[ 'url' ] ;?>" alt="<?= $img[ 'name' ] ;?>" />
			</li>
		<? endforeach ;?>
		<li>
			<div class="NoPicture"><?= wfMsg( 'toplits-image-browser-clear-picture' ) ;?></div>
		</li>
	</ul>
</div>