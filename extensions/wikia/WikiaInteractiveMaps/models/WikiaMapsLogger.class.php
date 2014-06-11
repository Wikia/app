<?php

class WikiaMapsLogger {

	// Logging
	const LOG_TYPE_NAME = 'maps';

	const ACTION_CREATE_MAP = 'create_map';
	const ACTION_CREATE_PIN_TYPE = 'create_pin_type';

	public static function newLogEntry( $action, $mapId, $comment, $params = [] ) {
		$result = new stdClass();
		$result->action = $action;
		$result->mapId = $mapId;
		$result->comment = $comment;
		$result->params = $params;
		return $result;
	}

	public static function addLogEntry( $action, $mapId, $comment, $params = [] ) {
		self::addLogEntries( [ self::newLogEntry( $action, $mapId, $comment, $params ) ] );
	}

	public static function addLogEntries( Array $logEntries, $type = self::LOG_TYPE_NAME ) {
		if ( is_array( $logEntries ) && !empty( $logEntries ) ) {
			$log = new LogPage( $type );
			$pagesCache = [];
			foreach ( $logEntries as $logEntry ) {
				if ( !isset( $pagesCache[ $logEntry->mapId ] ) ) {
					$pagesCache[ $logEntry->mapId ] = SpecialPage::getTitleFor(
						WikiaInteractiveMapsController::PAGE_NAME,
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