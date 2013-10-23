<!doctype html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>

<meta http-equiv="Content-Type" content="<?= $mimeType ?>; charset=<?= $charset ?>">
<?php if ( BodyController::isResponsiveLayoutEnabled() ) : ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<?php else : ?>
	<meta name="viewport" content="width=1200">
<?php endif ?>
<?= $headLinks ?>

<title><?= $pageTitle ?></title>

<!-- SASS-generated CSS file -->
<link rel="stylesheet" href="<?= AssetsManager::getInstance()->getSassCommonURL( $mainSassFile ) ?>">

<!-- CSS injected by extensions -->
<?= $cssLinks ?>

<?
	/*
	Add the wiki and user-specific overrides last.  This is a special case in Oasis because the modules run
	later than normal extensions and therefore add themselves later than the wiki/user specific CSS is
	normally added. See Skin::setupUserCss()
	*/
?>
<? if ( !empty( $wg->OasisLastCssScripts ) ): ?>
	<? foreach( $wg->OasisLastCssScripts as $src ): ?>
		<link rel="stylesheet" href="<?= $src ?>">
	<? endforeach ?>
<? endif ?>

<? /* RT #68514: load global user CSS (and other page specific CSS added via "SkinTemplateSetupPageCss" hook) */ ?>
<? if ( $pageCss ): ?>
	<style type="text/css"><?= $pageCss ?></style>
<? endif ?>

<? // 1% of JavaScript errors are logged for $wgEnableJSerrorLogging=true non-devbox wikis ?>
<? if ( ($wg->IsGASpecialWiki || $wg->EnableJavaScriptErrorLogging) && !$wg->DevelEnvironment ): ?>
<script>
window.onerror=function(m,u,l){
var q='//jserrorslog.wikia.com/',i=new Image();
if(Math.random()<0.01){
	try{var d=[m,u,l];
		try{d.push(document.cookie.match(/server.([A-Z]*).cache/)[1])}catch(e){}
		i.src=q+'l?'+JSON.stringify(d)
	}catch(e){i.src=q+'e?'+e}
}return!1}
</script>
<? endif ?>

<?= $topScripts ?>
<?= $wikiaScriptLoader; /*needed for jsLoader and for the async loading of CSS files.*/ ?>

<!-- Make IE recognize HTML5 tags. -->
<!--[if IE]>
	<script>/*@cc_on'abbr article aside audio canvas details figcaption figure footer header hgroup mark menu meter nav output progress section summary time video'.replace(/\w+/g,function(n){document.createElement(n)})@*/</script>
<![endif]-->

<? if ( !$jsAtBottom ): ?>
	<!--[if lt IE 8]>
		<script src="<?= $wg->ResourceBasePath ?>/resources/wikia/libraries/json2/json2.js"></script>
	<![endif]-->

	<!--[if lt IE 9]>
		<script src="<?= $wg->ResourceBasePath ?>/resources/wikia/libraries/html5/html5.min.js"></script>
	<![endif]-->

	<!-- Combined JS files and head scripts -->
	<?= $jsFiles ?>
<? endif ?>

<? if ( $displayAdminDashboard ): ?>
	<!--[if IE]><script src="<?= $wg->ResourceBasePath ?>/resources/wikia/libraries/excanvas/excanvas.js"></script><![endif]-->
<? endif ?>

<?= $headItems ?>

</head>
<body class="<?= implode(' ', $bodyClasses) ?>"<?= $itemType ?>>
<? if ( BodyController::isResponsiveLayoutEnabled() ): ?>
	<div class="background-image-gradient"></div>
<script>
// START DAR-1859 | A/B Test CTR on right rail modules below the article vs next to the article
// Those lines will be removed in DAR-2121, after the test
if ( window.Wikia.AbTest && (Wikia.AbTest.getGroup( "DAR_RIGHTRAILPOSITION" ) == "STATIC") ) {
	document.documentElement.className += " keep-rail-on-right";
}
// END DAR-1859 | A/B Test CTR on right rail modules below the article vs next to the article
</script>
<? endif ?>

<?= $comScore ?>
<?= $quantServe ?>
<?= $googleAnalytics ?>
<?= $ivw ?>
<?= $amazonDirectTargetedBuy ?>
<?= $dynamicYield ?>
<?= $body ?>

