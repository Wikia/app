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

	<link rel="stylesheet" href="<?= wfGetSassUrl($wgExtensionsPath."/wikia/ThemeDesigner/css/ThemeDesigner.scss") ?>">

	<script>
		var returnTo = <?= Xml::encodeJSVar($returnTo) ?>;
		var themeHistory = <?= Wikia::json_encode($themeHistory) ?>;
		var themeSettings = <?= Wikia::json_encode($themeSettings) ?>;
		var wgScript = <?= Xml::encodeJSVar($wgScript) ?>;
	</script>

	<script src="<?= $wgStylePath ?>/common/jquery/jquery-1.4.2.js"></script>
	<script src="<?= $wgStylePath ?>/common/jquery/jquery.wikia.js"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/js/ThemeDesigner.js"></script>

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
		<form>
			<?= wfRenderModule('ThemeDesigner', 'ThemeTab') ?>
			<?= wfRenderModule('ThemeDesigner', 'CustomizeTab') ?>
			<?= wfRenderModule('ThemeDesigner', 'WordmarkTab') ?>
			<div id="Toolbar" class="Toolbar">
				<button>Save</button>
			</div>
		</form>
	</div>

	<?= wfRenderModule('ThemeDesigner', 'Picker') ?>

	<iframe frameborder=0 id="PreviewFrame" class="PreviewFrame" src="<?= $wgServer ?>/wiki/Special:ThemeDesignerPreview"></iframe>


<? /* DEMO STUFF FROM INEZ
	<div style="width: 200px; height: 100px; border: solid 1px;">
		<input type="text" id="color-body" />

		<button onclick="document.getElementById('testIframe').contentWindow.importStylesheetURI('<?= $wgCdnRootUrl ?>/__sass/skins/oasis/css/oasis.scss/1282612788/color-body='+escape(document.getElementById('color-body').value));">
		Go!
		</button>

		<button onclick="document.getElementById('testIframe').contentWindow.importStylesheetURI('<?= $wgCdnRootUrl ?>/__sass/skins/oasis/css/oasis.scss/1282612788/color-body='+escape('#'+Math.floor(Math.random()*16777215).toString(16)));">
		Random color!
		</button>
	</div>
*/ ?>

</body>
</html>