<? if($user->isLoggedIn()): ?>
	<div class="notifications-header">
		<?= wfMsg('wall-notifications') ?>
		<? if( !empty($unread) ): ?>
			<div id="wall-notifications-markasread"><?= wfMsg('wall-notifications-markasread') ?></div>
		<? endif; ?>
	</div>
	<? if( empty($unread) && empty($read) ): ?>
		<div class="notifications-empty"><?= wfMsg('wall-notifications-empty') ?></div>
	<? endif; ?>
	<? foreach($unread as $value): ?>
		<? echo $app->renderView( 'WallNotificationsModule', 'notification', array('notify'=>$value,'unread'=>true) ); ?>
	<? endforeach; ?>
	<? foreach($read as $value): ?>
		<? echo $app->renderView( 'WallNotificationsModule', 'notification', array('notify'=>$value,'unread'=>false) ); ?>
	<? endforeach; ?>
<? endif; ?>