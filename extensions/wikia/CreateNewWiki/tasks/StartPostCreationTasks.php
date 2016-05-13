<?php

namespace Wikia\CreateNewWiki\Tasks;

class StartPostCreationTasks implements Task {

	use \Wikia\Logger\Loggable;

	/** @var  TaskContext */
	private $taskContext;

	public function __construct($taskContext) {
		$this->taskContext = $taskContext;
	}

	protected function getLoggerContext() {
		return TaskHelper::getLoggerContext( $this->taskContext );
	}

	public function prepare() {
		return TaskResult::createForSuccess();
	}

	public function check() {
		return TaskResult::createForSuccess();
	}

	public function run() {
		$creationTask = new \Wikia\Tasks\Tasks\CreateNewWikiTask();

		$jobParams = [];
		$jobParams['url'] = $this->taskContext->getURL();
		$jobParams['founderId'] = $this->taskContext->getFounder()->getId();
		$jobParams['founderName'] = $this->taskContext->getFounder()->getName();
		$jobParams['sitename'] = $this->taskContext->getSiteName();
		$jobParams['language'] = $this->taskContext->getLanguage();
		$jobParams['city_id'] = $this->taskContext->getCityId();

		// BugId:15644 - I need to pass this to CreateWikiLocalJob::changeStarterContributions
		$jobParams->sDbStarter = $this->taskContext->getStarterDb();

		$taskId = (new \Wikia\Tasks\AsyncTaskList())
			->wikiId( $this->taskContext->getCityId() )
			->prioritize()
			->add($creationTask->call('postCreationSetup', $jobParams))
			->add($creationTask->call('maintenance', rtrim( $this->taskContext->getURL(), "/" ) ) )
			->queue();

		wfRunHooks( "AfterWikiCreated", [ $this->taskContext->getCityId(), $this->taskContext->getStarterDb() ] );

		return TaskResult::createForSuccess( [ 'task_id' => $taskId ] );
	}
}

