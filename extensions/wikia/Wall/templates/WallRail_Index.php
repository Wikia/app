<?php if( !empty($usersInvolved) ): ?>
<section class="WallHistoryRail module">
	<h2><?= wfMessage( 'wall-history-who-involved-wall-title' )->escaped(); ?></h2>
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
						<li><a href="<?= $userInvolved['userwall']; ?>"> <?= wfMessage( 'wall-history-rail-wall' )->escaped(); ?></a></li>
					<? else: ?>
						<li><a href="<?= $userInvolved['usertalk']; ?>"> <?= wfMessage( 'talkpage' )->escaped(); ?></a></li>
					<? endif; ?>
					<li><a href="<?= $userInvolved['usercontribs']; ?>"> <?= wfMessage( 'wall-history-rail-contribs' )->escaped(); ?></a></li>
					<? if( $app->wg->User->isAllowed( 'block' ) ): ?>
						<li><a href="<?= $userInvolved['userblock']; ?>"> <?= wfMessage( 'wall-history-rail-block' )->escaped(); ?></a></li>
					<? endif; ?>
				</ul>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
<?php endif; ?>
