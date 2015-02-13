<?php
/**
 * Maintenance script for adding poweruser_frequent property
 * for users that have made more than 140 edits in the last 60 days.
 *
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 *
 *
 */

require_once( __DIR__.'/../../../../maintenance/Maintenance.php' );

use Wikia\PowerUser\PowerUser;

class PowerUserAddFrequentMaintenance extends Maintenance {
	const PERIOD_INTERVAL = '-60 days';

	/**
	 * Do the actual work. All child classes will need to implement this
	 */
	public function execute() {
		$aPotentialPowerUsersIds = $this->getPotentialNewFrequentPowerUsers();
		foreach ( $aPotentialPowerUsersIds as $iUserId ) {
			if ( $this->isNewFrequentPowerUser( $iUserId ) ) {
				$oPowerUser = new PowerUser( User::newFromId( $iUserId ) );
				$oPowerUser->addPowerUserProperty( PowerUser::TYPE_FREQUENT );
			}
		}
	}

	private function getPotentialNewFrequentPowerUsers() {
		global $wgExternalSharedDB;
		$oDB = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		$oSubQuery = ( new WikiaSQL() )
			->SELECT( 'up_user' )
			->FROM( 'user_properties' )
			->WHERE( 'up_property' )->EQUAL_TO( PowerUser::TYPE_FREQUENT )
			->AND_( 'up_value' )->EQUAL_TO( '1' );

		$aPotentialPowerUsersIds = ( new WikiaSQL() )->cacheGlobal( WikiaResponse::CACHE_STANDARD )
			->SELECT( 'user_id' )
			->FROM( 'user' )
			->WHERE( 'user_editcount' )->GREATER_THAN_OR_EQUAL( PowerUser::MIN_FREQUENT_EDITS )
			->AND_( null )
				->NOT_EXISTS( $oSubQuery )
			->ORDER_BY( [ 'user_id', 'DESC' ] )
			->runLoop( $oDB, function( &$aPotentialPowerUsersIds, $oRow ) {
				$aPotentialPowerUsersIds[] = $oRow->user_id;
			});

		return $aPotentialPowerUsersIds;
	}

	private function isNewFrequentPowerUser( $iUserId ) {
		global $wgDWStatsDB;
		$oDB = wfGetDB( DB_MASTER, [], $wgDWStatsDB );
		$sCurrentPeriodBeginning = date( 'Y-m-d H:i:s', strtotime( self::PERIOD_INTERVAL ) );

		$iCurrentPeriodEdits = ( new WikiaSQL() )
			->SELECT( 'user_id' )
			->SUM( 'edits' )->AS_( 'edits' )
			->FROM( 'rollup_wiki_user_events' )
			->WHERE( 'user_id' )->EQUAL_TO( $iUserId )
			->AND_( 'time_id' )->GREATER_THAN_OR_EQUAL( $sCurrentPeriodBeginning )
			->AND_( 'period_id' )->EQUAL_TO( DataMartService::PERIOD_ID_DAILY )
			->runLoop( $oDB, function( &$iCurrentPeriodEdits, $oRow ) {
				$iCurrentPeriodEdits = intval( $oRow->edits );
			} );

		return ( $iCurrentPeriodEdits >= PowerUser::MIN_FREQUENT_EDITS );
	}
}

$maintClass = "PowerUserAddFrequentMaintenance";
require_once( RUN_MAINTENANCE_IF_MAIN );
