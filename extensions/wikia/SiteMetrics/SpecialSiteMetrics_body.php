<?php

class SiteMetrics extends SpecialPage {

	function SiteMetrics(){
		UnlistedSpecialPage::UnlistedSpecialPage("SiteMetrics");
	}
	
	function formatDate($date){
		$date_array = split(" ",$date);
		
		$year = $date_array[0];
		$month = $date_array[1];
		
		$time = mktime(0,0,0,$month,1,"20".$year);
		return date("m",$time) . "/" . date("y",$time);
	}
	
	function formatDateDay($date){
		$date_array = split(" ",$date);
		
		$year = $date_array[0];
		$month = $date_array[1];
		$day = $date_array[2];
		
		$time = mktime(0,0,0,$month,$day,"20".$year);
		return date("m",$time) . "/" . date("d",$time) . "/" . date("y",$time);
	}
	
	function display_chart($stats) {
		
		//reverse stats array so that chart outputs correctly
		$reversed_stats = array_reverse($stats);
		
		//determine the maximum count
		$max=0;
		for($x=0;$x<=count($reversed_stats)-1;$x++){
			if ($reversed_stats[$x]["count"]>$max) {
				$max=$reversed_stats[$x]["count"];
			}
		}
		
		//Write Google Charts API script to generate graph
		$output = "<script>
		
		var simpleEncoding = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		var maxValue='{$max}';
		var valueArray= new Array(";
		
		for($x=0;$x<=count($reversed_stats)-1;$x++){
			
			//get first and last dates
			if ($x==0) { $first_date = $reversed_stats[$x]["date"]; }
			if ($x==count($stats)-1) { $last_date = $reversed_stats[$x]["date"];}
			
			//make value array for Charts API
			$output .= $reversed_stats[$x]["count"];
			if ($x!=count($stats)-1) {
				$output .= ",";	
			}
		}
		
		$output .=");

		function simpleEncode(valueArray,maxValue) {

		var chartData = ['s:'];
		  for (var i = 0; i < valueArray.length; i++) {
		    var currentValue = valueArray[i];
		    if (!isNaN(currentValue) && currentValue >= 0) {
		    chartData.push(simpleEncoding.charAt(Math.round((simpleEncoding.length-1) * currentValue / maxValue)));
		    }
		      else {
		      chartData.push('_');
		      }
		  }
		return chartData.join('');
		}

		imgSrc = '<img src=\"http://chart.apis.google.com/chart?chs=400x200&amp;cht=lc&amp;chd='+simpleEncode(valueArray,maxValue)+'&amp;chco=ff0000&amp;chg=20,50,1,5&amp;chxt=x,y&amp;chxl=0:|{$first_date}|{$last_date}|1:||".number_format($max)."\"/>';
		
		document.write(imgSrc);
		
		</script>";
		
		return $output;
		
	}

	function display_stats($title,$res, $type){
		$dbr =& wfGetDB( DB_SLAVE );
		
		//build stats array
		$stats = array();
		while ($row = $dbr->fetchObject( $res ) ) {
			
			if ($type=="month") {
				$stats[] = array("date"=>$this->formatDate($row->the_date),"count"=>$row->the_count);
			} else if ($type=="day") {
				$stats[] = array("date"=>$this->formatDateDay($row->the_date),"count"=>$row->the_count);
			}
			
		}
		
		$output = "";
		$output .= "<h3>{$title}</h3>";
		
		$output .= $this->display_chart($stats);
		
		$output .= "<table cellpadding=\"0\" cellspacing=\"0\" width=\"400\" border=\"1\">
			<tr class=\"smt-header\">
				<td>Date</td>
				<td>Count</td>
				<td>Difference</td>
			</tr>";
			   
			for ($x=0;$x<=count($stats)-1;$x++) {
				$diff = "";
				if ($x!=count($stats)-1) {
					$diff = $stats[$x]["count"] - $stats[$x+1]["count"];
					if ($diff>0) {
						$diff = "+{$diff}";
					} else {
						$diff = "{$diff}";
					}
				}
				$output .= "<tr>
					<td>{$stats[$x]['date']}</td>
					<td>".number_format($stats[$x]["count"])."</td>
					<td>{$diff}</td>
				</tr>"; 
			}
		
		$output .= "</table>";
		
		return $output;
		
	}
	
	
	function execute() {
		global $wgRequest, $IP, $wgOut, $wgStyleVersion, $wgTitle, $wgUser, $wgExtensionsPath;
		
		//$current_user_name = $wgUser->getName();
		//$user = User::newFromName($current_user_name);
		$user_groups = $wgUser->getGroups();
		$user_groups = array_flip($user_groups);
		$social_tools_available = false;
    
		$output = '';
		if (isset($user_groups['staff'])) {
			
			$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgExtensionsPath}/wikia/MetricsNY/SiteMetrics.css?{$wgStyleVersion}\"/>\n");
			
			$statistic = $wgRequest->getVal('stat');
			if($statistic=="")$statistic = "Edits";
			
			$wgOut->setPagetitle( "Site Metrics - {$statistic}" );
			
			$stat_link = Title::makeTitle(NS_SPECIAL, "SiteMetrics");
			
			$output .= "<div class=\"sm-navigation\">
				<h2>Editing and Content Statistics</h2>
				<a href=\"".$stat_link->escapeFullURL('stat=Edits')."\">Edits</a>
				<a href=\"".$stat_link->escapeFullURL('stat=Main Namespace Edits')."\">Main Namespace Edits</a>
				<a href=\"".$stat_link->escapeFullURL('stat=New Main Namespace Articles')."\">New Main Namespace Articles</a>
				<a href=\"".$stat_link->escapeFullURL('stat=Anonymous Edits')."\">Anonymous Edits</a>
				<a href=\"".$stat_link->escapeFullURL('stat=Images')."\">Images</a>";
		if($social_tools_available){
                        $output .= "<a href=\"".$stat_link->escapeFullURL('stat=Video')."\">Video</a>
				
				<h2>User and Social Statistics</h2>
				<a href=\"".$stat_link->escapeFullURL('stat=New Users')."\">New Users</a>
				<a href=\"".$stat_link->escapeFullURL('stat=Avatar Uploads')."\">Avatar Uploads</a>
				<a href=\"".$stat_link->escapeFullURL('stat=Profile Updates')."\">Profile Updates</a>
				<a href=\"".$stat_link->escapeFullURL('stat=User Page Edits')."\">User Page Edits</a>
				<a href=\"".$stat_link->escapeFullURL('stat=Friendships')."\">Friendships</a>
				<a href=\"".$stat_link->escapeFullURL('stat=Foeships')."\">Foeships</a>
				<a href=\"".$stat_link->escapeFullURL('stat=Gifts')."\">Gifts</a>
				<a href=\"".$stat_link->escapeFullURL('stat=Wall Messages')."\">Wall Messages</a>
				<a href=\"".$stat_link->escapeFullURL('stat=User Talk Messages')."\">User Talk Messages</a>
				
				<h2>Point and Award Statistics</h2>
				<a href=\"".$stat_link->escapeFullURL('stat=Awards')."\">Awards</a>
				<a href=\"".$stat_link->escapeFullURL('stat=Honorific Advancements')."\">Honorific Advancements</a>
				
				<h2>Casual Game Statistics</h2>
				<a href=\"".$stat_link->escapeFullURL('stat=Polls Created')."\">Polls Created</a>
				<a href=\"".$stat_link->escapeFullURL('stat=Polls Taken')."\">Polls Taken</a>
				<a href=\"".$stat_link->escapeFullURL('stat=Picture Games Created')."\">Picture Games Created</a>
				<a href=\"".$stat_link->escapeFullURL('stat=Picture Games Taken')."\">Picture Games Taken</a>
				<a href=\"".$stat_link->escapeFullURL('stat=Quizzes Created')."\">Quizzes Created</a>
				<a href=\"".$stat_link->escapeFullURL('stat=Quizzes Taken')."\">Quizzes Taken</a>
				
				<h2>Blog and Voting Statistics</h2>
				<a href=\"".$stat_link->escapeFullURL('stat=New Blog Pages')."\">New Blog Pages</a>
				<a href=\"".$stat_link->escapeFullURL('stat=Votes and Ratings')."\">Votes and Ratings</a>
				<a href=\"".$stat_link->escapeFullURL('stat=Comments')."\">Comments</a>
				<a href=\"".$stat_link->escapeFullURL('stat=Invitations to Read Blog Page')."\">Invitations To Read Blog Page</a>
				
				<h2>Viral Statistics</h2>
				<a href=\"".$stat_link->escapeFullURL('stat=Contact Invites')."\">Contact Imports</a>
				<a href=\"".$stat_link->escapeFullURL('stat=User Recruits')."\">User Recruits</a>";
		}
			$output .= "
      </div>
			<div class=\"sm-content\">";	
			
			
			$dbr =& wfGetDB( DB_SLAVE );
			
			if ($statistic=="Edits") {
	
				$sql = "SELECT count( * ) AS the_count,
					Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) as the_date
					From revision WHERE rev_user_text<>'MLB Stats Bot'
					GROUP BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' )
					ORDER BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) DESC
					LIMIT 0,12";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Total Edits By Month",$res, "month");
				
				$sql = "SELECT count( * ) AS the_count,
					Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' ) as the_date
					From revision WHERE rev_user_text<>'MLB Stats Bot'
					GROUP BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' )
					ORDER BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' ) DESC
					LIMIT 0,120";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Total Edits By Day",$res, "day");
			
			} else if ($statistic=="Main Namespace Edits") {
				
				$sql = "SELECT COUNT(*) AS the_count, 
					DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) AS the_date 
					FROM revision INNER JOIN page ON rev_page=page_id WHERE page_namespace=0 
					GROUP BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) 
					ORDER BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y  %m' ) 
					DESC LIMIT 0,12;";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Main Namespace Edits By Month",$res, "month");
				
				$sql = "SELECT COUNT(*) AS the_count, 
					DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' ) AS the_date 
					FROM revision INNER JOIN page ON rev_page=page_id WHERE page_namespace=0 
					GROUP BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' ) 
					ORDER BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y  %m %d' ) 
					DESC LIMIT 0,120;";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Main Namespace Edits By Day",$res, "day");
				
			} else if ($statistic=="New Main Namespace Articles") {
				
				$sql = "SELECT COUNT(*) as the_count, Date_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM revision WHERE rev_page=page_id ORDER BY rev_timestamp asc LIMIT 1) , '%y %m' ) as the_date FROM page WHERE page_namespace=0 GROUP BY Date_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM revision WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1), '%y %m' ) ORDER BY Date_FORMAT( (select FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) from revision where rev_page=page_id order by rev_timestamp asc limit 1), '%y %m' ) DESC LIMIT 0,12;";
	
				$res = $dbr->query($sql);
				$output .= $this->display_stats("New Main Namespace Articles By Month",$res, "month");
				
				$sql = "SELECT COUNT(*) as the_count, Date_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM revision WHERE rev_page=page_id ORDER BY rev_timestamp asc LIMIT 1) , '%y %m %d' ) as the_date FROM page WHERE page_namespace=0 GROUP BY Date_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM revision WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1), '%y %m %d' ) ORDER BY Date_FORMAT( (select FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) from revision where rev_page=page_id order by rev_timestamp asc limit 1), '%y %m %d' ) DESC LIMIT 0,120;";
	
				$res = $dbr->query($sql);
				$output .= $this->display_stats("New Main Namespace Articles By Day",$res, "day");
				
			} else if ($statistic=="Anonymous Edits") {
				
				$sql = "SELECT count( * ) AS the_count,
					Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) as the_date
					From revision
					where rev_user = 0
					GROUP BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' )
					ORDER BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) DESC
					LIMIT 0,12";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Anonymous Edits By Month",$res, "month");
				
				$sql = "SELECT count( * ) AS the_count,
					Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' ) as the_date
					From revision
					where rev_user = 0
					GROUP BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' )
					ORDER BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' ) DESC
					LIMIT 0,120";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Anonymous Edits By Day",$res, "day");
				
			} else if ($statistic=="Images") {
				
				$sql = "SELECT count(*) AS the_count, Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(img_timestamp)), '%y %m')  AS the_date 
				FROM image 
				GROUP BY Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(img_timestamp)), '%y %m') 
				ORDER BY Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(img_timestamp)), '%y %m') DESC 
				LIMIT 0,12";
	
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Images By Month",$res, "month");
				
				$sql = "SELECT count(*) AS the_count, Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(img_timestamp)), '%y %m %d')  AS the_date 
				FROM image 
				GROUP BY Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(img_timestamp)), '%y %m %d') 
				ORDER BY Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(img_timestamp)), '%y %m %d') DESC 
				LIMIT 0,120";
	
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Images by Day",$res, "day");
				
			} else if ($statistic=="Video") {
				
				$sql = "SELECT COUNT(*) as the_count, Date_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM revision WHERE rev_page=page_id ORDER BY rev_timestamp asc LIMIT 1) , '%y %m' ) as the_date FROM page WHERE page_namespace=400 GROUP BY Date_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM revision WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1), '%y %m' ) ORDER BY Date_FORMAT( (select FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) from revision where rev_page=page_id order by rev_timestamp asc limit 1), '%y %m' ) DESC LIMIT 0,12";
				
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Video By Month",$res, "month");
				
				$sql = "SELECT COUNT(*) as the_count, Date_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM revision WHERE rev_page=page_id ORDER BY rev_timestamp asc LIMIT 1) , '%y %m %d' ) as the_date FROM page WHERE page_namespace=400 GROUP BY Date_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM revision WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1), '%y %m %d' ) ORDER BY Date_FORMAT( (select FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) from revision where rev_page=page_id order by rev_timestamp asc limit 1), '%y %m %d' ) DESC LIMIT 0,120";
	
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Video By Day",$res, "day");
				
			} else if ($statistic=="New Users") {
				
				$sql = "SELECT count( * ) AS the_count, Date_FORMAT( `ur_date` , '%y %m' ) as the_date
					FROM `user_register_track`
					GROUP BY Date_FORMAT( `ur_date` , '%y %m' )
					ORDER BY Date_FORMAT( `ur_date` , '%y %m' ) DESC
					LIMIT 0,12";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("New Users By Month",$res, "month");
				
				$sql = "SELECT count( * ) AS the_count, Date_FORMAT( `ur_date` , '%y %m %d' ) as the_date
					FROM `user_register_track`
					GROUP BY Date_FORMAT( `ur_date` , '%y %m %d' )
					ORDER BY Date_FORMAT( `ur_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("New Users By Day",$res, "day");
				
			} else if ($statistic=="Avatar Uploads") {
				
				$sql = "SELECT count(*) AS the_count, Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m') AS the_date FROM logging WHERE log_type='avatar' GROUP BY Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m') ORDER BY Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m') DESC LIMIT 0,12";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Avatar Uploads By Month",$res, "month");
				
				$sql = "SELECT count(*) AS the_count, Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m %d') AS the_date FROM logging WHERE log_type='avatar' GROUP BY Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m %d') ORDER BY Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m %d') DESC LIMIT 0,120";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Avatar Uploads By Day",$res, "day");
				
			} else if ($statistic=="Profile Updates") {
				
				$sql = "SELECT count(*) AS the_count, Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m') AS the_date FROM logging WHERE log_type='profile' GROUP BY Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m') ORDER BY Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m') DESC LIMIT 0,12";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Profile Updates By Month",$res, "month");
				
				$sql = "SELECT count(*) AS the_count, Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m %d') AS the_date FROM logging WHERE log_type='profile' GROUP BY Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m %d') ORDER BY Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m %d') DESC LIMIT 0,120";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Profile Updates By Day",$res, "day");
				
			} else if ($statistic=="Friendships") {
			
				$sql = "SELECT count( * )/2 AS the_count, Date_FORMAT( `r_date` , '%y %m' ) as the_date
					FROM `user_relationship`
					where r_type=1
					GROUP BY Date_FORMAT( `r_date` , '%y %m' )
					ORDER BY Date_FORMAT( `r_date` , '%y %m' ) DESC
					LIMIT 0,12";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Friendships by Month",$res, "month");
				
				$sql = "SELECT count( * )/2 AS the_count, Date_FORMAT( `r_date` , '%y %m %d' ) as the_date
					FROM `user_relationship`
					where r_type=1
					GROUP BY Date_FORMAT( `r_date` , '%y %m %d' )
					ORDER BY Date_FORMAT( `r_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Friendships by Day",$res, "day");
				
			} else if ($statistic=="Foeships") {
				
				$sql = "SELECT count( * )/2 AS the_count, Date_FORMAT( `r_date` , '%y %m' ) as the_date
					FROM `user_relationship`
					where r_type=2
					GROUP BY Date_FORMAT( `r_date` , '%y %m' )
					ORDER BY Date_FORMAT( `r_date` , '%y %m' ) DESC
					LIMIT 0,12";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Foeships By Month",$res, "month");
				
				$sql = "SELECT count( * )/2 AS the_count, Date_FORMAT( `r_date` , '%y %m %d' ) as the_date
					FROM `user_relationship`
					where r_type=2
					GROUP BY Date_FORMAT( `r_date` , '%y %m %d' )
					ORDER BY Date_FORMAT( `r_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Foeships by Day",$res, "day");
				
			} else if ($statistic=="Gifts") {
				
				$sql = "SELECT count( * ) AS the_count, Date_FORMAT( `ug_date` , '%y %m' ) as the_date
					FROM `user_gift`
					GROUP BY Date_FORMAT( `ug_date` , '%y %m' )
					ORDER BY Date_FORMAT( `ug_date` , '%y %m' ) DESC
					LIMIT 0,12";
					
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Gifts by Month",$res, "month");
				
				$sql = "SELECT count( * ) AS the_count, Date_FORMAT( `ug_date` , '%y %m %d' ) as the_date
					FROM `user_gift`
					GROUP BY Date_FORMAT( `ug_date` , '%y %m %d' )
					ORDER BY Date_FORMAT( `ug_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
					
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Gifts by Day",$res, "day");
				
			} else if ($statistic=="Wall Messages") {
				
				$sql = "SELECT count(*) AS the_count, Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(ub_date)), '%y %m') AS the_date FROM user_board GROUP BY Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(ub_date)), '%y %m') ORDER BY Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(ub_date)), '%y %m') DESC LIMIT 0,12";
					
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Wall Messages by Month",$res, "month");
				
				$sql = "SELECT count(*) AS the_count, Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(ub_date)), '%y %m %d') AS the_date FROM user_board GROUP BY Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(ub_date)), '%y %m %d') ORDER BY Date_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(ub_date)), '%y %m %d') DESC LIMIT 0,120";
					
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Wall Messages by Day",$res, "day");
				
			} else if ($statistic=="User Page Edits") {
				
				$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) AS the_date FROM revision INNER JOIN page ON rev_page=page_id WHERE page_namespace=2 GROUP BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) ORDER BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) DESC LIMIT 0,12;";
					
				$res = $dbr->query($sql);
				$output .= $this->display_stats("User Page Edits By Month",$res, "month");
				
				$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' ) AS the_date FROM revision INNER JOIN page ON rev_page=page_id WHERE page_namespace=2 GROUP BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' ) ORDER BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y  %m %d' ) DESC LIMIT 0,120;";
					
				$res = $dbr->query($sql);
				$output .= $this->display_stats("User Page Edits By Day",$res, "day");
				
			} else if ($statistic=="User Talk Messages") {
				
				$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) AS the_date FROM revision INNER JOIN page ON rev_page=page_id WHERE page_namespace=3 GROUP BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) ORDER BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) DESC LIMIT 0,12;";
					
				$res = $dbr->query($sql);
				$output .= $this->display_stats("User Talk Messages By Month",$res, "month");
				
				$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' ) AS the_date FROM revision INNER JOIN page ON rev_page=page_id WHERE page_namespace=3 GROUP BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' ) ORDER BY Date_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y  %m %d' ) DESC LIMIT 0,120;";
					
				$res = $dbr->query($sql);
				$output .= $this->display_stats("User Talk Messages By Day",$res, "day");
				
			} else if ($statistic=="Polls Created") {
				
				$sql = "SELECT count(*) AS the_count, Date_FORMAT( `poll_date` , '%y %m' ) as the_date
					FROM `poll_question`
					GROUP BY Date_FORMAT( `poll_date` , '%y %m' )
					ORDER BY Date_FORMAT( `poll_date` , '%y %m' ) DESC
					LIMIT 0,12";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Polls Created By Month",$res, "month");
				
				$sql = "SELECT count(*) AS the_count, Date_FORMAT( `poll_date` , '%y %m %d' ) as the_date
					FROM `poll_question`
					GROUP BY Date_FORMAT( `poll_date` , '%y %m %d' )
					ORDER BY Date_FORMAT( `poll_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Polls Created By Day",$res, "day");
			
			} else if ($statistic=="Polls Taken") {
				
				$sql = "SELECT count(*) AS the_count, Date_FORMAT( `pv_date` , '%y %m' ) as the_date
					FROM `poll_user_vote`
					GROUP BY Date_FORMAT( `pv_date` , '%y %m' )
					ORDER BY Date_FORMAT( `pv_date` , '%y %m' ) DESC
					LIMIT 0,12";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Polls Taken By Month",$res, "month");
				
				$sql = "SELECT count(*) AS the_count, Date_FORMAT( `pv_date` , '%y %m %d' ) as the_date
					FROM `poll_user_vote`
					GROUP BY Date_FORMAT( `pv_date` , '%y %m %d' )
					ORDER BY Date_FORMAT( `pv_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Polls Taken By Day",$res, "day");
				
			} else if ($statistic=="Picture Games Created") {
				
				$sql = "SELECT count(*) AS the_count, Date_FORMAT( `pg_date` , '%y %m' ) as the_date
					FROM `picturegame_images`
					GROUP BY Date_FORMAT( `pg_date` , '%y %m' )
					ORDER BY Date_FORMAT( `pg_date` , '%y %m' ) DESC
					LIMIT 0,12";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Picture Games Created By Month",$res, "month");
				
				$sql = "SELECT count(*) AS the_count, Date_FORMAT( `pg_date` , '%y %m %d' ) as the_date
					FROM `picturegame_images`
					GROUP BY Date_FORMAT( `pg_date` , '%y %m %d' )
					ORDER BY Date_FORMAT( `pg_date` , '%y %m %d' ) DESC
					LIMIT 0,6";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Picture Games Created By Day",$res, "day");
				
			} else if ($statistic=="Picture Games Taken") {
				
				$sql = "SELECT count(*) AS the_count, Date_FORMAT( `vote_date` , '%y %m' ) as the_date
					FROM `picturegame_votes`
					GROUP BY Date_FORMAT( `vote_date` , '%y %m' )
					ORDER BY Date_FORMAT( `vote_date` , '%y %m' ) DESC
					LIMIT 0,12";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Picture Games Taken By Month",$res, "month");
				
				$sql = "SELECT count(*) AS the_count, Date_FORMAT( `vote_date` , '%y %m %d' ) as the_date
					FROM `picturegame_votes`
					GROUP BY Date_FORMAT( `vote_date` , '%y %m %d' )
					ORDER BY Date_FORMAT( `vote_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Picture Games Taken By Day",$res, "day");
				
			} else if ($statistic=="Quizzes Created") {
				
				$sql = "SELECT count(*) AS the_count, Date_FORMAT( `q_date` , '%y %m' ) as the_date
					FROM `quizgame_questions`
					GROUP BY Date_FORMAT( `q_date` , '%y %m' )
					ORDER BY Date_FORMAT( `q_date` , '%y %m' ) DESC
					LIMIT 0,12";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Quiz Questions Created By Month",$res, "month");
				
				$sql = "SELECT count(*) AS the_count, Date_FORMAT( `q_date` , '%y %m %d' ) as the_date
					FROM `quizgame_questions`
					GROUP BY Date_FORMAT( `q_date` , '%y %m %d' )
					ORDER BY Date_FORMAT( `q_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Quiz Questions Created By Day",$res, "day");
				
			} else if ($statistic=="Quizzes Taken") {
				
				$sql = "SELECT count(*) AS the_count, Date_FORMAT( `a_date` , '%y %m' ) as the_date
					FROM `quizgame_answers`
					GROUP BY Date_FORMAT( `a_date` , '%y %m' )
					ORDER BY Date_FORMAT( `a_date` , '%y %m' ) DESC
					LIMIT 0,12";
	
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Quizzes Taken By Month",$res, "month");
				
				$sql = "SELECT count(*) AS the_count, Date_FORMAT( `a_date` , '%y %m %d' ) as the_date
					FROM `quizgame_answers`
					GROUP BY Date_FORMAT( `a_date` , '%y %m %d' )
					ORDER BY Date_FORMAT( `a_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
	
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Quizzes Taken By Day",$res, "day");
				
			} else if ($statistic=="New Blog Pages") {
				
				$sql = "SELECT COUNT(*) as the_count, Date_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM revision WHERE rev_page=page_id ORDER BY rev_timestamp asc LIMIT 1) , '%y %m' ) as the_date FROM page WHERE page_namespace=500 GROUP BY Date_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM revision WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1), '%y %m' ) ORDER BY Date_FORMAT( (select FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) from revision where rev_page=page_id order by rev_timestamp asc limit 1), '%y %m' ) DESC LIMIT 0,12;";
	
				$res = $dbr->query($sql);
				$output .= $this->display_stats("New Blog Pages By Month",$res, "month");
				
				$sql = "SELECT COUNT(*) as the_count, Date_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM revision WHERE rev_page=page_id ORDER BY rev_timestamp asc LIMIT 1) , '%y %m %d' ) as the_date FROM page WHERE page_namespace=500 GROUP BY Date_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM revision WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1), '%y %m %d' ) ORDER BY Date_FORMAT( (select FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) from revision where rev_page=page_id order by rev_timestamp asc limit 1), '%y %m %d' ) DESC LIMIT 0,120;";
	
				$res = $dbr->query($sql);
				$output .= $this->display_stats("New Blog Pages By Day",$res, "day");
		
			} else if ($statistic=="Votes and Ratings") {
				
				$sql = "SELECT count( * ) AS the_count, Date_FORMAT( `Vote_Date` , '%y %m' ) as the_date
					FROM `Vote`
					GROUP BY Date_FORMAT( `Vote_Date` , '%y %m' )
					ORDER BY Date_FORMAT( `Vote_Date` , '%y %m' ) DESC
					LIMIT 0,12";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Votes and Ratings By Month",$res, "month");
				
				$sql = "SELECT count( * ) AS the_count, Date_FORMAT( `Vote_Date` , '%y %m %d' ) as the_date
					FROM `Vote`
					GROUP BY Date_FORMAT( `Vote_Date` , '%y %m %d' )
					ORDER BY Date_FORMAT( `Vote_Date` , '%y %m %d' ) DESC
					LIMIT 0,120";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Votes and Ratings By Day",$res, "day");
				
				
			} else if ($statistic=="Comments") {
				
				$sql = "SELECT count( * ) AS the_count, Date_FORMAT( `Comment_Date` , '%y %m' ) as the_date
					FROM `Comments`
					GROUP BY Date_FORMAT( `Comment_Date` , '%y %m' )
					ORDER BY Date_FORMAT( `Comment_Date` , '%y %m' ) DESC
					LIMIT 0,12";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Comments By Month",$res, "month");
				
				$sql = "SELECT count( * ) AS the_count, Date_FORMAT( `Comment_Date` , '%y %m %d' ) as the_date
					FROM `Comments`
					GROUP BY Date_FORMAT( `Comment_Date` , '%y %m %d' )
					ORDER BY Date_FORMAT( `Comment_Date` , '%y %m %d' ) DESC
					LIMIT 0,120";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Comment By Day",$res, "day");
				
			} else if ($statistic=="Contact Invites") {
				
				$sql = "SELECT sum( ue_count ) AS the_count, Date_FORMAT( `ue_date` , '%y %m' ) as the_date
						FROM `user_email_track`
						where ue_type in (1,2,3)
						GROUP BY Date_FORMAT( `ue_date` , '%y %m' )
						ORDER BY Date_FORMAT( `ue_date` , '%y %m' ) DESC
						LIMIT 0,12";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Contact Invites By Month",$res, "month");
				
				$sql = "SELECT sum( ue_count ) AS the_count, Date_FORMAT( `ue_date` , '%y %m %d' ) as the_date
					FROM `user_email_track`
					where ue_type in (1,2,3)
					GROUP BY Date_FORMAT( `ue_date` , '%y %m %d' )
					ORDER BY Date_FORMAT( `ue_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Contact Invites By Day",$res, "day");
				
			} else if ($statistic=="Invitations to Read Blog Page") {
				
				$sql = "SELECT sum( ue_count ) AS the_count, Date_FORMAT( `ue_date` , '%y %m' ) as the_date
					FROM `user_email_track`
					where ue_type in (4)
					GROUP BY Date_FORMAT( `ue_date` , '%y %m' )
					ORDER BY Date_FORMAT( `ue_date` , '%y %m' ) DESC
					LIMIT 0,12";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Invitations to Read Blog Page By Month",$res, "month");
				
				$sql = "SELECT sum( ue_count ) AS the_count, Date_FORMAT( `ue_date` , '%y %m %d' ) as the_date
					FROM `user_email_track`
					where ue_type in (4)
					GROUP BY Date_FORMAT( `ue_date` , '%y %m %d' )
					ORDER BY Date_FORMAT( `ue_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Invitations to Read Blog Page By Day",$res, "day");
				
			} else if ($statistic=="User Recruits") {
				
				$sql = "SELECT count( * ) AS the_count, Date_FORMAT( `ur_date` , '%y %m' ) as the_date
					FROM `user_register_track`
					where ur_user_id_referral <> 0
					GROUP BY Date_FORMAT( `ur_date` , '%y %m' )
					ORDER BY Date_FORMAT( `ur_date` , '%y %m' ) DESC
					LIMIT 0,12";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("User Recruits By Month",$res, "month");
				
				$sql = "SELECT count( * ) AS the_count, Date_FORMAT( `ur_date` , '%y %m %d' ) as the_date
					FROM `user_register_track`
					where ur_user_id_referral <> 0
					GROUP BY Date_FORMAT( `ur_date` , '%y %m %d' )
					ORDER BY Date_FORMAT( `ur_date` , '%y %m %d' ) DESC
					LIMIT 0,12";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("User Recruits By Day",$res, "day");
				
			} else if ($statistic=="Awards") {
				
				$sql = "SELECT count( * ) AS the_count, Date_FORMAT( `sg_date` , '%y %m' ) as the_date FROM `user_system_gift` GROUP BY Date_FORMAT( `sg_date` , '%y %m' ) ORDER BY Date_FORMAT( `sg_date` , '%y %m' ) DESC LIMIT 0,12";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Awards By Month",$res, "month");
				
				$sql = "SELECT count( * ) AS the_count, Date_FORMAT( `sg_date` , '%y %m %d' ) as the_date FROM `user_system_gift` GROUP BY Date_FORMAT( `sg_date` , '%y %m %d' ) ORDER BY Date_FORMAT( `sg_date` , '%y %m %d' ) DESC LIMIT 0,120";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Awards By Day",$res, "day");
				
			} else if ($statistic=="Honorific Advancements") {
				
				$sql = "SELECT count( * ) AS the_count, Date_FORMAT( `um_date` , '%y %m' ) as the_date FROM `user_system_messages` GROUP BY Date_FORMAT( `um_date` , '%y %m' ) ORDER BY Date_FORMAT( `um_date` , '%y %m' ) DESC LIMIT 0,12";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Awards By Month",$res, "month");
				
				$sql = "SELECT count( * ) AS the_count, Date_FORMAT( `um_date` , '%y %m %d' ) as the_date FROM `user_system_messages` GROUP BY Date_FORMAT( `um_date` , '%y %m %d' ) ORDER BY Date_FORMAT( `um_date` , '%y %m %d' ) DESC LIMIT 0,120";
				$res = $dbr->query($sql);
				$output .= $this->display_stats("Awards By Day",$res, "day");
				
			}
			
			$output .= "</div>";
			
			$wgOut->addHTML($output);
		}
		else {
			$output .= "You must be staff to view this page";
			/*
			foreach($user_groups as $key=>$value) {
				$output .= "{$key}:{$value}<br/>";	
			}
			*/
			$wgOut->setPageTitle("Permission Denied");
			$wgOut->addHTML($output);
		}
	}
}
