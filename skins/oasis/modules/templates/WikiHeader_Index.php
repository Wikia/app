<header id="WikiHeader" class="WikiHeader">
	<?= $app->renderView( 'WikiHeader', 'Wordmark' ) ?>
	<nav class="WikiNav">
		<? if ( $displayHeader ): ?>
			<h2><?= wfMessage( 'oasis-wiki-navigation', $wordmarkText )->escaped() ?></h2>
		<? endif; ?>
		<?= $app->renderView( 'WikiNavigation', 'Index' ) ?>
	</nav>
	<? if ( $displayHeaderButtons ) : ?>
		<div class="buttons">
			<?= $app->renderView( 'ContributeMenu', 'Index' ) ?>
		</div>
	<? endif ?>
	<div class="hiddenLinks">
		<?= Wikia::specialPageLink( 'Watchlist', 'watchlist', array( 'accesskey' => 'l' ) ) ?>
		<?= Wikia::specialPageLink( 'Random', 'randompage', array( 'accesskey' => 'x' ) ) ?>
		<?= Wikia::specialPageLink( 'RecentChanges', 'recentchanges', array( 'accesskey' => 'r' ) ) ?>
	</div>
</header>
