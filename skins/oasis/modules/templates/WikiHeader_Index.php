<header id="WikiHeader" class="WikiHeader">
	<?= $app->renderView( 'WikiHeader', 'Wordmark' ) ?>
	<nav class="WikiNav">
		<?php if ( $displayHeader ) { ?>
			<h2><?= wfMessage( 'oasis-wiki-navigation', $wordmarkText )->escaped() ?></h2>
		<?php } ?>
		<?= $app->renderView( 'WikiNavigation', 'Index' ) ?>
	</nav>
	<div class="hiddenLinks">
		<?= Wikia::specialPageLink( 'Watchlist', 'watchlist', [ 'accesskey' => 'l' ] ) ?>
		<?= Wikia::specialPageLink( 'Random', 'randompage', [ 'accesskey' => 'x' ] ) ?>
		<?= Wikia::specialPageLink( 'RecentChanges', 'recentchanges', [ 'accesskey' => 'r' ] ) ?>
	</div>
</header>
