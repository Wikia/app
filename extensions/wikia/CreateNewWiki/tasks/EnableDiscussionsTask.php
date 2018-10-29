<?php

namespace Wikia\CreateNewWiki\Tasks;

use \Wikia\Logger\WikiaLogger;

class EnableDiscussionsTask extends Task {

	public function run() {
		try {
			$this->activateDiscussions();
		} catch ( \Exception $e ) {
			$this->logException( $e );
		}

		return TaskResult::createForSuccess();
	}

	/**
	 * Creates a new instance of Discussions for this wiki.
	 */
	private function activateDiscussions() {
		( new \DiscussionsActivator(
			$this->taskContext->getCityId(),
			$this->taskContext->getSiteName(),
			$this->taskContext->getLanguage()
		) )->activateDiscussions();
	}

	private function logException( \Exception $e ) {
		WikiaLogger::instance()->error(
			'DISCUSSIONS Error while activating or enabling Discussions for new wiki',
			[
				'siteId' => $this->taskContext->getCityId(),
				'siteName' => $this->taskContext->getSiteName(),
				'exception' => $e
			]
		);
	}
}
