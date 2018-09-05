<?php

namespace Wikia\CreateNewWiki\Tasks;
use Wikia\Logger\Loggable;

/**
 * Class TaskRunner
 *
 * Manages tasks being part of the create new wiki process
 */
class TaskRunner {

	use Loggable;

	/** @var array Task[] */
	private $tasks = [];

	/** @var  TaskContext */
	private $taskContext;

	public function __construct($taskContext) {
		$this->taskContext = $taskContext;

		$this->tasks[] = new PrepareDomain( $taskContext );
		$this->tasks[] = new CreateDatabase( $taskContext );
		$this->tasks[] = new SetupWikiCities( $taskContext );
		$this->tasks[] = new ConfigureWikiFactory( $taskContext );
		$this->tasks[] = new LinkFandomCreatorCommunity( $taskContext );
		$this->tasks[] = new CreateTables( $taskContext );
		$this->tasks[] = new ImportStarterData( $taskContext );
		$this->tasks[] = new SetMainPageContent( $taskContext );
		$this->tasks[] = new ConfigureUsers( $taskContext );
		$this->tasks[] = new ConfigureCategories( $taskContext );
		$this->tasks[] = new SetCustomSettings( $taskContext );
		$this->tasks[] = new StartPostCreationTasks( $taskContext );
		$this->tasks[] = new EnableDiscussionsTask( $taskContext );
	}

	protected function getLoggerContext() {
		return TaskHelper::getLoggerContext( $this->taskContext );
	}

	public function prepare() {
		/** @var Task $task */
		foreach ( $this->tasks as $task) {

			$this->debug(__METHOD__ . ' starting preparation of task ' . get_class( $task ) );
			$timeCounter = new TimeCounter();

			$result = $task->prepare();
			$logContext = $timeCounter->getContext( $result->createLoggingContext() );

			if ( $result->isOk()) {
				$this->info(__METHOD__ . ' preparation of task ' . get_class( $task ) . ' finished successfully', $logContext);
			} else {
				$this->warning(__METHOD__ . ' preparation of task ' . get_class( $task ) . ' failed', $logContext );
				throw new \CreateWikiException( $result->getMessage() );
			}
		}
	}

	public function check() {
		/** @var Task $task */
		foreach ( $this->tasks as $task) {

			$this->debug(__METHOD__ . ' starting check of task ' . get_class( $task ) );
			$timeCounter = new TimeCounter();

			$result = $task->check();
			$logContext = $timeCounter->getContext( $result->createLoggingContext() );

			if ( $result->isOk()) {
				$this->info(__METHOD__ . ' check of task ' . get_class( $task ) . ' finished successfully' ,$logContext);
			} else {
				$this->warning(__METHOD__ . ' check of task ' . get_class( $task ) . ' failed', $logContext );
				throw new \CreateWikiException( $result->getMessage() );
			}
		}
	}

	public function run() {
		/** @var Task $task */
		foreach ( $this->tasks as $task) {

			$this->debug(__METHOD__ . ' starting task ' . get_class( $task ) );
			$timeCounter = new TimeCounter();

			$result = $task->run();
			$logContext = $timeCounter->getContext( $result->createLoggingContext() );

			if ( $result->isOk()) {
				$this->info(__METHOD__ . ' task ' . get_class( $task ) . ' finished successfully', $logContext );
			} else {
				$this->critical(__METHOD__ . ' task ' . get_class( $task ) . ' failed ', $logContext );
				throw new \CreateWikiException( $result->getMessage() );
			}
		}
	}
}
