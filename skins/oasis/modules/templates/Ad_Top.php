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

<div id="floor_adhesion" class="wikia-ad noprint"></div>
<div id="invisible_high_impact_2" class="wikia-ad noprint"></div>
