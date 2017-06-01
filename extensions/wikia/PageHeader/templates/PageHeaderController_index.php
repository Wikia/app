<header class="page-header">
	<h1 class="page-header__title"><?= !empty( $pageTitle->prefix ) ? '<span>' . $pageTitle->prefix . ':</span> ' : '' ?><?= $pageTitle->title ?></h1>
	<? if ( !$counter->isEmpty() ) : ?>
	<span class="page-header__counter"><?= $counter->text ?></span>
	<? endif; ?>
	<hr class="page-header__separator">
</header>
