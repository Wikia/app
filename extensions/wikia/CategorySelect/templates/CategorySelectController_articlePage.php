<nav class="WikiaArticleCategories CategorySelect articlePage<? if ( $showHidden ): ?> showHidden<? endif ?>" id="WikiaArticleCategories">
	<?= $categoriesLink ?>
	<div class="container">
		<?= $app->getView( 'CategorySelect', 'categories', array( 'categories' => $categories )) ?>
		<?= $app->getView( 'CategorySelect', 'addCategory' ) ?>
	</div>
</nav>