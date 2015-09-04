<?php
	if (!empty($notifications)) {
?>
<ul id="WikiaNotifications" class="WikiaNotifications<?php if( !empty($wg->EnableWikiaBarExt) ): echo ' hidden'; endif; ?>">
<?php
		foreach ($notifications as $notification) {
?>
	<li>
<?php
			switch($notification['type']) {
				// render badge notification
				case NotificationsController::NOTIFICATION_NEW_ACHIEVEMENTS_BADGE:
?>
		<div data-type="<?= Sanitizer::encodeAttribute( $notification['type'] ); ?>" class="WikiaBadgeNotification">
			<a class="sprite close-notification"></a>
			<img class="badge" src="<?= Sanitizer::encodeAttribute( $notification['data']['picture'] ); ?>" width="90" height="90" alt="<?= Sanitizer::encodeAttribute( $notification['data']['name'] ); ?>">
			<p>
				<big><?= htmlspecialchars( $notification['data']['points'] ) ?></big>
				<?= $notification['message'] ?>
			</p>
			<div class="notification-details"><a href="<?= htmlspecialchars($notification['data']['userPage']) ?>"><?= wfMessage( 'oasis-badge-notification-see-more' )->escaped(); ?></a></div>
		</div>
<?php
					break;

				// render talk page / edit similar / community message notification
				case NotificationsController::NOTIFICATION_TALK_PAGE_MESSAGE:
				case NotificationsController::NOTIFICATION_EDIT_SIMILAR:
				case NotificationsController::NOTIFICATION_COMMUNITY_MESSAGE:
?>
		<div data-type="<?= $notification['type'] ?>">
			<a class="sprite close-notification"></a>
			<?= $notification['message'] ?>
		</div>
<?php
					break;

				case NotificationsController::NOTIFICATION_SITEWIDE:
					$first = 1;
					foreach ($notification['message'] as $msgId => $data) {
?>
		<div data-type="<?= $notification['type'] ?>" id="msg_<?= $msgId ?>" style="display: <?= $first ? 'block' : 'none' ?>">
			<a class="sprite close-notification"></a><?= $data['text'] ?>
		</div>
<?php
						$first = 0;
					}
					break;

				case NotificationsController::NOTIFICATION_CUSTOM:
?>
		<div data-type="<?= $notification['type'] ?>" data-name="<?= $notification['data']['name'] ?>">
<?php
					if (!empty($notification['data']['dismissUrl'])) {
?>
			<a class="sprite close-notification" data-url="<?= htmlspecialchars($notification['data']['dismissUrl']) ?>"></a>
<?php
					}
?>
			<?= $notification['message'] ?>
		</div>
<?php
				break;

				// render generic notification
				default:
?>
		<div data-type="<?= $notification['type'] ?>"><?= $notification['message'] ?></div>
<?php
			}
?>
	</li>
<?php
		}
?>
</ul>
<?php
	}
?>
