<?php

class UpdateEditCounts extends UnlistedSpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'UpdateEditCounts' );
	}

	function updateMainEditsCount() {
		global $wgOut, $wgUser, $wgNamespacesForEditPoints;

		$wgOut->setPageTitle( 'Update Edit Counts' );

		if ( !$wgUser->isAllowed( 'updatepoints' ) ) {
			$wgOut->errorpage( 'error', 'badaccess' );
			return false;
		}

		$whereConds = array();
		$whereConds[] = 'rev_user <> 0';
		// If points are given out for editing non-main namespaces, take that
		// into account too.
		if (
			isset( $wgNamespacesForEditPoints ) &&
			is_array( $wgNamespacesForEditPoints )
		) {
			foreach( $wgNamespacesForEditPoints as $pointNamespace ) {
				$whereConds[] = 'page_namespace = ' . (int) $pointNamespace;
			}
		}

		$dbw = wfGetDB( DB_MASTER );
		$res = $dbw->select(
			array( 'revision', 'page' ),
			array( 'rev_user_text', 'rev_user', 'COUNT(*) AS the_count' ),
			$whereConds,
			__METHOD__,
			array( 'GROUP BY' => 'rev_user_text' ),
			array( 'page' => array( 'INNER JOIN', 'page_id = rev_page' ) )
		);

		foreach ( $res as $row ) {
			$user = User::newFromId( $row->rev_user );
			$user->loadFromId();

			if ( !$user->isAllowed( 'bot' ) ) {
				$edit_count = $row->the_count;
			} else {
				$edit_count = 0;
			}

			$s = $dbw->selectRow(
				'user_stats',
				array( 'stats_user_id' ),
				array( 'stats_user_id' => $row->rev_user ),
				__METHOD__
			);
			if ( !$s->stats_user_id ) {
				$dbw->insert(
					'user_stats',
					array(
						'stats_year_id' => 0,
						'stats_user_id' => $row->rev_user,
						'stats_user_name' => $row->rev_user_text,
						'stats_total_points' => 1000
					),
					__METHOD__
				);
			}
			$wgOut->addHTML( "<p>Updating {$row->rev_user_text} with {$edit_count} edits</p>" );

			$dbw->update(
				'user_stats',
				array( 'stats_edit_count = ' . $edit_count ),
				array( 'stats_user_id' => $row->rev_user ),
				__METHOD__
			);

			global $wgMemc;
			// clear stats cache for current user
			$key = wfMemcKey( 'user', 'stats', $row->rev_user );
			$wgMemc->delete( $key );
		}
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut;
		$dbr = wfGetDB( DB_MASTER );
		$this->updateMainEditsCount();

		global $wgUserLevels;
		$wgUserLevels = '';

		$res = $dbr->select(
			'user_stats',
			array( 'stats_user_id', 'stats_user_name', 'stats_total_points' ),
			array(),
			__METHOD__,
			array( 'ORDER BY' => 'stats_user_name' )
		);
		$out = '';
		foreach ( $res as $row ) {
			$x++;
			$stats = new UserStatsTrack( $row->stats_user_id, $row->stats_user_name );
			$stats->updateTotalPoints();
		}
		$out = "Updated stats for <b>{$x}</b> users";
		$wgOut->addHTML( $out );
	}
}
