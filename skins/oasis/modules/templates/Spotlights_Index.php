<section class="WikiaSpotlightsModule">
	<header>
		<h1>Wikia Spotlights</h1>
		<img src="<?= $wgBlankImgUrl; ?>" class="banner-corner-left">
		<img src="<?= $wgBlankImgUrl; ?>" class="banner-corner-right">
	</header>
	<ul>
		<li class="WikiaSpotlight item-1">
			<?= AdEngine::getInstance()->getPlaceHolderIframe('SPOTLIGHT_RAIL_1') ?>
			<!--
			<img src="/skins/oasis/images/temp_spotlight1.jpg" width="270" height="94">
			<p>This is placeholder for Wikia Community Spotlights.</p>
			-->
		</li>
		<li class="WikiaSpotlight item-2">
			<?= AdEngine::getInstance()->getPlaceHolderIframe('SPOTLIGHT_RAIL_2') ?>
			<!--
			<img src="/skins/oasis/images/temp_spotlight3.jpg" width="270" height="94">
			<p>This is placeholder for Wikia Community Spotlights.</p>
			-->
		</li>
		<li class="WikiaSpotlight item-3">
			<?= AdEngine::getInstance()->getPlaceHolderIframe('SPOTLIGHT_RAIL_3') ?>
			<!--
			<img src="/skins/oasis/images/temp_spotlight2.jpg" width="270" height="94">
			<p>This is placeholder for Wikia Community Spotlights.</p>
			-->
		</li>
	</ul>
</section>
