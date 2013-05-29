<?php
	global $wgBlankImgUrl;
	$wikiCount = count($notificationCounts);
?>
<? if($user->isLoggedIn()): ?>
	<li class="notifications-header">
		<span>
			<? if ( $wikiCount > 1): ?>
				<?= wfMsg('wall-notifications-all') ?>
			<? else: ?>
				<?= wfMsg('wall-notifications') ?>
			<? endif; ?>
			<? if( !empty($count) ): ?>
				<? if( $wikiCount == 1 || $notificationCounts[0]['unread'] == 0): ?>
					<div id="wall-notifications-markasread">
						<span id="wall-notifications-markasread-this-wiki" style="display: inline-block"><?= wfMsg('wall-notifications-markasread') ?></span>
					</div>
				<? else: ?>
					<div id="wall-notifications-markasread">
						<span id="wall-notifications-markasread-sub"><?= wfMsg('wall-notifications-markasread') ?></span>
						<div id="wall-notifications-markasread-sub-opts">
							<span id="wall-notifications-markasread-this-wiki"><?= wfMsg('wall-notifications-markasread-this-wiki') ?></span>
							<span id="wall-notifications-markasread-all-wikis"><?= wfMsg('wall-notifications-markasread-all-wikis') ?></span>
						</div>
					</div>
				<? endif; ?>
			<? endif; ?>
		</span>
	</li>
	<? foreach($notificationCounts as $wikiData): ?>	
	<? if ($wikiCount == 1 ): ?>
		<li class="notifications-for-wiki show" data-notification-key="<?= $notificationKey ?>" data-wiki-id="<?= $wikiData['id'] ?>">
	<? else: ?>
		<li class="notifications-for-wiki" data-notification-key="<?= $notificationKey ?>" data-wiki-path="<?= $wikiData['wgServer'] ?>" data-wiki-id="<?= $wikiData['id'] ?>">
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
			<li class="notifications-empty"><?= wfMsg('wall-notifications-loading') ?></li>
		</ul>
	</li>
	<? endforeach; ?>
<? endif; ?>