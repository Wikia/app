<section id=wkPage>
	<?= $pageHeaderContent ;?>
	<article id=wkMainCnt>
		<?= $bodyContent ;?>
		<footer id=wkMainCntFtr>
			<nav id=wkRltdCnt>
				<?= $relatedPages ;?>
				<?= $categoryLinks ;?>
			</nav>
			<? if ( !empty( $afterContentHookText ) || !empty( $afterBodyContent ) || !empty( $comments ) ) :?>
			<aside>
			<?= $afterContentHookText ;?>
			<?= $afterBodyContent ;?>
			<?= $comments ;?>
			</aside>
			<? endif ;?>
			<?= $navMenu ;?>
		</footer>
	</article>
</section>