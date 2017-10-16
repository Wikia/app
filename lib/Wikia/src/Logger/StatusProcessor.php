<?php

namespace Wikia\Logger;

use \Status;

/**
 * This is a custom formatter for MediaWiki's Status class
 */
class StatusProcessor {

	/**
	 * Customize the formatting of "context" logging fields by extending the Status objects
	 *
	 * @param array $record
	 * @return array
	 */
	function __invoke(array $record) {
		foreach($record['context'] as $key => $entry) {
			if ( $entry instanceof Status ) {
				$record['context'][$key] = $this->normalizeStatus( $entry );
			}
		}

		return $record;
	}

	/**
	 * @param Status $status
	 * @return array
	 */
	private function normalizeStatus(Status $status) {
		return [
			'is_ok' => $status->isOK(),
			'errors' => $status->getErrorsArray(),
			'message' => $status->getMessage(),
			'value' => $status->value,
		];
	}
}
