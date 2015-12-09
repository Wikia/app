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
// This is quick hacky fix for P2
// Ticket https://wikia-inc.atlassian.net/browse/XW-825
<script>
	document.addEventListener("DOMContentLoaded", function() {
		// Replace widget scripts with iframes
		$('script[type=x-wikia-widget]').each(function() {
			$(this).replaceWith(this.textContent);
		});

		// Show Polldaddy widget
		$('a[data-wikia-widget=polldaddy]').each(function() {
			var id = $(this).data('id');

			$(this).replaceWith('<a name="pd_a_' + id + '" style="display:inline;padding:0;margin:0;"></a>' +
				'<div class="PDS_Poll" id="PDI_container' + id + '"></div>');
			$.getScript('//static.polldaddy.com/p/' + id + '.js');
		});
	});
</script>
