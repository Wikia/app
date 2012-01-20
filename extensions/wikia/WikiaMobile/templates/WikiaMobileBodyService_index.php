<section id=wkPage>
	<?= $pageHeaderContent ;?>
	<article id=wkMainCnt>
		<?= $bodyContent ;?>
		<footer id=wkMainCntFtr>
			<nav id=wkRltdCnt>
				<?= $relatedPages ;?>
				<?= $categoryLinks ;?>
			</nav>
			<?= $afterContentHookText ;?>
			<? if ( !empty( $afterBodyContent ) ) :?><aside><?= $afterBodyContent ;?></aside><? endif ;?>
			<?= $navMenu ;?>
		</footer>
	</article>
</section>