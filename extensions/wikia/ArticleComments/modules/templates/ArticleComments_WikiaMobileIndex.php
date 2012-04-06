<section id=wkArtCom data-pages="<?= $pagesCount ;?>">
	<a name=article-comments></a>
	<h1 class=collSec><?= $wf->msgExt( 'wikiamobile-article-comments-header', array('parsemag'), $wg->lang->formatNum( $countCommentsNested ) ) ;?><span class=chev></span><? if ( $requestedPage < 1 ) :?><a id=wkShowCom href="?page=1#article-comments"><?= $wf->msg( 'wikiamobile-article-comments-show' ) ;?></a><? endif ;?></h1>
	<div id=wkComm><? if ( $requestedPage > 0 ) :?><?= F::app()->renderView( 'ArticleCommentsModule', 'WikiaMobileCommentsPage', array( 'error' => ( !empty( $error ) ) ? $error : false ) ) ;?><? endif ;?></div>
</section>