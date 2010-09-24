<section id="WikiaArticleComments" class="WikiaArticleComments noprint">

	<ul class="controls">
		<li><?= wfMsg('oasis-comments-showing-most-recent', $countCommentsNested) ?></li>
		<li><a href="<?= $wgTitle->getFullURL("showall=1") ?>"><?= wfMsg('oasis-comments-show-all') ?></a></li>
	</ul>
	<h1><?= wfMsgExt('oasis-comments-header', array('parsemag'), $countCommentsNested) ?></h1>

	<div id="article-comments">
	<?php
	if ( $canEdit && !$isBlocked && $commentingAllowed ) {
	?>
		<div id="article-comm-info">&nbsp;</div>

		<div class="session">
			<?php
				// Fail gracefully (use default avatar) for NY code.
				if(get_class($avatar) == "wAvatar"){
					$avatarUserName = "";
					$isLoggedIn = true;
				} else {
					$avatarUserName = $avatar->getUserName();
					$isLoggedIn = $avatar->mUser->isLoggedIn();
				}
				echo AvatarService::renderAvatar($avatarUserName, 50);

				if ($isLoggedIn) {
				// FIXME: wfMsg this
					// echo "You are Logged in as " . $avatar->mUser->getName(); /** out for now until designer tells gives updates on specs **/
				} else {
				/** @todo make anonymous posting impossible and force login **/
					echo "Anonymous User<br/> " . ' <a href="#">Log in?</a>';
				}
			?>
		</div>

		<form action="<?= $wgTitle->getFullURL() ?>" method="post" id="article-comm-form">
			<input type="hidden" name="wpArticleId" value="<?= $wgTitle->getArticleId() ?>" />
			<textarea name="wpArticleComment" id="article-comm"></textarea>
			<? if (!$isReadOnly) { ?>
				<input type="submit" name="wpArticleSubmit" id="article-comm-submit" class="wikia-button" value="<?= wfMsg('article-comments-post') ?>" />
			<? } ?>
		</form>
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

	echo wfRenderPartial('ArticleComments', 'CommentList', array('commentListRaw' => $commentListRaw));

	?>

<?php
	if ($countComments) {
		echo '<div class="article-comments-pagination"><div>' . $pagination . '</div></div>';
	}
?>
	</div>
</section>
