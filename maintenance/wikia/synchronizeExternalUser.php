<?php

/**
 * Script that removes per-cluster entries in user table that do not match those in shared DB (wikicities)
 *
 * @see SUS-1654
 */

require_once( __DIR__ . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class SynchronizeExternalUser extends Maintenance {

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'cluster', 'Which cluster to check (e.g. "c1")', true /* $required */, true /* $withArg */ );
		$this->addOption( 'clean', 'Really remove cluster copies of user table entries' );
		$this->mDescription = 'This script removes per-cluster entries in user table that do not match those in shared DB (wikicities)';
	}

	public function execute() {
		global $wgExternalSharedDB;

		$cluster = wfGetDB( DB_SLAVE, [], sprintf( 'wikicities_%s', $this->getOption( 'cluster' ) ) );
		$wikicities = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		$res = $cluster->select( '`user`', 'user_id, user_name', [], __METHOD__ );
		$this->output( sprintf( "Going to check %d accounts on %s...\n", $cluster->affectedRows(), $cluster->getDBname() ) );

		$scanned = $found = 0;

		while( $row = $res->fetchObject() ) {
			$shared_user_id = $wikicities->selectField( '`user`', 'user_id', [ 'user_name' => $row->user_name ], __METHOD__ );

			if ($row->user_id != $shared_user_id ) {
				$this->output( sprintf( "%s: ID mismatch found for %s (cluster #%d / shared #%d)\n",
					$cluster->getDBname(), $row->user_name, $row->user_id, $shared_user_id ) );

				$found++;

				// remove user copy on cluster (when run with --clean option)
				if ( $this->getOption('clean') ) {
					ExternalUser_Wikia::removeFromSecondaryClusters( $row->user_id );

					// do not hit shared DB master with too many queries
					sleep( 0.25 );
				}
			}

			$scanned++;
		}

		$this->output( "\n{$scanned} cluster users scanned, {$found} mismatches found!\n" );
	}
}

$maintClass = SynchronizeExternalUser:: class;
require_once( RUN_MAINTENANCE_IF_MAIN );
