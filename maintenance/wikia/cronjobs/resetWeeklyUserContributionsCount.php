<?php
/**
 * On Special:Community we have weekly users rank with most contributions.
 * We need to reset it after every Sunday.
 *
 * @group cronjobs
 * @see reset-weekly-user-contributions.yaml
 */

require_once __DIR__ . '/../../Maintenance.php';

class ResetWeeklyUserContributionsCount extends Maintenance {

	use Wikia\Logger\Loggable;

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'reset weekly user contribution count';
	}

	public function execute() {
		global $wgCityId, $wgEnableCommunityPageExt;

		$dbw = wfGetDB( DB_MASTER );

		$userIds = $dbw->selectFieldValues(
			'wikia_user_properties',
			'wup_user',
			[ 'wup_property' => 'editcountThisWeek' ],
			__METHOD__
		);

		$this->info( 'select users', [
			'users' => count( $userIds ),
			'query' => $dbw->lastQuery()
		] );

		$result = $dbw->delete(
			'wikia_user_properties',
			[ 'wup_property' => 'editcountThisWeek' ],
			__METHOD__
		);

		if ( $result === false ) {
			$this->error( 'error while deleting entries', [ 'query' => $dbw->lastQuery() ] );
		} else {
			$this->info( 'deleted entries', [
				'users' => $dbw->affectedRows(),
				'query' => $dbw->lastQuery()
			] );

			foreach ( $userIds as $id ) {
				UserStatsService::purgeOptionsWikiCache( $id, $wgCityId );
			}

			if ( $wgEnableCommunityPageExt ) {
				WikiaDataAccess::cachePurge( wfMemcKey( CommunityPageSpecialUsersModel::TOP_CONTRIB_MCACHE_KEY ) );
			}
		}

		$this->info( 'done' );
	}
}

$maintClass = 'ResetWeeklyUserContributionsCount';
require_once RUN_MAINTENANCE_IF_MAIN;
