<?php
/* @var Title $title */
/* @var WikiaGlobalRegistry $wg */

$commentsCounter = wfMessage( 'oasis-comments-header', $wg->Lang->FormatNum( $countCommentsNested ) )->text();
?>
<h3>
	<?= wfMessage('article-comments-toc-item')->text() ?>
	<span><?= wfMessage( 'parentheses', $commentsCounter )->text() ?></span>
</h3>
<div id="article-comments" class="article-comments">
	<? if ( !$isBlocked && $canEdit && $commentingAllowed ): ?>
		<? if ( $isMiniEditorEnabled ): ?>
			<?= $app->renderView( 'MiniEditorController', 'Setup' ) ?>
		<? endif ?>
		<div id="article-comm-info" class="article-comm-info"></div>
		<? if ( $isMiniEditorEnabled ): ?>
			<?= $app->getView( 'MiniEditorController', 'Header', [
					'attributes' => [
						'id' => 'article-comments-minieditor-newpost',
						'data-min-height' => 100,
						'data-max-height' => 400
					]
				])->render()
			?>
		<? endif ?>
		<div class="session">
			<?= $avatar ?>
			<?= $isAnon ? wfMessage( 'oasis-comments-anonymous-prompt' )->plain() : '' ?>
		</div>
		<form action="<?= $title->getLocalURL() ?>" method="post" class="article-comm-form" id="article-comm-form">
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
					<img src="<?= $ajaxicon ?>" class="throbber" />
					<input type="submit" name="wpArticleSubmit" id="article-comm-submit" class="wikia-button actionButton secondary" value="<?= wfMessage( 'article-comments-post' )->plain() ?>" />
				</div>
			<? endif ?>
		</form>
		<? if ( $isMiniEditorEnabled ): ?>
			<?= $app->getView( 'MiniEditorController', 'Footer' )->render() ?>
		<? endif ?>
	<? elseif ( $isBlocked ): ?>
		<p><?= wfMessage( 'article-comments-comment-cannot-add' )->plain() ?></p>
		<p><?= $reason ?></p>
	<? elseif ( !$canEdit ): ?>
		<p class="login"><?= wfMessage( 'article-comments-login', SpecialPage::getTitleFor( 'UserLogin' )->getLocalUrl() )->text() ?></p>
	<? elseif ( !$commentingAllowed ): ?>
		<p class="no-comments-allowed"><?= wfMessage( 'article-comments-comment-cannot-add' )->text() ?> </p>
	<? endif ?>
	<? if ( $countComments ): ?>
		<div class="article-comments-pagination upper-pagination"><?= $pagination ?></div>
	<? endif ?>
	<?= $app->getView( 'ArticleComments', 'VenusCommentList', [
			'commentListRaw' => $commentListRaw,
			'page' => $page,
			'useMaster' => false
		])->render()
	?>
		<button class="comments-show-more"><?= wfMessage('article-comments-show-more')->plain() ?></button>
	<? if ( $countComments ): ?>
		<div class="article-comments-pagination"><?= $pagination ?></div>
	<? endif ?>
</div>
