<ul class="controls">
	<li id="article-comments-counter-recent"><?= wfMessage( 'oasis-comments-showing-most-recent', count( $commentListRaw ) )->escaped() ?></li>
</ul>
<h1 id="article-comments-counter-header"><?= wfMessage( 'oasis-comments-header', $wg->Lang->FormatNum( $countCommentsNested ) )->text() ?></h1>
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
			<?= $isAnon ? wfMessage( 'oasis-comments-anonymous-prompt' )->escaped() : '' /* wfMessage( 'oasis-comments-user-prompt', $avatar->mUser->getName() ) ->escaped()*/ ?>
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
					<input type="submit" name="wpArticleSubmit" id="article-comm-submit" class="wikia-button actionButton" value="<?= wfMessage( 'article-comments-post' )->escaped() ?>" />
					<img src="<?= $ajaxicon ?>" class="throbber" />
				</div>
			<? endif ?>
		</form>
		<? if ( $isMiniEditorEnabled ): ?>
			<?= $app->getView( 'MiniEditorController', 'Footer' )->render() ?>
		<? endif ?>
	<? elseif ( $isBlocked ): ?>
		<p><?= wfMessage( 'article-comments-comment-cannot-add' )->escaped() ?></p>
		<p><?= $reason ?></p>
	<? elseif ( !$canEdit ): ?>
		<p class="login"><?= wfMessage( 'article-comments-login', SpecialPage::getTitleFor( 'UserLogin' )->getLocalUrl() )->escaped() ?></p>
	<? elseif ( !$commentingAllowed ): ?>
		<p class="no-comments-allowed"><?= wfMessage( 'article-comments-comment-cannot-add' )->escaped() ?> </p>
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
