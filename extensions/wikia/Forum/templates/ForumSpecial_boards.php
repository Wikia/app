<ul class="boards">
	<? foreach ( $boards as $board ): ?>
		<li class="board board-<?= $board['id'] ?>" data-id="<?= $board['id'] ?>">
			<div class="heading">
				<h4>
					<a href="<?= $board['url'] ?>"><?= htmlspecialchars( $board['name'] ) ?></a>
				</h4>
				<? if ( $isEditMode ): ?>
					<div class="editControls">
						<!-- Admin editControls here -->
						<img src="<?= wfBlankImgUrl() ?>" class="sprite edit-pencil">
						<img src="<?= wfBlankImgUrl() ?>" class="sprite trash">
						<span class="moveup"></span>
						<span class="movedown"></span>
					</div>
				<? endif; ?>
			</div>
			<p class="description grid-3 alpha">
				<?= $board['description'] ?>
			</p>
			<div class="grid-1">
				<!-- placeholder for future feature -->
			</div>
			<ul class="activity">
				<li class="threads"><?= wfMessage( 'forum-specialpage-board-threads' )->numParams( $board['threadCount'] )->escaped(); ?></li>
				<li class="posts"><?= wfMessage( 'forum-specialpage-board-posts' )->numParams( $board['postCount'] )->escaped(); ?></li>
			</ul>
			<? if ( !$isEditMode && $board['postCount'] > 0 ): ?>
				<p class="last-post"><?= $lastPostByMsg ?>
					<a href="<?= $board['lastPost']['userprofile'] ?>"><?= $board['lastPost']['username'] ?></a>
					<span class="timestamp timeago" title="<?= wfTimestamp( TS_ISO_8601, $board['lastPost']['timestamp'] ) ?>"><?= $wg->Lang->timeanddate( $board['lastPost']['timestamp'] ) ?></span>
				</p>
			<? endif; ?>
		</li>
	<? endforeach; ?>
</ul>
