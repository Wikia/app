<?php
/**
 * Maintenance script for removing poweruser_admin
 * property if a user lost his sysop rights.
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

class PowerUserRemoveAdminsMaintenance extends Maintenance {
	/**
	 * Do the actual work. All child classes will need to implement this
	 */
	public function execute() {
		$aAdminsIds = $this->getPowerUserAdminsIds();
		$aFormerAdminsIds = $this->getFormerAdmins( $aAdminsIds );

		foreach ( $aFormerAdminsIds as $iFormerAdminId ) {
			$oPowerUser = new PowerUser( User::newFromId( $iFormerAdminId ) );
			$oPowerUser->removePowerUserProperty( PowerUser::TYPE_ADMIN );
		}
	}

	private function getPowerUserAdminsIds() {
		global $wgExternalSharedDB;

		$oDB = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		$aAdminsIds = ( new WikiaSQL() )
			->SELECT( 'up_user' )
			->FROM( 'user_properties' )
			->WHERE( 'up_property' )->EQUAL_TO( PowerUser::TYPE_ADMIN )
			->AND_( 'up_value' )->EQUAL_TO( '1' )
			->runLoop( $oDB, function( &$aAdminsIds, $oRow ) {
				$aAdminsIds[] = intval( $oRow->up_user );
			});

		return $aAdminsIds;
	}

	private function getFormerAdmins( $aAdminsIds ) {
		global $wgSpecialsDB;
		$oDB = wfGetDB( DB_SLAVE, [], $wgSpecialsDB );

		$aFormerAdminsIds = [];
		foreach ( $aAdminsIds as $iAdminId ) {
			$iFormerAdminId = ( new WikiaSQL() )
				->SELECT( 'user_id', 'all_groups' )
				->FROM( 'events_local_users' )
				->WHERE( 'user_id' )->EQUAL_TO( $iAdminId )
				->runLoop( $oDB, function( &$iFormerAdminId, $oRow ) {
					/**
					 * If all_groups is not a string it means that
					 * a user has not been found so we do not have
					 * any evidence that he lost admin rights
					 */
					if ( is_string( $oRow->all_groups ) &&
						strpos( $oRow->all_groups, 'sysop' ) === false
					) {
						$iFormerAdminId = intval( $oRow->user_id );
					}
				});

			if ( intval( $iFormerAdminId ) > 0 ) $aFormerAdminsIds[] = $iFormerAdminId;
		}

		return $aFormerAdminsIds;
	}
}

$maintClass = "PowerUserRemoveAdminsMaintenance";
require_once( RUN_MAINTENANCE_IF_MAIN );
