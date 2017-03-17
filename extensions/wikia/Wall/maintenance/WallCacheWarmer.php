<?php
require_once __DIR__ . '/../../../../maintenance/Maintenance.php';

class WallCacheWarmer extends Maintenance {
	const BATCH_SIZE = 250;
	private $threadIds = [];

	public function __construct() {
		parent::__construct();

		$this->addOption( 'dry-run', 'Don\'t make any changes - just list number of threads and cache entries.' );
	}

	public function execute() {
		require_once __DIR__ . '/RecachedWallThread.php';

		if ( !$this->hasOption( 'dry-run' ) ) {
			$this->warmThreadCache();
			$this->verifyCache();
		} else {
			$this->printCountOfThreadsAndEntries();
		}
	}

	private function printCountOfThreadsAndEntries() {
		global $wgMemc;

		$offset = 0;
		$threadCount = 0;
		$cachedThreadCount = 0;
		while ( ( $res = $this->getWallThreads( $offset ) ) ) {
			foreach ( $res as $threadId ) {
				$wallThread = WallThread::newFromId( $threadId );
				$cacheKey = $wallThread->getThreadKey();

				if ( $wgMemc->get( $cacheKey ) ) {
					$cachedThreadCount++;
				}

				$threadCount++;
			}

			$offset += static::BATCH_SIZE;
		}

		$this->output( "Found $threadCount threads, of which $cachedThreadCount have memcache entry." );
	}

	private function warmThreadCache() {
		$offset = 0;
		while ( ( $res = $this->getWallThreads( $offset ) ) ) {
			foreach ( $res as $threadId ) {
				$wallThread = RecachedWallThread::newFromId( $threadId );
				$wallThread->getRepliesWallMessages();

				$this->threadIds[] = $threadId;
			}

			$offset += static::BATCH_SIZE;
		}
	}

	private function verifyCache() {
		global $wgMemc;

		$success = 0;
		$failed = 0;
		foreach ( $this->threadIds as $threadId ) {
			$oldVersionKey = WallThread::newFromId( $threadId )->getThreadKey();
			$oldVersion = $wgMemc->get( $oldVersionKey );

			if ( $oldVersion ) {
				$newVersionKey = RecachedWallThread::newFromId( $threadId )->getThreadKey();
				$newVersion = $wgMemc->get( $newVersionKey );

				if ( $newVersion ) {
					$success++;
				} else {
					$failed++;
				}
			}
		}

		$this->output( "Successfully warmed up $success new entries; failed to warm up $failed entries." );
	}

	private function getWallThreads( int $offset ) {
		return $this->getDB( DB_SLAVE )
			->selectFieldValues(
				'comments_index',
				'comment_id',
				[
					'parent_comment_id' => 0
				],
				__METHOD__,
				[
					'LIMIT' => static::BATCH_SIZE,
					'OFFSET' => $offset
				]
			);
	}
}

$maintClass = WallCacheWarmer::class;
require_once RUN_MAINTENANCE_IF_MAIN;
