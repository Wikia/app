<section id="WikiaPage">
	<?= $pageHeaderContent ;?>
	<article id="WikiaMainContent"><?= $bodyContent ;?></article>
	<?= $categoryLinks ;?>
	<footer id="WikiaMainContentFooter"><?= $afterContentHookText ;?></footer>
	<? if ( !empty( $afterBodyContent ) ) :?><aside id="WikiaAfterBodyContent"><?= $afterBodyContent ;?></aside><? endif ;?>
</section>