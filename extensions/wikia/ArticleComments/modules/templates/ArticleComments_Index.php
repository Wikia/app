<? if ( $isMiniEditorEnabled ): ?>
	<?= $app->renderView( 'MiniEditorController', 'Setup' ) ?>
<? endif ?>
<section id="WikiaArticleComments" class="WikiaArticleComments noprint" data-page="<?= $page ?>">
	<? if ( empty( $isLoadingOnDemand ) ): ?>
		<?= $app->renderView( 'ArticleCommentsController', 'Content' ) ?>
	<? endif ?>
</section>