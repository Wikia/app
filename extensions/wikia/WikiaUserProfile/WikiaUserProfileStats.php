<?php
/**
 *
 */

class WikiaUserProfileStats 
{
	/**
	 * All member variables should be considered private
	 * Please use the accessor functions
	 */

	var $user_id;
	var $user_name;
	var $profile; 
	var $shared_city = false;
	
	const MEM_STATS_TIME_1 = 7200;
	const MEM_STATS_TIME_2 = 1800;
	
	function __construct($username) 
	{
		global $wgSharedDB, $wgCityId, $wgDBname;
	
		$title = Title::newFromDBkey($username  );
		$this->user_name = $title->getText();
		$this->user_id = User::idFromName($this->user_name);
		$this->shared_city = (!empty($wgSharedDB)) ? false : $wgCityId;
		
		if (empty($wgSharedDB))
		{
			#---
			$this->shared_city = $wgCityId;
			#---
			if (empty($wgCityId))
			{
				$this->shared_city = WikiFactory::DBtoID($wgDBname);
			}
		}
	}
	
	function getUserStats()
	{
		global $wgUser;
		wfProfileIn( __METHOD__ );
		
		$userStats = array(
						'votes' => $this->getUserVotes(),
						'create_pages' => $this->getNewUserPages(),
						'edits' => $this->getUserEdits()
					);

		wfProfileOut( __METHOD__ );
		return $userStats;
	}

	private function getNewUserPages()
	{
		global $wgUser, $wgMemc;
		
		wfProfileIn( __METHOD__ );

		$key = wfMemcKey( 'user_stats', 'profile_user_news', $this->user_id );
		$data = $wgMemc->get( $key );
		
		#---
		if (empty($data))
		{
			$external = new ExternalStoreDB();
			$dbr = $external->getSlave( "archive1" );
			#---
			$sql_where = array( "rc_user" => $this->user_id, "rc_new" => "1" );
			#---
			if (!empty($this->shared_city))
			{
				$sql_where["rc_city_id"] = $this->shared_city;
			}
			#---
			$s = $dbr->selectRow( "`dbstats`.`city_recentchanges` FORCE INDEX (rc_user_inx)", array("count(rc_new) as cnt_new"), $sql_where, "" );
		
			if ( $s === false ) 
			{
				return false;
			}
			$wgMemc->set( $key, $s, self::MEM_STATS_TIME_1);
		}
		else
		{
			$s = $data;
		}

		wfProfileOut( __METHOD__ );
		return $s;
	}

	private function getUserEdits()
	{
		global $wgUser, $wgMemc, $wgSharedDB, $wgDBname;

		wfProfileIn( __METHOD__ );

		$key = wfMemcKey( 'user_stats', 'profile_user_edits', $this->user_id );
		$data = $wgMemc->get( $key );
		
		$db_name = (empty($wgSharedDB))?$wgDBname:$wgSharedDB;
		
		#---
		if (empty($data))
		{
			$dbr =& wfGetDB( DB_MASTER );
			$s = $dbr->selectRow( "`{$db_name}`.`user`", array("user_editcount as cnt_edit"), array( "user_id" => $this->user_id), "" );
		
			if ( $s === false ) 
			{
				return false;
			}
			$wgMemc->set( $key, $s, self::MEM_STATS_TIME_2);
		}
		else
		{
			$s = $data;
		}
		
		wfProfileOut( __METHOD__ );
		return $s;
	}

	private function getUserVotes()
	{
		global $wgUser, $wgMemc;

		wfProfileIn( __METHOD__ );

		$key = wfMemcKey( 'user_stats', 'profile_user_votes', $this->user_id );
		$data = $wgMemc->get( $key );
		
		#---
		if (empty($data))
		{
			$dbr =& wfGetDBStats();
			#---
			$sql_where = array( "user_id" => $this->user_id );
			#---
			if (!empty($this->shared_city))
			{
				$sql_where["city_id"] = $this->shared_city;
			}
			#---
			$s = $dbr->selectRow( "`dbstats`.`city_page_vote` FORCE INDEX (user_id)", array("count(vote) as count_vote, round(avg(vote),2) as avg_vote"), $sql_where, "" );
		
			if ( $s === false ) 
			{
				return false;
			}
			$wgMemc->set( $key, $s, self::MEM_STATS_TIME_1 );
		}
		else
		{
			$s = $data;
		}
		
		wfProfileOut( __METHOD__ );
		return $s;
	}
}

?>
