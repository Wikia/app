<!--
Owens backend
-->
<section class="LatestPhotosModule">
		<?= View::specialPageLink('Upload', 'oasis-add-photo', 'wikia-button'); ?>
	<details class="tally counter">
		<em>9,173</em><?= wfMsg('oasis-latest-photos-header') ?>
	</details>
	
<?php
if ($enableEmptyGallery == true) { ?>
	<details class="empty-photos">
		<div class="temp-image">
			<?= View::specialPageLink('Upload', 'oasis-latest-photos-empty'); ?>
		</div>
	</details>
<?php }
else {
	 ?>
	<?php
	$class = "";
	if ($enableScroll == false) {
		$class = " hidden";
	}
		?>
		<a href="#" class="previous<?= $class ?>"><img src="<?= $wgBlankImgUrl; ?>" class="latest-images-left"></a>
		<a href="#" class="next <?= $class ?>"><img src="<?= $wgBlankImgUrl; ?>" class="latest-images-right"></a>
	<ul class="carousel">		
	<?php
	$count = 1;
	foreach ($thumbUrls as $url) {
		echo sprintf('<li class="%s"><a href="%s"><img src="%s" /></a></li>',
				$count, $url["file_url"], $url["thumb_url"]);

	}
	?>
	<?php 
	if (count($thumbUrls) > 2) { ?>
		<li class="see-all"><?= View::specialPageLink('NewFiles', 'oasis-latest-photos-inner-message') ?></li>
	<?php 
	}
	else {?>
		<li class="add-more"><?= View::specialPageLink('Upload', 'oasis-latest-photos-single') ?></li>	
		<?php 

	}?>

	</ul>

	<?= View::specialPageLink('NewFiles', 'oasis-latest-photos-more', array('class' => 'more')) ?>
	
	
<?php }
	?>
</section>