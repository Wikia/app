<header id="WikiHeader" class="WikiHeaderRestyle">
	<?= F::app()->renderView('WikiHeader', 'Wordmark') ?>
    <nav class="WikiNav">
        <h1><?= wfMsg( 'oasis-wiki-navigation', $wordmarkText ); ?></h1>
		<?php
		// render wiki navigation
		echo F::app()->renderView('WikiNavigation', 'Index');
		?>
    </nav>
    <div class="buttons">
		<?php
		// render "Contribute" menu
		echo F::app()->renderView('ContributeMenu', 'Index');
		echo F::app()->renderView('SharingToolbar', 'ShareButton');
		?>
    </div>

    <div style="position: absolute; top: -1000px"><?php
		echo Wikia::specialPageLink('Watchlist', 'watchlist', array('accesskey' => 'l'));
		echo Wikia::specialPageLink('Random', 'randompage', array('accesskey' => 'x'));
		echo Wikia::specialPageLink('RecentChanges', 'recentchanges', array('accesskey' => 'r'));
		?></div>

	<? echo F::app()->renderView('SharingToolbar', 'Index'); ?>
</header>
<?= $displaySearch ? '<div class="adm-dash-search">'.F::app()->renderView('Search', 'Index').'</div>' : '' ?>
