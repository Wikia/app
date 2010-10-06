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
				<img src="<?php echo $value['imagename'] ?>" class="spotlight-slider <?php echo $slider_class; ?>">
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
	<p class="stay-connected">Stay in the know</p>
	<ul>
		<li class="facebook"><a href="<?= wfMsg('corporatepage-facebook-link') ?>"></a></li>
		<li class="blog"><a href="<?= wfMsg('corporatepage-wikia-blog-link') ?>"></a></li>
		<li class="twitter"><a href="<?= wfMsg('corporatepage-twitter-link') ?>"></a></li>
	</ul>
</section>

<div class="HomeContent">
	<h2>Get Started Today</h2>
	
	<p>Create a wiki about your favorite topic and begin collaborating with people who love what you love.</p>
	 <span><a href="http://www.wikia.com/Special:CreateWiki" class="wikia-button" style="font-size: 23px; padding: 20px 20px 20px 20px;">Start a wiki now</a></span>
</div>
<?php	} ?>
<?php } ?>