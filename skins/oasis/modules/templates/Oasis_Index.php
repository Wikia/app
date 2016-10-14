<!doctype html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>" class="<?= implode(' ', array_map( 'Sanitizer::escapeClass', $htmlClasses )) ?>">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
	<title><?= $pageTitle ?></title>









	<!--
	headLinks
	REQUESTS:
	SIZE:
	-->

	<!--<? $headLinks ?>-->

	<!-- / headLinks -->









	<!--
	cssLinks
	REQUESTS:
	SIZE:
	-->

	<!--<? $cssLinks ?>-->

	<!-- / cssLinks -->









	<!--
	$wg->OasisLastCssScripts
	REQUESTS:
	SIZE:
	-->

	<? if ( !empty( $wg->OasisLastCssScripts ) ): ?>
		<? foreach( $wg->OasisLastCssScripts as $src ): ?>
			<!--<link rel="stylesheet" href="<?= $src ?>">-->
		<? endforeach ?>
	<? endif ?>

	<!-- / $wg->OasisLastCssScripts -->









	<!--
	$pageCss
	REQUESTS:
	SIZE:
	-->

		<? /* RT #68514: load global user CSS (and other page specific CSS added via "SkinTemplateSetupPageCss" hook) */ ?>
		<? if ( $pageCss ): ?>
			<!--<style type="text/css"><?= $pageCss ?></style>-->
		<? endif ?>

	<!-- / $pageCss -->









	<!--
	$topScripts
	REQUESTS:
	SIZE:
	-->

	<!--<? $topScripts ?>-->

	<!-- / $topScripts -->









	<!--
	$globalBlockingScripts
	REQUESTS:
	SIZE:
	-->

	<!--<? $globalBlockingScripts; /*needed for jsLoader and for the async loading of CSS files.*/ ?>-->

	<!-- / $globalBlockingScripts -->









	<!-- Make IE recognize HTML5 tags. -->
	<!--[if IE]>
		<script>/*@cc_on'abbr article aside audio canvas details figcaption figure footer header hgroup mark menu meter nav output progress section summary time video'.replace(/\w+/g,function(n){document.createElement(n)})@*/</script>
	<![endif]-->









	<!--
	$jsFiles (top)
	REQUESTS:
	SIZE:
	-->

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

	<!-- / $jsFiles (top) -->









	<!-- $headItems
	REQUESTS:
	SIZE:
	-->

	<!--<? $headItems ?>-->

	<!-- / $headItems -->









</head>









<body class="<?= implode(' ', $bodyClasses) ?>" <?= $itemType ?>>
	<div class="background-image-gradient"></div>

	<!-- TRACKING PIXELS -->

	<?= $comScore ?>
	<?= $quantServe ?>
	<?= $rubiconFastlane ?>
	<?= $amazonMatch ?>
	<?= $openXBidder ?>
	<?= $prebid ?>
	<?= $rubiconVulcan ?>
	<?= $krux ?>
	<?= $dynamicYield ?>
	<?= $ivw3 ?>
	<?= $ivw2 ?>
	<?= $sourcePoint ?>
	<?= $ubisoft ?>

	<!-- / TRACKING PIXELS -->









	<div class="WikiaSiteWrapper">









		<!--
		$body
		REQUESTS:
		SIZE:
		-->

		<!--<? $body ?>-->

		<!-- / $body -->









		<!-- Ad_Index -->

		<?php
			echo F::app()->renderView('Ad', 'Index', ['slotName' => 'GPT_FLUSH', 'pageTypes' => ['*']]);
			echo F::app()->renderView('Ad', 'Index', ['slotName' => 'EVOLVE_FLUSH', 'pageTypes' => ['*']]);
			echo F::app()->renderView('Ad', 'Index', ['slotName' => 'TURTLE_FLUSH', 'pageTypes' => ['*']]);
		?>

		<!-- / Ad_Index -->









</div>









<!--
$jsFiles (bottom)
$body
REQUESTS:
SIZE:
-->

<? if( $jsAtBottom ): ?>
	<!--[if lt IE 8]>
		<script src="<?= $wg->ResourceBasePath ?>/resources/wikia/libraries/json2/json2.js"></script>
	<![endif]-->

	<!--[if lt IE 9]>
		<script src="<?= $wg->ResourceBasePath ?>/resources/wikia/libraries/html5/html5.min.js"></script>
	<![endif]-->

	<!-- Combined JS files and head scripts -->
	<!--<? $jsFiles ?>-->
<? endif ?>

<!-- / $jsFiles (bottom) -->










<script type="text/javascript">/*<![CDATA[*/ Wikia.LazyQueue.makeQueue(wgAfterContentAndJS, function(fn) {fn();}); wgAfterContentAndJS.start(); /*]]>*/</script>
<script type="text/javascript">/*<![CDATA[*/ if (typeof AdEngine_trackPageInteractive === 'function') {wgAfterContentAndJS.push(AdEngine_trackPageInteractive);} /*]]>*/</script>










<!--
$bottomScripts
$body
REQUESTS:
SIZE:
-->

<!--<? $bottomScripts ?>-->
<!--<? $nielsen ?>-->

<!-- / $bottomScripts -->










</body>

<?= wfReportTime() . "\n" ?>
<?= F::app()->renderView('Ad', 'Config') ?>

</html>
