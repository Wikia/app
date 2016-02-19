<div class="clearfix article-comm-edit-box">
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
		<form action="#" method="post" id="article-comm-reply-form-<?= $commentId ?>" class="article-comm-form">
			<input type="hidden" name="wpParentId" value="<?= $commentId ?>" />
			<div class="article-comm-input-text">
				<? if ( $isMiniEditorEnabled ): ?>
					<?= $app->getView( 'MiniEditorController', 'Editor_Header' )->render() ?>
				<? endif ?>
				<textarea name="wpArticleReply" id="article-comm-reply-textfield-<?= $commentId ?>"></textarea>
				<? if ( $isMiniEditorEnabled ): ?>
					<?= $app->getView( 'MiniEditorController', 'Editor_Footer' )->render() ?>
				<? endif ?>
				<div class="buttons" data-space-type="buttons">
					<input type="submit" class="actionButton" name="wpArticleSubmit" id="article-comm-reply-submit-<?= $commentId ?>" value="<?= wfMsg('article-comments-post') ?>" />
					<img src="<?= $stylePath ?>/common/images/ajax.gif" class="throbber" />
				</div>
			</div>
		</form>
		<? if ( $isMiniEditorEnabled ): ?>
			<?= $app->getView( 'MiniEditorController', 'Footer' )->render() ?>
		<? endif ?>
	</div>
</div>