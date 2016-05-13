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
	 * Wait for shared DB and the current DB cluster slaves
	 *
	 * @param TaskContext $taskContext
	 * @param string $functionName
	 * @see PLATFORM-1219
	 */
	public static function waitForSlaves( TaskContext $taskContext, $functionName ){
		global $wgExternalSharedDB;
		$timeCounter = new TimeCounter();

		// commit the changes
		$res = $taskContext->getWikiDBW()->commit( $functionName );

		# PLATFORM-1219 - wait for slaves to catch up (shared DB, cluster's shared DB and the new wiki DB)
		wfWaitForSlaves( $wgExternalSharedDB );     // wikicities (shared DB)
		wfWaitForSlaves( $taskContext->getDbName() ); // new_wiki_db

		\Wikia\Logger\WikiaLogger::instance()->info( __METHOD__ . ' Waiting for slaves ',
			self::getLoggerContext( $taskContext , [
				'commit_res' => $res,
				'fname'      => $functionName,
				'took'       => $timeCounter->getTimePassed(),
			] ) );
	}

	/**
	 * @param TaskContext $taskContext
	 * @param string[][] $additionalValues
	 * @return string[][]
	 */
	public static function getLoggerContext( TaskContext $taskContext, $additionalValues = [] ) {
		$context = (array) $taskContext;

		$context = array_merge( $context, $additionalValues );

		return $context;
	}
}
