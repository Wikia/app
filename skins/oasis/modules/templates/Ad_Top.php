<div class="WikiaTopAds" id="WikiaTopAds">

	<div class="WikiaTopAdsInner">

		<?= $app->renderView('Ad', 'Index', [
			'slotName' => 'hivi_leaderboard',
			'pageTypes' => ['homepage_logged', 'corporate', 'search', 'all_ads'],
			'addToAdQueue' => false
		]); ?>

		<?= $app->renderView('Ad', 'Index', [
			'slotName' => 'TOP_LEADERBOARD',
			'pageTypes' => ['homepage_logged', 'corporate', 'search', 'all_ads'],
			'addToAdQueue' => !AdEngine3::isEnabled()
		]); ?>

	</div>

	<?= $app->renderView('Ad', 'Index', [
		'slotName' => 'INVISIBLE_SKIN',
		'pageTypes' => ['homepage_logged', 'corporate', 'search', 'all_ads'],
		'addToAdQueue' => false
	]); ?>

</div>

<div id="InvisibleHighImpactWrapper" class="hidden">
	<div class="background"></div>

	<div class="top-bar">
		<div class="label"><?= ucfirst(wfMessage( 'adengine-advertisement' )->escaped()) ?></div>
		<a class="close">
			<div class="close-button"></div>
		</a>
	</div>
	<div id="<?php echo AdEngine3::isEnabled() ? 'invisible_high_impact_2' : 'INVISIBLE_HIGH_IMPACT_2'?>" class="wikia-ad noprint"></div>
</div>

