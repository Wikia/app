<?php

/**
 * Class TaskRunner
 *
 * Manages tasks being part of the create new wiki process
 */
class TaskRunner {

	use \Wikia\Logger\Loggable;

	/** @var array Task[] */
	private $tasks = [];

	public function __construct() {
		//Todo pass all required params
		$this->tasks[] = new CreateDatabase();
		$this->tasks[] = new ConfigureWikiFactory();
		$this->tasks[] = new CreateTables();
		$this->tasks[] = new ImportStarterData();
		$this->tasks[] = new ConfigureUsers();
		$this->tasks[] = new ConfigureStats();
		$this->tasks[] = new ConfigureCategories();
	}

	/**
	 * Checks if all criteria are met
	 *
	 * @return TaskPreValidationResult[]
	 */
	public function preValidate() {
		$resultArray = [];

		/** @var Task $task */
		foreach ( $this->tasks as $task) {

			Wikia\Logger\WikiaLogger::instance()->debug(
				__METHOD__ . ' starting pre validation of task ' . get_class( $task ) );

			$resultArray[] = $result = $task->preValidate();

			Wikia\Logger\WikiaLogger::instance()->info(
				__METHOD__ . ' pre validation of task ' . get_class( $task ) . ' finished with result ' . $result->isValid(),
				$result ); //TODO provide proper context. Need to ask how to do that properly
		}

		return $resultArray;
	}

	public function run() {
		$resultArray = [];

		/** @var Task $task */
		foreach ( $this->tasks as $task) {

			Wikia\Logger\WikiaLogger::instance()->debug(
				__METHOD__ . ' starting task ' . get_class( $task ) );

			$resultArray[] = $result = $task->run();

			Wikia\Logger\WikiaLogger::instance()->info(
				__METHOD__ . ' task ' . get_class( $task ) . ' finished with result ' . $result->isOk(),
				$result ); //TODO provide proper context. Need to ask how to do that properly
		}

		return $resultArray;
	}
}