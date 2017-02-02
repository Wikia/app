<div class="WikiaTopAds" id="WikiaTopAds">

	<div class="WikiaTopAdsInner">

		<?= $app->renderView('Ad', 'Index', [
			'slotName' => 'TOP_LEADERBOARD',
			'pageTypes' => ['homepage_logged', 'corporate', 'search', 'all_ads']
		]); ?>

		<?= $app->renderView('Ad', 'Index', ['slotName' => 'TOP_BUTTON_WIDE', 'pageTypes' => ['homepage_logged', 'search', 'all_ads']]); ?>

	</div>

	<?= $app->renderView('Ad', 'Index', ['slotName' => 'INVISIBLE_SKIN', 'pageTypes' => ['homepage_logged', 'corporate', 'search', 'all_ads']]); ?>

</div>

<div id="InvisibleHighImpactWrapper" class="hidden">
	<div class="background"></div>

	<div class="top-bar">
		<div class="label"><?= ucfirst(wfMessage( 'adengine-advertisement' )->escaped()) ?></div>
		<a class="close">
			<div class="close-button"></div>
		</a>
	</div>
	<div id="INVISIBLE_HIGH_IMPACT_2" class="wikia-ad noprint"></div>
</div>
