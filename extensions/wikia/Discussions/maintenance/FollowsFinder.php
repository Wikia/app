<?php


namespace Discussions;

use DumpForumData;

class FollowsFinder {

	const TABLE_THREAD_WATCHER = 'watchlist';

	const FOLLOWER_ID = "follower_id";
	const MW_THREAD_ID = "mw_thread_id";

	const COLUMNS_FOLLOWS = [
		self::FOLLOWER_ID,
		self::MW_THREAD_ID,
	];

	private $threadNameToId;

	public function __construct( $threadNameToId ) {
		$this->threadNameToId = $threadNameToId;
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
			$dbh = DumpForumData::getDBSafe( DB_SLAVE );
			$dbh->ping();
			( new \WikiaSQL() )->SELECT_ALL()
				->FROM( self::TABLE_THREAD_WATCHER )
				->WHERE( 'wl_namespace' )
				->EQUAL_TO( NS_WIKIA_FORUM_BOARD_THREAD )
				->AND_( 'wl_title' )
				->IN( $part )
				->runLoop( $dbh, function ( $result ) use ( $dbh, $fh ) {

					while ($row = $result->fetchObject()) {
						$insert = DumpForumData::createInsert(
							'import_follows',
							self::COLUMNS_FOLLOWS,
							[
								self::FOLLOWER_ID => $row->wl_user,
								self::MW_THREAD_ID => $this->threadNameToId[$row->wl_title],
							]
						);
						fwrite( $fh, $insert . "\n");
					}

					$dbh->freeResult( $result );
				}, [], false );

			$dbh->closeConnection();
			wfGetLB( false )->closeConnection( $dbh );
		}

		return [];
	}
}
