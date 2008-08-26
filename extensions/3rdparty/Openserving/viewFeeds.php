<?php
$wgExtensionFunctions[] = "wfViewFeeds";

function wfViewFeeds() {
    global $wgParser, $wgOut, $wgSiteView, $wgRequest;
	if($wgSiteView->isUserAdmin() == true && $wgSiteView->getDomainName()!="" ){
		$wgOut->setOnloadHandler( "start();" );
	}
	$wgParser->setHook( "viewFeeds", "renderFeeds" );
}

function renderFeeds( $input ) {
	global $wgOut;
	require_once ('ListPagesClass.php');
	purgePage();
	$wgOut->setOnloadHandler( "start()" );
	$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/viewFeeds.js\"></script>\n");
	$output = "";
	//$output .= " status: <span id=status></span><br> status2: <span id=status2></span>";
	$output .= "<a href=javascript:addFeed()>Add Feed</a><br><br><div id=listpages>";
	$items .= "var feedItems = [];";
	$dbr =& wfGetDB( DB_SLAVE );
	$sql = "SELECT feed_id,feed_title,feed_count,feed_ctg,feed_order_by,feed_item_order FROM feeds WHERE feed_mirror_id=1 ORDER BY feed_item_order";
	$res = $dbr->query($sql);
	$x = 0;
	while ($row = $dbr->fetchObject( $res ) ) {
		
		$output .= "<div class=feedItem id=item_" . $row->feed_id . ">";
		$output .= "<span class=feedEdit><a href=# class=editFeed id=el_" . $row->feed_id . " >edit<a> | <a href=# class=deleteFeed id=dl_" . $row->feed_id . ">remove</a></span>";
	 	
		$output .= "<span class=title>" . $row->feed_title . "</span>";
		$output .= "<br><br>";
	
		$list = new ListPages();
		$list->setCategory($row->feed_ctg);
		$list->setShowCount($row->feed_count);
		$list->setPageNo(1);
		$list->setOrder($row->feed_order_by);
		$list->setShowDetails("VoteBox");
		$list->setShowPublished("Yes");
		$output .=  $list->DisplayList();
	
		$output .= "</div>";
		$items .= "feedItems[" . $x  . "] = {id:" . $row->feed_id . ",title:'" .  str_replace("'","\'",$row->feed_title)  . "',categories:'" .  str_replace("'","\'",$row->feed_ctg)  . "',count:" .  $row->feed_count  . ",itemOrder:" .  $x  . ",orderBy:'" .  $row->feed_order_by  . "'};";
	 	$x++;
	 }
	
	$output .= "</div>";
	
	$output .= "<script>" . $items . "</script>";
	return $output;
}


?>
