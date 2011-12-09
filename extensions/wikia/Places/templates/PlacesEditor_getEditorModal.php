<div id="PlacesEditorWrapper">
	<div id="PlacesEditorColumn">
		<form>
			<label>
				<?= wfMsg('places-toolbar-button-address') ?>
				<input type="text" id="PlacesEditorAddress" autofocus>
			</label>
			<ul></ul>
		</form>

		<button id="PlacesEditorMyLocation"><?= wfMsg('places-editor-show-my-location') ?></button>

		<!-- parser hook code view -->
		<pre id="PlacesEditorCodeView"></pre>
	</div>

	<div id="PlacesEditorMap"></div>
</div>