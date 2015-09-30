<header id="WikiHeader" class="WikiHeader">
	<?= $app->renderView( 'WikiHeader', 'Wordmark' ) ?>
    <nav class="WikiNav">
    	<? if ( $displayHeader ) { ?>
    		<?= $seoTestOneH1 ? '<h2>' : '<h1>' ?>
				<?= wfMessage( 'oasis-wiki-navigation', $wordmarkText )->escaped() ?>
			<?= $seoTestOneH1 ? '</h2>' : '</h1>' ?>
        <? } ?>
		<?= $app->renderView( 'WikiNavigation', 'Index' ) ?>
    </nav>
    <?php if ( $displayHeaderButtons ) { ?>
		<div class="buttons">
			<?= $app->renderView( 'ContributeMenu', 'Index' ) ?>
		</div>
	<?php } ?>
    <div class="hiddenLinks">
		<?= Wikia::specialPageLink( 'Watchlist', 'watchlist', ['accesskey' => 'l'] ) ?>
		<?= Wikia::specialPageLink( 'Random', 'randompage', ['accesskey' => 'x'] ) ?>
		<?= Wikia::specialPageLink( 'RecentChanges', 'recentchanges', ['accesskey' => 'r'] ) ?>
    </div>
</header>
