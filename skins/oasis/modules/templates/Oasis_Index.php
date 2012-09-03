<!doctype html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
	<meta http-equiv="Content-Type" content="<?= $mimetype ?>; charset=<?= $charset ?>">
	<meta name="viewport" content="width=1200">

	<?php if( !$showAllowRobotsMetaTag ): ?>
		<meta name="robots" content="noindex, nofollow">
	<?php endif; ?>

	<?= $headlinks ?>

	<title><?= $pagetitle ?></title>
	<!-- SASS-generated CSS file -->
	<link rel="stylesheet" href="<?= AssetsManager::getInstance()->getSassCommonURL($mainsassfile) ?>">
	<!-- CSS injected by extensions -->
	<?= $csslinks ?>
	<?php
		/* // not used anymore - provided by modules=site in ResourceLoader - @author: wladek
		$srcs = AssetsManager::getInstance()->getGroupLocalURL($isUserLoggedIn ? 'site_user_css' : 'site_anon_css');
		foreach($srcs as $src) {
			echo '<link rel="stylesheet" href="'. htmlspecialchars( $src ) .'">';
		}
		*/

		// Add the wiki and user-specific overrides last.  This is a special case in Oasis because the modules run
		// later than normal extensions and therefore add themselves later than the wiki/user specific CSS is
		// normally added.
		// See Skin::setupUserCss()
		if (!empty($wg->OasisLastCssScripts)) {
			foreach($wg->OasisLastCssScripts as $src) {
				echo '<link rel="stylesheet" href="'.$src.'">';
			}
		}

		// RT #68514: load global user CSS (and other page specific CSS added via "SkinTemplateSetupPageCss" hook)
		if ($pagecss != '') {
	?>


	<!-- page CSS -->
	<style type="text/css"><?= $pagecss ?></style>
	<?php
		}
	?>

	<?= $topScripts ?>
	<?= ''//$globalVariablesScript ?>

	<?= $wikiaScriptLoader; /*needed for jsLoader and for the async loading of CSS files.*/ ?>

	<!-- Make IE recognize HTML5 tags. -->
	<!--[if IE]>
		<script>/*@cc_on'abbr article aside audio canvas details figcaption figure footer header hgroup mark menu meter nav output progress section summary time video'.replace(/\w+/g,function(n){document.createElement(n)})@*/</script>
	<![endif]-->

	<?php if( !$jsAtBottom ):?>
		<!--[if lt IE 8]>
			<script src="<?= $wg->ResourceBasePath ?>/resources/wikia/libraries/json2/json2.js"></script>
		<![endif]-->

		<!--[if lt IE 9]>
			<script src="<?= $wg->ResourceBasePath ?>/resources/wikia/libraries/html5/html5.min.js"></script>
		<![endif]-->

		<!-- Combined JS files and head scripts -->
		<?= $jsFiles ;?>
	<?endif;?>
	<? if($displayAdminDashboard) { ?>
		<!--[if IE]><script src="<?= $wg->ResourceBasePath ?>/resources/wikia/libraries/excanvas/excanvas.js"></script><![endif]-->
	<? } ?>

	<?= $headitems ?>
</head>
<body class="<?= implode(' ', $bodyClasses) ?>">
<!-- comScore -->
<?= $comScore ?>

<!-- quantServe -->
<?= $quantServe ?>

<!-- googleAnalytics -->
<?= $googleAnalytics ?>

<!-- IVW -->
<?= $ivw ?>

<?=  AdEngine::getLiftiumOptionsScript() //this script has a dependency on script from the AbTesting extension, which is in $globalVariablesScript above ?>

<?= $adsABtesting; ?>

<?= $body ?>

<?php
	if (empty($wg->SuppressAds)) {
		echo F::app()->renderView('Ad', 'Index', array('slotname' => 'INVISIBLE_1'));
		if (!$wg->EnableCorporatePageExt) {
			echo F::app()->renderView('Ad', 'Index', array('slotname' => 'INVISIBLE_2'));
		}
	}
?>
<?if( $jsAtBottom ):?>
		<!--[if lt IE 8]>
			<script src="<?= $wg->ResourceBasePath ?>/resources/wikia/libraries/json2/json2.js"></script>
		<![endif]-->

		<!--[if lt IE 9]>
			<script src="<?= $wg->ResourceBasePath ?>/resources/wikia/libraries/html5/html5.min.js"></script>
		<![endif]-->

		<!-- Combined JS files and head scripts -->
		<?= $jsFiles ;?>
<?endif;?>

<?= AdEngine::getInstance()->getDelayedIframeLoadingCode() ?>

<?php
	print '<script type="text/javascript">/*<![CDATA[*/while(wgAfterContentAndJS.length>0){wgAfterContentAndJS.shift()();}/*]]>*/</script>' . "\n";
	print "<!-- BottomScripts -->\n";
	print $bottomscripts;
	print "<!-- end Bottomscripts -->\n";
?>

<!-- printable CSS -->
<?= $printableCss ?>

<?= wfReportTime()."\n" ?>
</body>
<?= F::app()->renderView('Ad', 'Config') ?>
</html>
