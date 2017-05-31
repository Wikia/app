<header class="page-header">
	<h1 class="page-header__title"><?= !empty( $pageTitle->prefix ) ? '<span>' . $pageTitle->prefix . ':</span>' : '' ?><?= $pageTitle->title ?></h1>
	<span class="page-header__tally"><?= !empty($counter->message) ? '<em>' . $counter->message . '</em>' : '<em></em>' ?></span>
	<hr class="page-header__separator">

</header>
