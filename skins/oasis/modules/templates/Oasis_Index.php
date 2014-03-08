<!doctype html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>

<meta http-equiv="Content-Type" content="<?= $mimeType ?>; charset=<?= $charset ?>">
<?php if ( BodyController::isResponsiveLayoutEnabled() ) : ?>
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

<? // 1% of JavaScript errors are logged for $wgEnableJSerrorLogging=true non-devbox wikis
if (true||!$wg->DevelEnvironment):?>
	<script>
		function syslogReport(priority, message, context) {
			context = context || null;
			var url = "//jserrorslog.wikia.com/",
				i = new Image(),
				data = {
					'@message': message,
					'syslog_pri': priority
				};

//			url = '//jserrorslog.nelson.wikia-dev.com/';
			if (context) {
				data['@context'] = context;
			}

			try {
				data['@fields'] = { server: document.cookie.match(/server.([A-Z]*).cache/)[1] };
			} catch (e) {}

			try {
				i.src = url+'l?'+JSON.stringify(data);
			} catch (e) {
				i.src = url+'e?'+e;
			}
		}
	</script><?
	if ($wg->IsGASpecialWiki || $wg->EnableJavaScriptErrorLogging):?>
		<script>
			window.onerror = function(m,u,l) {
				if (Math.random() < 0.01) {
					syslogReport(3, m, {'url': u, 'line': l}); // 3 is "error"
				}

				return false;
			}
		</script>
	<? endif ?>
<? endif ?>

<?= $topScripts ?>
<?= $wikiaScriptLoader; /*needed for jsLoader and for the async loading of CSS files.*/ ?>

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
<? if ( BodyController::isResponsiveLayoutEnabled() ): ?>
	<div class="background-image-gradient"></div>
<? endif ?>

<?= $comScore ?>
<?= $quantServe ?>
<?= $googleAnalytics ?>
<?= $amazonDirectTargetedBuy ?>
<?= $dynamicYield ?>
<?= $ivw2 ?>
<div class="WikiaSiteWrapper">
	<?= $body ?>

	<?php
		echo F::app()->renderView('Ad', 'Index', array('slotname' => 'GPT_FLUSH'));
		if (empty($wg->SuppressAds)) {
			echo F::app()->renderView('Ad', 'Index', array('slotname' => 'INVISIBLE_1'));
			if (!$wg->EnableWikiaHomePageExt) {
				echo F::app()->renderView('Ad', 'Index', array('slotname' => 'INVISIBLE_2'));
			}
		}
		echo F::app()->renderView('Ad', 'Index', array('slotname' => 'SEVENONEMEDIA_FLUSH'));
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

<?= $bottomScripts ?>
<?= $cssPrintLinks ?>

</body>

<?= wfReportTime() . "\n" ?>
<?= F::app()->renderView('Ad', 'Config') ?>

</html>
