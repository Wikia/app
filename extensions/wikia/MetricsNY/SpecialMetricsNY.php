<?php

$wgExtensionFunctions[] = 'wfSpecialMetricsNY';

function wfSpecialMetricsNY(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class MetricsNY extends SpecialPage {

	
	function MetricsNY(){
		UnlistedSpecialPage::UnlistedSpecialPage("MetricsNY");
	}
	
	function formatDate($date){
		$date_array = split(" ",$date);
		
		$year = $date_array[0];
		$month = $date_array[1];
		$time = mktime(0,0,0,$month,1,"20".$year);
		return date("M",$time) . " - " . date("Y",$time);
	}

	function display_stats($title,$res){
		$dbr =& wfGetDB( DB_SLAVE );
		
		$output = "";
		$output .= "<div style=\"font-weight:800;\">
			{$title}
			   </div><table><tr><td bgcolor=\"#cccccc\">date</td><td bgcolor=\"#cccccc\">count</td><td bgcolor=\"#cccccc\">diff</td></tr>";
			   
		
		$stats = array();
		while ($row = $dbr->fetchObject( $res ) ) {
			$stats[] = array("date"=>$this->formatDate($row->the_date),"count"=>$row->the_count);
		}
		
		for($x=0;$x<=count($stats)-1;$x++){
			$diff = "";
			if($x!=count($stats)-1){
				$diff = $stats[$x]["count"] - $stats[$x+1]["count"];
				if($diff>0){
					$diff = "+{$diff}";
				}else{
					$diff = "{$diff}";
				}
			}
			$output .= "<tr>
					<td>{$stats[$x]["date"]}</td>
					<td>".number_format($stats[$x]["count"])."</td>
					<td>{$diff}</td>
				</tr>
				"; 
		}
		
		$output .= "</table>";
		
		return $output;
		
	}
	
	function execute(){
		global $wgRequest, $IP, $wgOut;
		
		$wgOut->setPagetitle( "Monthly Metrics" );
		$dbr =& wfGetDB( DB_SLAVE );
		
		$sql = "SELECT count( * ) AS the_count,
			Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) as the_date
			From revision WHERE rev_user_text<>'MLB Stats Bot'
			GROUP BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' )
			ORDER BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) DESC
			LIMIT 0,6";
		$res = $dbr->query($sql);
		$output .= $this->display_stats("MONTHLY EDITS",$res);

		/*   
		 
		MONTHLY NEW PAGES
			 
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "select count(*) as the_count , 
			Date_FORMAT( (select FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) )  from revision where rev_page=page_id order by rev_timestamp asc limit 1) , '%y %m' ) as the_date
			from page
			group by Date_FORMAT( (select FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) )  from revision where rev_page=page_id order by rev_timestamp asc limit 1), '%y %m' )
			ORDER BY Date_FORMAT( (select FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) )  from revision where rev_page=page_id order by rev_timestamp asc limit 1), '%y %m' ) DESC
			  limit 0,6
			 ";
		
		*/
		
		$sql = "SELECT count( * ) AS the_count,
			Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) as the_date
			From revision
			where rev_user = 0
			GROUP BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' )
			ORDER BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) DESC
			LIMIT 0,6";
		$res = $dbr->query($sql);
		$output .= $this->display_stats("ANON EDITS",$res);

			   
		$sql = "SELECT count( * ) AS the_count, Date_FORMAT( `Vote_Date` , '%y %m' ) as the_date
			FROM `Vote`
			GROUP BY Date_FORMAT( `Vote_Date` , '%y %m' )
			ORDER BY Date_FORMAT( `Vote_Date` , '%y %m' ) DESC
			LIMIT 0,6";
		$res = $dbr->query($sql);
		$output .= $this->display_stats("MONTHLY VOTES",$res);
		
		
		$sql = "SELECT count( * ) AS the_count, Date_FORMAT( `Comment_Date` , '%y %m' ) as the_date
			FROM `Comments`
			GROUP BY Date_FORMAT( `Comment_Date` , '%y %m' )
			ORDER BY Date_FORMAT( `Comment_Date` , '%y %m' ) DESC
			LIMIT 0,6";
		$res = $dbr->query($sql);
		$output .= $this->display_stats("MONTHLY COMMENTS",$res);
		
		$sql = "SELECT count( * ) AS the_count, Date_FORMAT( `ug_date` , '%y %m' ) as the_date
			FROM `user_gift`
			GROUP BY Date_FORMAT( `ug_date` , '%y %m' )
			ORDER BY Date_FORMAT( `ug_date` , '%y %m' ) DESC
			LIMIT 0,6";
		$res = $dbr->query($sql);
		$output .= $this->display_stats("MONTHLY GIFTS GIVEN OUT",$res);
		
		$sql = "SELECT count( * )/2 AS the_count, Date_FORMAT( `r_date` , '%y %m' ) as the_date
			FROM `user_relationship`
			where r_type=1
			GROUP BY Date_FORMAT( `r_date` , '%y %m' )
			ORDER BY Date_FORMAT( `r_date` , '%y %m' ) DESC
			LIMIT 0,6";
		$res = $dbr->query($sql);
		$output .= $this->display_stats("FRIENDSHIPS",$res);
		
		$sql = "SELECT count( * )/2 AS the_count, Date_FORMAT( `r_date` , '%y %m' ) as the_date
			FROM `user_relationship`
			where r_type=2
			GROUP BY Date_FORMAT( `r_date` , '%y %m' )
			ORDER BY Date_FORMAT( `r_date` , '%y %m' ) DESC
			LIMIT 0,6";
		$res = $dbr->query($sql);
		$output .= $this->display_stats("FOESHIPS",$res);
		
		$sql = "SELECT count( * ) AS the_count, Date_FORMAT( `ur_date` , '%y %m' ) as the_date
			FROM `user_register_track`
			GROUP BY Date_FORMAT( `ur_date` , '%y %m' )
			ORDER BY Date_FORMAT( `ur_date` , '%y %m' ) DESC
			LIMIT 0,6";
		$res = $dbr->query($sql);
		$output .= $this->display_stats("NEW USERS (since mid-late May 2007)",$res);
		
		$sql = "SELECT count( * ) AS the_count, Date_FORMAT( `ur_date` , '%y %m' ) as the_date
			FROM `user_register_track`
			where ur_user_id_referral <> 0
			GROUP BY Date_FORMAT( `ur_date` , '%y %m' )
			ORDER BY Date_FORMAT( `ur_date` , '%y %m' ) DESC
			LIMIT 0,6";
		$res = $dbr->query($sql);
		$output .= $this->display_stats("RECRUITS (since mid-late May 2007)",$res);
		
		$sql = "SELECT sum( ue_count ) AS the_count, Date_FORMAT( `ue_date` , '%y %m' ) as the_date
			FROM `user_email_track`
			where ue_type in (1,2,3)
			GROUP BY Date_FORMAT( `ue_date` , '%y %m' )
			ORDER BY Date_FORMAT( `ue_date` , '%y %m' ) DESC
			LIMIT 0,6";
		$res = $dbr->query($sql);
		$output .= $this->display_stats("INVITES VIA CONTACT IMPORTER (July 3rd 2007)",$res);

		$sql = "SELECT sum( ue_count ) AS the_count, Date_FORMAT( `ue_date` , '%y %m' ) as the_date
			FROM `user_email_track`
			where ue_type in (4)
			GROUP BY Date_FORMAT( `ue_date` , '%y %m' )
			ORDER BY Date_FORMAT( `ue_date` , '%y %m' ) DESC
			LIMIT 0,6";
		$res = $dbr->query($sql);
		$output .= $this->display_stats("INVITES TO READ NEW OPINION (July 3rd 2007)",$res);		
		
		$sql = "SELECT count(*) AS the_count, Date_FORMAT( `pg_date` , '%y %m' ) as the_date
			FROM `picturegame_images`
			 
			GROUP BY Date_FORMAT( `pg_date` , '%y %m' )
			ORDER BY Date_FORMAT( `pg_date` , '%y %m' ) DESC
			LIMIT 0,6";
		$res = $dbr->query($sql);
		$output .= $this->display_stats("PICTUREGAMES CREATED",$res);	

		$sql = "SELECT count(*) AS the_count, Date_FORMAT( `vote_date` , '%y %m' ) as the_date
			FROM `picturegame_votes`
			 
			GROUP BY Date_FORMAT( `vote_date` , '%y %m' )
			ORDER BY Date_FORMAT( `vote_date` , '%y %m' ) DESC
			LIMIT 0,6";
		$res = $dbr->query($sql);
		$output .= $this->display_stats("PICTUREGAME VOTES",$res);	
		
		$sql = "SELECT count(*) AS the_count, Date_FORMAT( `poll_date` , '%y %m' ) as the_date
			FROM `poll_question`
			 
			GROUP BY Date_FORMAT( `poll_date` , '%y %m' )
			ORDER BY Date_FORMAT( `poll_date` , '%y %m' ) DESC
			LIMIT 0,6";
		$res = $dbr->query($sql);
		$output .= $this->display_stats("POLLS CREATED",$res);				

		$sql = "SELECT count(*) AS the_count, Date_FORMAT( `pv_date` , '%y %m' ) as the_date
			FROM `poll_user_vote`
			 
			GROUP BY Date_FORMAT( `pv_date` , '%y %m' )
			ORDER BY Date_FORMAT( `pv_date` , '%y %m' ) DESC
			LIMIT 0,6";
		$res = $dbr->query($sql);
		$output .= $this->display_stats("POLL VOTES",$res);

		//images
		$sql = "SELECT count(*) AS the_count, Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(img_timestamp)), '%y %m')  AS the_date 
		FROM image 
		
		GROUP BY Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(img_timestamp)), '%y %m') 
		ORDER BY Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(img_timestamp)), '%y %m') DESC 
		LIMIT 0,6";
		
		$res = $dbr->query($sql);
		$output .= $this->display_stats("IMAGES",$res);


		global $wgSitename;
		if($wgSitename=="ArmchairGM"){
			
		$sql = "SELECT count(*) AS the_count, Date_FORMAT( `q_date` , '%y %m' ) as the_date
			FROM `quizgame_questions`
			 
			GROUP BY Date_FORMAT( `q_date` , '%y %m' )
			ORDER BY Date_FORMAT( `q_date` , '%y %m' ) DESC
			LIMIT 0,6";
		$res = $dbr->query($sql);
		$output .= $this->display_stats("QUIZ QUESTIONS CREATED",$res);		

		$sql = "SELECT count(*) AS the_count, Date_FORMAT( `a_date` , '%y %m' ) as the_date
			FROM `quizgame_answers`
			 
			GROUP BY Date_FORMAT( `a_date` , '%y %m' )
			ORDER BY Date_FORMAT( `a_date` , '%y %m' ) DESC
			LIMIT 0,6";
			
		$res = $dbr->query($sql);
		$output .= $this->display_stats("QUIZ ANSWERS",$res);	
		
		$sql = "SELECT count(*) AS the_count, Date_FORMAT( `us_date` , '%y %m' ) as the_date
			FROM `user_status`
			 
			GROUP BY Date_FORMAT( `us_date` , '%y %m' )
			ORDER BY Date_FORMAT( `us_date` , '%y %m' ) DESC
			LIMIT 0,6";
			
		$res = $dbr->query($sql);
		$output .= $this->display_stats("NETWORK THOUGHTS",$res);
		
		$sql = "SELECT count(*) AS the_count, Date_FORMAT( `pick_date` , '%y %m' ) as the_date
			FROM `pick_games_picks`
			 
			GROUP BY Date_FORMAT( `pick_date` , '%y %m' )
			ORDER BY Date_FORMAT( `pick_date` , '%y %m' ) DESC
			LIMIT 0,6";
			
		$res = $dbr->query($sql);
		$output .= $this->display_stats("PICK EM PICKS",$res);
		
				
		}
		
		$wgOut->addHTML($output);
		
		
	
	}
  
 
	
}

SpecialPage::addPage( new MetricsNY );

 


}

?>