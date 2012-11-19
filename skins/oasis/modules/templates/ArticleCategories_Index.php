<? if ( !empty( $wg->EnableCategorySelectExt ) ): ?>
	<?= F::app()->renderView( 'CategorySelect', 'articlePage' ) ?>

<? elseif ( !empty( $categoryLinks ) ): ?>
	<nav id="WikiaArticleCategories" class="WikiaArticleCategories">
		<h1><?= wfMsg( 'oasis-related-categories' ); ?></h1>
		<?= $categoryLinks ?>
	</nav>
<? endif ?>