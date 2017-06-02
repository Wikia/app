<header id="PageHeader" class="page-header">
	<div class="page-header__main">
	<?= $app->renderView( 'Wikia\PageHeader\PageHeaderController', 'categories' ); ?>
	<h1 class="page-header__main-title"><?= !empty( $pageTitle->prefix ) ? '<span>' . $pageTitle->prefix . ':</span> ' : '' ?><?= $pageTitle->title ?></h1>
	</div>
	<div class="page-header__contribution">
	<? if ( $counter->isNotEmpty() ) : ?>
		<span class="page-header__contribution-counter"><?= $counter->text ?></span>
	<? endif; ?>
	<? if ( $displayActionButton ): ?>
		<?= $app->renderView( 'Wikia\PageHeader\PageHeader', 'actionButton' ); ?>
	<? endif; ?>
	<?= $app->renderView( 'Wikia\PageHeader\PageHeader', 'subtitle' ); ?>
	</div>
</header>
<hr class="page-header__separator">
