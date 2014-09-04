<? if($user->isLoggedIn()): ?>
	<li>
		<header class="notifications-header">
			<? if ( $wikiCount > 1): ?>
				<?= wfMessage('wall-notifications-all')->text() ?>
			<? else: ?>
				<?= wfMessage('wall-notifications')->text() ?>
			<? endif; ?>
			<? if( 1 ): ?>
				<? if( /* $wikiCount == 1 || $notificationCounts[0]['unread'] ==*/ 0): ?>
					<span id="wall-notifications-markasread this-wiki"><?= wfMessage('wall-notifications-markasread')->text() ?></span>
				<? else: ?>
					<span id="wall-notifications-markasread sub"><?= wfMessage('wall-notifications-markasread')->text() ?></span>
					<span id="wall-notifications-markasread this-wiki"><?= wfMessage('wall-notifications-markasread-this-wiki')->text() ?></span>
					<span id="wall-notifications-markasread all-wikis"><?= wfMessage('wall-notifications-markasread-all-wikis')->text() ?></span>
				<? endif; ?>
			<? endif; ?>
		</header>
	</li>
	<? foreach($notificationCounts as $wikiData): ?>
		<? if (!empty($wikiData['sitename'])): ?>
			<? if ($wikiCount == 1 ): ?>
				<li class="notifications-for-wiki show" data-notification-key="<?= $notificationKey ?>" data-wiki-id="<?= $wikiData['id'] ?>">
			<? else: ?>
				<li class="notifications-for-wiki" data-notification-key="<?= $notificationKey ?>" data-wiki-path="<?= $wikiData['wgServer'] ?>" data-wiki-id="<?= $wikiData['id'] ?>">
			<? endif; ?>
				<? if ($alwaysGrouped || $wikiCount > 1): ?>
					<header class="notifications-wiki-header">
				<? else: ?>
					<header class="notifications-wiki-header" style="display: none">
				<? endif; ?>
					<?= $wikiData['sitename'] ?>
				</header>
				<ul class="notifications-for-wiki-list">
					<li class="notification empty"><?= wfMessage('wall-notifications-loading')->text() ?></li>
				</ul>
			</li>
		<? endif ?>
	<? endforeach; ?>
<? endif; ?>