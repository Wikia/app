<header id="WikiHeader" class="WikiHeader">
	<?= $app->renderView( 'WikiHeader', 'Wordmark' ) ?>
    <?php if ( BodyController::isResponsiveLayoutEnabled() ) : ?>
    <?php endif ?>
    <nav class="WikiNav">
    	<? if ( $displayHeader ): ?>
        <h1><?= wfMsg( 'oasis-wiki-navigation', $wordmarkText ) ?></h1>
        <? endif; ?>
		<?= $app->renderView( 'LocalNavigation', 'Index' ) ?>
    </nav>
    <div class="hiddenLinks">
		<?= Wikia::specialPageLink( 'Watchlist', 'watchlist', array( 'accesskey' => 'l' ) ) ?>
		<?= Wikia::specialPageLink( 'Random', 'randompage', array( 'accesskey' => 'x' ) ) ?>
		<?= Wikia::specialPageLink( 'RecentChanges', 'recentchanges', array( 'accesskey' => 'r' ) ) ?>
    </div>
</header>

<? if ( $displaySearch && empty( $wg->EnableGlobalNavExt ) ): ?>
<div class="adm-dash-search">
	<?= $app->renderView( 'Search', 'Index' ) ?>
</div>
<? endif ?>
