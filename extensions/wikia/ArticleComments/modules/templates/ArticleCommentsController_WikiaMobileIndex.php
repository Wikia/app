<section id=wkArtCom data-pages="<?= $pagesCount ;?>">
	<h2 class='collSec addChev'><?= wfMessage( 'wikiamobile-article-comments-header')->inContentLanguage()->params( $wg->ContLang->formatNum( $countCommentsNested ) )->parse() ;?><? if ( $requestedPage < 1 ) :?><a id=wkShowCom href="?page=1#wkArtCom"><?= wfMsg( 'wikiamobile-article-comments-show' ) ;?></a><? endif ;?></h2>
	<div id=wkComm><? if ( $requestedPage > 0 ) :?><?= $app->renderView( 'ArticleCommentsController', 'WikiaMobileCommentsPage', array( 'error' => ( !empty( $error ) ) ? $error : false ) ) ;?><? endif ;?></div>
</section>
