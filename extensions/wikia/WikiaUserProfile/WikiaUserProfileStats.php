<?php
/**
 *
 */

class WikiaUserProfileStats {

	/**
	 * All member variables should be considered private
	 * Please use the accessor functions
	 */

	public $user_id;
	public $user_name;
	public $profile;
	public $shared_city = false;

	const MEM_STATS_TIME_1 = 7200;
	const MEM_STATS_TIME_2 = 1800;

	/**
	 * @access public
	 */
	function __construct($username) {
		global $wgSharedDB, $wgCityId, $wgDBname;

		$title = Title::newFromDBkey($username  );
		$this->user_name = $title->getText();
		$this->user_id = User::idFromName($this->user_name);
		$this->shared_city = (!empty($wgSharedDB)) ? false : $wgCityId;

		if (empty($wgSharedDB)) {
			$this->shared_city = $wgCityId;
			if (empty($wgCityId)) {
				$this->shared_city = WikiFactory::DBtoID($wgDBname);
			}
		}
	}

	/**
	 * @access public
	 */
	function getUserStats() {
		global $wgUser;
		wfProfileIn( __METHOD__ );

		$userStats = array(
			'votes'        => $this->getUserVotes(),
			'edits'        => $this->getUserEdits(),
			'create_pages' => $this->getNewUserPages()
		);

		wfProfileOut( __METHOD__ );
		return $userStats;
	}

	/**
	 * @access private
	 */
	private function getNewUserPages() {
		global $wgUser, $wgMemc, $wgExternalStatsDB;

		wfProfileIn( __METHOD__ );

		$key = wfMemcKey( 'user_stats', 'profile_user_news', $this->user_id );
		$data = $wgMemc->get( $key );

		if (empty($data)) {
			$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalStatsDB );
			$sql_where = array( "rc_user" => $this->user_id, "rc_new" => "1" );
			if (!empty($this->shared_city)) {
				$sql_where["rc_city_id"] = $this->shared_city;
			}
			$row = $dbr->selectRow(
				array( "city_recentchanges" ),
				array("count(rc_new) as cnt_new"),
				$sql_where,
				__METHOD__,
				array( "USE INDEX" => "rc_user_inx" )
			);

			if( $row === false ) {
				return false;
			}
			$wgMemc->set( $key, $row, self::MEM_STATS_TIME_1);
		}
		else {
			$row = $data;
		}

		wfProfileOut( __METHOD__ );
		return $row;
	}

	/**
	 * @access private
	 */
	private function getUserEdits() {
		global $wgUser, $wgMemc, $wgExternalSharedDB;

		wfProfileIn( __METHOD__ );

		$key = wfMemcKey( 'user_stats', 'profile_user_edits', $this->user_id );
		$data = $wgMemc->get( $key );

		if (empty($data)) {
			$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
			$row = $dbr->selectRow(
				array( "user" ),
				array( "user_editcount as cnt_edit" ),
				array( "user_id" => $this->user_id),
				__METHOD__
			);

			if ( $row === false ) {
				return false;
			}
			$wgMemc->set( $key, $row, self::MEM_STATS_TIME_2);
		}
		else {
			$row = $data;
		}

		wfProfileOut( __METHOD__ );
		return $row;
	}

	private function getUserVotes() {
		global $wgUser, $wgMemc, $wgExternalStatsDB;

		wfProfileIn( __METHOD__ );

		$key = wfMemcKey( 'user_stats', 'profile_user_votes', $this->user_id );
		$data = $wgMemc->get( $key );

		if (empty($data)) {
			$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalStatsDB );
			$sql_where = array( "user_id" => $this->user_id );
			if (!empty($this->shared_city)) {
				$sql_where["city_id"] = $this->shared_city;
			}
			$row = $dbr->selectRow(
				array( "city_page_vote" ),
				array("count(vote) as count_vote, round(avg(vote),2) as avg_vote" ),
				$sql_where,
				__METHOD__,
				array( "USE INDEX" => "user_id" )
			);

			if ( $row === false ) {
				return false;
			}
			$wgMemc->set( $key, $row, self::MEM_STATS_TIME_1 );
		}
		else {
			$row = $data;
		}

		wfProfileOut( __METHOD__ );
		return $row;
	}
}
