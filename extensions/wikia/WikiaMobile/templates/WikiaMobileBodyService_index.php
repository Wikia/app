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
<div id=wkMdlWrp>
	<div id=wkMdlTB>
		<div id=wkMdlTlBar></div>
		<div id=wkMdlClo class=clsIco></div>
	</div>
	<div id=wkMdlCnt></div>
	<div id=wkMdlFtr></div>
</div>