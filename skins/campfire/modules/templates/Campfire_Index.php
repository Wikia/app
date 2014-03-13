<!doctype html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
	<meta http-equiv="Content-Type" content="<?= $mimetype ?>; charset=<?= $charset ?>">
	<?= $headlinks ?>

	<title><?= $pagetitle ?></title>
	<!-- SASS-generated CSS file -->
	<link rel="stylesheet" href="<?= AssetsManager::getInstance()->getSassCommonURL($mainsassfile) ?>">
	<!-- CSS injected by extensions -->
	<?= $csslinks ?>
	<?php
		global $wgUser;
		// RT #68514: load global user CSS
		if ($pagecss != '') {
	?>


	<!-- page CSS -->
	<style type="text/css"><?= $pagecss ?></style>
	<?php
		}
	?>

	<?= $globalVariablesScript ?>

	<!-- Used for page load time tracking -->
	<script>/*<![CDATA[*/
		var wgNow = new Date();
	/*]]>*/</script><?php
		if(!$jsAtBottom) {
			print $wikiaScriptLoader; // needed for jsLoader and for the async loading of CSS files.
			print "\n\n\t<!-- Combined JS files and head scripts -->\n";
			print $jsFiles . "\n";
		}
	?>
</head>
<body class="<?= implode(' ', $bodyClasses) ?>">
<?= $body ?>

<!-- comScore -->
<?= $comScore ?>

<!-- googleAnalytics -->
<?= $googleAnalytics ?>

<?php
	if($jsAtBottom) {
		print $wikiaScriptLoader; // needed for jsLoader and for the async loading of CSS files.
		print "\n\n\t<!-- Combined JS files and head scripts -->\n";
		print $jsFiles . "\n";
	}
?>

<!-- quantServe -->
<?= $quantServe ?>

<?php
	print '<script type="text/javascript">/*<![CDATA[*/for(var i=0;i<wgAfterContentAndJS.length;i++){wgAfterContentAndJS[i]();}/*]]>*/</script>' . "\n";

	print "<!-- BottomScripts -->\n";
	print $bottomscripts;
	print "<!-- end Bottomscripts -->\n";
?>

<?= wfReportTime()."\n" ?>
</body>
</html>
