<div id="recipes_saved_pages_box">
	<dl class="widget">
		<dd>
			<h3><?= wfMsg('recipes-my-saved-pages') ?></h3>
<?php
	if (empty($pages)) {
?>
			<p><?= wfMsg('recipes-my-saved-pages-empty') ?></p>
<?php
	}
	else {
?>
			<ul>
<?php
		foreach($pages as $page) {
?>
				<li><a href="<?= htmlspecialchars($page['url']) ?>"><?= htmlspecialchars($page['title']) ?></a></li>
<?php
		}
?>
			</ul>
<?php
	}
?>
			<div class="toolbar neutral color1">
				<a class="wikia_button forward" href="<?= htmlspecialchars($moreLink) ?>"><span><?= wfMsg('recipes-more') ?></span></a>
			</div>
		</dd>
	</dl>
</div>
