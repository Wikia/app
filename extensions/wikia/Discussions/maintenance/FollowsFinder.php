<?php


namespace Discussions;

use DumpUtils;

class FollowsFinder {

	const TABLE_THREAD_WATCHER = 'watchlist';

	const FOLLOWER_ID = "follower_id";
	const MW_THREAD_ID = "mw_thread_id";

	const COLUMNS_FOLLOWS = [
		self::FOLLOWER_ID,
		self::MW_THREAD_ID,
	];

	private $threadNameToId;
	private $bulk;

	public function __construct( $threadNameToId, $bulk = false ) {
		$this->threadNameToId = $threadNameToId;
		$this->bulk = $bulk;
	}

	/**
	 * Watchlist
	 * +--------------------------+------------------+------+-----+-------------------+-------+
	 * | Field                    | Type             | Null | Key | Default           | Extra |
	 * +--------------------------+------------------+------+-----+-------------------+-------+
	 * | wl_user                  | int(10) unsigned | NO   | PRI | NULL              |       |
	 * | wl_namespace             | int(11)          | NO   | PRI | 0                 |       |
	 * | wl_title                 | varchar(255)     | NO   | PRI |                   |       |
	 * | wl_notificationtimestamp | varbinary(14)    | YES  |     | NULL              |       |
	 * | wl_wikia_addedtimestamp  | timestamp        | YES  | MUL | CURRENT_TIMESTAMP |       |
	 * +--------------------------+------------------+------+-----+-------------------+-------+
	 */
	public function findFollows( $fh ) {
		$pageTitles = array_keys( $this->threadNameToId );
		$pageTitlesChunks = array_chunk($pageTitles, 100);

		$dbh = wfGetDB( DB_SLAVE );
		$dbh->ping();

		if (!$dbh->tableExists(self::TABLE_THREAD_WATCHER)) {
			return [];
		}

		foreach($pageTitlesChunks as $part) {
			$dbh = DumpUtils::getDBWithRetries( DB_SLAVE );
			$dbh->ping();
			$inserts = [];
			( new \WikiaSQL() )->SELECT_ALL()
				->FROM( self::TABLE_THREAD_WATCHER )
				->WHERE( 'wl_namespace' )
				->EQUAL_TO( NS_WIKIA_FORUM_BOARD_THREAD )
				->AND_( 'wl_title' )
				->IN( $part )
				->runLoop( $dbh, function ( $result ) use ( $dbh, $fh, &$inserts ) {

					while ($row = $result->fetchObject()) {
						$insert = DumpUtils::createInsert(
							'import_follows',
							self::COLUMNS_FOLLOWS,
							[
								self::FOLLOWER_ID => $row->wl_user,
								self::MW_THREAD_ID => $this->threadNameToId[$row->wl_title],
							]
						);

						$inserts[] = $insert;

						if ( !$this->bulk ) {
							fwrite( $fh, $insert . "\n");
							fflush( $fh );
						}
					}

					$dbh->freeResult( $result );
				}, [], false );

			$dbh->closeConnection();
			wfGetLB( false )->closeConnection( $dbh );

			if ( $this->bulk && !empty( $inserts )) {
				$chunks = array_chunk( $inserts, 100 );
				foreach ( $chunks as $chunk ) {
					$multiInsert = DumpUtils::createMultiInsert('import_follows',
							self::COLUMNS_FOLLOWS, $chunk) . "\n";
					fwrite( $fh, $multiInsert );
					fflush( $fh );
					unset( $multiInsert );
				}
			}

			unset( $inserts );
		}

		return [];
	}
}
