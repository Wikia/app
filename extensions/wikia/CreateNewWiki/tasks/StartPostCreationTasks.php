<?php

namespace Wikia\CreateNewWiki\Tasks;

use Wikia\Logger\Loggable;
use Wikia\Tasks\AsyncTaskList;
use Wikia\Tasks\Tasks\CreateNewWikiTask;

class StartPostCreationTasks extends Task {

	use Loggable;

	public function run() {
		$creationTask = new CreateNewWikiTask();

		$jobParams = [];
		$jobParams['url'] = $this->taskContext->getURL();
		$jobParams['founderId'] = $this->taskContext->getFounder()->getId();
		$jobParams['founderName'] = $this->taskContext->getFounder()->getName();
		$jobParams['sitename'] = $this->taskContext->getSiteName();
		$jobParams['language'] = $this->taskContext->getLanguage();
		$jobParams['city_id'] = $this->taskContext->getCityId();

		// Used by CreateNewWikiTask:changeStarterContributions
		$jobParams['sDbStarter'] = $this->taskContext->getStarterDb();

		$taskId = (new AsyncTaskList())
			->wikiId( $this->taskContext->getCityId() )
			->prioritize()
			->add($creationTask->call('postCreationSetup', $jobParams))
			->add($creationTask->call('maintenance', rtrim( $this->taskContext->getURL(), "/" ) ) )
			->queue();

		wfRunHooks( "AfterWikiCreated", [ $this->taskContext->getCityId(), $this->taskContext->getStarterDb() ] );

		return TaskResult::createForSuccess( [ 'task_id' => $taskId ] );
	}
}

