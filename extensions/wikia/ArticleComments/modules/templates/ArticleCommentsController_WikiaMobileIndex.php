<section id=wkArtCom data-pages="<?= $pagesCount ;?>">
	<h2 id=wkArtComHeader class=collSec><?= wfMessage( 'wikiamobile-article-comments-header')->inContentLanguage()->params( $wg->ContLang->formatNum( $countCommentsNested ) )->parse() ;?><? if ( $requestedPage < 1 ) :?><a id=wkShowCom href="?page=1#wkArtCom"><?= wfMessage( 'wikiamobile-article-comments-show' )->plain() ;?></a><? endif ;?></h2>
	<div id=wkComm><? if ( $requestedPage > 0 ) :?><?= $app->renderView( 'ArticleCommentsController', 'WikiaMobileCommentsPage', array( 'error' => ( !empty( $error ) ) ? $error : false ) ) ;?><? endif ;?></div>
</section>
