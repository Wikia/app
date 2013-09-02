<header id="WikiHeader" class="WikiHeader">
	<?= $app->renderView( 'WikiHeader', 'Wordmark' ) ?>
    <?php if ( BodyController::isResponsiveLayoutEnabled() ) : ?>
    <div class="WikiHeaderSearch">
        <?= $app->renderView( 'Search', 'Index', array( 'searchFormId' => 'HeaderWikiaSearch' ) ) ?>
    </div>
    <?php endif ?>
    <nav class="WikiNav">
    	<? if ( $displayHeader ): ?>
        <h1><?= wfMsg( 'oasis-wiki-navigation', $wordmarkText ) ?></h1>
        <? endif; ?>
		<?= $app->renderView( 'WikiNavigation', 'Index' ) ?>
    </nav>
    <div class="buttons">
		<?= $app->renderView( 'ContributeMenu', 'Index' ) ?>
		<?= $app->renderView( 'SharingToolbar', 'ShareButton' ) ?>
    </div>

    <div class="hiddenLinks">
		<?= Wikia::specialPageLink( 'Watchlist', 'watchlist', array( 'accesskey' => 'l' ) ) ?>
		<?= Wikia::specialPageLink( 'Random', 'randompage', array( 'accesskey' => 'x' ) ) ?>
		<?= Wikia::specialPageLink( 'RecentChanges', 'recentchanges', array( 'accesskey' => 'r' ) ) ?>
    </div>
</header>

<? if ( $displaySearch ): ?>
<div class="adm-dash-search">
	<?= $app->renderView( 'Search', 'Index' ) ?>
</div>
<? endif ?>
