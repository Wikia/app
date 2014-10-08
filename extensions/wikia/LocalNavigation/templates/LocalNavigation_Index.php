<nav id="localNavigation" class="local-navigation">
	<?= $app->renderView( 'LocalNavigation', 'Wordmark') ?>
	<?= $app->renderView( 'LocalNavigation', 'menu' ); ?>
	<? if ( !empty( $wg->HideNavigationHeaders ) ): ?>
		<?= $app->renderView( 'LocalNavigationContributeMenu', 'Index' ) ?>
	<? endif; ?>
</nav>
