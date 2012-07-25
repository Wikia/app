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
<ul id="article-comments-ul" class="comments">
	<? if ( count( $commentListRaw ) ): ?>
		<? $odd = true ?>
		<? $id = 1 ?>
		<? foreach ( $commentListRaw as $commentId => $commentArr ): ?>
			<? $rowClass = $odd ? 'odd' : 'even' ?>
			<? $odd = !$odd ?>
			<? if ( isset( $commentArr[ 'level1' ] ) && $commentArr[ 'level1' ] instanceof ArticleComment ): ?>
				<?= $app->getView( 'ArticleComments', 'Comment', array(
						'comment' => $commentArr[ 'level1' ]->getData( $useMaster ),
						'commentId' => $commentId,
						'rowClass' => $rowClass,
						'level' => 1,
						'page' => $page,
						'id' => $id++
					))
				?>
			<? endif ?>
			<? if ( isset( $commentArr[ 'level2' ] ) ): ?>
				<ul class="sub-comments">
					<? foreach ( $commentArr[ 'level2' ] as $commentId => $reply ): ?>
						<? if ( $reply instanceof ArticleComment ): ?>
							<?= $app->getView( 'ArticleComments', 'Comment', array(
									'comment' => $reply->getData( $useMaster ),
									'commentId' => $commentId,
									'rowClass' => $rowClass,
									'level' => 2
								))
							?>
						<? endif ?>
					<? endforeach ?>
				</ul>
			<? endif ?>
		<? endforeach ?>
	<? endif ?>
	<? if ( $countComments ): ?>
		<div class="article-comments-pagination"><div><?= $pagination ?></div></div>
	<? endif ?>
</ul>