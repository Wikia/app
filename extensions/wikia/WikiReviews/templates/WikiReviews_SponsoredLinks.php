<section class="SponsoredLinksModule module">
<h1><?= wfMsg('wiki-reviews-sponsor-header') ?></h1>
<ul>
</ul>
</section>

<script type="text/javascript">/*<![CDATA[*/
wgAfterContentAndJS.push(function() {
	if(typeof(wgAdSS_selfAd) !== 'undefined') {
		$(wgAdSS_selfAd).appendTo( $("section.SponsoredLinksModule > ul") )
			.find("a").bind( "click", { adId: '00' }, AdSS.onClick );
		$.tracker.byStr( "adss/publisher/view/00" );
	}
});
/*]]>*/</script>
