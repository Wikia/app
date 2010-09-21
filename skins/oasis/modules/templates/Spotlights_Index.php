<section class="WikiaSpotlightsModule">
	<header>
		<? if ($wgSingleH1) { ?>
		<div class="headline-div">Wikia Spotlights</div>
		<? } else { ?>
		<h1>Wikia Spotlights</h1>
		<? } ?>
		<img src="<?= $wgBlankImgUrl; ?>" class="banner-corner-left" height="0" width="0">
		<img src="<?= $wgBlankImgUrl; ?>" class="banner-corner-right" height="0" width="0">
	</header>
	<ul>
		<li class="WikiaSpotlight item-1">
			<?= AdEngine::getInstance()->getPlaceHolderIframe('SPOTLIGHT_RAIL_1') ?>
		</li>
		<li class="WikiaSpotlight item-2">
			<?= AdEngine::getInstance()->getPlaceHolderIframe('SPOTLIGHT_RAIL_2') ?>
		</li>
		<li class="WikiaSpotlight item-3">
			<?= AdEngine::getInstance()->getPlaceHolderIframe('SPOTLIGHT_RAIL_3') ?>
		</li>
	</ul>
</section>
