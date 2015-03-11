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

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

use Wikia\PowerUser\PowerUser;

class PowerUserAddFrequentMaintenance extends Maintenance {
	const PERIOD_INTERVAL = '-60 days';

	/**
	 * Workflow:
	 * 1. Get potential new PowerUsers of a type frequent
	 *    (min. of edits and a poweruser property set to false)
	 * 2. Check each one against statsdb/rollup_wiki_user_events
	 * 3. Add the property to the new frequent PUs
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

	/**
	 * Gets an array of IDs of potential new frequebt PowerUsers
	 * who has made a minimum of frequent edits overall and
	 * are not PUs yet
	 *
	 * @return Array An array of potential PUs IDs
	 */
	private function getPotentialNewFrequentPowerUsers() {
		global $wgExternalSharedDB;
		$oDB = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		$oSubQuery = ( new WikiaSQL() )
			->SELECT( 'up_user' )
			->FROM( 'user_properties' )
			->WHERE( 'user_id' )->EQUAL_TO_FIELD( 'up_user' )
			->AND_( 'up_property' )->EQUAL_TO( PowerUser::TYPE_FREQUENT )
			->AND_( 'up_value' )->EQUAL_TO( '1' );

		$aPotentialPowerUsersIds = ( new WikiaSQL() )
			->SELECT( 'user_id' )
			->FROM( 'user' )
			->WHERE( 'user_editcount' )->GREATER_THAN_OR_EQUAL( PowerUser::MIN_FREQUENT_EDITS )
			->AND_( null )->NOT_EXISTS( $oSubQuery )
			->ORDER_BY( [ 'user_id', 'DESC' ] )
			->runLoop( $oDB, function( &$aPotentialPowerUsersIds, $oRow ) {
				$aPotentialPowerUsersIds[] = $oRow->user_id;
			} );

		return $aPotentialPowerUsersIds;
	}

	/**
	 * Checks if a user has made a minimum of edits
	 * in a specified period.
	 *
	 * @param int $iUserId A user's ID
	 * @return bool
	 * @throws Exception
	 *
	 */
	private function isNewFrequentPowerUser( $iUserId ) {
		global $wgDWStatsDB;
		$oDB = wfGetDB( DB_SLAVE, [], $wgDWStatsDB );
		$sCurrentPeriodBeginning = date( 'Y-m-d H:i:s', strtotime( self::PERIOD_INTERVAL ) );

		$iCurrentPeriodEdits = ( new WikiaSQL() )
			->SELECT( 'user_id' )
			->SUM( 'edits' )->AS_( 'edits' )
			->SUM( 'creates' )->AS_( 'creates' )
			->FROM( 'rollup_wiki_user_events' )
			->WHERE( 'user_id' )->EQUAL_TO( $iUserId )
			->AND_( 'time_id' )->GREATER_THAN_OR_EQUAL( $sCurrentPeriodBeginning )
			->AND_( 'period_id' )->EQUAL_TO( DataMartService::PERIOD_ID_DAILY )
			->runLoop( $oDB, function( &$iCurrentPeriodEdits, $oRow ) {
				$iEdits = intval( $oRow->edits );
				$iCreates = intval( $oRow->creates );
				$iCurrentPeriodEdits = $iCreates + $iEdits;
			} );

		return ( $iCurrentPeriodEdits >= PowerUser::MIN_FREQUENT_EDITS );
	}
}

$maintClass = 'PowerUserAddFrequentMaintenance';
require_once( RUN_MAINTENANCE_IF_MAIN );
