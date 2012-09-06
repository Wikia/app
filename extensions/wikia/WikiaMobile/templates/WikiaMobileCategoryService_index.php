<?
/**
 * @var $categoryLinks
 * @var $wf WikiaFunctionWrapper
 */
?>
<? if ( !empty( $categoryLinks ) ) :?>
<section id=wkArtCat>
	<h1 class='collSec addChev'><?= $wf->MsgForContent( 'wikiamobile-article-categories' ); ?></h1>
	<?= $categoryLinks ?>
</section>
<? endif ;?>
