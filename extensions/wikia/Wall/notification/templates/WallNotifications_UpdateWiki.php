<? if($user->isLoggedIn()): ?>
	<? if( empty($unread) && empty($read) ): ?>
		<li class="notifications-empty"><?= wfMsg('wall-notifications-empty') ?></li>
	<? endif; ?>

	<? foreach($unread as $value): ?>
		<? echo $app->renderView( 'WallNotifications', 'Notification', array('notify'=>$value,'unread'=>true) ); ?>
	<? endforeach; ?>
	<? foreach($read as $value): ?>
		<? echo $app->renderView( 'WallNotifications', 'Notification', array('notify'=>$value,'unread'=>false) ); ?>
	<? endforeach; ?>
<? endif; ?>
