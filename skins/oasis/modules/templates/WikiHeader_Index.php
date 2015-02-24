<header id="WikiHeader" class="WikiHeader">
	<?= $app->renderView( 'WikiHeader', 'Wordmark' ) ?>
    <nav class="WikiNav">
    	<? if ( $displayHeader ): ?>
        <h1><?= wfMsg( 'oasis-wiki-navigation', $wordmarkText ) ?></h1>
        <? endif; ?>
		<?= $app->renderView( 'WikiNavigation', 'Index' ) ?>
    </nav>
	<? if ( $displayHeaderButtons ) : ?>
    <div class="buttons">
		<?= $app->renderView( 'ContributeMenu', 'Index' ) ?>
		<?= $app->renderView( 'SharingToolbar', 'ShareButton' ) ?>
    </div>
	<? endif ?>
    <div class="hiddenLinks">
		<?= Wikia::specialPageLink( 'Watchlist', 'watchlist', array( 'accesskey' => 'l' ) ) ?>
		<?= Wikia::specialPageLink( 'Random', 'randompage', array( 'accesskey' => 'x' ) ) ?>
		<?= Wikia::specialPageLink( 'RecentChanges', 'recentchanges', array( 'accesskey' => 'r' ) ) ?>
    </div>
</header>

