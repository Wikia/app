<?php ?>
<div id="image-browser-dialog">
	<? if ( !empty( $selectedImage ) ) :?>
		<img src="<?= $selectedImage[ 'url' ] ;?>" class="selected"
		     alt="<?= wfMsg( 'toplits-image-browser-selected-picture', $selectedImage[ 'name' ] ) ;?>"
		     title="<?= wfMsg( 'toplits-image-browser-selected-picture', $selectedImage[ 'name' ] ) ;?>"/>
	<? else :?>
		<div class="selected"
		     title="<?= wfMsg( 'toplits-image-browser-no-picture-selected' ) ;?>">
			<?= wfMsg( 'toplits-image-browser-no-picture-selected' ) ;?>
		</div>
	<? endif ;?>

	<img class="osprite shadow-short" src="<?= wfBlankImgUrl() ;?>">

	<ul class="SuggestedPictures">
		<? foreach( $images as $img ) :?>
			<li>
				<a href="#" title="<?= $img[ 'name' ] ;?>">
					<img src="<?= $img[ 'url' ] ;?>" alt="<?= $img[ 'name' ] ;?>" />
				</a>
			</li>
		<? endforeach ;?>
		<li>
			<div class="NoPicture"
			     title="<?= wfMsg( 'toplits-image-browser-clear-picture' ) ;?>">
				<?= wfMsg( 'toplits-image-browser-clear-picture' ) ;?>
			</div>
		</li>
	</ul>

	<img class="osprite shadow-short" src="<?= wfBlankImgUrl() ;?>">
	<form id="toplist-image-upload" action="<?= $wgScriptPath ?>/index.php?action=ajax&amp;rs=AchAjax&amp;method=addPlatinumBadge" method="POST" enctype="multipart/form-data">
		<input type="file" name="wpUploadFile" />
	</form>
</div>