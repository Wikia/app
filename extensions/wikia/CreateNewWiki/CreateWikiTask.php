<?php
/**
 * CreateWiki Celery task responsible for creating and setting up  wiki
 *
 * @see SUS-4383
 */

use Wikia\Tasks\Tasks\BaseTask;
use Wikia\CreateNewWiki\Tasks\TaskContext;

class CreateWikiTask extends BaseTask {

	const CREATION_LOG_TABLE = 'city_creation_log';

	// we waited enough for the task to start, fail after a minute
	const TASK_CREATION_DELAY_THRESHOLD = 60;

	private static function getDB( int $type = DB_SLAVE ) {
		global $wgExternalSharedDB;
		return wfGetDB( $type, [], $wgExternalSharedDB );
	}

	private static function addCreationLogEntry( string $task_id ) : int {
		$dbw = self::getDB( DB_MASTER );

		$dbw->insert(
			self::CREATION_LOG_TABLE,
			[
				'task_id' => $task_id
			],
			__METHOD__
		);

		return $dbw->insertId();
	}

	public static function updateCreationLogEntry( string $task_id, array $data ) {
		self::getDB( DB_MASTER )->update(
			self::CREATION_LOG_TABLE,
			$data,
			[
				'task_id' => $task_id
			],
			__METHOD__
		);
	}

	public static function getCreationLogEntry( string $task_id ) {
		return self::getDB( DB_SLAVE )->selectRow(
			self::CREATION_LOG_TABLE,
			[ 'city_id', 'completed', 'creation_started', 'creation_ended', 'exception_message' ],
			[
				'task_id' => $task_id
			],
			__METHOD__
		);
	}

	/**
	 * @param int $timestamp
	 * @throws CreateWikiException
	 */
	private function validateTimestamp( int $timestamp ) {
		$delay = time() - $timestamp;
		if ( $delay > self::TASK_CREATION_DELAY_THRESHOLD ) {
			// we waited enough for the task to start, fail after a minute
			throw new CreateWikiException( "TASK_CREATION_DELAY_THRESHOLD exceeded, delay was $delay seconds" );
		}
	}

	/**
	 * Create a new wiki with given parameters
	 *
	 * @param string $name
	 * @param string $domain
	 * @param string $language
	 * @param int $vertical
	 * @param string $description
	 * @param string[] $categories
	 * @param bool $allAges
	 * @param int $timestamp when was the task scheduled
	 * @param string $ip IP address of a user that is creating the wiki
	 * @param string $fandomCreatorCommunityId
	 * @throws Exception an exception with status of operation set
	 */
	public function create( string $name, string $domain, string $language, int $vertical, string $description,
	                        array $categories, bool $allAges, int $timestamp, string $ip, string $fandomCreatorCommunityId = null ) {
		wfProfileIn( __METHOD__ );

		// SUS-4838 | add an entry to creation log
		// front-end code with poll for the status using this table
		self::addCreationLogEntry( $this->getTaskId() );

		// work on behalf of a user who wants to create a wiki
		global $wgUser;
		$wgUser = $this->createdByUser();

		$then = microtime( true );

		$context = TaskContext::newFromUserInput( $name, $domain, $language, $vertical, $description, $categories, $allAges, $this->getTaskId(), $ip, $fandomCreatorCommunityId );

		$context->setFounder( $wgUser );

		$taskRunner = new Wikia\CreateNewWiki\Tasks\TaskRunner( $context );

		try {

			$this->validateTimestamp( $timestamp );

			$taskRunner->prepare();

			$taskRunner->check();

			$taskRunner->run();

		} catch ( Exception $ex ) {
			// SUS-4383 | mark the wiki as not fully created and log the exception message
			self::updateCreationLogEntry( $this->getTaskId(), [
				'creation_ended' => wfTimestamp( TS_DB ),
				'completed' => 0,
				'exception_message' => substr( $ex->getMessage(), 0, 255 ),
			] );

			throw $ex;
		}

		// SUS-4383 | log the CreateNewWiki process time
		$this->info( __METHOD__, [
			'took' => microtime( true ) - $then, // [sec]
		] );

		// SUS-4383 | mark the wiki as created
		self::updateCreationLogEntry( $this->getTaskId(), [
			'creation_ended' => wfTimestamp( TS_DB ),
			'completed' => 1,
		] );

		wfProfileOut( __METHOD__ );
	}
}
