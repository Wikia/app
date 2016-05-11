<?php

namespace Wikia\CreateNewWiki\Tasks;

class CreateDatabase implements Task {

	use \Wikia\Logger\Loggable;

	/** @var  TaskContext */
	private $taskContext;

	public function __construct($taskContext) {
		$this->taskContext = $taskContext;
	}

	public function prepare() {
		$clusterDB = "wikicities_" . TaskContext::ACTIVE_CLUSTER;
		$dbw = wfGetDB( DB_MASTER, array(), $clusterDB );
		$this->taskContext->setClusterDB( $clusterDB );
		$this->taskContext->setWikiDBW( $dbw );

		return TaskResult::createForSuccess();
	}

	public function check() {
		if ( wfReadOnly() ) {
			return TaskResult::createForError( 'DB is read only' );
		} else {
			return TaskResult::createForSuccess();
		}
	}

	public function run() {
		$this->taskContext->getWikiDBW()->query( sprintf( "CREATE DATABASE `%s`", $this->taskContext->getDBname() ) );

		return TaskResult::createForSuccess();
	}
}
