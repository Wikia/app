<header id="WikiHeader" class="WikiHeader">
	<?= $app->renderView( 'WikiHeader', 'Wordmark' ) ?>
	<nav class="WikiNav">
		<?php if ( $displayHeader ) {
			echo ( $seoTestOneH1 ? '<h2>' : '<h1>' );
				echo wfMessage( 'oasis-wiki-navigation', $wordmarkText )->escaped();
			echo ( $seoTestOneH1 ? '</h2>' : '</h1>' );
		} ?>
		<?= $app->renderView( 'WikiNavigation', 'Index' ) ?>
	</nav>
	<div class="hiddenLinks">
		<?= Wikia::specialPageLink( 'Watchlist', 'watchlist', [ 'accesskey' => 'l' ] ) ?>
		<?= Wikia::specialPageLink( 'Random', 'randompage', [ 'accesskey' => 'x' ] ) ?>
		<?= Wikia::specialPageLink( 'RecentChanges', 'recentchanges', [ 'accesskey' => 'r' ] ) ?>
	</div>
</header>
