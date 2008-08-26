<?php

$wgExtensionFunctions[] = 'wfSpecialTopUsersUpdate';


function wfSpecialTopUsersUpdate(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class TopUsersUpdate extends UnlistedSpecialPage {

  function TopUsersUpdate(){
    UnlistedSpecialPage::UnlistedSpecialPage("TopUsersUpdate");
  }

  function execute(){
    global $wgUser, $wgOut; 
    $dbr =& wfGetDB( DB_MASTER );
    $sql = "SELECT stats_user_id,stats_user_name, stats_total_points from user_stats where stats_year_id = 1 ORDER BY stats_user_name";
    $res = $dbr->query($sql);
    $row = $dbr->fetchObject( $res );
    $out = "";
    while ($row = $dbr->fetchObject( $res ) ) {
	    $x++;
	    $stats = new UserStatsTrack(1,$row->stats_user_id,$row->stats_user_name);
	    $stats->updatePublishedOpinionsCount();
	   // $stats->updateTotalPoints();
    }
    $out = "Updated stats for <b>{$x}</b> users";
    $wgOut->addHTML($out);
  }

}

 SpecialPage::addPage( new TopUsersUpdate );
 global $wgMessageCache,$wgOut;
 //$wgMessageCache->addMessage( 'commenteaction', 'comment action' );
 


}

?>