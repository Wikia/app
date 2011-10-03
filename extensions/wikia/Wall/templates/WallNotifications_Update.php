<? if($user->isLoggedIn()): ?>
	<li class="notifications-header">
		<?= wfMsg('wall-notifications') ?>
		<? if( !empty($unread) ): ?>
			<div id="wall-notifications-markasread"><?= wfMsg('wall-notifications-markasread') ?></div>
		<? endif; ?>
	</li>
	<? if( empty($unread) && empty($read) ): ?>
		<li class="notifications-empty"><?= wfMsg('wall-notifications-empty') ?></li>
	<? endif; ?>
	<? foreach($unread as $value): ?>
		<? echo $app->renderView( 'WallNotificationsModule', 'notification', array('notify'=>$value,'unread'=>true) ); ?>
	<? endforeach; ?>
	<? foreach($read as $value): ?>
		<? echo $app->renderView( 'WallNotificationsModule', 'notification', array('notify'=>$value,'unread'=>false) ); ?>
	<? endforeach; ?>
<? endif; ?>