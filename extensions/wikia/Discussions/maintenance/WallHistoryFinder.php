<?php

namespace Discussions;

use DumpUtils;

class WallHistoryFinder {

	const TABLE_WALL_HISTORY = 'wall_history';

	const COLUMNS = [
		'revision_id',
		'comment_id',
		'event_date',
		'action',
		'is_reply',
		'post_user_id',
	];
	private $pageIdsInNamespace;
	private $bulk;

	public function __construct( $pageIdsInNamespace, $bulk = false ) {
		$this->pageIdsInNamespace = $pageIdsInNamespace;
		$this->bulk = $bulk;
	}

	/**
	 * Wall_history
	 * +-------------------+------------------+------+-----+-------------------+-------+
	 * | Field             | Type             | Null | Key | Default           | Extra |
	 * +-------------------+------------------+------+-----+-------------------+-------+
	 * | parent_page_id    | int(8) unsigned  | YES  | MUL | NULL              |       |
	 * | post_user_id      | int(10) unsigned | YES  |     | NULL              |       |
	 * | post_user_ip_bin  | varbinary(16)    | YES  |     | NULL              |       |
	 * | is_reply          | tinyint(1)       | YES  |     | NULL              |       |
	 * | action            | tinyint(3)       | YES  |     | NULL              |       |
	 * | metatitle         | varchar(201)     | YES  |     | NULL              |       |
	 * | reason            | varchar(101)     | YES  |     | NULL              |       |
	 * | parent_comment_id | int(8) unsigned  | YES  | MUL | NULL              |       |
	 * | comment_id        | int(8) unsigned  | YES  | MUL | NULL              |       |
	 * | revision_id       | int(8) unsigned  | YES  |     | NULL              |       |
	 * | event_date        | timestamp        | NO   |     | CURRENT_TIMESTAMP |       |
	 * +-------------------+------------------+------+-----+-------------------+-------+
	 *
	 * Page
	 * +-------------------+---------------------+------+-----+----------------+----------------+
	 * | Field             | Type                | Null | Key | Default        | Extra          |
	 * +-------------------+---------------------+------+-----+----------------+----------------+
	 * | page_id           | int(10) unsigned    | NO   | PRI | NULL           | auto_increment |
	 * | page_namespace    | int(10) unsigned    | NO   | MUL | NULL           |                |
	 * | page_title        | varchar(255)        | NO   |     | NULL           |                |
	 * | page_restrictions | tinyblob            | NO   |     | NULL           |                |
	 * | page_is_redirect  | tinyint(3) unsigned | NO   | MUL | 0              |                |
	 * | page_is_new       | tinyint(3) unsigned | NO   |     | 0              |                |
	 * | page_random       | double unsigned     | NO   | MUL | NULL           |                |
	 * | page_touched      | binary(14)          | NO   |     |                |                |
	 * | page_latest       | int(10) unsigned    | NO   |     | NULL           |                |
	 * | page_len          | int(10) unsigned    | NO   | MUL | NULL           |                |
	 * +-------------------+---------------------+------+-----+----------------+----------------+
	 */
	public function find( $fh ) {
		$pageIdsChunks = array_chunk($this->pageIdsInNamespace, 500);

		foreach ($pageIdsChunks as $part) {
			$dbh = DumpUtils::getDBWithRetries( DB_SLAVE );
			$dbh->ping();
			$inserts = [];
			( new \WikiaSQL() )->SELECT( ...self::COLUMNS )
				->FROM( self::TABLE_WALL_HISTORY )
				->WHERE( 'parent_page_id' )
				->IN( $part )
				->runLoop( $dbh, function ( $result ) use ( $dbh, $fh, &$inserts ) {

					while ($row = $result->fetchObject()) {
						$insert = DumpUtils::createInsert(
							'import_history',
							self::COLUMNS,
							[
								'revision_id' => $row->revision_id,
								'comment_id' => $row->comment_id,
								'event_date' => $row->event_date,
								'action' => $row->action,
								'is_reply' => $row->is_reply,
								'post_user_id' => $row->post_user_id,
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
					$multiInsert = DumpUtils::createMultiInsert('import_history',
							self::COLUMNS, $chunk) . "\n";
					fwrite( $fh, $multiInsert );
					fflush( $fh );
					unset( $multiInsert );
				}
			}

			unset( $inserts );
		}
	}

}
