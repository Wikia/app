<div class="WikiaTopAds" id="WikiaTopAds">
<div class="WikiaTopAdsInner">

<?php

if (WikiaPageType::isWikiaHub()) {
	$leaderboardName = 'HUB_TOP_LEADERBOARD';
} elseif ($wg->EnableWikiaHomePageExt) {
	if (WikiaPageType::isSearch()) {
		$leaderboardName = 'TOP_LEADERBOARD';
	} else {
		$leaderboardName = 'CORP_TOP_LEADERBOARD';
	}
} elseif (WikiaPageType::isMainPage()) {
	$leaderboardName = 'HOME_TOP_LEADERBOARD';
} else {
	$leaderboardName = 'TOP_LEADERBOARD';
}

echo $app->renderView('Ad', 'Index', ['slotname' => $leaderboardName, 'pageTypes' => ['*']]);
echo $app->renderView('Ad', 'Index', ['slotname' => 'TOP_BUTTON_WIDE']);

?>

</div>

<?= $app->renderView('Ad', 'Index', ['slotname' => 'INVISIBLE_SKIN', 'pageTypes' => ['homepage_logged', 'all']]); ?>

</div>
