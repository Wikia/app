<form method="post" id="cssEditorForm">
	<div class="css-editor">
		<pre class="css-editor-container" id="cssEditorContainer"><?= htmlspecialchars($cssContent); ?></pre>
	</div>
	<aside class="css-side-bar">
		<div class="version-box">
			<?= wfMessage('special-css-current-version')->rawParams(['1.0.17'])->text(); ?>
		</div>
	</aside>
	<footer class="css-footer">
		<label><input type="checkbox" name="minorEdit"/><?= wfMessage('special-css-minor-edit-label')->plain(); ?></label>
		<textarea name="editSummary" placeholder="<?= wfMessage('special-css-summary-placeholder')->plain(); ?>"></textarea>
		<input class="big" type="submit" value="<?= wfMessage('special-css-publish-button')->escaped(); ?>" />
	</footer>
</form>