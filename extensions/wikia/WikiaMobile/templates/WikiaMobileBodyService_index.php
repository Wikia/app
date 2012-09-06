<?
/**
 * @var $pageHeaderContent String
 * @var $bodyContent String
 * @var $navMenu String
 * @var $relatedPages String
 * @var $categoryLinks String
 * @var $afterContentHookText String
 * @var $afterBodyContent String
 * @var $afterBodyContent String
 */
?>
<section id=wkPage>
	<?= $pageHeaderContent ;?>
	<article id=wkMainCnt>
		<?= $bodyContent ;?>
		<?= $navMenu ;?>
		<footer id=wkMainCntFtr>
			<nav id=wkRltdCnt>
			<?= $relatedPages ;?>
			<?= $categoryLinks ;?>
			</nav>
			<? if ( !empty( $afterContentHookText ) || !empty( $afterBodyContent ) ) :?>
			<aside>
			<?= $afterContentHookText ;?>
			<?= $afterBodyContent ;?>
			</aside>
			<? endif ;?>
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