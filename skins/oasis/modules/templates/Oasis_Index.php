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

	<?= $headLinks ?>

	<!-- / headLinks -->









	<!--
	$cssLinks without ad recovery and site
	REQUESTS: +3
	SIZE:     +123KB

	$cssLinks with ad recovery and site
	REQUESTS: +6
	SIZE:     +126KB
	-->

	<?= $cssLinks ?>

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









	<!-- Rychu preloading -->

	<img src="http://sandbox-s1.slot1.wikia.com/skins/shared/images/sprite.png" height="1" alt="preload">
	<img src="http://img3.wikia.nocookie.net/__cb15/scrubs/images/5/50/Wiki-background" height="1" alt="preload">
	<link rel="stylesheet" src="http://sandbox-s1.slot1.wikia.com/skins/oasis/fonts/yanone/YanoneKaffeesatz-Regular-webfont.woff" lazyload>

	<!-- / Rychu preloading -->









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
		REQUESTS: +0
		SIZE:     +28KB

		$body with images
		REQUESTS: +3
		SIZE:     +18KB
		-->

		<?= $body ?>

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
