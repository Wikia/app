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

	<!-- Opentag -->
	<script>
		function getKruxSegment() {
			var kruxSegment = 'not set',
				uniqueKruxSegments = {
					ocry7a4xg: 'Game Heroes 2014',
					ocr1te1tc: 'Digital DNA 2014',
					ocr6m2jd6: 'Inquisitive Minds 2014',
					ocr05ve5z: 'Culture Caster 2014',
					ocr88oqh9: 'Social Entertainers 2014'
				},
				uniqueKruxSegmentsKeys = Object.keys(uniqueKruxSegments),
				markedSegments = [],
				kruxSegments = [];

			console.log("window.localStorage", window.localStorage)
			if (window.localStorage) {
				kruxSegments = (window.localStorage.kxsegs || '').split(',');
				console.log("kruxSegments", kruxSegments)
			}

			if (kruxSegments.length) {
				console.log("kruxSegments.length", kruxSegments.length)
				markedSegments = uniqueKruxSegmentsKeys.filter(function (n) {
					return kruxSegments.indexOf(n) !== -1;
				});
				console.log("markedSegments.length", markedSegments.length)
				if (markedSegments.length) {
					kruxSegment = uniqueKruxSegments[markedSegments[0]];
				}
			}

			console.log("kruxSegment", kruxSegment)

			return kruxSegment;
		}

		function getEsrbRating() {
			var rating = 'not set';

			if (window.ads && window.ads.context.targeting.esrbRating) {
				rating = window.ads.context.targeting.esrbRating;
			}

			return rating;
		}

		window['abtest_gua_dimensions'] = [];
		window['abtest_gua_dimensions_ads'] = [];

		if (window.Wikia && window.Wikia.AbTest) {
			var abList = window.Wikia.AbTest.getExperiments(/* includeAll */ true),
				abExp, abGroupName, abSlot, abIndex,
				abForceTrackOnLoad = false;

			for (abIndex = 0; abIndex < abList.length; abIndex++) {
				abExp = abList[abIndex];

				if (!abExp || !abExp.flags) {
					continue;
				}

				if (!abExp.flags.ga_tracking) {
					continue;
				}

				if (abExp.flags.forced_ga_tracking_on_load && abExp.group) {
					// we will read this variable in TMS and send custom GA event:
					// window.guaTrackEvent('ABtest', 'ONLOAD', 'TIME', renderTime);
					// where renderTime = (new Date()).getTime() - window.abRenderStart.getTime();
					window.abRenderStart = window.wgNow || (new Date())
				}

				abSlot = window.Wikia.AbTest.getGASlot(abExp.name);

				if (abSlot >= 40 && abSlot <= 49) {
					abGroupName = abExp.group ? abExp.group.name : (abList.nouuid ? 'NOBEACON' : 'NOT_IN_ANY_GROUP');
					window['abtest_gua_dimensions'].push(['set', 'dimension' + abSlot, abGroupName]);
					window['abtest_gua_dimensions_ads'].push(['ads.set', 'dimension' + abSlot, abGroupName]);
				}
			}
		}

		window.universal_variable = <?php echo json_encode($universal_variable); ?>;
		window['kruxSegment'] = getKruxSegment();
		window['esrbRating'] = getEsrbRating();

		// Check the UV Listener array exists
		window.uv_listener = window.uv_listener || [];

		// Create event listener
		window.uv_listener.push(['on', 'event', function(event) {
			if (event.action === "community-page-entry-point") {
				console.log("DUPA1")
			} else  {
				console.log("DUPA2")
			}
		}]);
	</script>
	<script src='//d3c3cq33003psk.cloudfront.net/opentag-165812-devdiana.js' async defer></script>

</head>
<body class="<?= implode(' ', $bodyClasses) ?>" <?= $itemType ?>>
<? if ( BodyController::isResponsiveLayoutEnabled() || BodyController::isOasisBreakpoints() ): ?>
	<div class="background-image-gradient"></div>
<? endif ?>

<?//= $comScore ?>
<?//= $quantServe ?>
<?//= $rubiconFastlane ?>
<?//= $amazonMatch ?>
<?//= $openXBidder ?>
<?//= $prebid ?>
<?//= $rubiconVulcan ?>
<?//= $krux ?>
<?//= $netzathleten ?>
<?//= $dynamicYield ?>
<?//= $ivw3 ?>
<?//= $ivw2 ?>
<?//= $sourcePoint ?>
<?//= $gfc ?>

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
