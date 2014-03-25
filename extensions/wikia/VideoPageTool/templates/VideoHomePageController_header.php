<header class="main-header row">
	<section class="columns small-4 large-5">
		<a class="wv-logo" href="#"></a>
	</section>
	<nav class="columns small-2 medium-2 large-2 discover dropdown">
		<span><?= wfMessage('videohomepage-header-dropdown-name')->plain() ?></span><div class="chevron"></div>
	</nav>
	<section class="columns small-8 large-7 search-container">
		<?= $app->renderView('Search', 'Index', array(
			'placeholder' => 'Search for Wikia videos'
		)) ?>

		<a class="browse" href="<?= SpecialPage::getTitleFor( 'Videos' )->escapeLocalUrl() ?>"><?= wfMessage( 'videohomepage-header-browse' ) ?></a>
	</section>
</header>
