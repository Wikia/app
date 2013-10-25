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

if ($wg->EnableTopButtonWide) {
	echo $app->renderView('Ad', 'Index', array('slotname' => 'TOP_BUTTON_WIDE'));
} else if ($wg->EnableTopButton) {
	echo $app->renderView('Ad', 'Index', array('slotname' => 'TOP_BUTTON'));
}

?>

</div>

<?= $app->renderView('Ad', 'Index', array('slotname' => 'INVISIBLE_SKIN')); ?>

</div>

<? if ($wg->Title && $wg->Title->getPageLanguage()->getCode() === 'de'): ?>
	<? // SevenOne Media requested HTML {{{ ?>
	<div id="ads-outer" class="noprint">
		<?= $app->renderView('Ad', 'Index', array('slotname' => 'ad-popup1')); ?>
		<div id="ad-fullbanner2-outer">
			<?= $app->renderView('Ad', 'Index', array('slotname' => 'ad-fullbanner2')); ?>
		</div>
		<div id="ad-skyscraper1-outer">
			<?= $app->renderView('Ad', 'Index', array('slotname' => 'ad-skyscraper1')); ?>
		</div>
	</div>
	<? // }}} SevenOne Media requested HTML ?>
<? endif; ?>
