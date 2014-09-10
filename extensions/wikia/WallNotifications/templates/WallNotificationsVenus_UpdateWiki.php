<? if($user->isLoggedIn()): ?>
	<? if( empty($unread) && empty($read) ): ?>
		<li class="notification empty"><?= wfMessage('wall-notifications-empty')->text() ?></li>
	<? endif; ?>

	<? foreach($unread as $value): ?>
		<? echo $app->renderView( 'WallNotificationsVenus', 'Notification', [ 'notify'=>$value,'unread'=>true ] ); ?>
	<? endforeach; ?>
	<? foreach($read as $value): ?>
		<? echo $app->renderView( 'WallNotificationsVenus', 'Notification', [ 'notify'=>$value,'unread'=>false ] ); ?>
	<? endforeach; ?>
<? endif; ?>
