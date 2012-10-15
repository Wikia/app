<?php

/**
 * Object representing a log entry
 */
class ServerAdminLogEntry {

	/**
	 * Inserts an entry into the database
	 *
	 * @param $channel ServerAdminLogChannel
	 * @param $user User|string
	 * @param $message string
	 * @return int ID of the new entry
	 */
	public static function create( ServerAdminLogChannel $channel, $user, $message ) {
		$db = wfGetDB( DB_MASTER );

		if ( $user instanceof User ) {
			$userId = $user->getId();
			$userText = null; // We use JOINs here
		} else {
			$userId = 0;
			$userText = $user;
		}

		$db->insert(
			'sal_entry',
			array(
				'sale_channel' => $channel->getId(),
				'sale_user' => $userId,
				'sale_user_text' => $userText,
				'sale_timestamp' => $db->timestamp(),
				'sale_comment' => $message,
			),
			__METHOD__
		);

		return $db->insertId();
	}
}
