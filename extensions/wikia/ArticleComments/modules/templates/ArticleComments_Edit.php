<div class="article-comments clearfix">
<? if ( $canEdit ): ?>
	<div class="article-comm-input reset clearfix">
		<? if ( $isMiniEditorEnabled ): ?>
			<?= $app->getView( 'MiniEditorController', 'Header', [
				'attributes' => [
					'data-min-height' => 100,
					'data-max-height' => 400
				]
			] )->render()
		?>
		<? endif ?>
		<form action="<?= $articleFullUrl ?>" method="post" id="article-comm-form-<?= $articleId ?>" class="article-comm-form">
			<input type="hidden" name="wpArticleId" value="<?= $articleId ?>" />
			<div class="article-comm-input-text">
				<? if ( $isMiniEditorEnabled ): ?>
					<?= $app->getView( 'MiniEditorController', 'Editor_Header' )->render() ?>
				<? endif ?>
				<textarea name="wpArticleComment" id="article-comm-textfield-<?= $articleId ?>"><?= $comment ?></textarea><br />
				<? if ( $isMiniEditorEnabled ): ?>
					<?= $app->getView( 'MiniEditorController', 'Editor_Footer' )->render() ?>
				<? endif ?>
				<? if ( !$isReadOnly ): ?>
					<div class="buttons" data-space-type="buttons">
						<input type="submit" name="wpArticleSubmit" id="article-comm-submit-<?= $articleId ?>" class="actionButton" value="<?= wfMessage( 'article-comments-post' )->escaped() ?>" />
						<input type="submit" name="wpArticleCancel" id="article-comm-edit-cancel-<?= $articleId ?>" class="wikia-button secondary actionButton" value="<?= wfMessage( 'article-comments-cancel' )->escaped() ?>" />
						<img src="<?= $stylePath ?>/common/images/ajax.gif" class="throbber" />
					</div>
				<? endif ?>
			</div>
		</form>
		<? if ( $isMiniEditorEnabled ): ?>
			<?= $app->getView( 'MiniEditorController', 'Footer' )->render() ?>
		<? endif ?>
	</div>
<? else: ?>
	<?= $comment ?>
<? endif ?>
</div>