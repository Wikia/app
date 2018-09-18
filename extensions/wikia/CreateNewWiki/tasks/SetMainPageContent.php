<?php

namespace Wikia\CreateNewWiki\Tasks;

use Wikia\Logger\Loggable;

class SetMainPageContent extends Task {
	use Loggable;

	public function run() {
		global $IP, $wgPhpCli;

		// this task is executed on global wiki with other CNW tasks. To edit the article on a wiki, we have to
		// switch the context. To avoid passing the user-provided multi-line description in command line params, it
		// was stored in $wgWikiDescription earlier.

		$cmd = sprintf(
			'SERVER_ID=%d %s %s/maintenance/setMainPageContent.php',
			$this->taskContext->getCityId(),
			$wgPhpCli,
			"{$IP}/extensions/wikia/CreateNewWiki"
		);

		$this->debug( implode( ":", [ __METHOD__, "Executing script: {$cmd}" ] ) );
		wfShellExec( $cmd, $retVal );

		if ( $retVal > 0 ) {
			return TaskResult::createForError( 'Setting main page content failed', [
				'retval' => $retVal
			] );
		}

		return TaskResult::createForSuccess();
	}
}
