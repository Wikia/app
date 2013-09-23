<header class="main-header row">
	<section class="columns small-5 med-5">
		<a class="wv-logo" href="#"></a>
	</section>
	<nav class="columns small-2 med-2 discover dropdown">
		<span><?= wfMessage('videohomepage-header-dropdown-name')->plain() ?></span><div class="chevron"></div>
	</nav>
	<section class="columns small-5 med-5 search-container">
		<form action="" id="WikiaSearch" class="WikiaSearch">
			<input type="text" placeholder="<?= wfMessage('videohomepage-header-search-placeholder')->plain() ?>">
			<button class="wikia-button" type="submit">
				<div class="sprite search" width="21" height="17">
			</button>
		</form>
	</section>
</header>
