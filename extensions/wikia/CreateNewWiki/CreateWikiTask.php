<?php
/**
 * CreateWiki Celery task responsible for creating and setting up  wiki
 *
 * @see SUS-4383
 */

use Wikia\Tasks\Tasks\BaseTask;
use Wikia\CreateNewWiki\Tasks\TaskContext;

class CreateWikiTask extends BaseTask {

	/**
	 * Create a new wiki with given parameters
	 *
	 * @param string $name
	 * @param string $domain
	 * @param string $language
	 * @param int $vertical
	 * @param string[] $categories
	 * @throw CreateWikiException an exception with status of operation set
	 */
	public function create( string $name, string $domain, string $language, int $vertical, array $categories ) {
		wfProfileIn( __METHOD__ );

		// work on behalf of a user who wants to create a wiki
		global $wgUser;
		$wgUser = $this->createdByUser();

		$then = microtime( true );

		$context = TaskContext::newFromUserInput( $name, $domain, $language, $vertical, $categories );

		$taskRunner = new Wikia\CreateNewWiki\Tasks\TaskRunner( $context );

		$taskRunner->prepare();

		$taskRunner->check();

		$taskRunner->run();

		// SUS-4383 | log the CreateNewWiki process time
		$this->info( __METHOD__, [
			'took' => microtime( true ) - $then, // [sec]
		] );

		wfProfileOut( __METHOD__ );
	}
}
