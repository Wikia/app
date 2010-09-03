<div id="WikiHeader" class="WikiHeader">
	<h1 class="wordmark">
		<a accesskey="z" href="<?= htmlspecialchars($mainPageURL) ?>"><?= htmlspecialchars($wgSitename) ?></a>
	</h1>
	<nav>
		<ul>

<?php
if(is_array($menuNodes) && isset($menuNodes[0])) {
	foreach($menuNodes[0]['children'] as $level0) {
?>
			<li>
				<a href="<?= $menuNodes[$level0]['href'] ?>">
					<?= $menuNodes[$level0]['text'] ?><?php /*cannot be space between text and &nbsp;*/ if(isset($menuNodes[$level0]['children'])) { ?>&nbsp;<img src="<?= $wgBlankImgUrl; ?>" class="chevron"><?php } ?>
				</a>
<?php
		if(isset($menuNodes[$level0]['children'])) {
?>
				<ul class="subnav">
<?php
			foreach($menuNodes[$level0]['children'] as $level1) {
?>
					<li>
						<a href="<?= $menuNodes[$level1]['href'] ?>"><?= $menuNodes[$level1]['text'] ?></a>
					</li>
<?php
			}
?>
<?php
			if($canEdit) {
?>
					<li class="edit-menu last">
						<a href="<?= $editURL['href'] ?>"><?= $editURL['text'] ?></a>
					</li>
<?php
			}
?>

				</ul>
<?php
		}
?>
			</li>
<?php
	}
}
?>
		</ul>
	</nav>
	<div class="buttons">
		<?= View::specialPageLink('Random', 'oasis-button-random-page', array('accesskey' => 'x', 'class' => 'wikia-button secondary', 'data-id' => 'randompage'), 'blank.gif') ?><?= View::specialPageLink('WikiActivity', 'oasis-button-wiki-activity', array('accesskey' => 'g', 'class' => 'wikia-button secondary', 'data-id' => 'wikiactivity'), 'blank.gif') ?>
	</div>
	<div style="position: absolute; top: -1000px">
		<?= View::specialPageLink('Watchlist', 'watchlist', array('accesskey' => 'l')) ?>
		<?= View::specialPageLink('RecentChanges', 'recentchanges', array('accesskey' => 'r')) ?>
	</div>
	<img class="shade" src="<?= $wgBlankImgUrl ?>">
	<img class="smask" src="<?= $wgBlankImgUrl ?>">
</div>