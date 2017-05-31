<header class="page-header">
	<h1 class="page-header__title"><?= !empty( $pageTitle->prefix ) ? '<span>' . $pageTitle->prefix . ':</span>' : '' ?><?= $pageTitle->title ?></h1>
	<? if ( !empty( $tally->message ) ) : ?>
	<span class="page-header__tally"><?= $tally->message ?></span>
	<? endif; ?>
	<hr class="page-header__separator">
</header>
