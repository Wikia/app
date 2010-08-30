<section class="FollowedPagesModule">
	<h1><?= wfMsg('wikiafollowedpages-userpage-heading') ?></h1>
<?php
	if(count($data) == 0) {
		echo wfMsg('wikiafollowedpages-special-empty');
	} else {
?>
	<ul>
<?php

for ($i=0; $i < $max_followed_pages; $i++) {
	$item = $data[$i];?>
		<li>
			<div>
				<a href="<?= $item['url'] ?>">
					<?= $item['wl_title'] ?>
				</a><?php /*&nbsp;<span class="wikia-chiclet-button"><img src="<?= $wgStylePath ?>/oasis/images/icon_article_comments.png"></span> 5<?= $comments ?> */ ?>
			</div>
			<!--<div class="controls">
				<?php /** out for now **/ /*<img src="<?= $wgStylePath ?>/oasis/images/icon_article_like.png"> 12<?= $likes ?> */ ?>
				<?php /** moved up for now **/ /*  */ ?>
			</div>-->
		</li>
<?php	} 
	}
?>
	</ul>
	<?= $follow_all_link ?>
</section>