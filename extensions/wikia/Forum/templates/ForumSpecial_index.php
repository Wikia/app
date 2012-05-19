<section id="Forum" class="Forum">
	<h3><?= $blurbHeading ?></h3>
	<section class="blurb"><?= $blurb ?></section>
	<ul class="boards">
		<? foreach($boards as $board): ?>
		<li class="board board-<?= $board['id'] ?>">
			<h4><a href="<?= $board['url'] ?>"><?= $board['name'] ?></a></h4>
			<ul class="activity">
				<li class="threads"><?= $wf->MsgExt( 'forum-specialpage-board-threads', array( 'parsemag' ), $board['threadCount'] ) ?></li>
				<li class="posts"><?= $wf->MsgExt( 'forum-specialpage-board-posts', array( 'parsemag' ), $board['postCount'] ) ?></li>
			</ul>
			<? if ($board['postCount'] > 0): ?>
				<p class="last-post"><?= $lastPostBy ?>
					<a href="<?= $board['lastPost']['userprofile'] ?>"><?= $board['lastPost']['username'] ?></a>
					<span class="timestamp timeago" title="<?= $wf->Timestamp( TS_ISO_8601, $board['lastPost']['timestamp'] ) ?>"><?= $wg->Lang->timeanddate( $board['lastPost']['timestamp'] ) ?></span>
				</p>
			<? endif; ?>
		</li>
		<? endforeach; ?>
	</ul>
</section>
