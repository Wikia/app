<section id="WikiaArticleComments" data-pages="<?= $pagesCount ;?>">
	<h1 id="article-comments-counter-header"><?= $wf->MsgExt('wikiamobile-article-comments-header', array('parsemag'), $wg->Lang->formatNum( $countCommentsNested ) ) ;?></h1>

	<?= wfRenderPartial( 'ArticleComments', 'CommentList', array( 'commentListRaw' => $commentListRaw, 'page' => $page, 'useMaster' => false ) );?>

	<? if ( $showMore ) :?>
		<div class="load-more"><?= $wf->Msg( 'wikiamobile-article-comments-more' ) ;?></div>
	<? endif ;?>
</section>
