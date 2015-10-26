<?php

namespace Wikia\TemplateClassification;

use Wikia\Interfaces\IRequest;
use Wikia\Logger\Loggable;

class Logger {

	use Loggable;

	const EXCEPTION_MESSAGE = 'TemplateClassification client exception';

	/**
	 * Log an exception on
	 * @param \Exception $e
	 * @param IRequest|null $request
	 */
	public function exception( \Exception $e, IRequest $request = null ) {
		$context = [
			'tcExcptn' => [
				'tcExcptnMessage' => $e->getMessage(),
				'tcExcptnCode' => $e->getCode(),
				'tcExcptnFile' => $e->getFile() . ':' . $e->getLine(),
				'tcExcptnBcktrc' => $e->getTraceAsString(),
			],
		];

		if ( $request !== null ) {
			$context['tcRqst'] = $request->getValues();
		}

		$this->error( self::EXCEPTION_MESSAGE, $context );
	}
}
