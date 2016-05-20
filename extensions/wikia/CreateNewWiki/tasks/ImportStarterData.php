<?php

namespace Wikia\CreateNewWiki\Tasks;

use Wikia\CreateNewWiki\Starters;
use Wikia\Logger\Loggable;

class ImportStarterData extends Task {

	use Loggable;

	private $phpBin = "/usr/bin/php";

	public function check() {
		// php-cli is required for spawning PHP maintenance scripts
		if ( !$this->canExecute() ) {
			return TaskResult::createForError( $this->phpBin . " doesn't exist or is not an executable" );
		} else {
			return TaskResult::createForSuccess();
		}
	}

	public function run() {
		// I need to pass $this->sDbStarter to CreateWikiLocalJob::changeStarterContributions
		$starterDatabase = Starters::getStarterByLanguage( $this->taskContext->getLanguage() );
		$this->taskContext->setStarterDb( $starterDatabase );

		// import a starter database XML dump from DFS
		$then = microtime( true );

		$retVal = $this->executeShell();

		if ( $retVal > 0 ) {
			return TaskResult::createForError( 'starter dump import failed', [
				'starter' => $starterDatabase,
				'retval' => $retVal
			] );
		}

		if ( $retVal > 0 ) {
			return TaskResult::createForError( 'starter dump import failed', [
				'starter' => $starterDatabase,
				'retval' => $retVal
			] );
		}

		$took = microtime( true ) - $then;
		TaskHelper::waitForSlaves( $this->taskContext, __METHOD__ );

		return TaskResult::createForSuccess( [
			'retval' => $retVal,
			'starter' => $starterDatabase,
			'took' => $took
		] );
	}

	public function canExecute() {
		return file_exists( $this->phpBin ) && is_executable( $this->phpBin );
	}

	public function executeShell() {
		global $IP;

		$cmd = sprintf(
			"SERVER_ID=%d %s %s/maintenance/importStarter.php",
			$this->taskContext->getCityId(),
			$this->phpBin,
			"{$IP}/extensions/wikia/CreateNewWiki"
		);

		$this->debug( implode( ":", [ __METHOD__, "Executing script: {$cmd}" ] ) );
		wfShellExec( $cmd, $retVal );

		return $retVal;
	}
}
