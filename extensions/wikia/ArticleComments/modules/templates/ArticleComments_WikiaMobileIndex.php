<section id="WikiaArticleComments" data-pages="<?= $pagesCount ;?>">
	<h1 id="commentsHeader" class="collapsible-section"><?= $wf->MsgExt( 'wikiamobile-article-comments-header', array('parsemag'), $wg->Lang->formatNum( $countCommentsNested ) ) ;?><span class="chevron"></span></h1>
	<div id="commentsBody">
		<? if ( $countCommentsNested > 0 ) :?>
			<? if ( $showMore ) :?>
				<div id="commentsLoadPrev"><span class="label"><?= $wf->Msg( 'wikiamobile-article-comments-prev' ) ;?></span></div>
			<? endif ;?>
			
			<?= wfRenderPartial( 'ArticleComments', 'CommentList', array( 'commentListRaw' => $commentListRaw, 'page' => $page, 'useMaster' => false ) );?>
		
			<? if ( $showMore ) :?>
				<div id="commentsLoadMore"><span class="label"><?= $wf->Msg( 'wikiamobile-article-comments-more' ) ;?></span></div>
			<? endif ;?>
		<? else :?>
			<span class="message"><?= $wf->Msg( 'wikiamobile-article-comments-none' ) ;?></span>
		<? endif ;?>
	</div>
</section>
