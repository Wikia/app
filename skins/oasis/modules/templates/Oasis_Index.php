<!doctype html>
<html lang="en" dir="<?= $dir ?>">
<head>
	<meta http-equiv="Content-Type" content="<?= $mimetype ?>; charset=<?= $charset ?>">
	<meta name="viewport" content="width=1200">
	<?= $headlinks ?>

	<title><?= $pagetitle ?></title>
	<?= $globalVariablesScript ?>

	<!-- Make IE recognize HTML5 tags. -->
	<!--[if IE]>
		<script>/*@cc_on'abbr article aside audio canvas details figcaption figure footer header hgroup mark menu meter nav output progress section summary time video'.replace(/\w+/g,function(n){document.createElement(n)})@*/</script>
	<![endif]-->

	<!-- SASS-generated CSS file -->
	<link rel="stylesheet" href="<?= wfGetSassUrl("skins/oasis/css/oasis.scss") ?>">

	<!-- CSS files to be combined by server-side process (eg: a .scss file instead of StaticChute)-->
	<link rel="stylesheet" href="/extensions/wikia/ShareFeature/css/ShareFeature.css">
	<link rel="stylesheet" href="/extensions/wikia/CreatePage/css/CreatePage.css">

	<!-- CSS injected by extensions -->
	<?= $csslinks ?>

	<!-- Used for page load time tracking -->
	<script>/*<![CDATA[*/
		var wgNow = new Date();
	/*]]>*/</script>

	<!-- Combined JS files (StaticChute) -->
	<?= $staticChuteHtml ?>

	<!-- Headscripts -->
	<?= $headscripts ?>
</head>
<body class="<?= $bodyClasses ?>"<?= $body_ondblclick ? ' ondblclick="' . htmlspecialchars($body_ondblclick) . '"' : '' ?>>
<?= $body ?>
<?= $printableCss ?>
<?= AdEngine::getInstance()->getDelayedIframeLoadingCode() ?>
<?= $analytics ?>
<?php

	// TODO: SWC: When we're ready to test JS after the content, move StaticChute and headscripts down here.
/*
	print $staticChuteHtml;
	
	// TODO: SWC: TO TEST ASYNC LOADING, REMOVE PRINT OF $staticChuteHtml ABOVE AND UNCOMMENT THESE TWO LINES:
	//print $wikiaScriptLoader;
	//print $jsLoader;
	
	print $headscripts;
*/
	
	// TODO: SWC: Get bottomscripts working. I thought they were set by SkinTemplate automatically.
	//print $bottomscripts;
?>
<?= $reporttime ?>
</body>
<?= wfRenderModule('Ad', 'Config') ?>
</html>
