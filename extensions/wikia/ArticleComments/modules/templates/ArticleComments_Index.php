<?
if ( $wg->EnableMiniEditorExtForArticleComments ) {
	echo $app->renderView('MiniEditorController', 'Setup');
}
?>

<section id="WikiaArticleComments" class="WikiaArticleComments noprint">

	<ul class="controls">
		<li id="article-comments-counter-recent"><?= wfMsg('oasis-comments-showing-most-recent', count($commentListRaw)) ?></li>
	<?php
	global $wgLang;
	$countCommentsNestedFormatted = $wgLang->formatNum($countCommentsNested);
	 /*see RT#64641*/  /*see RT#65179*/  /*see RT#68572 */
	if ( $countCommentsNested > 1 && $countCommentsNested <= 200 && $countComments > $commentsPerPage ) {
	?>
		<li><a href="<?= $title->getFullURL("showall=1") ?>"><?= wfMsg('oasis-comments-show-all') ?></a></li>
	<?php } ?>
	</ul>
	<h1 id="article-comments-counter-header"><?= wfMsgExt('oasis-comments-header', array('parsemag'), $countCommentsNestedFormatted) ?></h1>

	<div id="article-comments">
	<?php
	if ( $canEdit && !$isBlocked && $commentingAllowed ) {
	?>
		<div id="article-comm-info">&nbsp;</div>
		<? if ( $wg->EnableMiniEditorExtForArticleComments ):
			echo $app->getView( 'MiniEditorController', 'Header', array(
				'attributes' => array(
					'id' => 'article-comments-minieditor-newpost',
					'data-min-height' => 100,
					'data-max-height' => 400
				)
			))->render();
		endif; ?>
		<div class="session">
			<?php
				echo $avatar;

				if ($isLoggedIn) {
				// FIXME: wfMsg this
					// echo "You are Logged in as " . $avatar->mUser->getName(); /** out for now until designer tells gives updates on specs **/
				} else {
				/** @todo make anonymous posting impossible and force login **/
					echo wfMsg('oasis-comments-anonymous-prompt');
				}
			?>
		</div>
		<form action="<?= $title->getFullURL() ?>" method="post" class="article-comm-form" id="article-comm-form">
			<input type="hidden" name="wpArticleId" value="<?= $title->getArticleId() ?>" />
			<? if ( $wg->EnableMiniEditorExtForArticleComments ):
				echo $app->getView( 'MiniEditorController', 'Editor_Header' )->render(); 
			endif; ?>
			<textarea name="wpArticleComment" id="article-comm"></textarea>
			<? if ( $wg->EnableMiniEditorExtForArticleComments ):
				echo $app->getView( 'MiniEditorController', 'Editor_Footer' )->render(); 
			endif; ?>
			<? if (!$isReadOnly) { ?>
				<div class="buttons">
					<input type="submit" name="wpArticleSubmit" id="article-comm-submit" class="wikia-button" value="<?= wfMsg('article-comments-post') ?>" />
					<img src="<?= $ajaxicon ?>" class="throbber" />
				</div>
			<? } ?>
		</form>
		<? if ( $wg->EnableMiniEditorExtForArticleComments ):
			echo $app->getView( 'MiniEditorController', 'Footer' )->render(); 
		endif; ?>
	<?php
	} else {
		if ( $isBlocked ) {
	?>
		<p><?= wfMsg('article-comments-comment-cannot-add') ?></p>
		<p><?= $reason ?></p>
	<?php } else if (!$canEdit) { ?>
		<br/>
		<p><?= wfMsg('article-comments-login', SpecialPage::getTitleFor('UserLogin')->getLocalUrl() ); ?> </p>
	<?php
		} else if (!$commentingAllowed) { ?>
		<br/>
		<p><?= wfMsg('article-comments-comment-cannot-add'); ?> </p>
	<?php
		}
	}

	if ($countComments) {
		echo '<div class="article-comments-pagination upper-pagination"><div>' . $pagination . '</div></div>';
	}
?>
<ul id="article-comments-ul" class="comments">
<?= wfRenderPartial('ArticleComments', 'CommentList', array('commentListRaw' => $commentListRaw, 'page' => $page, 'useMaster' => false)) ;?>
</ul>
<?php
	if ($countComments) {
		echo '<div class="article-comments-pagination"><div>' . $pagination . '</div></div>';
	}
?>
	</div>
</section>
