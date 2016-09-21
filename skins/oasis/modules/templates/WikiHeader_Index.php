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
		<a href="<?= Sanitizer::encodeAttribute( $hiddenLinks['watchlist'] ); ?>" accesskey="l"><?= wfMessage( 'watchlist' )->escaped(); ?></a>
		<a href="<?= Sanitizer::encodeAttribute( $hiddenLinks['random'] ); ?>" accesskey="x"><?= wfMessage( 'randompage' )->escaped(); ?></a>
		<a href="<?= Sanitizer::encodeAttribute( $hiddenLinks['recentchanges'] ); ?>" accesskey="r"><?= wfMessage( 'recentchanges' )->escaped(); ?></a>
	</div>
</header>
