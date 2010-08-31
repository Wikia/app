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
	<div class="carousel-container">
		<div>
			<ul class="carousel">	
	<?php
	$count = 1;
	foreach ($thumbUrls as $url) {?>
		<li><a href="<?= $url["file_url"] ?>"><img src="<?= $url["thumb_url"] ?>" /></a></li>
	<?php
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
		</div>
	</div>
	<?= View::specialPageLink('NewFiles', 'oasis-latest-photos-more', array('class' => 'more')) ?>
	
	
<?php }
	?>
</section>


<!--
Bernhard's test front end
-->
<!--
<section class="LatestPhotosModule">
	<a class="wikia-button">Add a Photo</a>
	<details class="counter">
		<em>9,173</em><?= wfMsg('oasis-latest-photos-header') ?>
	</details>
	
		<a href="#" class="previous"><img src="<?= $wgBlankImgUrl; ?>" class="latest-images-left"></a>
		<a href="#" class="next"><img src="<?= $wgBlankImgUrl; ?>" class="latest-images-right"></a>
		<div class="carousel-container">
			<div>
				<ul class="carousel">
					<li class="1"><a href="#"><img src="/skins/oasis/images/latestphotos/1.jpg" /></a></li>
					<li class="2"><a href="#"><img src="/skins/oasis/images/latestphotos/2.jpg" /></a></li>
					
					<li class="3"><a href="#"><img src="/skins/oasis/images/latestphotos/3.jpg" /></a></li>
					<li class="4"><a href="#"><img src="/skins/oasis/images/latestphotos/4.jpg" /></a></li>
					<li class="5"><a href="#"><img src="/skins/oasis/images/latestphotos/5.jpg" /></a></li>
					<li class="6"><a href="#"><img src="/skins/oasis/images/latestphotos/6.jpg" /></a></li>	
					<li class="7"><a href="#"><img src="/skins/oasis/images/latestphotos/7.jpg" /></a></li>	
					<li class="8"><a href="#"><img src="/skins/oasis/images/latestphotos/8.jpg" /></a></li>		
					<li class="9"><a href="#"><img src="/skins/oasis/images/latestphotos/9.jpg" /></a></li>
					<li class="10"><a href="#"><img src="/skins/oasis/images/latestphotos/10.jpg" /></a></li>
					<li class="see-all"><a href="#">See All Photos</a></li>		
				</ul>
			</div>
		</div>
	<a class="more">See All Photos in This Gallery ></a>
</section>
-->