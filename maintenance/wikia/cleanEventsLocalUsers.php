<?php

require_once( __DIR__ . '/../Maintenance.php' );

/**
 * Remove incorrect entries from specials.events_local_users
 *
 * @see PLATFORM-2061
 * @see PLATFORM-2094
 */
class CleanEventsLocalUsersMaintenance extends Maintenance {

	const TABLE_NAME = 'events_local_users';

	public function execute() {
		$this->removeIncorrectUsers();
		#$this->removeBogusRows();
	}

	public function removeIncorrectUsers() {
		global $wgCityId, $wgSpecialsDB;
		$dbw = $this->getDB( DB_MASTER, [], $wgSpecialsDB );

		// select user_id, user_name from events_local_users where wiki_id = 878889;
		$res = $dbw->select(
			self::TABLE_NAME,
			'user_id, user_name',
			[
				'wiki_id' => $wgCityId
			],
			__METHOD__
		);

		while ( $row = $res->fetchRow() ) {
			$user_name = User::newFromId( $row['user_id'] )->getName();

			// user_id and user_name do not match, remove this entry
			if ( $user_name !== $row['user_name'] ) {
				$dbw->delete(
					self::TABLE_NAME,
					[
						// PRIMARY KEY (`wiki_id`,`user_id`,`user_name`)
						'wiki_id' => $wgCityId,
						'user_id' => $row['user_id'],
						'user_name' => $row['user_name']
					],
					__METHOD__
				);

				Wikia\Logger\WikiaLogger::instance()->info( __METHOD__ . ' - row removed', [
					'city_id' => $wgCityId,
					'user_id' => $row['user_id'],
					'user_name' => $row['user_name'],
				] );

				$this->output( sprintf ("Removed an entry for user #%d (%s)\n", $row['user_id'], $row['user_name'] ) );
			}
		}

		wfWaitForSlaves( $wgSpecialsDB );
	}

	public function removeBogusRows() {
		global $wgCityId, $wgSpecialsDB;

		$dbw = $this->getDB( DB_MASTER, [], $wgSpecialsDB );
		$dbw->query(
			sprintf( "DELETE FROM events_local_users where wiki_id = '%d' and (user_name = '0' OR all_groups = '0' OR single_group = '0' OR cnt_groups > 20 OR user_is_blocked > 1 OR (last_revision = 0 AND edits > 0) OR (last_revision > 0 AND edits = 0) OR (editdate = '0000-00-00 00:00:00' AND edits > 0))", $wgCityId ),
			__METHOD__
		);

		$this->output( sprintf ("Rows removed: %d\n", $dbw->affectedRows() ) );

		wfWaitForSlaves( $wgSpecialsDB );
	}
}

$maintClass = CleanEventsLocalUsersMaintenance::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
