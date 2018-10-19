<?php

namespace Wikia\CreateNewWiki\Tasks;

class TimeCounter {

	private $startTime;

	public function __construct() {
		$this->startTime = microtime( true );
	}

	public function getTimePassed() {
		return microtime( true ) - $this->startTime;
	}

	public function getContext( $context = null ) {
		$timeContext = [ 'took' => $this->getTimePassed() ];
		if ( !empty( $context ) ) {
			return array_merge( $context, $timeContext );
		}  else {
			return $timeContext;
		}
	}
}

class TaskHelper {

	/**
	 * @param TaskContext $taskContext
	 * @param string[][] $additionalValues
	 * @return string[][]
	 */
	public static function getLoggerContext( TaskContext $taskContext, $additionalValues = [] ) {
		$context = $taskContext->getLoggerContext();

		$context = array_merge( $context, $additionalValues );

		return $context;
	}
}
