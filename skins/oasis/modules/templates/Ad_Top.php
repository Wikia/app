<?php
echo '<div class="WikiaTopAds'.$topAdsExtraClasses.'" id="WikiaTopAds">';

if (ArticleAdLogic::isWikiaHub()) {
	echo wfRenderModule('Ad', 'Index', array('slotname' => 'HUB_TOP_LEADERBOARD'));
}
elseif ($wg->EnableCorporatePageExt) {
	if (ArticleAdLogic::isSearch()) {
		echo wfRenderModule('Ad', 'Index', array('slotname' => 'TOP_LEADERBOARD'));
	}
	else {
		echo wfRenderModule('Ad', 'Index', array('slotname' => 'CORP_TOP_LEADERBOARD'));
	}
} else {
	if (in_array('leaderboard', $wg->ABTests)) {
		// no leaderboard ads
	} else {
		echo wfRenderModule('Ad', 'Index', array('slotname' => 'TOP_LEADERBOARD'));
		echo wfRenderModule('Ad', 'Index', array('slotname' => 'HOME_TOP_LEADERBOARD'));
	}
}
if ($wg->EnableTopButton) {
	echo wfRenderModule('Ad', 'Index', array('slotname' => 'TOP_BUTTON'));
}

echo '</div>';
?>