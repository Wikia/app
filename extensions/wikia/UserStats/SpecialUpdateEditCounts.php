<?php

$wgExtensionFunctions[] = 'wfSpecialUpdateEditsCount';


function wfSpecialUpdateEditsCount(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


  class UpdateEditCounts extends UnlistedSpecialPage {
	
	  function UpdateEditCounts(){
		  UnlistedSpecialPage::UnlistedSpecialPage("UpdateEditCounts");
	  }
	
	  function updateMainEditsCount(){
		  global $wgOut, $wgUser;
		  
		  if( !in_array('staff',($wgUser->getGroups())) ){
			$wgOut->errorpage( "error", "badaccess" );
			return false;
		  }
		  
		  $dbr =& wfGetDB( DB_MASTER );
		  $sql = "select rev_user_text, rev_user,  count(*) as the_count from revision inner join page on page_id = rev_page where page_namespace = 0 and rev_user <> 0  group by rev_user_text  ";
		  $res = $dbr->query($sql);
		  while ($row = $dbr->fetchObject( $res ) ) {
			  
			$user = User::newFromId($row->rev_user);
			$user->loadFromId();
			
			if( !$user->isBot() ){
				$edit_count = $row->the_count;
			}else{
				$edit_count = 0;
			}
	
			$s = $dbr->selectRow( '`user_stats`', array( 'stats_user_id' ), array('stats_user_id'=>$row->rev_user), __METHOD__ );
			if ( ! $s->stats_user_id  ) {
				
				$dbr->insert( '`user_stats`',
				array(
					'stats_year_id' => 0,
					'stats_user_id' => $row->rev_user,
					'stats_user_name' => $row->rev_user_text,
					'stats_total_points' => 1000
					), $fname
				);
			}   
			$wgOut->addHTML("<p>Updating {$row->rev_user_text} with {$edit_count} edits</p>");
			
			
			$dbr->update( 'user_stats',
					array( "stats_edit_count=".$edit_count ),
					array( 'stats_user_id' => $row->rev_user  ),
					__METHOD__ );
		
			
			
			global $wgMemc;
			
			
			//clear stats cache for current user
			$key = wfMemcKey( 'user', 'stats', $row->rev_user );
			$wgMemc->delete( $key );
			
		  }
	  }
	  
	  
		function execute(){
			global $wgUser, $wgOut; 
			$dbr =& wfGetDB( DB_MASTER );
			$this->updateMainEditsCount();
			
			global $wgUserLevels;
			$wgUserLevels = "";
			
			
			
			
			$sql = "SELECT stats_user_id,stats_user_name, stats_total_points from user_stats  ORDER BY stats_user_name";
			$res = $dbr->query($sql);
			$out = "";
			while ($row = $dbr->fetchObject( $res ) ) {
			    $x++;
			    $stats = new UserStatsTrack($row->stats_user_id,$row->stats_user_name);
			
			    $stats->updateTotalPoints();
			}
			$out = "Updated stats for <b>{$x}</b> users";
			$wgOut->addHTML($out);
		
		}
	
	}

	SpecialPage::addPage( new UpdateEditCounts );
}
 


?>