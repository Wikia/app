<?php

class UpdateEditCounts extends UnlistedSpecialPage {

	/**
	 * Constructor
	 */
	function __construct(){
		parent::__construct( 'UpdateEditCounts' );
	}

	function updateMainEditsCount(){
		global $wgOut, $wgUser, $wgDBprefix;

		$wgOut->setPageTitle('Update Edit Counts');

		if( !in_array( 'staff', ( $wgUser->getGroups() ) ) ){
			$wgOut->errorpage( 'error', 'badaccess' );
			return false;
		}

		$dbw = wfGetDB( DB_MASTER );
		$sql = "SELECT rev_user_text, rev_user,	count(*) AS the_count FROM ".$wgDBprefix."revision INNER JOIN ".$wgDBprefix."page ON page_id = rev_page WHERE page_namespace = 0 AND rev_user <> 0 GROUP BY rev_user_text	";
		$res = $dbw->query($sql);
		while( $row = $dbw->fetchObject( $res ) ) {

		$user = User::newFromId($row->rev_user);
		$user->loadFromId();

		if( !$user->isBot() ){
			$edit_count = $row->the_count;
		} else {
			$edit_count = 0;
		}

		$s = $dbw->selectRow( 'user_stats', array( 'stats_user_id' ), array( 'stats_user_id' => $row->rev_user ), __METHOD__ );
		if ( !$s->stats_user_id ) {

			$dbw->insert( 'user_stats',
			array(
				'stats_year_id' => 0,
				'stats_user_id' => $row->rev_user,
				'stats_user_name' => $row->rev_user_text,
				'stats_total_points' => 1000
				), __METHOD__
			);
		}
		$wgOut->addHTML("<p>Updating {$row->rev_user_text} with {$edit_count} edits</p>");

		$dbw->update( 'user_stats',
				array( "stats_edit_count=".$edit_count ),
				array( 'stats_user_id' => $row->rev_user ),
				__METHOD__ );

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
	public function execute( $par ){
		global $wgUser, $wgOut, $wgDBprefix;
		$dbr = wfGetDB( DB_MASTER );
		$this->updateMainEditsCount();

		global $wgUserLevels;
		$wgUserLevels = '';

		$sql = "SELECT stats_user_id,stats_user_name, stats_total_points FROM ".$wgDBprefix."user_stats ORDER BY stats_user_name";
		$res = $dbr->query($sql);
		$out = '';
		while ( $row = $dbr->fetchObject( $res ) ) {
			$x++;
			$stats = new UserStatsTrack($row->stats_user_id, $row->stats_user_name);
			$stats->updateTotalPoints();
		}
		$out = "Updated stats for <b>{$x}</b> users";
		$wgOut->addHTML($out);
	}
}
