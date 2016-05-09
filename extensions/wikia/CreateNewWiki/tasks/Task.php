<?php


interface Task {

	/**
	 *
	 * @return TaskPreValidationResult
	 */
	public function preValidate();

	/**
	 *
	 * @return TaskRunResult - if operation was unsuccessful it is rollbacked.
	 */
	public function run();


	//TODO Do we need it? possibly should be part of run.
	//public function prepare();
}