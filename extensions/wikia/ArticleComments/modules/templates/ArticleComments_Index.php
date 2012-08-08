<? if ( $wg->EnableMiniEditorExtForArticleComments ): ?>
	<?= $app->renderView( 'MiniEditorController', 'Setup' ) ?>
<? endif ?>
<section id="WikiaArticleComments" class="WikiaArticleComments noprint<?= !empty( $wg->ArticleCommentsLoadOnDemand ) ? ' loading' : '' ?>" data-page="<?= $page ?>">
	<? if ( empty( $wg->ArticleCommentsLoadOnDemand ) ): ?>
		<?= $app->renderView( 'ArticleCommentsController', 'Content' ) ?>
	<? endif ?>
</section>
