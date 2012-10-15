<?php
echo '<div class="WikiaTopAds'.$topAdsExtraClasses.'" id="WikiaTopAds">';
echo '<div class="WikiaTopAdsInner">';

if (WikiaPageType::isWikiaHub()) {
	echo F::app()->renderView('Ad', 'Index', array('slotname' => 'HOME_TOP_LEADERBOARD'));
}
elseif ($wg->EnableCorporatePageExt) {
	if (WikiaPageType::isSearch()) {
		echo F::app()->renderView('Ad', 'Index', array('slotname' => 'TOP_LEADERBOARD'));
	}
	else {
		echo F::app()->renderView('Ad', 'Index', array('slotname' => 'CORP_TOP_LEADERBOARD'));
	}
} else {
	if (in_array('leaderboard', $wg->ABTests)) {
		// no leaderboard ads
	} else {
		echo F::app()->renderView('Ad', 'Index', array('slotname' => 'TOP_LEADERBOARD'));
		echo F::app()->renderView('Ad', 'Index', array('slotname' => 'HOME_TOP_LEADERBOARD'));
	}
}
if ($wg->EnableTopButton) {
	echo F::app()->renderView('Ad', 'Index', array('slotname' => 'TOP_BUTTON'));
}

echo '</div>';
echo '</div>';
?>
