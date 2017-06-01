<header class="page-header">
	<h1 class="page-header__title"><?= !empty( $pageTitle->prefix ) ? '<span>' . $pageTitle->prefix . ':</span>' : '' ?><?= $pageTitle->title ?></h1>
	<? if ( !empty( $counter->message ) ) : ?>
		<span class="page-header__counter"><?= $counter->message ?></span>
	<? endif; ?>

	<? if ( $displayActionButton ): ?>
		<?= $app->renderView( 'Wikia\PageHeader\PageHeader', 'actionButton' ); ?>
	<? endif; ?>

	<?= $app->renderView( 'Wikia\PageHeader\PageHeader', 'subtitle' ); ?>
	<hr class="page-header__separator">
</header>
