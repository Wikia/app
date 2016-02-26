<li>
	<div class="avatar"><?= AvatarService::renderAvatar( ${ForumConst::username}, 30 ) ?></div>
	<div class="message">
		<div class="author">
			<a href="<?= ${ForumConst::user_author_url} ?>"><?= ${ForumConst::displayname} ?></a>
			<? if ( !empty( ${ForumConst::isStaff} ) ): ?>
				<span class="stafflogo"></span>
			<? endif ?>
		</div>
		<? if ( $wg->EnableMiniEditorExtForWall ): ?>
			<?= $app->getView( 'MiniEditorController', 'Header', [
				'attributes' => [
					'data-min-height' => 100,
					'data-max-height' => 400
				]
			] )->render() ?>
		<? endif ?>
		<? if ( $wg->EnableMiniEditorExtForWall ): ?>
			<?= $app->getView( 'MiniEditorController', 'Editor_Header' )->render() ?>
		<? endif ?>
		<div class="msg-body"><?= ${ForumConst::body} ?></div>
		<? if ( $wg->EnableMiniEditorExtForWall ): ?>
			<?= $app->getView( 'MiniEditorController', 'Editor_Footer' )->render() ?>
		<? endif ?>
		<!--
			<div class="edit-buttons sourceview">
				<button class="wikia-button cancel-edit cancel-source"><?= wfMsg( 'wall-button-done-source' ) ?></button>
			</div>
			<div class="edit-buttons edit" data-space-type="buttons">
				<button class="wikia-button save-edit"><?= wfMsg( 'wall-button-save-changes' ) ?></button>
				<button class="wikia-button cancel-edit secondary"><?= wfMsg( 'wall-button-cancel-changes' ) ?></button>
			</div>
			-->
		<div class="msg-toolbar">
			<div class="buttonswrapper">
				<?= $app->renderView( 'ForumController', 'threadMessageButtons', [ 'comment' => ${ForumConst::comment} ] ) ?>
			</div>
		</div>
		<div class="timestamp">
			<? if ( ${ForumConst::isEdited} ): ?>
				<?= wfMsg( 'wall-message-edited', [ ${ForumConst::editorUrl}, ${ForumConst::editorName}, ${ForumConst::historyUrl} ] ) ?>
			<? endif ?>
			<a class="permalink" href="<?= ${ForumConst::fullpageurl} ?>" tabindex="-1">
				<? if ( !is_null( ${ForumConst::iso_timestamp} ) ): ?>
					<span class="timeago abstimeago" title="<?= ${ForumConst::iso_timestamp} ?>" alt="<?= ${ForumConst::fmt_timestamp} ?>">&nbsp;</span>
					<span class="timeago-fmt"><?= ${ForumConst::fmt_timestamp} ?></span>
				<? else : ?>
					<span><?= ${ForumConst::fmt_timestamp} ?></span>
				<? endif ?>
			</a>
		</div>
		<? if ( $wg->EnableMiniEditorExtForWall ): ?>
			<?= $app->getView( 'MiniEditorController', 'Footer' )->render() ?>
		<? endif ?>
		<div class="throbber"></div>
	</div>
</li>
