<?/**
 * @var $categoryLinks
 * @var $wf WikiaFunctionWrapper
 */?>
<? if ( !empty( $categoryLinks ) ) :?>
<section id=wkArtCat>
	<h2><?= wfMessage( 'wikiamobile-article-categories' )->inContentLanguage()->text(); ?></h2>
	<?= $categoryLinks ?>
</section>
<? endif ;?>
