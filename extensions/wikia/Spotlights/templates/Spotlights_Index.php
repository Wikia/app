<? if ( !$wg->NoExternals && !$wg->SuppressSpotlights ): ?>
<section>
	<div class="header-container">
		<h2><?= wfMessage( 'oasis-spotlights-footer-title' )->escaped(); ?></h2>
		<? if ( $wg->EnableRandomWikiOasisButton ): ?>
			<a id="WikiaRandomWiki" href="http://community.wikia.com/wiki/Special:RandomWiki/<?= $wg->CityId ?>" class="wikia-button"><?= wfMessage( 'oasis-random-wiki' )->escaped(); ?></a>
		<? endif; ?>
	</div>
	<script type="text/javascript">
		wgAfterContentAndJS.push(function() {
			window.OpenXSPC = {};
			window.OpenXSPC[ 'fillElem_SPOTLIGHT_FOOTER' ] = function() {
				var output = window.OA_output || [];
				( 14 in output ) && $( '#SPOTLIGHT_FOOTER_1' ).html( output[ 14 ] );
				( 15 in output ) && $( '#SPOTLIGHT_FOOTER_2' ).html( output[ 15 ] );
				( 16 in output ) && $( '#SPOTLIGHT_FOOTER_3' ).html( output[ 16 ] );
			};
		});
	</script>
	<ul id="SPOTLIGHT_FOOTER" class="LazyLoadAd SPOTLIGHT_FOOTER">
		<li class="WikiaSpotlight item-1" id="SPOTLIGHT_FOOTER_1"></li>
		<li class="WikiaSpotlight item-2" id="SPOTLIGHT_FOOTER_2"></li>
		<li class="WikiaSpotlight item-3" id="SPOTLIGHT_FOOTER_3"></li>
	</ul>
</section>
<? endif; ?>
