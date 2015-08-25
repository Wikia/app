<header id="WikiHeader" class="WikiHeader">
	<?= $app->renderView( 'WikiHeader', 'Wordmark' ) ?>
    <nav class="WikiNav">
    	<? if ( $displayHeader ) { ?>
            <h1><?= wfMessage( 'oasis-wiki-navigation', $wordmarkText )->escaped() ?></h1>
        <? } ?>
		<?= $app->renderView( 'WikiNavigation', 'Index' ) ?>
    </nav>
    <div class="hiddenLinks">
		<?= Wikia::specialPageLink( 'Watchlist', 'watchlist', ['accesskey' => 'l'] ) ?>
		<?= Wikia::specialPageLink( 'Random', 'randompage', ['accesskey' => 'x'] ) ?>
		<?= Wikia::specialPageLink( 'RecentChanges', 'recentchanges', ['accesskey' => 'r'] ) ?>
    </div>
</header>

