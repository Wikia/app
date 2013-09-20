<?
/**
 * @var $categoryLinks String
 * @var $wf WikiaFunctionWrapper
 */
?>

<? if ( !empty( $categoryLinks ) ) :?>
<section id=wkArtCat>
	<h1 class=collSec><?= wfMsg( 'wikiamobile-article-categories' ); ?><span class=chev></span></h1>
	<?= $categoryLinks ?>
</section>
<? endif ;?>