<section id="WikiaArticleComments" class="WikiaArticleComments noprint<?= !$showComments ? ' on-demand' : '' ?>">
	<ul class="controls">
		<li id="article-comments-counter-recent"><?= wfMsg( 'oasis-comments-showing-most-recent', count( $commentListRaw ) ) ?></li>
		<? if ( $countCommentsNested > 1 && $countCommentsNested <= 200 && $countComments > $commentsPerPage ): ?>
			<li><a href="<?= $title->getFullURL( 'showall=1' ) ?>"><?= wfMsg( 'oasis-comments-show-all' ) ?></a></li>
		<? endif ?>
	</ul>
	<h1 id="article-comments-counter-header"><?= wfMsgExt( 'oasis-comments-header', array( 'parsemag' ), $wg->Lang->FormatNum( $countCommentsNested ) ) ?></h1>
	<div id="article-comments-wrapper" class="article-comments-wrapper">
		<div id="article-comments" data-page="<?= $page ?>">
			<? if ( $showComments ): ?>
				<?= $app->renderView( 'ArticleCommentsController', 'Content' ) ?>
			<? else: ?>
				<? /* FIXME: this URL needs to go to a page with comments on it for users without javascript */ ?>
				<a href="<?= $title->getFullURL() ?>" class="show-comments" id="show-article-comments"><?= wfMsgExt( 'oasis-comments-load', array( 'parsemag' ), $countCommentsNested ) ?></a>
			<? endif ?>
		</div>
	</div>
</section>