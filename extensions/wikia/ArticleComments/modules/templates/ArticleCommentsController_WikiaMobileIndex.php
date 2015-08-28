<section id=wkArtCom data-pages="<?= $pagesCount ;?>">
	<h2 id=wkArtComHeader data-count="<?=  $wg->ContLang->formatNum( $countCommentsNested ) ?>"><?= wfMessage( 'wikiamobile-article-comments-header')->inContentLanguage()->escaped(); ?></h2>
	<div id=wkComm><? if ( $requestedPage > 0 ) :?><?= $app->renderView( 'ArticleCommentsController', 'WikiaMobileCommentsPage', [ 'error' => ( !empty( $error ) ) ? $error : false ] ) ;?><? endif ;?></div>
</section>
