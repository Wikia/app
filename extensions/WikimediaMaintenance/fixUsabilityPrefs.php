<?php

require_once( dirname( __FILE__ ) . '/WikimediaMaintenance.php' );

class FixUsabilityPrefs extends WikimediaMaintenance {
	function __construct() {
		parent::__construct();
	}

	function execute() {
		$dbw = wfGetDB( DB_MASTER );

		echo "Fixing usebetatoolbar\n";

		$batchSize = 100;
		$allIds = array();
		while ( true ) {
			$dbw->begin();
			$res = $dbw->select( 'user_properties', array( 'up_user' ),
				array( 'up_property' => 'usebetatoolbar', 'up_value' => '' ),
				__METHOD__,
				array( 'LIMIT' => $batchSize, 'FOR UPDATE' ) );
			if ( !$res->numRows() ) {
				$dbw->commit();
				break;
			}

			$ids = array();
			foreach ( $res as $row ) {
				$ids[] = $row->up_user;
			}
			$dbw->delete( 'user_properties',
				array( 'up_property' => 'usebetatoolbar', 'up_user' => $ids ),
				__METHOD__ );
			$dbw->commit();
			$allIds = array_merge( $allIds, $ids );
			wfWaitForSlaves( 10 );
		}

		echo "Fixing wikieditor-*\n";

		$likeWikieditor = $dbw->buildLike( 'wikieditor-', $dbw->anyString() );
		while ( true ) {
			$dbw->begin();
			$res = $dbw->select( 'user_properties', array( 'DISTINCT up_user' ),
				array(  "up_property $likeWikieditor" ),
				__METHOD__,
				array( 'LIMIT' => $batchSize, 'FOR UPDATE' ) );
			if ( !$res->numRows() ) {
				$dbw->commit();
				break;
			}

			$ids = array();
			foreach ( $res as $row ) {
				$ids[] = $row->up_user;
			}
			$dbw->delete( 'user_properties',
				array( "up_property $likeWikieditor", 'up_user' => $ids ),
				__METHOD__ );
			$dbw->commit();
			$allIds = array_merge( $allIds, $ids );
			wfWaitForSlaves( 10 );
		}

		$allIds = array_unique( $allIds );

		echo "Invalidating user cache\n";
		$i = 0;
		foreach ( $allIds as $id ) {
			$user = User::newFromId( $id );
			if ( !$user->isLoggedIn() ) {
				continue;
			}
			$dbw->begin();
			$user->invalidateCache();
			$dbw->commit();
			$i++;
			if ( $i % 1000 == 0 ) {
				wfWaitForSlaves( 10 );
			}
		}

		echo "Done\n";
	}
}

$maintClass = 'FixUsabilityPrefs';
require_once( DO_MAINTENANCE );