<?php
	echo F::app()->renderView('Ad', 'Index', array('slotname' => 'GPT_FLUSH'));
	if (empty($wg->SuppressAds)) {
		echo F::app()->renderView('Ad', 'Index', array('slotname' => 'INVISIBLE_1'));
		if (!$wg->EnableWikiaHomePageExt) {
			echo F::app()->renderView('Ad', 'Index', array('slotname' => 'INVISIBLE_2'));
		}
	}
?>

<? if( $jsAtBottom ): ?>
	<!--[if lt IE 8]>
		<script src="<?= $wg->ResourceBasePath ?>/resources/wikia/libraries/json2/json2.js"></script>
	<![endif]-->

	<!--[if lt IE 9]>
		<script src="<?= $wg->ResourceBasePath ?>/resources/wikia/libraries/html5/html5.min.js"></script>
	<![endif]-->

	<!-- Combined JS files and head scripts -->
	<?= $jsFiles ?>
<? endif ?>

<script type="text/javascript">/*<![CDATA[*/ Wikia.LazyQueue.makeQueue(wgAfterContentAndJS, function(fn) {fn();}); wgAfterContentAndJS.start(); /*]]>*/</script>

<?= $bottomScripts ?>
<?= $cssPrintLinks ?>

<? if ( $wg->AdDriverUseSevenOneMedia ): ?>
	<script src="<?= htmlspecialchars(AssetsManager::getInstance()->getOneCommonURL('extensions/wikia/AdEngine/SevenOneMedia/my_ad_integration.js')); ?>"></script>
	<script src="<?= htmlspecialchars(AssetsManager::getInstance()->getOneCommonURL('extensions/wikia/AdEngine/SevenOneMedia/allinone.js')); ?>"></script>
	<script>
		Wikia.SevenOneMediaIntegration.loadStyle(<?= json_encode(AssetsManager::getInstance()->getOneCommonURL('extensions/wikia/AdEngine/SevenOneMedia/my_ad_integration.css')); ?>);
	</script>
	<script>Wikia.SevenOneMediaIntegration.initVars();</script>
	<script>Wikia.SevenOneMediaIntegration.track("init");</script>
	<script>Wikia.SevenOneMediaIntegration.enabled && myAd.loadScript("site");</script>
	<script>Wikia.SevenOneMediaIntegration.enabled && myAd.loadScript("global");</script>
	<script>Wikia.SevenOneMediaIntegration.track("scripts");</script>
	<div id="ads-postponed" style="display: none">
		<table><tr><td>
			<div id="ad-popup1-postponed" class="ad-wrapper">
				<script>Wikia.SevenOneMediaIntegration.enabled && myAd.insertAd("popup1");</script>
			</div>
		</td></tr></table>
		<script>Wikia.SevenOneMediaIntegration.enabled && myAd.finishAd("popup1", "move");</script>
		<table><tr><td>
			<div id="ad-fullbanner2-postponed" class="ad-wrapper">
				<script>Wikia.SevenOneMediaIntegration.enabled && myAd.insertAd("fullbanner2");</script>
			</div>
		</td></tr></table>
		<script>
			if (Wikia.SevenOneMediaIntegration.enabled) {
				myAd.finishAd("fullbanner2", "move");
				if (!myAd.isSpecialAd("fullbanner2")) {
					window.adslots2.push(["TOP_BUTTON_WIDE.force"]);
				}
			}
		</script>
		<table><tr><td>
			<div id="ad-skyscraper1-postponed" class="ad-wrapper">
				<script>Wikia.SevenOneMediaIntegration.enabled && myAd.insertAd("skyscraper1");</script>
			</div>
		</td></tr></table>
		<script>Wikia.SevenOneMediaIntegration.enabled && myAd.finishAd("skyscraper1", "move");</script>
		<table><tr><td>
			<div id="ad-rectangle1-postponed" class="ad-wrapper">
				<script>Wikia.SevenOneMediaIntegration.enabled && myAd.insertAd("rectangle1");</script>
			</div>
		</td></tr></table>
		<script>
			if (Wikia.SevenOneMediaIntegration.enabled) {
				$("#TOP_RIGHT_BOXAD, #HOME_TOP_RIGHT_BOXAD").removeClass("default-height");
				myAd.finishAd("rectangle1", "move");
			}
		</script>
	</div>
	<script>Wikia.SevenOneMediaIntegration.track("ads");</script>
<? endif ?>

</body>

<?= wfReportTime() . "\n" ?>
<?= F::app()->renderView('Ad', 'Config') ?>

</html>
