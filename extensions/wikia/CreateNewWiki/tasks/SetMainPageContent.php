<?php

namespace Wikia\CreateNewWiki\Tasks;

use Wikia\Logger\Loggable;

class SetMainPageContent extends Task {
	use Loggable;

	public function run() {
		global $IP, $wgPhpCli;

		$cmd = sprintf(
			"SERVER_ID=%d %s %s/maintenance/setMainPageContent.php",
			$this->taskContext->getCityId(),
			$wgPhpCli,
			"{$IP}/extensions/wikia/CreateNewWiki"
		);

		$this->debug( implode( ":", [ __METHOD__, "Executing script: {$cmd}" ] ) );
		wfShellExec( $cmd, $retVal );

		if ( $retVal > 0 ) {
			return TaskResult::createForError( 'setting main page content failed', [
				'city_id' => $this->taskContext->getCityId()
			] );
		}

		return TaskResult::createForSuccess( [
			'retval' => $retVal,
			'city_id' => $this->taskContext->getCityId()
		] );
	}
}
