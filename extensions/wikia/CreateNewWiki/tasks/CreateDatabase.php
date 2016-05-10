<?php

namespace Wikia\CreateNewWiki\Tasks;

class CreateDatabase implements Task {

	/** @var  TaskContext */
	private $taskContext;

	public function __construct($taskContext) {
		$this->taskContext = $taskContext;
	}

	public function preValidate() {
		if ( wfReadOnly() ) {
			return PreValidationResult::createForError( 'DB is read only', PreValidationResult::ERROR_READONLY );
		} else {
			return PreValidationResult::createForSuccess();
		}
	}

	public function run() {

		$this->mNewWiki->dbw->query( sprintf( "CREATE DATABASE `%s`", $this->mNewWiki->dbname ) );
		wfDebugLog( "createwiki", __METHOD__ . ": Database {$this->mNewWiki->dbname} created\n", true );
	}
}