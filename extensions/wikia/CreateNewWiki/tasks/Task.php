<?php

namespace Wikia\CreateNewWiki\Tasks;

interface Task {

	/**
	 *
	 * @return TaskResult
	 */
	public function prepare();

	/**
	 *
	 * @return TaskResult
	 */
	public function check();

	/**
	 *
	 * @return TaskResult
	 */
	public function run();
}