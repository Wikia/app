<?php
global $wgScriptPath;
?>
<div id="image-browser-dialog">
	<? if ( !empty( $selectedImage ) ) :?>
		<img src="<?= Sanitizer::encodeAttribute( $selectedImage[ 'url' ] ); ?>" class="selected"
		     alt="<?= wfMessage( 'toplits-image-browser-selected-picture', $selectedImage[ 'name' ] )->escaped(); ?>"
		     title="<?= wfMessage( 'toplits-image-browser-selected-picture', $selectedImage[ 'name' ] )->escaped(); ?>"/>
	<? else :?>
		<div class="selected"
		     title="<?= wfMessage( 'toplits-image-browser-no-picture-selected' )->escaped(); ?>">
			<span><?= wfMessage( 'toplits-image-browser-no-picture-selected' )->escaped(); ?></span>
		</div>
	<? endif ;?>

	<ul class="SuggestedPictures">
		<? foreach( $images as $img ) :?>
			<li>
				<a title="<?= Sanitizer::encodeAttribute( $img[ 'name' ] ); ?>">
					<img src="<?= Sanitizer::encodeAttribute( $img[ 'url' ] ); ?>" alt="<?= Sanitizer::encodeAttribute( $img[ 'name' ] ); ?>" />
				</a>
			</li>
		<? endforeach ;?>
		<li>
			<div class="NoPicture"
			     title="<?= wfMessage( 'toplits-image-browser-clear-picture' )->escaped(); ?>">
				<span><?= wfMessage( 'toplits-image-browser-clear-picture' )->escaped(); ?></span>
			</div>
		</li>
	</ul>

	<img class="osprite shadow-short" src="<?= wfBlankImgUrl() ;?>">
	<form id="toplist-image-upload" action="<?= $wgScriptPath ?>/index.php?action=ajax&rs=TopListHelper::uploadImage" method="POST" enctype="multipart/form-data">
		<label for="wpUploadFile"><?= wfMessage( 'toplists-image-browser-upload-label' )->escaped(); ?></label>
		<div>
			<div class="button"><?= wfMessage( 'toplists-image-browser-upload-btn' )->escaped(); ?><input type="file" name="wpUploadFile" /></div>
		</div>
		<p class="error"></p>
		<div class="BlockInput"></div>
	</form>
</div>
