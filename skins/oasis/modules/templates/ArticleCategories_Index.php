<? if ( !empty( $categoryLinks ) ): ?>
	<nav id="articleCategories" class="article-categories">
		<h1><?= wfMsg( 'oasis-related-categories' ); ?></h1>
		<?= $categoryLinks ?>
	</nav>
<? endif ?>