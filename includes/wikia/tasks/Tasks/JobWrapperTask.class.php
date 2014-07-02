<?php
/**
 * JobWrapperTask
 *
 * Wrapper for core MediaWiki Job classes. This is useful so we can upgrade extensions without needing to re-migrate
 * its job changes to the new job queue.
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks\Tasks;


class JobWrapperTask extends BaseTask {
	protected $params;

	public function getAdminExecuteableMethods() {
		return [];
	}

	public function call() {
		global $wgCityId;

		list($command, $title, $this->params) = func_get_args();
		$this->wikiId($wgCityId); // jobs always run in the context of the wiki in which they're called
		$this->title($title);

		return parent::call('wrap', $command);
	}

	public function wrap($command) {
		$job = \Job::factory($command, $this->title, $this->params);
		return $job->run();
	}
}
