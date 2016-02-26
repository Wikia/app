<li class="thread" data-id="<?= ${ForumConst::id} ?>">
	<div class="thread-left">
		<h4><a href="<?= ${ForumConst::fullpageurl} ?>"><?= ${ForumConst::feedtitle} ?></a></h4>
		<p class="last-post">
			<a href="<?= ${ForumConst::user_author_url} ?>"><?= AvatarService::renderAvatar( ${ForumConst::username}, 30 ) ?></a>
			<?= wfMessage( 'forum-specialpage-board-lastpostby' )->escaped() ?> <a href="<?= ${ForumConst::user_author_url} ?>"><?= ${ForumConst::displayname} ?></a>
			<span class="timestamp timeago" title="<?= ${ForumConst::iso_timestamp} ?>"><?= ${ForumConst::fmt_timestamp} ?></span>
		</p>
	</div>
	<div class="thread-right">
		<ul class="activity">
			<li class="threads"><?= wfMessage( 'forum-board-thread-replies', $wg->Lang->formatNum( ${ForumConst::repliesNumber} ) )->escaped() ?></li>
			<li class="posts"><?= wfMessage( 'forum-board-thread-kudos', $wg->Lang->formatNum( ${ForumConst::kudosNumber} ) )->escaped() ?></li>
			<? if ( ${ForumConst::isWatched} ): ?>
				<li class="follow following" data-iswatched="1"><?= wfMessage( 'forum-board-thread-following' )->escaped() ?></li>
			<? else : ?>
				<li class="follow" data-iswatched="0"><?= wfMessage( 'forum-board-thread-follow' )->escaped() ?></li>
			<? endif ?>
		</ul>
	</div>
</li>
