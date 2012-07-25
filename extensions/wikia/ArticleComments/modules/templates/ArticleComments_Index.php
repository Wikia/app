<section id="WikiaArticleComments" class="WikiaArticleComments noprint">
	<ul class="controls">
		<li id="article-comments-counter-recent">
			<? if ( !empty( $wg->ArticleCommentsLoadOnDemand ) ): ?>
				<a href="<?= $title->getFullURL( 'showall=1' ) ?>" class="show-comments" id="show-article-comments"><?= wfMsg( 'oasis-comments-show' ) ?></a>
			<? else: ?>
				<?= wfMsg( 'oasis-comments-showing-most-recent', count( $commentListRaw ) ) ?>
			<? endif ?>
		</li>
		<? if ( $countCommentsNested > 1 && $countCommentsNested <= 200 && $countComments > $commentsPerPage ): ?>
			<li><a href="<?= $title->getFullURL( 'showall=1' ) ?>"><?= wfMsg( 'oasis-comments-show-all' ) ?></a></li>
		<? endif ?>
	</ul>
	<h1 id="article-comments-counter-header"><?= wfMsgExt( 'oasis-comments-header', array( 'parsemag' ), $wg->Lang->FormatNum( $countCommentsNested ) ) ?></h1>
	<div id="article-comments">
		<? if ( empty( $wg->ArticleCommentsLoadOnDemand ) ): ?>
			<?= $app->renderView( 'ArticleCommentsController', 'CommentList' ) ?>
		<? endif ?>
	</div>
</section>