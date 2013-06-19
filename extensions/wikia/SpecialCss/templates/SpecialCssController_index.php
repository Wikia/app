<form method="post" id="cssEditorForm">
	<div class="css-editor">
		<pre class="css-editor-container" id="cssEditorContainer"><?= htmlspecialchars($cssContent); ?></pre>
	</div>
	<aside class="css-side-bar">
		<div class="css-edit-box">
            <label for="minorEdit"><input id="minorEdit" type="checkbox" name="minorEdit"/><?= wfMessage('special-css-minor-edit-label')->plain(); ?></label>
            <label for="editSummary"><?= wfMessage('special-css-edit-summary')->plain() ?></label>
			<textarea id="editSummary" name="editSummary"></textarea>
            <nav class="wikia-menu-button primary">
				<input class="css-publish-button" type="submit" value="<?= wfMessage('special-css-publish-button') ?>"/>
                <span class="drop">
					<img src="<?= $wg->BlankImgUrl ?>" class="chevron">
					</span>
					<ul class="WikiaMenuElement">
						<li>
							<a href="#" data-id=""><?= wfMessage('special-css-history-button')->plain() ?></a>
						</li>
						<li>
                            <a href="#" data-id=""><?= wfMessage('special-css-compare-button')->plain() ?></a>
						</li>
						<li>
                            <a href="#" data-id=""><?= wfMessage('special-css-delete-button')->plain() ?></a>
						</li>
					</ul>
            </nav>
		</div>
		<div class="version-box">
			<?= wfMessage('special-css-current-version')->rawParams(['1.0.17'])->text(); ?>
		</div>
		<a href="#" id="showChanges">show changes</a>
	</aside>
	<footer class="css-footer">
	</footer>
</form>
