<?php

use \Wikia\Tasks\Tasks\BaseTask;

/**
 * This task is used to asynchronously add notifications after wall messages is submitted.
 *
 * @see SUS-1644
 */
class WallAddNotificationsTask extends BaseTask {

	/**
	 * Code below was moved here from WallMessage::buildNewMessageAndPost method
	 *
	 * @param int $message_id
	 * @param bool $notify
	 * @param bool $notifyEveryone
	 * @param bool $hasParent
	 */
	public function notify( int $message_id, bool $notify, bool $notifyEveryone, bool $hasParent ) {
		$message = WallMessage::newFromId( $message_id );

		$this->info( __METHOD__, [
			'message_id' => $message->getId()
		] );

		if ( $notify ) {
			$message->sendNotificationAboutLastRev();
		}

		// someone submitted a post to Forum thread marked with "notify everyone"
		if ( $hasParent === false && $notifyEveryone ) {
			$message->notifyEveryone();
		}
	}
}
