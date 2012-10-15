<?php

/**
 * This scripts removes the narayamDisable property from users that enabled
 * it and sets narayamEnable to false instead.
 * --batch-size can be used to specify number of users to process at once,
 * the default is 100.
 *
 * @author Amir E. Aharoni
 * based on extensions/Translate/scipts/list-mwext-i18n-files.php and
 * extensions/WikimediaMaintenance/fixUsabilityPrefs2.php
 *
 * @copyright Copyright © 2011
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

// Standard boilerplate to define $IP
if ( getenv( 'MW_INSTALL_PATH' ) !== false ) {
        $IP = getenv( 'MW_INSTALL_PATH' );
} else {
        $dir = dirname( __FILE__ ); $IP = "$dir/../../..";
}
require_once( "$IP/maintenance/Maintenance.php" );

class FixNarayamDisablePref extends Maintenance {
	function __construct() {
		parent::__construct();
		$this->setBatchSize( 100 );
	}

	function execute() {
		$dbw = wfGetDB( DB_MASTER );

		$table = 'user_properties';
		$oldPropName = 'narayamDisable';
		$newPropName = 'narayamEnable';
		$this->output( "Changing $oldPropName to $newPropName\n" );

		$allIds = array();
		while ( true ) {
			$dbw->begin();
			$res = $dbw->select(
				$table,
				array( 'up_user' ),
				array( 'up_property' => $oldPropName, 'up_value' => 1 ),
				__METHOD__,
				array( 'LIMIT' => $this->mBatchSize, 'FOR UPDATE' ) );
			if ( !$res->numRows() ) {
				break;
			}

			$ids = array();
			foreach ( $res as $row ) {
				$ids[] = $row->up_user;
			}
			$dbw->update(
				$table,
				array( 'up_property' => $newPropName, 'up_value' => 0 ),
				array( 'up_property' => $oldPropName, 'up_user' => $ids ),
				__METHOD__ );
			$dbw->commit();

			foreach ( $ids as $id ) {
				$user = User::newFromID( $id );
				if ( $user ) {
					$user->invalidateCache();
				}
			}

			wfWaitForSlaves( 10 );
		}

		$this->output( "Old preference $oldPropName was migrated to $newPropName\n" );
	}
}

$maintClass = 'FixNarayamDisablePref';
require_once( RUN_MAINTENANCE_IF_MAIN );
