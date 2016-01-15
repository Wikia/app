<!doctype html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
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

<? if ( $displayAdminDashboard ): ?>
	<!--[if IE]><script src="<?= $wg->ResourceBasePath ?>/resources/wikia/libraries/excanvas/excanvas.js"></script><![endif]-->
<? endif ?>

<?= $headItems ?>

</head>
<body class="<?= implode(' ', $bodyClasses) ?>"<?= $itemType ?>>
<? if ( BodyController::isResponsiveLayoutEnabled() || BodyController::isOasisBreakpoints() ): ?>
	<div class="background-image-gradient"></div>
<? endif ?>

<?= $comScore ?>
<?= $quantServe ?>
<?= $amazonMatch ?>
<?= $openXBidder ?>
<?= $rubiconFastlane ?>
<?= $dynamicYield ?>
<?= $ivw2 ?>
<div class="WikiaSiteWrapper">
	<?= $body ?>

	<?php
		echo F::app()->renderView('Ad', 'Index', ['slotName' => 'GPT_FLUSH', 'pageTypes' => ['*']]);
		echo F::app()->renderView('Ad', 'Index', ['slotName' => 'TURTLE_FLUSH', 'pageTypes' => ['*']]);
		echo F::app()->renderView('Ad', 'Index', ['slotName' => 'SEVENONEMEDIA_FLUSH', 'pageTypes' => ['*']]);
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
<?php if ($wg->EnableAdEngineExt) { ?>
<script type="text/javascript">/*<![CDATA[*/ if (typeof AdEngine_trackPageInteractive === 'function') {wgAfterContentAndJS.push(AdEngine_trackPageInteractive);} /*]]>*/</script>
<?php } ?>
<?= $bottomScripts ?>

<?= $nielsen ?>

<script type="text/javascript">
	console.log('== Qualaroo experiment enabled ==');

	var wgQualarooKruxMapping = {
			'all': {
				'Xbox One': 'p9jqe7dyz',
				'Playstation 3': 'p9jqe7dyz',
				'Playstation 4': 'p9jqe7dyz'
			},
			'152278': {
				'Xbox One': 'p9jp8yb4b',
				'Playstation 3': 'p9jp28ur3',
				'Playstation 4': 'p9jp28ur3'
			}
		},
		wgKruxPubId = '<?= $wg->KruxPubId; ?>',
		sentSegments = {};

	function hasSegmentBeenSent(segment) {
		return !!sentSegments[segment];
	}

	function sendKruxRequest(segment) {
		if(!hasSegmentBeenSent(segment)) {
			$.ajax({
				url: 'http://cdn.krxd.net/userdata/add',
				type: "POST",
				async: true,
				dataType: 'jsonp',
				data: {
					pub: wgKruxPubId,
					seg: segment
				},
				success: function() {
					sentSegments[segment] = true;
					console.log("Qualaroo-Krux integration: request to Krux sent (" + segment + ")");
				}
			});
		} else {
			console.log("Qualaroo-Krux integration: segment already added (" + segment + ")");
		}
	}

	function matchSegmentsAndSendRequests(nudgeId, answer) {
		if(wgQualarooKruxMapping[nudgeId] && wgQualarooKruxMapping[nudgeId][answer]) {
			var escapedAnswer = encodeURI(answer);

			// 1st method which probably doesn't work
			sendKruxRequest(wgQualarooKruxMapping[nudgeId][answer]);

			// 2nd method using Krux events
			if( Krux ) {
				Krux('admEvent','KSBbroTm', {response: escapedAnswer});
				console.log("Qualaroo-Krux integration: fired a Krux event (" + escapedAnswer + ")");
			}
		} else if(wgQualarooKruxMapping['all'][answer]) {
			// 1st method which probably doesn't work
			sendKruxRequest(wgQualarooKruxMapping['all'][answer]);

			// 2nd method using Krux events
			if( Krux ) {
				Krux('admEvent','KSBbroTm', {response: escapedAnswer});
				console.log("Qualaroo-Krux integration: fired a Krux event (" + escapedAnswer + ")");
			}
		} else {
			console.log('Qualaroo-Krux integration: no segment found for the answer');
		}
	}

	function validateAndSendKruxRequests(fieldsList, nudgeId) {
		var answer = '',
			answers;

		if(!Object.keys) {
			console.log('Qualaroo-Krux integration: unsupported browser');
			return;
		}

		if(!fieldsList[0]['answer']) {
			console.log('Qualaroo-Krux integration: no answers found');
			return;
		}

		answers = fieldsList[0]['answer'];

		if(typeof answers === 'string') {
			matchSegmentsAndSendRequests(nudgeId, answers);
		} else {
			Object.keys(answers).forEach(function(i) {
				matchSegmentsAndSendRequests(nudgeId, answers[i]);
			});
		}
	}

	window._kiq.push(['eventHandler', 'submit', function(field_list, nudge_id, node_id){
		validateAndSendKruxRequests(field_list, nudge_id);
	}]);
</script>

</body>

<?= wfReportTime() . "\n" ?>
<?= F::app()->renderView('Ad', 'Config') ?>

</html>
