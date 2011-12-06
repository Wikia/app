<? if ( !empty( $categoryLinks ) ) :?>
<section id="WikiaArticleCategories">
	<h1 class="collapsible-section"><?= $wf->Msg( 'wikiamobile-article-categories' ); ?><span class="chevron"></span></h1>
	<?= $categoryLinks ?>
</section>
<? endif ;?>