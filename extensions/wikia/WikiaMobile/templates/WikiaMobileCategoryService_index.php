<?/**
 * @var $categoryLinks
 * @var $wf WikiaFunctionWrapper
 */?>
<? if ( !empty( $categoryLinks ) ) :?>
<section id=wkArtCat>
	<h1 class='collSec addChev'><?= $wf->Message( 'wikiamobile-article-categories' )->inContentLanguage()->text(); ?></h1>
	<?= $categoryLinks ?>
</section>
<? endif ;?>
