<?php

namespace Wikia\CreateNewWiki\Tasks;

use \Wikia\Logger\WikiaLogger;

class EnableDiscussionsTask extends Task {

	public function run() {
		try {
			$this->activateDiscussions();
			$this->enableDiscussions();
		} catch ( \Exception $e ) {
			WikiaLogger::instance()->error(
				'Error while activating or enabling Discussions for new community',
				[
					'cityId' => \F::app()->wg->CityId,
					'exception' => $e
				]
			);
		}

		return TaskResult::createForSuccess();
	}

	/**
	 * Creates a new instance of Discussions for this community.
	 */
	private function activateDiscussions() {
		( new \DiscussionsApi(
			$this->taskContext->getCityId(),
			$this->taskContext->getSiteName(),
			$this->taskContext->getLanguage()
		) )->activateDiscussions();
	}

	/**
	 * Sets the appropriate wg variables to make the new discussions
	 * instance enabled and available on this new wiki
	 */
	private function enableDiscussions() {
		( new \DiscussionsVarToggler( $this->taskContext->getCityId() ) )
			->setEnableDiscussions( true )
			->setEnableDiscussionsNav( true )
			->setEnableForums( false )
			->setArchiveWikiForums( true )
			->save();
	}
}
