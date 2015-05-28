<section class="FollowedPagesModule module">
	<h2><?= wfMsg('wikiafollowedpages-userpage-heading') ?></h2>
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
				</a>
			</div>
		</li>
<?php	} 
	}
?>
	</ul>
	<?= isset($follow_all_link) ? $follow_all_link : '' ?>
</section>
