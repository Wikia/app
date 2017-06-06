<header id="PageHeader" class="page-header">
	<?= $app->renderView( 'Wikia\PageHeader\PageHeaderController', 'categories' ) ?>
	<h1 class="page-header__title"><?= !empty( $pageTitle->prefix ) ? '<span>' . $pageTitle->prefix . ':</span> ' : '' ?><?= $pageTitle->title ?></h1>
	<? if ( $counter->isNotEmpty() ) : ?>
		<span class="page-header__counter"><?= $counter->text ?></span>
	<? endif; ?>
	<?= $app->renderView('Wikia\PageHeader\PageHeader', 'subtitle'); ?>
	<hr class="page-header__separator">
</header>
