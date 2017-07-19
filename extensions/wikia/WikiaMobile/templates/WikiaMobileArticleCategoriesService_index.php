<?
/**
 * @var $categoryLinks String
 */
?>

<? if ( !empty( $categoryLinks ) ) :?>
<section id=wkArtCat>
	<h1 class=collSec><?= wfMessage( 'wikiamobile-article-categories' )->escaped(); ?><span class=chev></span></h1>
	<?= $categoryLinks ?>
</section>
<? endif ;?>
