<!doctype html>
<html lang="en" dir="<?= $dir ?>">
<head>
	<meta http-equiv="Content-Type" content="<?= $mimetype ?>; charset=<?= $charset ?>">
	<meta name="viewport" content="width=1200">

	<title><?= wfMsg('themedesigner-title') ?></title>

	<!-- Make IE recognize HTML5 tags. -->
	<!--[if IE]>
		<script>/*@cc_on'abbr article aside audio canvas details figcaption figure footer header hgroup mark menu meter nav output progress section summary time video'.replace(/\w+/g,function(n){document.createElement(n)})@*/</script>
	<![endif]-->

	<link rel="stylesheet" href="<?= wfGetSassUrl($wgExtensionsPath."/wikia/ThemeDesigner/css/ThemeDesigner.scss", '') ?>">

	<script>
		var returnTo = <?= Xml::encodeJSVar($returnTo) ?>;
		var themeHistory = <?= Wikia::json_encode($themeHistory) ?>;
		var themeSettings = <?= Wikia::json_encode($themeSettings) ?>;
		var wgServer = <?= Xml::encodeJSVar($wgServer) ?>;
		var wgScript = <?= Xml::encodeJSVar($wgScript) ?>;
	</script>

	<script src="<?= $wgStylePath ?>/common/jquery/jquery-1.4.2.js"></script>
	<script src="<?= $wgStylePath ?>/common/jquery/jquery.wikia.js"></script>
	<script src="<?= $wgStylePath ?>/common/jquery/jquery.json-1.3.js"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/js/ThemeDesigner.js"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/js/aim.js"></script>

</head>
<body>

	<div id="Designer" class="Designer">
		<nav id="Navigation" class="Navigation">
			<ul>
				<li>
					<a href="#" rel="ThemeTab">Theme</a>
				</li>
				<li>
					<a href="#" rel="CustomizeTab">Customize</a>
				</li>
				<li>
					<a href="#" rel="WordmarkTab">Wordmark</a>
				</li>
			</ul>
		</nav>
		<?= wfRenderModule('ThemeDesigner', 'ThemeTab') ?>
		<?= wfRenderModule('ThemeDesigner', 'CustomizeTab') ?>
		<?= wfRenderModule('ThemeDesigner', 'WordmarkTab') ?>
		<div id="Toolbar" class="Toolbar">
			<div class="inner">
				<span class="mode">Preview Mode...</span>
				<div class="history">
					<div class="revisions">5</div>
					Previous Versions
					<img class="chevron" src="<?= $wgBlankImgUrl ?>">
					<ul>
						<li>
							<?= View::specialPageLink('#', null, 'wikia-chiclet-button', 'blank.gif', 'recycle'); ?>
							what is going on here what is going on here
						</li>
						<li>
							<?= View::specialPageLink('#', null, 'wikia-chiclet-button', 'blank.gif', 'recycle'); ?>
							is
						</li>
						<li>
							<?= View::specialPageLink('#', null, 'wikia-chiclet-button', 'blank.gif', 'recycle'); ?>
							going
						</li>
					</ul>
				</div>
				<button class="save">Save, I'm Done</button>
				<button class="cancel secondary">Cancel</button>
			</div>
		</div>
	</div>

	<?= wfRenderModule('ThemeDesigner', 'Picker') ?>

	<iframe frameborder=0 id="PreviewFrame" class="PreviewFrame" src="<?= $wgServer ?>/wiki/Special:ThemeDesignerPreview"></iframe>

</body>
</html>