<? if ( !empty( $categoryLinks ) ) :?>
<section id=wkArtCat>
	<h1 class=collSec><?= $wf->MsgForContent( 'wikiamobile-article-categories' ); ?><span class=chev></span></h1>
	<?= $categoryLinks ?>
</section>
<? endif ;?>