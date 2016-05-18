<? if ( $user->isLoggedIn() ) : ?>
	<? if (!empty( $notificationCounts) ) : ?>
		<li id="notificationsContainer">
			<ul>
				<? foreach( $notificationCounts as $wikiData ): ?>
					<? if ( !empty( $wikiData['sitename'] ) ) : ?>
						<? if ($wikiCount == 1 ): ?>
							<li class="notifications-for-wiki show"
							data-notification-key="<?= Sanitizer::encodeAttribute( $notificationKey ) ?>"
							data-wiki-id="<?= $wikiData['id'] ?>"
							data-unread-count="<?= $wikiData['unread'] ?>"
							>
						<? else: ?>
							<li class="notifications-for-wiki"
							data-notification-key="<?= Sanitizer::encodeAttribute( $notificationKey ) ?>"
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
			</ul>
		</li>
		<? if( !empty( $count ) ): ?>
			<li>
				<header class="notifications-markasread">
					<?= wfMessage('wall-notifications-markasread')->text() ?>
				</header>
			</li>
		<? endif; ?>
	<? else : ?>
		<li class="notification empty"><?= wfMessage('wall-notifications-empty')->text() ?></li>
	<? endif ?>
<? endif; ?>
