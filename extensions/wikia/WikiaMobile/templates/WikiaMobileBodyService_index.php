<section id="WikiaPage">
	<?= $pageHeaderContent ;?>
	<article id="WikiaMainContent"><?= $bodyContent ;?></article>
	<footer id="WikiaMainContentFooter">
		<nav id="WikiaRelatedContent">
			<?//TODO: add related pages here ;?>
			<?= $categoryLinks ;?>
		</nav>
		<?= $afterContentHookText ;?>
		<? if ( !empty( $afterBodyContent ) ) :?><aside id="WikiaAfterBodyContent"><?= $afterBodyContent ;?></aside><? endif ;?>
	</footer>
</section>