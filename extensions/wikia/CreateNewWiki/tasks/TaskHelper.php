<?php

namespace Wikia\CreateNewWiki\Tasks;

class TaskHelper {

	/**
	 * Wait for shared DB and the current DB cluster slaves
	 *
	 * @param string $fname
	 * @see PLATFORM-1219
	 */
	public static function waitForSlaves( TaskContext $taskContext, $fname ){
		global $wgExternalSharedDB;
		$then = microtime( true );

		// commit the changes
		$res = $taskContext->getWikiDBW()->commit( $fname );

		# PLATFORM-1219 - wait for slaves to catch up (shared DB, cluster's shared DB and the new wiki DB)
		wfWaitForSlaves( $wgExternalSharedDB );     // wikicities (shared DB)

		//TODO finish refactoring to use context
		wfWaitForSlaves( $this->mClusterDB );       // wikicities_c7
		wfWaitForSlaves( $this->mNewWiki->dbname ); // new_wiki_db

		$this->info( __METHOD__, [
			'commit_res' => $res,
			'cluster'    => $this->mClusterDB,
			'fname'      => $fname,
			'took'       => microtime( true ) - $then,
		] );
	}
}