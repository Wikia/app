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

	<!-- CSS files to be combined by server-side process -->
	<link rel="stylesheet" href="/extensions/wikia/ShareFeature/css/ShareFeature.css">
	<link rel="stylesheet" href="/extensions/wikia/CreatePage/css/CreatePage.css">

	<?= $csslinks ?>

	<!-- Used for page load time tracking -->
	<script>/*<![CDATA[*/
		var wgNow = new Date();
	/*]]>*/</script>

	<script src="/skins/common/wikibits.js"></script>
	<script src="/skins/common/jquery/jquery-1.4.2.js"></script>
	<script src="/skins/common/jquery/jquery.json-1.3.js"></script>
	<script src="/skins/common/jquery/jquery.wikia.js"></script>

	<?= $headscripts ?>

	<!-- JS files to be combined by server-side process -->
	<script src="/skins/oasis/js/tracker.js"></script>
	<script src="/skins/oasis/js/hoverMenu.js"></script>
	<script src="/skins/oasis/js/PageHeader.js"></script>
	<script src="/skins/oasis/js/Search.js"></script>
	<script src="/skins/oasis/js/WikiaFooter.js"></script>
	<script src="/skins/oasis/js/buttons.js"></script>
	<script src="/extensions/wikia/ShareFeature/js/ShareFeature.js"></script>
	<script src="/skins/oasis/js/WikiaNotifications.js"></script>
	<!--<script src="/skins/oasis/js/modal.js"></script>-->
	<script src="/skins/common/jquery/jquery.wikia.modal.js"></script>
	<script src="/skins/common/jquery/jquery.wikia.tracker.js"></script>
	<!-- Extensions -->
	<script src="/extensions/wikia/ImageLightbox/ImageLightbox.js"></script>
	<script src="/extensions/wikia/CreatePage/js/CreatePage.js"></script>
	<script src="/extensions/wikia/WikiaPhotoGallery/js/WikiaPhotoGallery.view.js"></script>
</head>
<body class="<?= $bodyClasses ?>"<?= $body_ondblclick ? ' ondblclick="' . htmlspecialchars($body_ondblclick) . '"' : '' ?>>
<?= $body ?>
<?= $printableCss ?>
<?= AdEngine::getInstance()->getDelayedIframeLoadingCode() ?>
<?= $analytics ?>
<?= $reporttime ?>
</body>
<?= wfRenderModule('Ad', 'Config') ?>
</html>
