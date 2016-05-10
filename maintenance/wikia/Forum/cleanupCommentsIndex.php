<?php
/**
 * Cleanup the dangling references in comments_index.
 * https://wikia-inc.atlassian.net/browse/CONN-506
 */

class CleanupCommentsIndex {

	/**
	 * Runner. See maintenance/wikia/runOnCluster.php
	 *
	 * If --test is given checks to see if there are any bad comments_index rows. OTW, runs the fix
	 * which marks those rows with deleted = 1.
	 *
	 */
	public static function run( DatabaseBase $db, $test = false, $verbose = false, $params ) {
		$dbname = $params['dbname'];

		if ( !self::commentsIndexExists( $db) ) {
			return;
		}

		if ( $test ) {
			self::checkCommentsIndex( $db, $dbname );
		} else {
			self::fixCommentsIndex( $db, $dbname );
		}

	}

	/**
	 * Check the comments_index table for bad records. Emits a line to STDOUT
	 * indicating the how many were found.
	 *
	 * @param DatabaseBase $db the db handle
	 * @param string $dbname the database name
	 */
	public static function checkCommentsIndex( DatabaseBase $db, $dbname ) {
		$sql = <<<SQL
		SELECT COUNT(*) AS count
		FROM comments_index
		LEFT JOIN revision ON (
		 revision.rev_id = comments_index.first_rev_id
		)
		WHERE comments_index.removed = 0 AND
			comments_index.deleted = 0 AND
			comments_index.archived = 0 AND
			revision.rev_id IS NULL
SQL;
		$ret = $db->query( $sql );
		$row = $db->fetchObject( $ret );
		printf("%s: Found %d bad comments_index rows.\n", $dbname, $row->count);
	}

	/**
	 * Fixes the bad rows in the comments_index table by marking them with deleted=1.
	 *
	 * @param DatabaseBase $db the db handle
	 * @param string $dbname the database name
	 */
	public function fixCommentsIndex( DatabaseBase $db, $dbname ) {
		printf("%s: fixing bad comments_index rows...\n", $dbname);

		$sql = <<<SQL
		CREATE TEMPORARY TABLE temporary_bad_comments_index_records AS (
			SELECT parent_page_id, first_rev_id, removed, deleted, archived
			FROM comments_index
			LEFT JOIN revision ON (
				revision.rev_id = comments_index.first_rev_id
			)
			WHERE comments_index.removed = 0 AND
				comments_index.deleted = 0 AND
				comments_index.archived = 0 AND
				revision.rev_id IS NULL
		);
SQL;
		$db->query($sql);
		$row = $db->fetchObject( $ret );

		$sql = <<<SQL
		UPDATE comments_index, temporary_bad_comments_index_records
			SET comments_index.deleted = 1
			WHERE comments_index.parent_page_id = temporary_bad_comments_index_records.parent_page_id AND
				comments_index.first_rev_id = temporary_bad_comments_index_records.first_rev_id;
SQL;
		$db->query($sql);
		$row = $db->fetchObject( $ret );
	}

	/**
	 * Check to see if the comments_index table exists.
	 *
	 * @param DatabaseBase $db the db handle
	 */
	public static function commentsIndexExists( DatabaseBase $db ) {
		return $db->query("SHOW TABLES LIKE 'comments_index'")->numRows() > 0;
	}
}
