<?php
	global $wgBlankImgUrl;
	$wikiCount = count($notificationCounts);
?>
<? if($user->isLoggedIn()): ?>
	<li class="notifications-header">
		<span>
			<? if ( $wikiCount > 1): ?>
				<?= wfMessage('wall-notifications-all')->text() ?>
			<? else: ?>
				<?= wfMessage('wall-notifications')->text() ?>
			<? endif; ?>
			<? if( !empty($count) ): ?>
				<? if( $wikiCount == 1 || $notificationCounts[0]['unread'] == 0): ?>
					<div id="wall-notifications-markasread">
						<span id="wall-notifications-markasread-this-wiki" style="display: inline-block"><?= wfMessage('wall-notifications-markasread')->text() ?></span>
					</div>
				<? else: ?>
					<div id="wall-notifications-markasread">
						<span id="wall-notifications-markasread-sub"><?= wfMessage('wall-notifications-markasread')->text() ?></span>
						<div id="wall-notifications-markasread-sub-opts">
							<span id="wall-notifications-markasread-this-wiki"><?= wfMessage('wall-notifications-markasread-this-wiki')->text() ?></span>
							<span id="wall-notifications-markasread-all-wikis"><?= wfMessage('wall-notifications-markasread-all-wikis')->text() ?></span>
						</div>
					</div>
				<? endif; ?>
			<? endif; ?>
		</span>
	</li>
	<? foreach($notificationCounts as $wikiData): ?>
		<? if (!empty($wikiData['sitename'])): ?>
			<? if ($wikiCount == 1 ): ?>
				<li class="notifications-for-wiki show" data-notification-key="<?= Sanitizer::encodeAttribute( $notificationKey ) ?>" data-wiki-id="<?= $wikiData['id'] ?>">
			<? else: ?>
				<li class="notifications-for-wiki" data-notification-key="<?= Sanitizer::encodeAttribute( $notificationKey ) ?>" data-wiki-id="<?= $wikiData['id'] ?>">
			<? endif; ?>
				<? if ($alwaysGrouped || $wikiCount > 1): ?>
				<div class="notifications-wiki-header">
				<? else: ?>
				<div class="notifications-wiki-header" style="display: none">
				<? endif; ?>
					<?= $wikiData['sitename'] ?>
					<img src="<?= $wgBlankImgUrl ?>" class="chevron" />
					<? if ($wikiData['unread'] > 0): ?>
						<span class="notifications-wiki-count-container">
					<? else: ?>
						<span class="notifications-wiki-count-container" style="display: none">
					<? endif; ?>
						<span class="notifications-wiki-count"><?= $wikiData['unread'] ?></span>
					</span>
				</div>
				<ul class="notifications-for-wiki-list">
					<li class="notifications-empty"><?= wfMessage('wall-notifications-loading')->text() ?></li>
				</ul>
			</li>
		<? endif ?>
	<? endforeach; ?>
<? endif; ?>
