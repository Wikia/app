<!doctype html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
	<meta http-equiv="Content-Type" content="<?= $mimetype ?>; charset=<?= $charset ?>">
	<meta name="viewport" content="width=1200">
	<?= $headlinks ?>

	<title><?= $pagetitle ?></title>
	<!-- SASS-generated CSS file -->
	<link rel="stylesheet" href="<?= wfGetSassUrl("skins/oasis/css/oasis.scss") ?>">
	<?php
		// NOTE: CSS files that are needed on every Oasis page should go into the bottom of /skins/oasis/css/oasis.scss
		// It serves the function that StaticChute formerly served for CSS.
	?>

	<!-- CSS injected by extensions -->
	<?= $csslinks ?>

	<?= $globalVariablesScript ?>

	<!-- Make IE recognize HTML5 tags. -->
	<!--[if IE]>
		<script>/*@cc_on'abbr article aside audio canvas details figcaption figure footer header hgroup mark menu meter nav output progress section summary time video'.replace(/\w+/g,function(n){document.createElement(n)})@*/</script>
	<![endif]-->

	<!-- Used for page load time tracking -->
	<script>/*<![CDATA[*/
		var wgNow = new Date();
	/*]]>*/</script><?php
		if(!$jsAtBottom) {
			print "\n<!-- Combined JS files (StaticChute) -->\n";
			print $staticChuteHtml."\n";
			print $wikiaScriptLoader; // needed for jsLoader and for the asnyc loading of CSS files.
			// TODO: SWC: TO TEST ASYNC LOADING, REMOVE PRINT OF $staticChuteHtml ABOVE AND UNCOMMENT THIS LINE:
			//print $jsLoader;
			print "<!-- Headscripts -->\n";
			print $headscripts."\n";
		}
	?>
	<? if ($wgEnableOpenXSPC) { // will: this is very ugly but necessary to make OpenX SPC work. this call must take place in HEAD! ?>
	<script>
		<?= str_replace("\n", ' ', AdProviderOpenX::getOpenXSPCUrlScript(AdProviderOpenX::OASIS_SPOTLIGHTS_AFFILIATE_ID)); ?>
		document.write('<scr'+'ipt type="text/javascript" src="'+openxspc_base_url+'"></scr'+'ipt>');
	</script>
	<? } ?>
</head>
<body class="<?= implode(' ', $bodyClasses) ?>"<?= $body_ondblclick ? ' ondblclick="' . htmlspecialchars($body_ondblclick) . '"' : '' ?>>
<?= $body ?>
<?php
	if($jsAtBottom) {
		print "<!-- Combined JS files (StaticChute) -->\n";
		print $staticChuteHtml."\n";
	}
?>
<?= $analytics ?>

<?= AdEngine::getInstance()->getDelayedIframeLoadingCode() ?>

<!-- Tracking pixels-->
<?= $trackingPixels ?>

<?php
	// Load Javacript right before the closing body tag.
	if($jsAtBottom){
		print $wikiaScriptLoader; // needed for jsLoader and for the asnyc loading of CSS files.
		// TODO: SWC: TO TEST ASYNC LOADING, REMOVE PRINT OF $staticChuteHtml ABOVE AND UNCOMMENT THIS LINE:
		//print $jsLoader;

		print "<!-- Headscripts -->\n";
		print $headscripts."\n";

	}
	print '<script type="text/javascript">/*<![CDATA[*/for(var i=0;i<wgAfterContentAndJS.length;i++){wgAfterContentAndJS[i]();}/*]]>*/</script>' . "\n";

	print "<!-- BottomScripts -->\n";
	print $bottomscripts;
	print "<!-- end Bottomscripts -->\n";
?>
<?= $printableCss ?>

<?= wfReportTime()."\n" ?>
</body>
<?= wfRenderModule('Ad', 'Config') ?>
</html>
