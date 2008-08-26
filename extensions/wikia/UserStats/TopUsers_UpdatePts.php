<?php
/*
$wgExtensionFunctions[] = 'wfSpecialTopUsersUpdate';


function wfSpecialTopUsersUpdate(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class TopUsersUpdate extends UnlistedSpecialPage {

  function TopUsersUpdate(){
    UnlistedSpecialPage::UnlistedSpecialPage("TopUsersUpdate");
  }

  function updateMainEditsCount(){
	  global $wgOut, $wgUser;
	  
	  $dbr =& wfGetDB( DB_MASTER );
	  $sql = "select rev_user_text, rev_user,  count(*) as the_count from revision inner join page on page_id = rev_page where page_namespace = 0 and rev_user <> 0  group by rev_user_text  ";
	  $res = $dbr->query($sql);
	  while ($row = $dbr->fetchObject( $res ) ) {
		  
		$s = $dbr->selectRow( '`user_stats`', array( 'stats_user_id' ), array('stats_user_id'=>$row->rev_user), __METHOD__ );
		if ( $s === false ) {
			
			$dbr->insert( '`user_stats`',
			array(
				'stats_year_id' => 0,
				'stats_user_id' => $row->rev_user,
				'stats_user_name' => $row->rev_user_text,
				'stats_total_points' => 1000
				), $fname
			);
		}   
		$wgOut->addHTML("<p>Updating {$row->rev_user_text} with {$row->the_count} edits</p>");
		
		
		$dbr->update( 'user_stats',
				array( "stats_edit_count=".$row->the_count ),
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

 SpecialPage::addPage( new TopUsersUpdate );
 global $wgMessageCache,$wgOut;
 


}
*/

$wgExtensionFunctions[] = 'wfSpecialTopUsersUpdate';


function wfSpecialTopUsersUpdate(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class TopUsersUpdate extends UnlistedSpecialPage {

  function TopUsersUpdate(){
    UnlistedSpecialPage::UnlistedSpecialPage("TopUsersUpdate");
  }

  
  function execute(){
    global $wgUser, $wgOut, $wgMemCachedServers , $wgMemc; 
     
	$wgMemCachedServers = array(
		'216.224.121.134:11000',	# ap1.sjc
		'216.224.121.145:11000',	# ap2.sjc
#		'216.224.121.146:11000',	# ap3.sjc
#		'216.224.121.148:11000',	# cache4.sjc
#		'216.224.121.144:11000',	# cache2.sjc
#		'216.224.121.149:11000',	# ap4.sjc
	);
	
	$key = wfMemcKey( 'user_stats', 'top', 'points', "weekly", 10 );
	$data = $wgMemc->get( $key );
	$user_list = $data;
	$random_user = $user_list[ array_rand( $user_list, 1) ];
	$stats = new UserStats($random_user["user_id"], $random_user["user_name"]);
		$stats_data = $stats->getUserStats();
	echo "ok";
	exit();
/*
    $dbr =& wfGetDB( DB_MASTER );
  
    

    
    
    $sql = "select r_user_name, r_user_name_relation, count(*) as the_count from user_relationship group by r_user_name, r_user_name_relation;";
    $res = $dbr->query($sql);
    $out = "";
    while ($row = $dbr->fetchObject( $res ) ) {
	   
	    
	    if( $row->the_count > 1 ){
		    $wgOut->addHTML($row->r_user_name . " and " . $row->r_user_name_relation . " - " . $row->the_count . " times<P>");
		    
		    //get earliest relationship
		    $s = $dbr->selectRow( '`user_relationship`', 
				array( 'r_id', 'r_user_id'),
				array( 'r_user_name' => $row->r_user_name, 'r_user_name_relation' => $row->r_user_name_relation ), $fname ,
				array( 'ORDER BY' => 'r_id asc')
		   );
		   
		   $dbr->delete( '`user_relationship`', array( 'r_user_name' => $row->r_user_name, 'r_user_name_relation' => $row->r_user_name_relation, 'r_id > ' . $s->r_id ), $fname );

		   $stats = new UserStatsTrack( $s->r_user_id, $row->r_user_name );
		   $stats->updateRelationshipCount(1);
		   $x++;
	    }
		    
    }
    $out = "fixed friends for <b>{$x}</b> users";
    $wgOut->addHTML($out);
    */
     
  }

}

 SpecialPage::addPage( new TopUsersUpdate );
 global $wgMessageCache,$wgOut;
 


}
?>