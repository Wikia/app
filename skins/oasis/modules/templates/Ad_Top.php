<div class="WikiaTopAds" id="WikiaTopAds">

	<div class="WikiaTopAdsInner">


		<?= $app->renderView('Ad', 'Index', [
			'slotName' => $leaderboardName,
			'pageTypes' => ['homepage_logged', 'corporate', 'search', 'all_ads']
		]); ?>

		<?= $app->renderView('Ad', 'Index', ['slotName' => 'TOP_BUTTON_WIDE', 'pageTypes' => ['homepage_logged', 'search', 'all_ads']]); ?>

	</div>

	<?= $app->renderView('Ad', 'Index', ['slotName' => 'INVISIBLE_SKIN', 'pageTypes' => ['homepage_logged', 'corporate', 'search', 'all_ads']]); ?>

</div>
