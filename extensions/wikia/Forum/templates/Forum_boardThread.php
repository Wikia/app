<li class="thread" data-id="<?= $id ?>">
	<div class="thread-left">
		<h4><a href="<?= $fullpageurl ?>"><?= $feedtitle ?></a></h4>
		<p class="last-post">
			<a href="<?= $user_author_url ?>"><?= AvatarService::renderAvatar( $username, 30 ) ?></a>
			<?= wfMessage( 'forum-specialpage-board-lastpostby' )->escaped() ?> <a href="<?= $user_author_url ?>"><?= $displayname ?></a>
			<span class="timestamp timeago" title="<?= $iso_timestamp ?>"><?= $fmt_timestamp ?></span>
		</p>
	</div>
	<div class="thread-right">
		<ul class="activity">
			<li class="threads"><?= wfMessage( 'forum-board-thread-replies' )->numParams( $repliesNumber )->escaped() ?></li>
			<li class="posts"><?= wfMessage( 'forum-board-thread-kudos' )->numParams( $kudosNumber )->escaped() ?></li>
			<? if ( $showFollowing ): ?>
				<? if ( $isWatched ): ?>
					<li class="follow following" data-iswatched="1"><?= wfMessage( 'forum-board-thread-following' )->escaped() ?></li>
				<? else : ?>
					<li class="follow" data-iswatched="0"><?= wfMessage( 'forum-board-thread-follow' )->escaped() ?></li>
				<? endif ?>
			<? endif ?>
		</ul>
	</div>
</li>
