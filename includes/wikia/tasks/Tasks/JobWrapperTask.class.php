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

		switch ( func_num_args() ) {
			case 2: // command, title, no params
				list( $command, $title ) = func_get_args();
				break;
			case 3: // command, title, params
				list( $command, $title, $this->params ) = func_get_args();
				break;
			default:
				throw new \InvalidArgumentException;
		}

		$this->wikiId( $wgCityId ); // jobs always run in the context of the wiki in which they're called
		$this->title( $title );

		return parent::call( 'wrap', $command );
	}

	public function wrap( $command ) {
		$job = \Job::factory( $command, $this->title, $this->params );
		return $job->run();
	}
}
