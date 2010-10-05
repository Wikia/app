<header id="WikiHeader" class="WikiHeader">
	<? if ($wgSingleH1) { ?>
	<div class="headline-div wordmark <?= $wordmarkSize ?> <?= $wordmarkType ?> <?= $wordmarkFont ?>" <?= $wordmarkStyle ?>>
		<a accesskey="z" href="<?= htmlspecialchars($mainPageURL) ?>"><?= htmlspecialchars($wordmarkText) ?></a>
	</div>
	<? } else { ?>
	<h1 class="wordmark <?= $wordmarkSize ?> <?= $wordmarkType ?> <?= $wordmarkFont ?>" <?= $wordmarkStyle ?>>
		<a accesskey="z" href="<?= htmlspecialchars($mainPageURL) ?>"><?= htmlspecialchars($wordmarkText) ?></a>
	</h1>
	<? } ?>
	<nav>
		<? if (!$wgSingleH1) { ?>
		<h1><?= htmlspecialchars($wordmarkText) ?> Navigation</h1>
		<? } ?>
		<ul>

<?php
if(is_array($menuNodes) && isset($menuNodes[0])) {
	foreach($menuNodes[0]['children'] as $level0) {
?>
			<li>
				<a href="<?= $menuNodes[$level0]['href'] ?>">
					<?= $menuNodes[$level0]['text'] ?><?php /*cannot be space between text and &nbsp;*/ if(isset($menuNodes[$level0]['children'])) { ?>&nbsp;<img src="<?= $wgBlankImgUrl; ?>" class="chevron" width="0" height="0"><?php } ?>
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
			if($editURL) {
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
<?php if ($wgEnableCorporatePageExt) { 
		echo wfRenderModule('RandomWiki');
} else { ?>
		<?= View::specialPageLink('Random', 'oasis-button-random-page', array('accesskey' => 'x', 'class' => 'wikia-button secondary', 'data-id' => 'randompage'), 'blank.gif') ?>
		<?= View::specialPageLink('WikiActivity', 'oasis-button-wiki-activity', array('accesskey' => 'g', 'class' => 'wikia-button secondary', 'data-id' => 'wikiactivity'), 'blank.gif') ?>
<?php } ?>
	</div>
	<div style="position: absolute; top: -1000px">
		<?= View::specialPageLink('Watchlist', 'watchlist', array('accesskey' => 'l')) ?>
		<?= View::specialPageLink('RecentChanges', 'recentchanges', array('accesskey' => 'r')) ?>
	</div>
	<img class="shadow-mask" src="<?= $wgBlankImgUrl ?>" width="0" height="0">
</header>