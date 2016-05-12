<?php

namespace Wikia\CreateNewWiki\Tasks;

use Wikia\CreateNewWiki\Starters;

class ImportStarterData implements Task {

	private $phpBin = "/usr/bin/php";

	/** @var  TaskContext */
	private $taskContext;

	public function __construct($taskContext) {
		$this->taskContext = $taskContext;
	}

	public function prepare() {
	}

	public function check() {
		// php-cli is required for spawning PHP maintenance scripts
		if( !file_exists( $this->phpBin ) && !is_executable( $this->phpBin ) ) {
			return TaskResult::createForError( $this->phpBin . " doesn't exist or is not an executable");
		} else {
			return TaskResult::createForSuccess();
		}
	}

	public function run() {
		global $IP;

		// BugId:15644 - I need to pass $this->sDbStarter to CreateWikiLocalJob::changeStarterContributions
		$starterDatabase = Starters::getStarterByLanguage( $this->taskContext->getLanguage() );
		$this->taskContext->setStarterDb( $starterDatabase );

		// import a starter database XML dump from DFS
		$then = microtime( true );

		$cmd = sprintf(
			"SERVER_ID=%d %s %s/maintenance/importStarter.php",
			$this->taskContext->getCityId(),
			$this->phpBin,
			"{$IP}/extensions/wikia/CreateNewWiki"
		);
		wfShellExec( $cmd, $retVal );

		if ( $retVal > 0 ) {
			return TaskResult::createForError( 'starter dump import failed', [
				'starter' => $starterDatabase,
				'retval'  => $retVal
			] );
		}

		$took = microtime( true ) - $then;
		TaskHelper::waitForSlaves( $this->taskContext, __METHOD__ );

		return TaskResult::createForSuccess( [
			'retval'  => $retVal,
			'starter' => $starterDatabase,
			'took'    => $took
		] );
	}
}