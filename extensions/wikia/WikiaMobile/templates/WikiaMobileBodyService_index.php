<section id="WikiaPage">
	<?= $pageHeaderContent ;?>
	<article id="WikiaMainContent">
		<?= $bodyContent ;?>
		<footer id="WikiaMainContentFooter">
			<nav id="WikiaRelatedContent">
				<?= $relatedPages ;?>
				<?= $categoryLinks ;?>
			</nav>
			<?= $afterContentHookText ;?>
			<? if ( !empty( $afterBodyContent ) ) :?><aside id="WikiaAfterBodyContent"><?= $afterBodyContent ;?></aside><? endif ;?>
			<?= $navMenu ;?>
		</footer>
	</article>
</section>