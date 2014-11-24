<header id="localNavigation" class="local-navigation">
	<?= $app->renderView( 'LocalNavigation', 'Wordmark') ?>
	<?= $app->renderView( 'LocalNavigation', 'menu' ); ?>
	<? if ( $enableContributeButton ): ?>
		<?= $app->renderView( 'LocalNavigationContributeMenu', 'Index' ) ?>
	<? endif; ?>
</header>
