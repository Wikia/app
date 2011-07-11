<?php

class GetViewers{
	public function __construct(){
	}
	
	private function GetDatabaseData($databaseName){
	
		return wfGetDB( DB_SLAVE, array(), $databaseName );
	}
	
	public function GetTenTopUsers($WikiID, $Week = null){
			global $wgStatsDB;
		if( is_null($Week) ) {
			$Week = date('Y').date('W');
		}
		
		$statDB = $this->GetDatabaseData($wgStatsDB);
		$statDBres = $statDB->select(array('page_views_weekly_user'), array('pv_user_id', 'pv_views'),
		array('pv_city_id' => $WikiID, 'pv_week' => $Week), __METHOD__, array( 'ORDER BY' => 'pv_views DESC', 'LIMIT' => 10)
		);
		
		while ($row = $statDB->fetchObject($statDBres)){
			$viewer = new Viewer($row->pv_user_id );
			$viewer->SetViews($row->pv_views);
			$viewer->FindName();
			
			$users[] = $viewer;
		}
			
		return $users;
	}
	
	public function saveComment($id, $comment, $WikiID){
		$id = intval($id);
		$comment = (string) $comment;
		
		if ($id > 0 && !empty($comment)) {
			$viewer = new Viewer($id);
			$viewer->addComment($comment, $WikiID);
		}
	}
}