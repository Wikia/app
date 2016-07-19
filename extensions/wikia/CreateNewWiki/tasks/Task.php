<?php

namespace Wikia\CreateNewWiki\Tasks;

abstract class Task {

	/** @var TaskContext */
	protected $taskContext;

	public function __construct( TaskContext $taskContext ) {
		$this->taskContext = $taskContext;
	}

	protected function getLoggerContext() {
		return TaskHelper::getLoggerContext( $this->taskContext );
	}

	/**
	 *
	 * @return TaskResult
	 */
	public function prepare() {
		return TaskResult::createForSuccess();
	}

	/**
	 *
	 * @return TaskResult
	 */
	public function check() {
		return TaskResult::createForSuccess();
	}

	/**
	 *
	 * @return TaskResult
	 */
	public function run() {
		return TaskResult::createForSuccess();
	}
}
