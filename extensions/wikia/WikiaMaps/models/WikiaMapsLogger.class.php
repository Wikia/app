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
						WikiaMapsController::PAGE_NAME,
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

	/**
	 * Format Log entry for Wikia Maps
	 *
	 * @param string $type Type of the entry
	 * @param string $action Action of the entry
	 * @param mixed $title Page title or null
	 * @param mixed $skin Skin object or null
	 * @param array $params Params array
	 * @param bool $filterWikilinks - whether to filter wiki links
	 * @return string
	 */
	public static function formatLogEntry( $type, $action, $title, $skin, Array $params, $filterWikilinks ) {
		global $wgLang;

		if( empty( $params[ 0 ] ) ) {
			Wikia::log( __METHOD__, false, 'Invalid $params for WikiaMapsLogger::formatLogEntry(); username required' );
			$username = 'Unknown';
		} else {
			$username = $params[ 0 ];
		}

		$mapPageTitle = $wgLang->convertTitle( $title );

		// A little bit verbose but according to http://www.mediawiki.org/wiki/Localisation#Using_messages
		// that's the way to go
		$messageKey = 'wikia-interactive-maps-unknown-log-entry';
		$translations = [
			self::ACTION_CREATE_MAP => 'wikia-interactive-maps-create-map-log-entry',
			self::ACTION_UPDATE_MAP => 'wikia-interactive-maps-update-map-log-entry',
			self::ACTION_DELETE_MAP => 'wikia-interactive-maps-delete-map-log-entry',
			self::ACTION_UNDELETE_MAP => 'wikia-interactive-maps-undelete-map-log-entry',
			self::ACTION_CREATE_PIN_TYPE => 'wikia-interactive-maps-create-pin-type-log-entry',
			self::ACTION_UPDATE_PIN_TYPE => 'wikia-interactive-maps-update-pin-type-log-entry',
			self::ACTION_DELETE_PIN_TYPE => 'wikia-interactive-maps-delete-pin-type-log-entry',
			self::ACTION_CREATE_PIN => 'wikia-interactive-maps-create-pin-log-entry',
			self::ACTION_UPDATE_PIN => 'wikia-interactive-maps-update-pin-log-entry',
			self::ACTION_DELETE_PIN => 'wikia-interactive-maps-delete-pin-log-entry',
		];

		if ( isset( $translations[ $action ] ) ) {
			$messageKey = $translations[ $action ];
		}

		if ( is_null( $skin ) ) {
			return wfMessage( $messageKey, $username, $mapPageTitle )->text();
		}

		return wfMessage( $messageKey, $username, $mapPageTitle )->parse();
	}
}
