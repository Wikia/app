<header class="main-header row">
	<section class="columns small-5 medium-5 large-6">
		<a class="wv-logo" href="#"></a>
	</section>
	<nav class="columns small-2 medium-2 large-2 discover dropdown">
		<span><?= wfMessage('videohomepage-header-dropdown-name')->plain() ?></span><div class="chevron"></div>
	</nav>
	<section class="columns small-5 medium-5 large-4 search-container">
		<?= $app->renderView('Search', 'Index', array(
			'placeholder' => 'Search for Wikia videos'
		)) ?>
	</section>
</header>
