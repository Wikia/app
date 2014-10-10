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
	 * @param integer $mapId Map id
	 * @param string $comment Comment
	 * @param array $params Additional params; first parameter must be username
	 * @return stdClass Log entry
	 */
	public static function newLogEntry( $action, $mapId, $comment, $params = [] ) {
		$result = new stdClass();
		$result->action = $action;
		$result->mapId = $mapId;
		$result->comment = $comment;
		$result->params = $params;
		return $result;
	}

	/**
	 * Helper method to add single logEntry
	 *
	 * @param string $action Action name as defined above
	 * @param integer $mapId Map id
	 * @param string $comment Comment
	 * @param array $params Additional params; first parameter must be username
	 */
	public static function addLogEntry( $action, $mapId, $comment, $params = [] ) {
		self::addLogEntries( [ self::newLogEntry( $action, $mapId, $comment, $params ) ] );
	}

	/**
	 * Batch add array of Log entries
	 *
	 * @param array $logEntries
	 * @param string $type Log type category name
	 */
	public static function addLogEntries( Array $logEntries, $type = self::LOG_TYPE_NAME ) {
		if ( !empty( $logEntries ) ) {
			$log = new LogPage( $type, self::SHOW_IN_RECENT_CHANGES );
			$pagesCache = [];
			foreach ( $logEntries as $logEntry ) {
				if ( !isset( $pagesCache[ $logEntry->mapId ] ) ) {
					$pagesCache[ $logEntry->mapId ] = SpecialPage::getTitleFor(
						WikiaMapsSpecialController::PAGE_NAME,
						$logEntry->mapId
					);
				}
				$log->addEntry(
					$logEntry->action,
					$pagesCache[ $logEntry->mapId ],
					$logEntry->comment,
					$logEntry->params
				);
			}
		}
	}
}
