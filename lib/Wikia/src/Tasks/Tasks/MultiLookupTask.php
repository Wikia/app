<?php
namespace Wikia\Tasks\Tasks;

/**
 * Class MultiLookupTask updates the MultiLookup entry for an IP address if it edits on a wiki
 * @package Wikia\Tasks\Tasks
 */
class MultiLookupTask extends BaseTask {
	public function updateMultiLookup( string $ip ) {
		global $wgSpecialsDB;

		$dbw = wfGetDB( DB_MASTER, [], $wgSpecialsDB );

		$now = $dbw->timestamp( wfTimestampNow() );
		$row = [
			'ml_city_id' => $this->getWikiId(),
			'ml_ip_bin' => inet_pton( $ip ),
			'ml_ts' => $now
		];

		$dbw->upsert( 'multilookup', $row, [], [ 'ml_ts' => $now ], __METHOD__ );
	}
}
