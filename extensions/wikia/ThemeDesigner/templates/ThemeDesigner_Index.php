<html>
	<body style="margin: 0">
		<div style="width: 200px; height: 100px; border: solid 1px;">
			<input type="text" id="color-body" />

			<button onclick="document.getElementById('testIframe').contentWindow.importStylesheetURI('<?= $wgCdnRootUrl ?>/__sass/skins/oasis/css/oasis.scss/1282612788/color-body='+escape(document.getElementById('color-body').value));">
			Go!
			</button>

			<button onclick="document.getElementById('testIframe').contentWindow.importStylesheetURI('<?= $wgCdnRootUrl ?>/__sass/skins/oasis/css/oasis.scss/1282612788/color-body='+escape('#'+Math.floor(Math.random()*16777215).toString(16)));">
			Random color!
			</button>
		</div>
		<iframe frameborder=0 id="testIframe" src="<?= $wgServer ?>" style="width: 100%; height:470px">
		</iframe>
	</body>
</html>