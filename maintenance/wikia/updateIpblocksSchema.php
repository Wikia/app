<?php

require_once __DIR__ . '/../Maintenance.php';

/**
 * Maintenance script to delete duplicate blocks from ipblocks table
 * and update table schema to enforce a stricter constraint
 *
 * @see https://wikia-inc.atlassian.net/browse/SUS-1563
 */
class UpdateIpblocksSchema extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->addOption( 'really-do-changes', 'Actually delete duplicate rows and update schema.' );
	}

	public function execute() {
		list( $allIds, $allIdsCount ) = $this->getDuplicateBlocks();

		if ( $this->hasOption( 'really-do-changes' ) ) {
			if ( $allIdsCount > 0 ) {
				$this->deleteDuplicateBlocks( $allIds, $allIdsCount );
			}

			$this->updateTableSchema();
		}
	}

	/**
	 * Load and print block IDs to be deleted
	 * @return array list of block IDs to be deleted and count of block IDs to be deleted
	 */
	private function getDuplicateBlocks(): array {
		/*
			SELECT GROUP_CONCAT(ipb_id) FROM ipblocks WHERE ipb_auto = 0 GROUP BY ipb_address, ipb_user HAVING count(*) > 1;
			+----+-------------+----------+------+---------------+------+---------+------+------+----------------+
			| id | select_type | table    | type | possible_keys | key  | key_len | ref  | rows | Extra          |
			+----+-------------+----------+------+---------------+------+---------+------+------+----------------+
			|  1 | SIMPLE      | ipblocks | ALL  | NULL          | NULL | NULL    | NULL |   72 | Using filesort |
			+----+-------------+----------+------+---------------+------+---------+------+------+----------------+
		 */
		$res = $this->getDB( DB_SLAVE )->select(
			'ipblocks',
			[
				'GROUP_CONCAT(ipb_id) AS duplicate_ids',
				'ipb_address',
				'ipb_user'
			],
			[ 'ipb_auto' => 0 ],
			__METHOD__,
			[
				'GROUP BY' => 'ipb_address, ipb_user',
				'HAVING' => 'count(*) > 1'
			]
		);

		$allIds = [];
		/** @var object $row */
		foreach ( $res as $row ) {
			$duplicates = str_getcsv( $row->duplicate_ids );

			// Remove the highest block ID (newest block) so that it is not deleted
			sort( $duplicates );
			$newest = array_pop( $duplicates );

			$this->output( "target: {$row->ipb_address}, duplicates: {$row->duplicate_ids}, preserve: $newest\n" );

			$allIds = array_merge( $allIds, $duplicates );
		}

		$allIdsCount = count( $allIds );
		if ( $allIdsCount > 0 ) {
			$this->output( "$allIdsCount block IDs to be deleted.\n" );
		} else {
			$this->output( "nothing to do" );
		}

		return [ $allIds, $allIdsCount ];
	}

	/**
	 * Delete the given block IDs from the database
	 *
	 * @param array $blockIds
	 * @param int $count
	 */
	private function deleteDuplicateBlocks( array $blockIds, int $count ) {
		$dbw = $this->getDB( DB_MASTER );
		$dbw->delete( 'ipblocks', [ 'ipb_id' => $blockIds ], __METHOD__ );

		$this->output( "Received {$count} IDs to delete, deleted {$dbw->affectedRows()} rows.\n" );

		wfWaitForSlaves();
	}

	/**
	 * Perform update on ipblocks table schema.
	 *
	 * We're removing existing constraint `ipb_address` and introducing a stricter one which requires non-autoblock targets to be unique
	 */
	private function updateTableSchema() {
		$sql = "ALTER TABLE ipblocks DROP INDEX `ipb_address`, ADD UNIQUE KEY `ipb_address_unique` (`ipb_address`(255),`ipb_user`,`ipb_auto`);";

		$res = $this->getDB( DB_MASTER )->query( $sql, __METHOD__ );
		wfWaitForSlaves();

		if ( $res ) {
			$this->output( "Successfully updated ipblocks table schema.\n" );
		} else {
			$this->error( "ailed to update ipblocks table schema!\n" );
		}
	}
}

$maintClass = UpdateIpblocksSchema::class;
require_once RUN_MAINTENANCE_IF_MAIN;
