<?php
/**
 * UserSystemMessage class
 * Used to send "You have advanced to level [fill in this]" messages
 * to users when User Levels is activated ($wgUserLevels is defined)
 */
class UserSystemMessage {

	/**
	 * Adds the message into the database
	 *
	 * @param $user_name Mixed: the name of the user who's receiving the message
	 * @param $type Integer: 0 by default
	 * @param $message Mixed: message to be sent out
	 */
	public function addMessage( $user_name, $type, $message ) {
		$user_id = User::idFromName( $user_name );
		$dbw = wfGetDB( DB_MASTER );

		$dbw->insert( 'user_system_messages',
			array(
				'um_user_id' => $user_id,
				'um_user_name' => $user_name,
				'um_type' => $type,
				'um_message' => $message,
				'um_date' => date( "Y-m-d H:i:s" ),
			), __METHOD__
		);
		$dbw->commit();
	}

	/**
	 * Deletes a message from the user_system_messages table in the database
	 * @param $um_id Integer: internal ID number of the message to delete
	 */
	static function deleteMessage( $um_id ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'user_system_messages', array( 'um_id' => $um_id ), __METHOD__ );
		$dbw->commit();
	}

	/**
	 * Gets a list of system messages for the current user from the database
	 *
	 * @param $type Integer: 0 by default
	 * @param $limit Integer: LIMIT for database queries, 0 by default
	 * @param $page Integer: 0 by default
	 * @return $requests
	 */
	public function getMessageList( $type, $limit = 0, $page = 0 ) {
		$dbw = wfGetDB( DB_MASTER );

		$limit_sql = '';
		if ( $limit > 0 ) {
			$limitvalue = 0;
			if ( $page )
				$limitvalue = $page * $limit - ( $limit );
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
			# $params['LIMIT'] = $limitvalue;
		}

/*		$params['ORDER BY'] = 'ug_id DESC';
		$res = $dbw->select( array( 'user_gift', 'gift' ),
			array(
				'ug_id', 'ug_user_id_from', 'ug_user_name_from', 'ug_gift_id', 'ug_date', 'ug_status',
				'gift_name', 'gift_description', 'gift_given_count'
			),
			array( 'ug_user_id_to' => $this->user_id ),
			__METHOD__,
			$params,
			array( 'gift' => array( 'INNER JOIN', 'ug_gift_id = gift_id' ) )
		);*/
		$sql = "SELECT ug_id, ug_user_id_from, ug_user_name_from, ug_gift_id, ug_date, ug_status,
			gift_name, gift_description, gift_given_count
			FROM {$dbw->tableName( 'user_gift' )} INNER JOIN {$dbw->tableName( 'gift' )} ON ug_gift_id=gift_id
			WHERE ug_user_id_to = {$this->user_id}
			ORDER BY ug_id DESC
			{$limit_sql}";

		$res = $dbw->query( $sql );
		$requests = array();
		while ( $row = $dbw->fetchObject( $res ) ) {
			$requests[] = array(
				'id' => $row->ug_id,
				'gift_id' => $row->ug_gift_id,
				'timestamp' => ( $row->ug_date ),
				'status' => $row->ug_status,
				'user_id_from' => $row->ug_user_id_from,
				'user_name_from' => $row->ug_user_name_from,
				'gift_name' => $row->gift_name,
				'gift_description' => $row->gift_description,
				'gift_given_count' => $row->gift_given_count
			);
		}
		return $requests;
	}

	/**
	 * Sends out the "you have advanced to level [fill in this]" messages to the users
	 *
	 * @param $user_id_to Integer: user ID of the receiver
	 * @param $level Mixed: name of the level that the user advanced to
	 */
	public function sendAdvancementNotificationEmail( $user_id_to, $level ) {
		wfLoadExtensionMessages( 'SocialProfileUserStats' );
		$user = User::newFromId( $user_id_to );
		$user->loadFromDatabase();
		if ( $user->isEmailConfirmed() && $user->getIntOption( 'notifyhonorifics', 1 ) ) {
			$update_profile_link = SpecialPage::getTitleFor( 'UpdateProfile' );
			$subject = wfMsgExt( 'level-advance-subject', 'parsemag',
				$level
			);
			$body = wfMsgExt( 'level-advance-body', 'parsemag',
				( ( trim( $user->getRealName() ) ) ? $user->getRealName() : $user->getName() ),
				$level,
				$update_profile_link->getFullURL()
			);
			$user->sendMail( $subject, $body );
		}
	}

}
