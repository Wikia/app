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
 * @var $trendingArticles
 */
?>
<section id=wkPage>
	<?= !empty( $pageHeaderContent ) ? $pageHeaderContent : ''; ?>
	<article id=wkMainCnt>
		<?= $bodyContent ;?>
		<footer id=wkMainCntFtr>
			<?= !empty( $afterBodyContent ) ? $afterBodyContent : ''; ?>
			<nav id="wkRltdCnt">
				<div id="RelatedPagesModuleWrapper"></div>
				<?= !empty( $trendingArticles ) ? $trendingArticles : ''; ?>
				<?= !empty( $categoryLinks ) ? $categoryLinks : ''; ?>
			</nav>
			<?= !empty( $afterContentHookText ) ? $afterContentHookText : ''; ?>
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
