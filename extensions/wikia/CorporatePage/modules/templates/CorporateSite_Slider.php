<?php if (!empty($slider)) {
	$class_hub = ($isMainPage == true) ? "": ' hub';	
?>

<section id="HomepageFeature">
	<section id="spotlight-slider" class="<?php echo $slider_class; echo $class_hub; ?>">
	<ul>
		<?php
			$wiki_featured_images = array();
			foreach($slider as $key => $value):
		?>
		<li id="spotlight-slider-<?php echo $key; ?>">
			<a href="<?php echo $value['href'] ?>">
				<img src="<?php echo $value['imagename'] ?>" class="spotlight-slider-image <?php echo $slider_class; ?>">
			</a>
			<div class="description">
				<h2><?php echo $value['title'] ?></h2>
				<p><?php echo $value['desc'] ?></p>
				<a href="<?php echo $value['href'] ?>" class="wikia-button secondary">
					<?php echo wfMsg('corporatepage-go-to-wiki',$value['title']); ?>
				</a>
			</div>
			<p class="nav <?php echo $slider_class; ?>">
				<img width="50" height="25" alt="" src="<?php echo $value['imagethumb'] ?>">
			</p>
		</li>
		<?php array_push($wiki_featured_images, $value['imagename']);
					endforeach;?>
	</ul>
	</section>
</section>



<?php 
	if ($isMainPage == true) {?>
<section class="HomepageLink">
	<p class="stay-connected"><?= wfMsg('corporatepage-stay-in-the-know') ?></p>
	<ul>
		<li class="facebook"><a href="<?= wfMsg('corporatepage-facebook-link') ?>"></a></li>
		<li class="blog"><a href="<?= wfMsg('corporatepage-wikia-blog-link') ?>"></a></li>
		<li class="twitter"><a href="<?= wfMsg('corporatepage-twitter-link') ?>"></a></li>
	</ul>
</section>
<?php	} ?>
<?php } ?>