<?php

namespace Wikia\CreateNewWiki\Tasks;

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
		$then = microtime( true );

		// commit the changes
		$res = $taskContext->getWikiDBW()->commit( $functionName );

		# PLATFORM-1219 - wait for slaves to catch up (shared DB, cluster's shared DB and the new wiki DB)
		wfWaitForSlaves( $wgExternalSharedDB );     // wikicities (shared DB)
		wfWaitForSlaves( $taskContext->getDbName() ); // new_wiki_db

		\Wikia\Logger\WikiaLogger::instance()->info( __METHOD__ . ' Waiting for slaves ',
			self::getLoggerContext( $taskContext , [
				'commit_res' => $res,
				'fname'      => $functionName,
				'took'       => microtime( true ) - $then,
			] ) );
	}

	/**
	 * @param TaskContext $taskContext
	 * @param string[][] $additionalValues
	 * @return string[][]
	 */
	public static function getLoggerContext( TaskContext $taskContext, $additionalValues = null ) {
		//TODO expand
		return [
			'domain'   => $taskContext->getDomain(),
			'dbname'   => $taskContext->getDbName(),
			'logGroup' => 'createwiki',
		];
		//TODO merge the two parameters and extract logging context from task context
		//return $taskContext;
	}
}
