<?/**
 * @var $categoryLinks
 */?>
<? if ( !empty( $categoryLinks ) ) :?>
<section id=wkArtCat>
	<h2 id="wkCategories"><?= wfMessage( 'wikiamobile-article-categories' )->inContentLanguage()->text(); ?></h2>
	<?= $categoryLinks ?>
</section>
<? endif ;?>
