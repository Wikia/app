<header id="PageHeader" class="page-header">
	<div class="page-header__main">
		<?= $app->renderView( 'Wikia\PageHeader\PageHeaderController', 'categories' ); ?>
		<h1 class="page-header__title"><?= !empty( $pageTitle->prefix ) ? '<span>' . $pageTitle->prefix . ':</span> ' : '' ?><?= $pageTitle->title ?></h1>
		<?= $app->renderView( 'Wikia\PageHeader\PageHeader', 'subtitle' ); ?>
	</div>
	<div class="page-header__contribution">
		<div> <!--Empty div to ensure $actionButton is always pushed to bottom of the container-->
		<? if ( $languages->shouldDisplay() ): ?>
			<?= $app->renderView( 'Wikia\PageHeader\PageHeader', 'languages' ); ?>
		<? endif; ?>
		<? if ( $counter->isNotEmpty() ) : ?>
			<span class="page-header__counter"><?= $counter->text ?></span>
		<? endif; ?>
		</div>
		<? if ( $actionButton->shouldDisplay() ): ?>
			<?= $app->renderView( 'Wikia\PageHeader\PageHeader', 'actionButton' ); ?>
		<? endif; ?>
	</div>
</header>
<hr class="page-header__separator">
