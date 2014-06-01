<?php if( !empty($usersInvolved) ): ?>
<section class="WallHistoryRail module">
	<h1><?= wfMsg('wall-history-who-involved-wall-title'); ?></h1>
	<ul>
		<?php foreach($usersInvolved as $userInvolved): ?>
			<li>
				<a href="<?= $userInvolved['userpage']; ?>" class="avatar"><?= AvatarService::renderAvatar($userInvolved['username'], 30); ?></a>
				<span class="names">
					<a href="<?= $userInvolved['userpage']; ?>">
						<?= $userInvolved['name1']; ?>
					</a>
					<?php if( !empty($userInvolved['name2']) ): ?>
						<a class='realname' href="<?= $userInvolved['userpage']; ?>">
							<small>
								<?= $userInvolved['name2']; ?>
							</small>
						</a>
					<?php endif; ?>
				</span>
				<ul class="actionlinks">
					<? if(!$showTalkPage): ?>
						<li><a href="<?= $userInvolved['userwall']; ?>"> <?= wfMsg('wall-history-rail-wall'); ?></a></li>
					<? else: ?>
						<li><a href="<?= $userInvolved['usertalk']; ?>"> <?= wfMsg('talkpage'); ?></a></li>
					<? endif; ?>
					<li><a href="<?= $userInvolved['usercontribs']; ?>"> <?= wfMsg('wall-history-rail-contribs'); ?></a></li>
					<li><a href="<?= $userInvolved['userblock']; ?>"> <?= wfMsg('wall-history-rail-block'); ?></a></li>
				</ul>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
<?php endif; ?>