<nav id="WikiaArticleCategories" class="CategorySelect WikiaArticleCategories">
	<h1><?= wfMsg( 'oasis-related-categories' ); ?></h1>
	<ul class="categories">
	<? if ( count( $categories ) ): ?>
		<? foreach( $categories as $index => $category ): ?>
			<?= $app->renderView( 'CategorySelectController', 'category', array(
				'index' => $index,
				'category' => $category
			)) ?>
		<? endforeach ?>
	<? endif ?>
	</ul>
	<button class="addCategory" type="button" title="<?= wfMsg( 'categoryselect-category-add' ) ?>"><?= wfMsg( 'categoryselect-category-add' ) ?></button>
</nav>