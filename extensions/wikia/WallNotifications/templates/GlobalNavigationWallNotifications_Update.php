<? if ( $user->isLoggedIn() ) : ?>
	<li>
		<header class="notifications-header">
			<? if ( $wikiCount > 1): ?>
				<?= wfMessage('wall-notifications-all')->text() ?>
			<? else: ?>
				<?= wfMessage('wall-notifications')->text() ?>
			<? endif; ?>

			<? if( !empty( $count ) ): ?>
				<div class="notifications-markasread">
				<? if( $wikiCount == 0 || $notificationCounts[0]['unread'] == 0 ): ?>
					<span id="markasread-this-wiki"><?= wfMessage('wall-notifications-markasread')->text() ?></span>
				<? else: ?>
					<span id="markasread-sub"><?= wfMessage('wall-notifications-markasread')->text() ?></span>
					<div>
						<span id="markasread-this-wiki"><?= wfMessage('wall-notifications-markasread-this-wiki')->text() ?></span>
						<span id="markasread-all-wikis"><?= wfMessage('wall-notifications-markasread-all-wikis')->text() ?></span>
					</div>
				<? endif; ?>
				</div>
			<? endif; ?>
		</header>
	</li>
	<li id="notificationsContainer">
		<ul>
			<? if (!empty( $notificationCounts) ) : ?>
				<? foreach( $notificationCounts as $wikiData ): ?>
					<? if ( !empty( $wikiData['sitename'] ) ) : ?>
						<? if ($wikiCount == 1 ): ?>
							<li class="notifications-for-wiki show"
								data-notification-key="<?= $notificationKey ?>"
								data-wiki-id="<?= $wikiData['id'] ?>"
								data-unread-count="<?= $wikiData['unread'] ?>"
							>
						<? else: ?>
							<li class="notifications-for-wiki"
								data-notification-key="<?= $notificationKey ?>"
								data-wiki-path="<?= $wikiData['wgServer'] ?>"
								data-wiki-id="<?= $wikiData['id'] ?>"
								data-unread-count="<?= $wikiData['unread'] ?>"
							>
						<? endif; ?>
							<? if ( $alwaysGrouped || $wikiCount > 1 ): ?>
								<header class="notifications-wiki-header">
							<? else: ?>
								<header class="notifications-wiki-header" style="display: none">
							<? endif; ?>
								<?= $wikiData['sitename'] ?>
								<img class="chevron" src="<?= $wg->BlankImgUrl; ?>">
							</header>
							<ul class="notifications-for-wiki-list">
								<li class="notification empty"><?= wfMessage('wall-notifications-loading')->text() ?></li>
							</ul>
						</li>
					<? endif ?>
				<? endforeach; ?>
			<? else : ?>
				<li class="notification empty"><?= wfMessage('wall-notifications-empty')->text() ?></li>
			<? endif ?>
		</ul>
	</li>
<? endif; ?>
