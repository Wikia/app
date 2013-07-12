<form method="post" id="cssEditorForm" class="cssEditorForm">
	<div class="css-editor">
		<div class="editor-changes-info-wrapper">
			<?= $deletedArticle ?>
				<? if (!empty($diff)): ?>
				<div class="css-diff">
					<?= $diff; ?>
				</div>
				<? endif ?>
		</div>
		<pre class="css-editor-container" id="cssEditorContainer"><?= htmlspecialchars($cssFileInfo['content']); ?></pre>
	</div>
	<aside class="css-side-bar">
		<div class="css-edit-box">
			<input type="hidden" name="lastEditTimestamp" value="<?= $cssFileInfo['lastEditTimestamp'] ?>" />
			<label for="minorEdit" class="css-minor-label"><input id="minorEdit" type="checkbox" name="minorEdit"/><?= wfMessage('special-css-minor-edit-label')->plain(); ?></label>
			<label for="editSummary"><?= wfMessage( 'edit-summary' )->plain() ?></label>
			<textarea id="editSummary" class="edit-summary" name="editSummary" placeholder="<?= wfMessage
			('special-css-summary-placeholder')->plain(); ?>"></textarea>
			<?= F::app()->renderView('MenuButton',
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
			<?= F::app()->renderView('CommentsLikes',
				'Index',
				array(
					'title' => $cssFileTitle,
					'comments' => $cssFileCommentsCount
				)
			); ?>

		</div>

		<?php if( !empty($cssUpdates) ): ?>
			<div class="community-updates widget-box">
				<h2><?= wfMessage('special-css-community-update-headline')->text(); ?></h2>
				<ul class="community-updates-list">
					<?php foreach( $cssUpdates as $cssUpdate ): ?>
						<li class="community-update-item plainlinks">
							<?= $cssUpdate['userAvatar']; ?>
							<h4><a href="<?= $cssUpdate['url']; ?>"><?= $cssUpdate['title']; ?></a></h4>
							<span><?= wfMessage('special-css-community-update-by')->params([$cssUpdate['timestamp'], $cssUpdate['userUrl'], $cssUpdate['userName']])->parse(); ?></span>
							<blockquote><?= $cssUpdate['text']; ?></blockquote>
							<a href="<?= $cssUpdate['url']; ?>"><?= wfMessage('special-css-community-read-more')->plain(); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
				<a href="<?= $cssUpdatesUrl; ?>" title="<?= wfMessage('special-css-community-update-see-all')->text(); ?>" class="see-all-link"><?= wfMessage('special-css-community-update-see-all')->text(); ?></a>
			</div>
		<?php endif; ?>

		<ul class="education-links">
			<li class="widget-box">
				<h2>
					<a href="http://community.wikia.com/wiki/File:Intro_to_CSS_%26_Your_Wiki_Webinar" title="<?= wfMessage('special-css-education-item-webinars-link-title')->text(); ?>">
						<?= wfMessage('special-css-education-item-webinars-header')->text(); ?>
					</a>
				</h2>
				<p><?= wfMessage('special-css-education-item-webinars-paragraph')->text(); ?></p>
			</li>
			<li class="widget-box">
				<h2>
					<a href="http://community.wikia.com/wiki/Help:CSS" title="<?= wfMessage('special-css-education-item-help-link-title')->text(); ?>">
						<?= wfMessage('special-css-education-item-help-header')->text(); ?>
					</a>
				</h2>
				<p><?= wfMessage('special-css-education-item-help-paragraph')->text(); ?></p>
			</li>
			<li class="widget-box">
				<h2>
					<a href="http://community.wikia.com/wiki/Board:Support_Requests_-_Designing_Your_Wiki" title="<?= wfMessage('special-css-education-item-com-center-link-title')->text(); ?>">
						<?= wfMessage('special-css-education-item-com-center-header')->text(); ?>
					</a>
				</h2>
				<p><?= wfMessage('special-css-education-item-com-center-paragraph')->text(); ?></p>
			</li>
		</ul>
	</aside>
	<footer class="css-footer">
	</footer>
</form>
<script type="text/template" id="SpecialCssLoading">
	<div class="diffContent">
		<img src="{{stylepath}}/common/images/ajax.gif" class="loading">
	</div>
</script>
