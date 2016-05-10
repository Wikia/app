<?php

namespace Wikia\CreateNewWiki\Tasks;

interface Task {

	/**
	 *
	 * @return PreValidationResult
	 */
	public function preValidate();

	/**
	 *
	 * @return RunResult - if operation was unsuccessful it is rollbacked.
	 */
	public function run();


	//TODO Do we need it? possibly should be part of run.
	//public function prepare();
}