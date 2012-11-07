<? if ( !empty( $categoryLinks ) ): ?>
	<nav id="WikiaArticleCategories" class="WikiaArticleCategories">
		<h1><?= wfMsg( 'oasis-related-categories' ); ?></h1>
		<?= $categoryLinks ?>
		<? if ( !empty( $wg->EnableCategorySelectExt ) ): ?>
			<?= F::app()->renderView( 'CategorySelect', 'articlePage' ) ?>
		<? endif ?>
	</nav>
<? endif ?>