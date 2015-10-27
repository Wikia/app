<?php

namespace Wikia\TemplateClassification;

use Swagger\Client\ApiException;
use Wikia\Logger\Loggable;

class Logger {

	use Loggable;

	const EXCEPTION_MESSAGE = 'TemplateClassification client exception';

	/**
	 * Log exceptions thrown by TemplateClassification service
	 * @param  $e
	 */
	public function exception( ApiException $e ) {
		$context = [
			'tcExcptnMessage' => $e->getMessage(),
			'tcExcptnCode' => $e->getCode(),
			'tcExcptnBcktrc' => $e->getTraceAsString(),
		];

		$this->error( self::EXCEPTION_MESSAGE, $context );
	}
}
