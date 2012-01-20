<section id=wkArtCom data-pages="<?= $pagesCount ;?>">
	<h1 class=collSec><?= $wf->MsgExt( 'wikiamobile-article-comments-header', array('parsemag'), $wg->Lang->formatNum( $countCommentsNested ) ) ;?><span class=chev></span></h1>
	<div class=comms>
		<? if ( $countCommentsNested > 0 ) :?>
			<? if ( $showMore ) :?>
				<div id=commPrev><span class=lbl><?= $wf->Msg( 'wikiamobile-article-comments-prev' ) ;?></span></div>
			<? endif ;?>
			
			<?= wfRenderPartial( 'ArticleComments', 'CommentList', array( 'commentListRaw' => $commentListRaw, 'page' => $page, 'useMaster' => false ) );?>
		
			<? if ( $showMore ) :?>
				<div id=commMore><span class=lbl><?= $wf->Msg( 'wikiamobile-article-comments-more' ) ;?></span></div>
			<? endif ;?>
		<? else :?>
			<?= $wf->Msg( 'wikiamobile-article-comments-none' ) ;?>
		<? endif ;?>
	</div>
</section>
