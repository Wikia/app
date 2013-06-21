<section id=wkArtCom data-pages="<?= $pagesCount ;?>">
	<h1 class='collSec addChev'><?= wfMsgExt( 'wikiamobile-article-comments-header', array('parsemag', 'content'), $wg->ContLang->formatNum( $countCommentsNested ) ) ;?><? if ( $requestedPage < 1 ) :?><a id=wkShowCom href="?page=1#wkArtCom"><?= wfMsg( 'wikiamobile-article-comments-show' ) ;?></a><? endif ;?></h1>
	<div id=wkComm><? if ( $requestedPage > 0 ) :?><?= $app->renderView( 'ArticleCommentsController', 'WikiaMobileCommentsPage', array( 'error' => ( !empty( $error ) ) ? $error : false ) ) ;?><? endif ;?></div>
</section>
