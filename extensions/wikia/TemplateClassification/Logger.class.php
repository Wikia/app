<?php

namespace Wikia\TemplateClassification;

use Wikia\Logger\Loggable;

class Logger {

	use Loggable;

	const EXCEPTION_MESSAGE = 'TemplateClassification client exception';

	/**
	 * Log an exception on
	 * @param \Exception $e
	 */
	public function exception( \Exception $e ) {
		$context = [
			'tcExcptnMessage' => $e->getMessage(),
			'tcExcptnCode' => $e->getCode(),
			'tcExcptnBcktrc' => $e->getTraceAsString(),
		];

		$this->error( self::EXCEPTION_MESSAGE, $context );
	}
}
