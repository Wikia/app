<!doctype html>
<html lang="en" dir="<?= $dir ?>">
<head>
	<meta http-equiv="Content-Type" content="<?= $mimetype ?>; charset=<?= $charset ?>">
	<meta name="viewport" content="width=1200">

	<title><?= wfMsg('themedesigner-title') ?></title>

	<link rel="stylesheet" href="<?= wfGetSassUrl($wgExtensionsPath."/wikia/ThemeDesigner/css/ThemeDesigner.scss") ?>">

	<script src="<?= $wgStylePath ?>/common/jquery/jquery-1.4.2.js"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/js/ThemeDesigner.js"></script>

</head>
<body>

	<div id="Designer" class="Designer">
		<ul class="tabs">
			<li class="selected">
				<a href="#">Theme</a>
			</li>
			<li>
				<a href="#">Customize</a>
			</li>
			<li>
				<a href="#">Wordmark</a>
			</li>
			<li>
				<a href="#">Banner</a>
			</li>
		</ul>
		<?= wfRenderModule('ThemeDesigner', 'ThemeTab') ?>
		<div class="Toolbar">
			<button>Save</button>
		</div>
	</div>


	<div id="EventThief" class="EventThief"></div>
	<iframe frameborder=0 id="PreviewFrame" class="PreviewFrame" src="<?= $wgServer ?>"></iframe>

	
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