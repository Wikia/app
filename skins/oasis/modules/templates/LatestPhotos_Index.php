<section class="LatestPhotosModule module" id="LatestPhotosModule">
	<h1 class="tight"><?= wfMsg('oasis-latest-photos-title') ?></h1>
	<?= (!empty($wg->EnableUploads)) ? Wikia::specialPageLink('Upload', 'oasis-add-photo', (!$isUserLoggedIn ? 'wikia-button upphotoslogin' :'wikia-button upphotos'), 'blank.gif', 'oasis-add-photo-to-wiki', 'sprite photo', '', 'tooltip') : '' ?>
	<div class="tally counter">
		<?= wfMsgExt('oasis-latest-photos-header', array( 'parsemag' ), $total, ($total < 100000 ? 'fixedwidth' : '') ) ?>
	</div>

<?php
if ($enableEmptyGallery == true) { ?>
	<div class="empty-photos">
		<div class="temp-image">
			 <?= Wikia::specialPageLink('Upload', 'oasis-latest-photos-empty'); ?>
		</div>
	</div>
<?php }
else {
	 ?>
	<?php
	$class = "";
	if ($enableScroll == false) {
		$class = " hidden";
	}
		?>
		<a href="#" class="previous<?= $class ?>"><img src="<?= $wg->BlankImgUrl; ?>" class="latest-images-left" height="0" width="0"></a>
		<a href="#" class="next<?= $class ?>"><img src="<?= $wg->BlankImgUrl; ?>" class="latest-images-right" height="0" width="0"></a>
	<div class="carousel-container">
		<div>
			<ul class="carousel">
	<?php
	// macbre: how many images to show at the page load, next images will be lazy loaded
	$load = 3;
	foreach ($thumbUrls as $i => $url) {?>
		<li class="thumbs"><a class="image" data-ref="<?= $url["image_filename"] ?>" href="<?= $url["file_url"] ?>">
			<? if ( isset( $url['isVideoThumb'] ) && $url['isVideoThumb'] ) echo WikiaFileHelper::videoPlayButtonOverlay( LatestPhotosController::THUMB_SIZE, LatestPhotosController::THUMB_SIZE ); ?>
			<img class="thumbimage" height="<?= LatestPhotosController::THUMB_SIZE; ?>" width="<?= LatestPhotosController::THUMB_SIZE; ?>" <?= $i < $load ? 'src' : "src='$wg->BlankImgUrl' data-src" ?>="<?= $url["thumb_url"] ?>" />
		</a>

		<span class="thumbcaption">
			<?= wfMsg('oasis-latest-photos-by'); ?> <?= $url["user_href"] ?><br/>
			<time class="timeago" datetime="<?= $url["date"] ?>"><?= $url["date"] ?></time><br/>

			<?php
		if (count($url["links"]) >= 1) {?>
			<?= wfMsg('oasis-latest-photos-posted-in'); ?>
			<?= implode(',&nbsp;', $url["links"] ); ?>
		<?php
		}
			?>
		</span>
		</li>
	<?php
	}
	?>
	<?php
	if (count($thumbUrls) > 2) { ?>
		<li class="see-all">
			<?= Wikia::specialPageLink('NewFiles', 'oasis-latest-photos-inner-message') ?>
		</li>
	<?php
	}
	else {?>
		<li class="add-more single-photo"><?= Wikia::specialPageLink('Upload', 'oasis-latest-photos-single') ?></li>
		<?php

	}?>
			</ul>
		</div>
	</div>
	<?= Wikia::specialPageLink('NewFiles', 'oasis-latest-photos-more', array('class' => 'more')) ?>


<?php }
	?>
</section>
