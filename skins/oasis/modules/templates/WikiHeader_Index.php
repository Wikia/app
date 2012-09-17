<header id="WikiHeader" class="WikiHeader">
	<?= F::app()->renderView('WikiHeader', 'Wordmark') ?>
	<nav>
		<h1><?= wfMsg( 'oasis-wiki-navigation', (!empty($wordmarkText)?$wordmarkText:null) ); ?></h1>
		<ul>

<?php
if( is_array($menuNodes) && isset($menuNodes[0]) && $showMenu) {
	foreach($menuNodes[0]['children'] as $level0) {
?>
			<li>
				<a href="<?= $menuNodes[$level0]['href'] ?>">
					<?= $menuNodes[$level0]['text'] ?><?php /*cannot be space between text and &nbsp;*/ if(isset($menuNodes[$level0]['children'])) { ?>&nbsp;<img src="<?= $wg->BlankImgUrl; ?>" class="chevron" width="0" height="0"><?php } ?>
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
			if(isset($editURL)) {
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
<?php if ($wg->EnableCorporatePageExt) {
		if (WikiaPageType::isMainPage()) echo F::app()->renderView('Search', 'Index');
		echo F::app()->renderView('RandomWiki', 'Index');
} else { ?>
		<?= Wikia::specialPageLink('Random', 'oasis-button-random-page', array('accesskey' => 'x', 'class' => 'wikia-button secondary', 'data-id' => 'randompage', 'title' => wfMsg('oasis-button-random-page-tooltip')), 'blank.gif', null, 'sprite random') ?>
		<?= Wikia::specialPageLink('WikiActivity', 'oasis-button-wiki-activity', array('accesskey' => 'g', 'class' => 'wikia-button secondary', 'data-id' => 'wikiactivity', 'title' => wfMsg('oasis-button-wiki-activity-tooltip')), 'blank.gif', null, 'sprite activity') ?>
<?php } ?>
	</div>
	<div style="position: absolute; top: -1000px">
		<?= Wikia::specialPageLink('Watchlist', 'watchlist', array('accesskey' => 'l')) ?>
		<?= Wikia::specialPageLink('RecentChanges', 'recentchanges', array('accesskey' => 'r')) ?>
	</div>
	<?= $displaySearch ? F::app()->renderView('Search', 'Index') : '' ?>
</header>
