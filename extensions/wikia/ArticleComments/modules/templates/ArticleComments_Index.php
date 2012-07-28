<? if ( $wg->EnableMiniEditorExtForArticleComments ): ?>
	<?= $app->renderView( 'MiniEditorController', 'Setup' ) ?>
<? endif ?>
<section id="WikiaArticleComments" class="WikiaArticleComments noprint">
	<ul class="controls">
		<li id="article-comments-counter-recent"><?= wfMsg( 'oasis-comments-showing-most-recent', count( $commentListRaw ) ) ?></li>
		<? if ( $countCommentsNested > 1 && $countCommentsNested <= 200 && $countComments > $commentsPerPage ): ?>
			<li><a href="<?= $title->getFullURL( 'showall=1' ) ?>"><?= wfMsg( 'oasis-comments-show-all' ) ?></a></li>
		<? endif ?>
	</ul>
	<h1 id="article-comments-counter-header"><?= wfMsgExt( 'oasis-comments-header', array( 'parsemag' ), $wg->Lang->FormatNum( $countCommentsNested ) ) ?></h1>
	<div id="article-comments-wrapper" class="article-comments-wrapper<?= empty( $wg->ArticleCommentsLoadOnDemand ) ? '' : ' loading' ?>">
		<div id="article-comments" class="article-comments" data-page="<?= $page ?>">
			<? if ( empty( $wg->ArticleCommentsLoadOnDemand ) ): ?>
				<?= $app->renderView( 'ArticleCommentsController', 'Content' ) ?>
			<? endif ?>
		</div>
	</div>
</section>
