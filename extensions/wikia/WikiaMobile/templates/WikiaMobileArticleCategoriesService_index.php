<? if ( !empty( $categoryLinks ) ) :?>
<nav id="WikiaArticleCategories">
	<h1 class="collapsible-section"><?= $wf->Msg( 'wikiamobile-article-categories' ); ?><span class="chevron"></span></h1>
	<?= $categoryLinks ?>
</nav>
<? endif ;?>