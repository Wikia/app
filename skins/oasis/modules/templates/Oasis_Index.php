<!doctype html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
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
	/*]]>*/</script><?php
		// There were some problems moving JS to the bottom.  Allow us to control it via the URL for now.
		global $wgRequest;
		$JS_AT_BOTTOM = ($wgRequest->getVal('jsatbottom', '1') == "1");
		if(!$JS_AT_BOTTOM){
			print "<!-- Combined JS files (StaticChute) -->\n";
			print $staticChuteHtml."\n";
			// TODO: SWC: TO TEST ASYNC LOADING, REMOVE PRINT OF $staticChuteHtml ABOVE AND UNCOMMENT THESE TWO LINES:
			//print $wikiaScriptLoader;
			//print $jsLoader;
			print "<!-- Headscripts -->\n";
			print $headscripts."\n";
		}
	?>
</head>
<body class="<?= implode(' ', $bodyClasses) ?>"<?= $body_ondblclick ? ' ondblclick="' . htmlspecialchars($body_ondblclick) . '"' : '' ?>>
<?= $body ?>
<?= $printableCss ?>
<?php
	if($JS_AT_BOTTOM){
		print "<!-- Combined JS files (StaticChute) -->\n";
		print $staticChuteHtml."\n";
	}
?>
<?= AdEngine::getInstance()->getDelayedIframeLoadingCode() ?>
<?= $analytics ?>
<?php
	// Load Javacript right before the closing body tag.
	if($JS_AT_BOTTOM){
		// TODO: SWC: TO TEST ASYNC LOADING, REMOVE PRINT OF $staticChuteHtml ABOVE AND UNCOMMENT THESE TWO LINES:
		//print $wikiaScriptLoader;
		//print $jsLoader;

		print "<!-- Headscripts -->\n";
		print $headscripts."\n";

	}
	print '<script type="text/javascript">/*<![CDATA[*/for(var i=0;i<wgAfterContentAndJS.length;i++){wgAfterContentAndJS[i]();}/*]]>*/</script>' . "\n";

	// TODO: SWC: Get bottomscripts working. I thought they were set by SkinTemplate automatically.
	//print $bottomscripts;
?>
<?= $reporttime."\n" ?>
</body>
<?= wfRenderModule('Ad', 'Config') ?>
</html>
