<?
	//TODO: move it to controller
	$helper = new WallHelper();
?>
<? if($unread): ?>
<li class="unread_notification">
<? else: ?>
<li class="read_notification">
<? endif; ?>
	<a href="<?= $url ?>">
		<div class="avatars">
			<?php foreach($authors as $key => $author): ?>
				<div class="avatars_<?php echo count($authors); ?>_<?php echo $key + 1 ?>">	
					<?= AvatarService::renderAvatar($author['username'], 30 - (count($authors) - 1)*2 ) ?>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="notification">
			<div class="msg-title"><?= $helper->shortenText($title, WallNotificationsController::NOTIFICATION_TITLE_LIMIT) ?></div>		
			<? if($unread): ?>
				<div class="msg-body">
					<?= $msg ?>
				</div>
			<? endif; ?>
			<div class="timeago" title="<?= $iso_timestamp ?>"></div>
		</div>
	</a>
</li>