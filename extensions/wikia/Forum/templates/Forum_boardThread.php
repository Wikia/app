<li class="thread" data-id="<?= $id ?>">
	<div class="thread-left">
		<h4><a href="<?= $fullpageurl ?>"><?= $feedtitle ?></a></h4>
		<p class="last-post">
			<a href="<?= $user_author_url ?>"><?= AvatarService::renderAvatar( $username, 30 ) ?></a>
			<?= wfMsg('forum-specialpage-board-lastpostby') ?> <a href="<?= $user_author_url ?>"><?= $displayname ?></a>
			<span class="timestamp timeago" title="<?= $iso_timestamp ?>"><?= $fmt_timestamp ?></span>
		</p>
	</div>
	<div class="thread-right">
		<ul class="activity">
			<li class="threads"><?= wfMsgExt( 'forum-board-thread-replies', array('parsemag'), $repliesNumber ) ?></li>
			<li class="posts"><?= wfMsgExt( 'forum-board-thread-kudos', array('parsemag'), $kudosNumber ) ?></li>
			<? if ($isWatched): ?>
				<li class="follow following" data-iswatched="1"><?= wfMsg( 'forum-board-thread-following' ) ?></li>
			<? else: ?>
				<li class="follow" data-iswatched="0"><?= wfMsg( 'forum-board-thread-follow' ) ?></li>
			<? endif ?>
		</ul>
	</div>
</li>
