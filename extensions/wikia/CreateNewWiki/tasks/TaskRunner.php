<?php

namespace Wikia\CreateNewWiki\Tasks;

/**
 * Class TaskRunner
 *
 * Manages tasks being part of the create new wiki process
 */
class TaskRunner {

	use \Wikia\Logger\Loggable;

	/** @var array Task[] */
	private $tasks = [];

	/** @var  TaskContext */
	private $taskContext;

	public function __construct($taskContext) {
		$this->taskContext = $taskContext;

		//Todo pass all required params
		$this->tasks[] = new PrepareDomain( $taskContext );
		$this->tasks[] = new CreateDatabase( $taskContext );
		$this->tasks[] = new ConfigureWikiFactory( $taskContext );
		$this->tasks[] = new CreateTables();
		$this->tasks[] = new ImportStarterData( $taskContext );
		$this->tasks[] = new ConfigureUsers();
		$this->tasks[] = new ConfigureStats();
		$this->tasks[] = new ConfigureCategories();
	}

	/**
	 * Add more context to messages sent to LogStash
	 *
	 * @return array
	 */
	protected function getLoggerContext() {
		return TaskHelper::getLoggerContext( $this->taskContext );
	}

	public function prepare() {
		/** @var Task $task */
		foreach ( $this->tasks as $task) {

			$this->debug(__METHOD__ . ' starting preparation of task ' . get_class( $task ) );

			$result = $task->prepare();

			if ( $result->isOk()) {
				$this->info(__METHOD__ . ' preparation of task ' . get_class( $task ) . ' finished successfully');
			} else {
				$this->warning(__METHOD__ . ' preparation of task ' . get_class( $task ) . ' failed', $result->createLoggingContext() );
				throw new \CreateWikiException( $result->getMessage() );
			}
		}
	}

	public function check() {
		/** @var Task $task */
		foreach ( $this->tasks as $task) {

			$this->debug(__METHOD__ . ' starting check of task ' . get_class( $task ) );

			$result = $task->check();

			if ( $result->isOk()) {
				$this->info(__METHOD__ . ' check of task ' . get_class( $task ) . ' finished successfully');
			} else {
				//TODO provide proper context. Need to ask how to do that properly
				$this->warning(__METHOD__ . ' check of task ' . get_class( $task ) . ' failed', $result->createLoggingContext() );
				throw new \CreateWikiException( $result->getMessage() );
			}
		}
	}

	public function run() {
		/** @var Task $task */
		foreach ( $this->tasks as $task) {

			$this->debug(__METHOD__ . ' starting task ' . get_class( $task ) );

			$result = $task->run();

			if ( $result->isOk()) {
				$this->info(__METHOD__ . ' task ' . get_class( $task ) . ' finished successfully' );
			} else {
				//TODO provide proper context. Need to ask how to do that properly
				$this->error(__METHOD__ . ' task ' . get_class( $task ) . ' failed ', $result->createLoggingContext() );
				throw new \CreateWikiException( $result->getMessage() );
			}
		}
	}
}
