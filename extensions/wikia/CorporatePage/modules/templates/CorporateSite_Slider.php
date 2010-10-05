<?php if (!empty($slider)) { ?>
<section id="HomepageFeature">
	<section id="spotlight-slider">
	<ul>
		<?php
					$wiki_featured_images = array();
					foreach($slider as $key => $value):
		?>
		<li id="spotlight-slider-<?php echo $key; ?>">
			<a href="<?php echo $value['href'] ?>">
				<img width="620" height="250" src="<?php echo $value['imagename'] ?>" class="spotlight-slider">
			</a>
			<div class="description">
				<h2><?php echo $value['title'] ?></h2>
				<p><?php echo $value['desc'] ?></p>
				<a href="<?php echo $value['href'] ?>" class="wikia-button secondary">
					<?php echo wfMsg('corporatepage-go-to-wiki',$value['title']); ?>
				</a>
			</div>
			<p class="nav">
				<img width="50" height="25" alt="" src="<?php echo $value['imagethumb'] ?>">
			</p>
		</li>
		<?php array_push($wiki_featured_images, $value['imagename']);
					endforeach;?>
	</ul>
	</section>
</section>
<?php } ?>