<? if ( !$isBlocked && $canEdit && $commentingAllowed ): ?>
	<? if ( $wg->EnableMiniEditorExtForArticleComments ): ?>
		<?= $app->renderView( 'MiniEditorController', 'Setup' ) ?>
	<? endif ?>
	<div id="article-comm-info">&nbsp;</div>
	<? if ( $wg->EnableMiniEditorExtForArticleComments ): ?>
		<?= $app->getView( 'MiniEditorController', 'Header', array(
				'attributes' => array(
					'id' => 'article-comments-minieditor-newpost',
					'data-min-height' => 100,
					'data-max-height' => 400
				)
			))->render()
		?>
	<? endif ?>
	<div class="session">
		<?= $avatar ?>
		<?= $isLoggedIn ? /* wfMsg( 'oasis-comments-user-prompt', $avatar->mUser->getName() ) */'' : wfMsg( 'oasis-comments-anonymous-prompt' ) ?>
	</div>
	<form action="<?= $title->getFullURL() ?>" method="post" class="article-comm-form" id="article-comm-form">
		<input type="hidden" name="wpArticleId" value="<?= $title->getArticleId() ?>" />
		<? if ( $wg->EnableMiniEditorExtForArticleComments ): ?>
			<?= $app->getView( 'MiniEditorController', 'Editor_Header' )->render() ?>
		<? endif ?>
		<textarea name="wpArticleComment" id="article-comm"></textarea>
		<? if ( $wg->EnableMiniEditorExtForArticleComments ): ?>
			<?= $app->getView( 'MiniEditorController', 'Editor_Footer' )->render() ?>
		<? endif ?>
		<? if ( !$isReadOnly ): ?>
			<div class="buttons">
				<input type="submit" name="wpArticleSubmit" id="article-comm-submit" class="wikia-button actionButton" value="<?= wfMsg( 'article-comments-post' ) ?>" />
				<img src="<?= $ajaxicon ?>" class="throbber" />
			</div>
		<? endif ?>
	</form>
	<? if ( $wg->EnableMiniEditorExtForArticleComments ): ?>
		<?= $app->getView( 'MiniEditorController', 'Footer' )->render() ?>
	<? endif ?>
<? elseif ( $isBlocked ): ?>
	<p><?= wfMsg( 'article-comments-comment-cannot-add' ) ?></p>
	<p><?= $reason ?></p>
<? elseif ( !$canEdit ): ?>
	<p class="login"><?= wfMsg( 'article-comments-login', SpecialPage::getTitleFor( 'UserLogin' )->getLocalUrl() ) ?></p>
<? elseif ( !$commentingAllowed ): ?>
	<p class="no-comments-allowed"><?= wfMsg( 'article-comments-comment-cannot-add' ) ?> </p>
<? endif ?>
<? if ( $countComments ): ?>
	<div class="article-comments-pagination upper-pagination"><div><?= $pagination ?></div></div>
<? endif ?>
<?= $app->getView( 'ArticleComments', 'CommentList', array(
		'commentListRaw' => $commentListRaw,
		'page' => $page,
		'useMaster' => false
	))->render()
?>
<? if ( $countComments ): ?>
	<div class="article-comments-pagination"><div><?= $pagination ?></div></div>
<? endif ?>