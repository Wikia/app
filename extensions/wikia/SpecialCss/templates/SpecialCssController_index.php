<form method="post" id="cssEditorForm">
	<div class="css-editor">
		<?= $deletedArticle ?>
		<pre class="css-editor-container" id="cssEditorContainer"><?= htmlspecialchars($cssContent); ?></pre>
	</div>
	<aside class="css-side-bar">
		<div class="css-edit-box">
            <label for="minorEdit"><input id="minorEdit" type="checkbox" name="minorEdit"/><?= wfMessage('special-css-minor-edit-label')->plain(); ?></label>
            <label for="editSummary"><?= wfMessage('special-css-edit-summary')->plain() ?></label>
			<textarea id="editSummary" name="editSummary" placeholder="<?= wfMessage('special-css-summary-placeholder')->plain(); ?>"></textarea>
            <nav class="wikia-menu-button primary">
				<input class="css-publish-button" type="submit" value="<?= wfMessage('special-css-publish-button') ?>"/>
                <span class="drop">
					<img src="<?= $wg->BlankImgUrl ?>" class="chevron">
					</span>
					<ul class="WikiaMenuElement">
						<?php if ( isset( $historyUrl ) ): ?>
							<li>
								<a href="<?= $historyUrl ?>"><?= wfMessage('special-css-history-button')->plain() ?></a>
							</li>
						<?php endif ?>
						<li>
                            <a href="#" id="showChanges"><?= wfMessage('special-css-compare-button')->plain() ?></a>
						</li>
						<?php if ( isset( $deleteUrl ) ): ?>
							<li>
								<a href="<?= $deleteUrl ?>"><?= wfMessage('special-css-delete-button')->plain() ?></a>
							</li>
						<?php endif ?>
						<?php if ( isset( $undeleteUrl ) ): ?>
							<li>
								<a href="<?= $undeleteUrl ?>"><?= wfMessage('special-css-undelete-button')->plain() ?></a>
							</li>
						<?php endif ?>
					</ul>
            </nav>
		</div>
		<div class="version-box">
			<?= wfMessage('special-css-current-version')->rawParams(['1.0.17'])->text(); ?>
		</div>
	</aside>
	<footer class="css-footer">
	</footer>
</form>
