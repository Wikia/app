<ul class="boards">
	<? foreach($boards as $board): ?>
		<li class="board board-<?= $board['id'] ?>" data-id="<?= $board['id'] ?>">
			<div class="heading">
				<h4>
					<a href="<?= $board['url'] ?>"><?= htmlspecialchars($board['name']) ?></a>
				</h4>
				<? if ($isEditMode): ?>
					<div class="editControls">
						<!-- Admin editControls here -->
						<img src="<?= $wf->BlankImgUrl() ?>" class="sprite edit-pencil">
						<img src="<?= $wf->BlankImgUrl() ?>" class="sprite trash">
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
				<li class="threads"><?= $wf->MsgExt( 'forum-specialpage-board-threads', array( 'parsemag' ), $board['threadCount'] ) ?></li>
				<li class="posts"><?= $wf->MsgExt( 'forum-specialpage-board-posts', array( 'parsemag' ), $board['postCount'] ) ?></li>
			</ul>
			<? if (!$isEditMode && $board['postCount'] > 0): ?>
				<p class="last-post"><?= $lastPostByMsg ?>
					<a href="<?= $board['lastPost']['userprofile'] ?>"><?= $board['lastPost']['username'] ?></a>
					<span class="timestamp timeago" title="<?= $wf->Timestamp( TS_ISO_8601, $board['lastPost']['timestamp'] ) ?>"><?= $wg->Lang->timeanddate( $board['lastPost']['timestamp'] ) ?></span>
				</p>
			<? endif; ?>
		</li>
	<? endforeach; ?>
</ul>