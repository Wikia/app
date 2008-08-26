<?php

$wgExtensionFunctions[] = 'wfSpecialGenerateTopUsersReport';


function wfSpecialGenerateTopUsersReport(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class GenerateTopUsersReport extends UnlistedSpecialPage {

  function GenerateTopUsersReport(){
    UnlistedSpecialPage::UnlistedSpecialPage("GenerateTopUsersReport");
  }

  function execute($period){
    global $wgUser, $wgOut, $wgRequest; 


    $period = $wqRequest->getVal("period");
    
    $wgOut->setPagetitle( "Generate Top Users Report" );
    
        $css = "
    	<style>
  

.top-fan{
	width:160px;
	padding-right:10px;
	font-weight: bold;
	font-size: 90%;
	float: left;
}

.top-fan a{
	font-size:13px;
}

.top-fan img {
	vertical-align: middle;
	padding-right:4px;
}

.top-fan-num{
	font-weight: bold;
	font-size: 18px;
	color:#cccccc;
	float: left;
	width:25px;
	padding-top:5px;
}

.top-fan-points{
	float: left;
	font-size: 13px;
	color:#666666;
	height:30px;
	padding-top:5px;
}



.top-fan-row { 
	min-height: 1.7em; /*for the hover*/
	clear: both; 
	padding-bottom:3px;
}

.top-fan-level{
	font-size:16px;
	font-weight:800;
	color:#666666;
}
</style>
";
	$wgOut->addHTML($css);

    
    $user_count = $wgRequest->getVal("user_count");
    if(!$user_count)$user_count = 10;



if($period=="weekly"){
	$period_title = date("m/d/Y",strtotime("-1 week")) . "-" .  date("m/d/Y",time()) ;
}else{
	$period_title = date("M Y",strtotime("-1 month"));
}

    
    $dbr =& wfGetDB( DB_MASTER );
    $sql = "SELECT up_user_id, up_user_name, up_points from user_points_{$period} 
   	    ORDER BY up_points DESC LIMIT 0,{$user_count}";
    $res = $dbr->query($sql);




	
    $out .= "<div class=\"top-users\">";
   
    $last_total = 0;
    $x = 1;
    while ($row = $dbr->fetchObject( $res ) ) {
	    if($row->up_points==$last_total){
		    $rank = $last_rank;
	    }else{
		    $rank = $x;
	    }
	    $last_rank = $x;
	    $last_total = $row->up_points;
	    $x++;
	    $users[] = array("user_id" => $row->up_user_id,"user_name"=> $row->up_user_name,"points"=>$row->up_points,"rank"=> $rank);
    }
	
   
    $winner_count=0;
    $winner = "";
    foreach($users as $user){
	    $user_title = Title::makeTitle( NS_USER  ,  $user["user_name"]  );
	    
	    if($user["rank"] == 1){
		    $stats = new UserStatsTrack($user["user_id"],$user["user_name"]);
		    $stats->incStatField("points_winner_{$period}");
		    if($winners)$winners .=", ";
		    $winners .= "[[User:{$user["user_name"]}|{$user["user_name"]}]]";
		    $winner_count++;
	    }
    }
    
    $page_content = "__NOTOC__\n";
    
    if($winner_count==1){
	    $page_content .= "==".ucwords($period)." Winner==\n\n";
    }else{
	    $page_content .= "==".ucwords($period)." Winners==\n\n";
    }
    $page_content .= "Congratulations to the following user" . (($winner_count>1)?"s":"") . ", who earned a {$period} win and '''{$stats->point_values["points_winner_{$period}"]}''' extra points\n\n";
    $page_content .= "=={$winners}==\n\n<br>\n";
    
    $page_content .= "==Full Top $user_count==\n\n";
    
    foreach($users as $user){
	    $user_title = Title::makeTitle( NS_USER  ,  $user["user_name"]  );    
	    $page_content .=  "({$user["rank"]}) [[User:{$user["user_name"]}|{$user["user_name"]}]] - '''" . number_format($user["points"]) . "''' points\n\n";
	 
	    $out .= "<div class=\"top-fan-row\">
			<span class=\"top-fan-num\">{$user["rank"]}</span><span class=\"top-fan\"> <a href='" . $user_title->getFullURL() . "' >" . $user["user_name"] . "</a>
			</span>";
			
	    $out .=  "<span class=\"top-fan-points\"><b>" . number_format($user["points"]) . "</b> points</span>
		</div>";
    }
    
    $wgUser = User::newFromName( 'MediaWiki default' );
    $wgUser->addGroup( 'bot' );
    
     $page_content .= "\n\n''this page was generated automatically''\n\n";

    $title = Title::makeTitleSafe(NS_COMMENT_FORUM, "{$period} User Points Report ({$period_title})");
    
	$article = new Article( $title );
	if(!$article->exists()){
   	$article->doEdit(  $page_content, "automated {$period} user report " );
	
		$date = date("Y-m-d H:i:s");
		//archive points
		$dbr->insertSelect( 'user_points_archive', "user_points_{$period}",
				array(
					'up_user_name' => 'up_user_name',
					'up_user_id' => 'up_user_id',
					'up_points'=> 'up_points',
					'up_period' => (($period=="weekly")?1:2),
					'up_date' => $dbr->addQuotes($date)
				), "*" , __METHOD__
			);
			
	$res = $dbr->query("Delete from user_points_{$period} ");
	}
	    
     $out .= "</div>";
    $wgOut->addHTML($out);
  
  }

}

 SpecialPage::addPage( new GenerateTopUsersReport );
 global $wgMessageCache,$wgOut;
 
}

?>