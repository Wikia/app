<!doctype html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>" class="<?= implode(' ', array_map( 'Sanitizer::escapeClass', $htmlClasses )) ?>">
<head>

<meta http-equiv="Content-Type" content="<?= $mimeType ?>; charset=<?= $charset ?>">
<?php if ( BodyController::isResponsiveLayoutEnabled() || BodyController::isOasisBreakpoints() ) : ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<?php else : ?>
	<meta name="viewport" content="width=1200">
<?php endif ?>
<?= $headLinks ?>

<title><?= $pageTitle ?></title>

<!-- CSS injected by skin and extensions -->
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

<?= $topScripts ?>

<!-- One tag - Tealium IQ: start -->
<script type="text/javascript">
	cookieExists = function (cookieName) {
		return document.cookie.indexOf(cookieName) > -1;
	};

	var quantcastLabels = "";
	if (window.wgWikiVertical) {
		quantcastLabels += wgWikiVertical;
		if (window.wgDartCustomKeyValues) {
			var keyValues = wgDartCustomKeyValues.split(';');
			for (var i=0; i<keyValues.length; i++) {
				var keyValue = keyValues[i].split('=');
				if (keyValue.length >= 2) {
					quantcastLabels += ',' + wgWikiVertical + '.' + keyValue[1];
				}
			}
		}
	}

	var dartGnreValues = window.dartGnreValues || [];

	var utag_data = {
		sampleRate: (cookieExists('qualaroo_survey_submission') ? 100 : 10),
		loginStatus: !!window.wgUserName ? 'user' : 'anon',
		isCorporatePage: (window.wikiaPageIsCorporate ? 'Yes' : 'No'),
		isPowerUserAdmin: !!window.wikiaIsPowerUserAdmin,
		isPowerUserFrequent: !!window.wikiaIsPowerUserFrequent,
		isPowerUserLifetime: !!window.wikiaIsPowerUserLifetime,
		isLoggedIn: !!window.wgUserName,
		cpBenefitsModalShown: cookieExists('cpBenefitsModalShown'),
		isDartGnreAdventure: dartGnreValues.indexOf('adventure') > -1,
		isDartGnreAction: dartGnreValues.indexOf('action') > -1,
		isDartGnreFantasy: dartGnreValues.indexOf('fantasy') > -1,
		isDartGnreRpg:dartGnreValues.indexOf('rpg') > -1,
		isDartGnreScifi: dartGnreValues.indexOf('scifi') > -1,
		isDartGnreOpenworld: dartGnreValues.indexOf('openworld') > -1,
		isDartGnreFighting: dartGnreValues.indexOf('fighting') > -1,
		isDartGnreDrama: dartGnreValues.indexOf('drama') > -1,
		isDartGnreCasual: dartGnreValues.indexOf('casual') > -1,
		isDartGnreAnime: dartGnreValues.indexOf('anime') > -1,
		isDartGnreShooter: dartGnreValues.indexOf('shooter') > -1,
		isDartGnreCartoon: dartGnreValues.indexOf('cartoon') > -1,
		isDartGnreComedy: dartGnreValues.indexOf('comedy') > -1,
		isDartGnre3rdpersonshooter: dartGnreValues.indexOf('3rdpersonshooter') > -1,
		isDartGnreFps: dartGnreValues.indexOf('fps') > -1,
		isDartGnreHorror: dartGnreValues.indexOf('horror') > -1,
		isDartGnreDriving: dartGnreValues.indexOf('driving') > -1,
		isDartGnreSports: dartGnreValues.indexOf('sports') > -1,
		quantcastId: 'p-8bG6eLqkH6Avk',
		quantcastLabels: quantcastLabels
	};
</script>

<!-- Loading script asynchronously -->
<script type="text/javascript">
	(function(a,b,c,d){
		a='//tags.tiqcdn.com/utag/wikia/main/dev/utag.js';
		b=document;c='script';d=b.createElement(c);d.src=a;d.type='text/java'+c;d.async=true;
		a=b.getElementsByTagName(c)[0];a.parentNode.insertBefore(d,a);
	})();
</script>
<!-- One tag - Tealium IQ: end -->


<?= $globalBlockingScripts; /*needed for jsLoader and for the async loading of CSS files.*/ ?>

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

<?= $headItems ?>

</head>
<body class="<?= implode(' ', $bodyClasses) ?>" <?= $itemType ?>>
<? if ( BodyController::isResponsiveLayoutEnabled() || BodyController::isOasisBreakpoints() ): ?>
	<div class="background-image-gradient"></div>
<? endif ?>

<?= $comScore ?>
<?= $rubiconFastlane ?>
<?= $amazonMatch ?>
<?= $openXBidder ?>
<?= $prebid ?>
<?= $rubiconVulcan ?>
<?= $krux ?>
<?= $netzathleten ?>
<?= $dynamicYield ?>
<?= $ivw3 ?>
<?= $ivw2 ?>
<?= $sourcePoint ?>
<?= $gfc ?>

<div class="WikiaSiteWrapper">
	<?= $body ?>

	<?php
		echo F::app()->renderView('Ad', 'Index', ['slotName' => 'GPT_FLUSH', 'pageTypes' => ['*']]);
		echo F::app()->renderView('Ad', 'Index', ['slotName' => 'EVOLVE_FLUSH', 'pageTypes' => ['*']]);
		echo F::app()->renderView('Ad', 'Index', ['slotName' => 'TURTLE_FLUSH', 'pageTypes' => ['*']]);
	?>
</div>
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
<script type="text/javascript">/*<![CDATA[*/ if (typeof AdEngine_trackPageInteractive === 'function') {wgAfterContentAndJS.push(AdEngine_trackPageInteractive);} /*]]>*/</script>
<?= $bottomScripts ?>

<?= $nielsen ?>
</body>

<?= wfReportTime() . "\n" ?>
<?= F::app()->renderView('Ad', 'Config') ?>

</html>
