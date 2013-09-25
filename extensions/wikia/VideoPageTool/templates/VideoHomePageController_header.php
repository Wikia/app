<header class="main-header row">
	<section class="columns small-5 med-5">
		<a class="wv-logo" href="#"></a>
	</section>
	<nav class="columns small-2 med-2 discover dropdown">
		<span><?= wfMessage('videohomepage-header-dropdown-name')->plain() ?></span><div class="chevron"></div>
	</nav>
	<section class="columns small-5 med-5 search-container">
		<?= $app->renderView('Search', 'Index', array(
			'placeholder' => 'Search for Wikia videos'
		)) ?>
	</section>
</header>
