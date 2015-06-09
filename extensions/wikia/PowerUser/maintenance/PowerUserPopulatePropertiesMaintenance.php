<?php
/**
 * Maintenance script for populating user_properties tables
 * with initial data on power users.
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

class PowerUserPopulatePropertiesMaintenance extends Maintenance {

	private
		$iPowerUsersLifetimeCounter = 0,
		$iPowerUsersAdminCounter = 0;

	/**
	 * Workflow:
	 * 1. Populate the table with PowerUser properties of a lifetime type
	 * 2. Populate the table with PowerUser properties of an admin type
	 */
	public function execute() {
		$this->output( "Populating with PowerUsers for lifetime edits... \n" );
		$this->populatePowerUsersLifetime();
		$this->output( "Populating with PowerUsers for admin rights... \n" );
		$this->populatePowerUsersAdmin();
	}

	private function populatePowerUsersLifetime() {
		global $wgExternalSharedDB;
		$oDB = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		$aPowerUsersLifetimeIds = ( new WikiaSQL() )
			->SELECT( 'user_id' )
			->FROM( 'user' )
			->WHERE( 'user_editcount' )->GREATER_THAN_OR_EQUAL( PowerUser::MIN_LIFETIME_EDITS )
			->runLoop( $oDB, function( &$aPowerUsersLifetimeIds, $oRow ) {
				$oPowerUser = new PowerUser( User::newFromId( $oRow->user_id ) );
				if ( $oPowerUser->addPowerUserProperty( PowerUser::TYPE_LIFETIME ) ) {
					$this->iPowerUsersLifetimeCounter++;
				}
			} );

		$this->output( "PowerUsers for lifetime edits populated! Count: {$this->iPowerUsersLifetimeCounter}\n" );
	}

	private function populatePowerUsersAdmin() {
		global $wgSpecialsDB;
		$oDB = wfGetDB( DB_SLAVE, [], $wgSpecialsDB );

		$aPowerUsersAdminIds = ( new WikiaSQL() )
			->SELECT( 'user_id' )
			->FROM( 'events_local_users' )
			->WHERE( 'all_groups' )->LIKE( 'sysop' )
			->GROUP_BY( 'user_id' )
			->runLoop( $oDB, function( &$aPowerUsersAdminIds, $oRow ) {
				$oPowerUser = new PowerUser( User::newFromId( $oRow->city_id ) );
				if ( $oPowerUser->addPowerUserProperty( PowerUser::TYPE_ADMIN ) ) {
					$this->iPowerUsersAdminCounter++;
				}
			} );

		$this->output( "PowerUsers for lifetime edits populated! Count: {$this->iPowerUsersAdminCounter}\n" );
	}
}

$maintClass = 'PowerUserPopulatePropertiesMaintenance';
require_once( RUN_MAINTENANCE_IF_MAIN );
