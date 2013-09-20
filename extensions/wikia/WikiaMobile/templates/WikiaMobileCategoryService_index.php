<?/**
 * @var $categoryLinks
 * @var $wf WikiaFunctionWrapper
 */?>
<? if ( !empty( $categoryLinks ) ) :?>
<section id=wkArtCat>
	<h1 class='collSec addChev'><?= wfMessage( 'wikiamobile-article-categories' )->inContentLanguage()->text(); ?></h1>
	<?= $categoryLinks ?>
</section>
<? endif ;?>
