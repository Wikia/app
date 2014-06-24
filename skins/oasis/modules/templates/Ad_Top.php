<div class="WikiaTopAds" id="WikiaTopAds">
	<div class="WikiaTopAdsInner">

		<div id="10db0330b9" class="pagefair-acceptable">

			<?php echo $app->renderView('Ad', 'Index', ['slotName' => $leaderboardName, 'pageTypes' => ['homepage_logged', 'corporate', 'all_ads']]); ?>

		</div>
		<?php

		echo $app->renderView('Ad', 'Index', ['slotName' => 'TOP_BUTTON_WIDE', 'pageTypes' => ['homepage_logged', 'all_ads']]);

		?>

	</div>

	<?= $app->renderView('Ad', 'Index', ['slotName' => 'INVISIBLE_SKIN', 'pageTypes' => ['homepage_logged', 'corporate', 'all_ads']]); ?>

</div>
