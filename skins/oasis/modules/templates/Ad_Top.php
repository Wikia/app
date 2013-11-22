<div class="WikiaTopAds" id="WikiaTopAds">
<div class="WikiaTopAdsInner">

<?php

if (WikiaPageType::isWikiaHub()) {
	echo $app->renderView('Ad', 'Index', array('slotname' => 'HUB_TOP_LEADERBOARD'));
} elseif ($wg->EnableWikiaHomePageExt) {
	if (WikiaPageType::isSearch()) {
		echo $app->renderView('Ad', 'Index', array('slotname' => 'TOP_LEADERBOARD'));
	} else {
		echo $app->renderView('Ad', 'Index', array('slotname' => 'CORP_TOP_LEADERBOARD'));
	}
} elseif (WikiaPageType::isMainPage()) {
	echo $app->renderView('Ad', 'Index', array('slotname' => 'HOME_TOP_LEADERBOARD'));
} else {
	echo $app->renderView('Ad', 'Index', array('slotname' => 'TOP_LEADERBOARD'));
}

echo $app->renderView('Ad', 'Index', array('slotname' => 'TOP_BUTTON_WIDE'));

?>

</div>

<?= $app->renderView('Ad', 'Index', array('slotname' => 'INVISIBLE_SKIN')); ?>

</div>
