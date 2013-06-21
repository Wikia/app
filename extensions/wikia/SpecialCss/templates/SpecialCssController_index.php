<form method="post" id="cssEditorForm">
	<div class="css-editor">
		<?= $deletedArticle ?>
		<pre class="css-editor-container" id="cssEditorContainer"><?= htmlspecialchars($cssContent); ?></pre>
	</div>
	<aside class="css-side-bar">
		<div class="css-edit-box">
            <label for="minorEdit"><input id="minorEdit" type="checkbox" name="minorEdit"/><?= wfMessage('special-css-minor-edit-label')->plain(); ?></label>
            <label for="editSummary"><?= wfMessage('special-css-edit-summary')->plain() ?></label>
            <textarea id="editSummary" class="edit-summary" name="editSummary" placeholder="<?= wfMessage
			('special-css-summary-placeholder')->plain(); ?>"></textarea>
			<?= F::app()->renderView('MenuButton',
				'Index',
				array(
					'action' => array("text" => wfMessage('special-css-publish-button'), 'class' => 'css-publish-button'),
					'name' => 'submit',
					'class' => 'primary',
					'dropdown' => $dropdown
				)
			) ?>
		</div>
		<div class="version-box">
			<?= wfMessage('special-css-current-version')->rawParams(['1.0.17'])->text(); ?>
		</div>
	</aside>
	<footer class="css-footer">
	</footer>
</form>
