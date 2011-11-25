<? if ( !empty( $categoryLinks ) ) :?>
<nav id="WikiaArticleCategories">
	<h1><?= $wf->Msg( 'wikiamobile-article-categories' ); ?><span class="chevron"></span></h1>
	<?= $categoryLinks ?>
</nav>
<? endif ;?>