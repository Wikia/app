<?php

class WikiaMapsLogger {

	// Logging
	const LOG_TYPE_NAME = 'maps';
	const SHOW_IN_RECENT_CHANGES = true;

	const ACTION_CREATE_MAP = 'create_map';
	const ACTION_UPDATE_MAP = 'update_map';
	const ACTION_DELETE_MAP = 'delete_map';
	const ACTION_UNDELETE_MAP = 'undelete_map';

	const ACTION_CREATE_PIN_TYPE = 'create_pin_type';
	const ACTION_UPDATE_PIN_TYPE = 'update_pin_type';
	const ACTION_DELETE_PIN_TYPE = 'delete_pin_type';

	const ACTION_CREATE_PIN = 'create_pin';
	const ACTION_UPDATE_PIN = 'update_pin';
	const ACTION_DELETE_PIN = 'delete_pin';

	/**
	 * Create new Log entry
	 *
	 * @param string $action Action name as defined above
	 * @param $user User
	 * @param integer $mapId Map id
	 * @param string $comment Comment
	 * @param array $params Additional params
	 * @return ManualLogEntry
	 */
	public static function newLogEntry( $action, $user, $mapId, $comment, $params = [] ) {
		$logEntry = new ManualLogEntry( self::LOG_TYPE_NAME, $action );

		$logEntry->setPerformer($user);
		$logEntry->setTarget( SpecialPage::getTitleFor(
			WikiaMapsSpecialController::PAGE_NAME,
			$mapId
		) );
		$logEntry->setComment( $comment );

		if ( !empty( $params ) ) {
			// we can't allow to pass those elements
			// more info: https://www.mediawiki.org/wiki/Manual:Logging_to_Special:Log#1.19_and_later
			unset( $params[1], $params[2], $params[3] );
			$logEntry->setParameters( $params );
		}

		return $logEntry;
	}

	/**
	 * Helper method to add single logEntry
	 *
	 * @param string $action Action name as defined above
	 * @param $user User
	 * @param integer $mapId Map id
	 * @param string $comment Comment
	 * @param array $params Additional params
	 */
	public static function addLogEntry( $action, $user, $mapId, $comment, $params = [] ) {
		self::addLogEntries( [ self::newLogEntry( $action, $user, $mapId, $comment, $params ) ] );
	}

	/**
	 * @brief Batch add array of Log entries
	 *
	 * @param array $logEntries
	 */
	public static function addLogEntries( Array $logEntries ) {
		if ( !empty( $logEntries ) ) {
			foreach ( $logEntries as $logEntry ) {
				/** @var ManualLogEntry $logEntry */
				$logId = $logEntry->insert();

				if ( self::SHOW_IN_RECENT_CHANGES === true ) {
					$logEntry->publish( $logId );
				}
			}
		}
	}
}
