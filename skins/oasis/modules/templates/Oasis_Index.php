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
	<?= $anonSiteCss ?>

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
			print $wikiaScriptLoader; // needed for jsLoader and for the async loading of CSS files.
			print "\n\n\t<!-- Combined JS files (StaticChute) and head scripts -->\n";
			print $jsFiles . "\n";
		}
	?>
</head>
<body class="<?= implode(' ', $bodyClasses) ?>"<?= $body_ondblclick ? ' ondblclick="' . htmlspecialchars($body_ondblclick) . '"' : '' ?>>
<?= $body ?>

<?= $googleAnalytics ?>

<?php
	if($jsAtBottom) {
		print $wikiaScriptLoader; // needed for jsLoader and for the async loading of CSS files.
		print "\n\n\t<!-- Combined JS files (StaticChute) and head scripts -->\n";
		print $jsFiles . "\n";
	}
?>

<?php
	if (empty($wgSuppressAds)) {
		echo wfRenderModule('Ad', 'Index', array('slotname' => 'INVISIBLE_1'));
		echo wfRenderModule('Ad', 'Index', array('slotname' => 'INVISIBLE_2'));
	}
?>
<?= AdEngine::getInstance()->getDelayedIframeLoadingCode() ?>

<!-- Tracking pixels-->
<?= $trackingPixels ?>

<?php
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
