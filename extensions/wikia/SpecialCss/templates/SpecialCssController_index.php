<form method="post" id="cssEditorForm">
	<div class="css-editor">
		<?= $deletedArticle ?>
		<pre class="css-editor-container" id="cssEditorContainer"><?= htmlspecialchars($cssContent); ?></pre>
	</div>
	<aside class="css-side-bar">
		<div class="css-edit-box">
            <label for="minorEdit" class="css-minor-label"><input id="minorEdit" type="checkbox" name="minorEdit"/><?= wfMessage('special-css-minor-edit-label')->plain(); ?></label>
            <label for="editSummary"><?= wfMessage('special-css-edit-summary')->plain() ?></label>
            <textarea id="editSummary" class="edit-summary" name="editSummary" placeholder="<?= wfMessage
			('special-css-summary-placeholder')->plain(); ?>"></textarea>
			<?= $app->renderView('MenuButton',
				'Index',
				array(
					'action' => array(
						'text' => wfMessage('special-css-publish-button'),
						'class' => 'css-publish-button'
					),
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
<script type="text/template" id="SpecialCssLoading">
	<div class="diffContent">
		<img src="{{stylepath}}/common/images/ajax.gif" class="loading">
	</div>
</script>
