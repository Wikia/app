<ul class="controls">
	<li id="article-comments-counter-recent"><?= wfMsg( 'oasis-comments-showing-most-recent', count( $commentListRaw ) ) ?></li>
</ul>
<h1 id="article-comments-counter-header"><?= wfMsgExt( 'oasis-comments-header', array( 'parsemag' ), $wg->Lang->FormatNum( $countCommentsNested ) ) ?></h1>
<div id="article-comments" class="article-comments">
	<? if ( !$isBlocked && $canEdit && $commentingAllowed ): ?>
		<? if ( $isMiniEditorEnabled ): ?>
			<?= $app->renderView( 'MiniEditorController', 'Setup' ) ?>
		<? endif ?>
		<div id="article-comm-info" class="article-comm-info"></div>
		<? if ( $isMiniEditorEnabled ): ?>
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
			<?= $isAnon ? wfMsg( 'oasis-comments-anonymous-prompt' ) : '' /* wfMsg( 'oasis-comments-user-prompt', $avatar->mUser->getName() ) */ ?>
		</div>
		<form action="<?= $title->getFullURL() ?>" method="post" class="article-comm-form" id="article-comm-form">
			<input type="hidden" name="wpArticleId" value="<?= $title->getArticleId() ?>" />
			<? if ( $isMiniEditorEnabled ): ?>
				<?= $app->getView( 'MiniEditorController', 'Editor_Header' )->render() ?>
			<? endif ?>
			<textarea name="wpArticleComment" id="article-comm"></textarea>
			<? if ( $isMiniEditorEnabled ): ?>
				<?= $app->getView( 'MiniEditorController', 'Editor_Footer' )->render() ?>
			<? endif ?>
			<? if ( !$isReadOnly ): ?>
				<div class="buttons" data-space-type="buttons">
					<input type="submit" name="wpArticleSubmit" id="article-comm-submit" class="wikia-button actionButton" value="<?= wfMsg( 'article-comments-post' ) ?>" />
					<img src="<?= $ajaxicon ?>" class="throbber" />
				</div>
			<? endif ?>
		</form>
		<? if ( $isMiniEditorEnabled ): ?>
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
		<div class="article-comments-pagination upper-pagination"><?= $pagination ?></div>
	<? endif ?>
	<?= $app->getView( 'ArticleComments', 'CommentList', array(
			'commentListRaw' => $commentListRaw,
			'page' => $page,
			'useMaster' => false
		))->render()
	?>
	<? if ( $countComments ): ?>
		<div class="article-comments-pagination"><?= $pagination ?></div>
	<? endif ?>
</div>