<?php

$wgExtensionFunctions[] = 'wfAdminPoll';

function wfAdminPoll(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class AdminPoll extends SpecialPage {

	
	function AdminPoll(){
		UnlistedSpecialPage::UnlistedSpecialPage("AdminPoll");
	}

	
	function execute(){
		global $wgRequest, $wgUser, $wgOut, $wgRequest, $IP, $wgStyleVersion, $wgUploadPath, $wgPollScripts;
		
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgPollScripts}/Poll.css?{$wgStyleVersion}\"/>\n");
		
		global $wgMessageCache;
		require_once ( "Poll.i18n.php" );
		foreach( efWikiaPoll() as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}
		
		$wgOut->addHTML("<script>
				var _POLL_OPEN_MESSAGE = \"" . addslashes(wfMsgForContent( 'poll_open_message' )) . "\"
				var _POLL_CLOSE_MESSAGE = \"" . addslashes(wfMsgForContent( 'poll_close_message' )) . "\"
				var _POLL_FLAGGED_MESSAGE = \"" . addslashes(wfMsgForContent( 'poll_flagged_message' )) . "\"
				var _POLL_DELETE_MESSAGE = \"" . addslashes(wfMsgForContent( 'poll_delete_message' )) . "\"
				
			function poll_admin_status(id, status){
				if(status==0)msg = _POLL_CLOSE_MESSAGE
				if(status==1)msg = _POLL_OPEN_MESSAGE
				if(status==2)msg = _POLL_FLAGGED_MESSAGE
				var ask = confirm(msg);
			
				if (ask){
					var url = \"index.php?action=ajax\";
					var pars = 'rs=wfUpdatePollStatus&rsargs[]=' + id + '&rsargs[]=' + status
					var callback = {
						success: function( oResponse ) {
							\$(\"poll-\" + id + \"-controls\").innerHTML = \"action complete\"
						}
					};
					var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);			
				}			
			}
			function poll_delete(id){
				msg = _POLL_DELETE_MESSAGE
				var ask = confirm(msg);
			
				if (ask){
					var url = \"index.php?action=ajax\";
					var pars = 'rs=wfDeletePoll&rsargs[]=' + id
					var callback = {
						success: function( oResponse ) {
							\$(\"poll-\" + id + \"-controls\").innerHTML = \"action complete\"
						}
					};
					var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);			
				}			
			}
		</script>");
		
		//pagination
		$per_page = 20;
		$page = $wgRequest->getVal('page');
		if(!$page  || !is_numeric($page) )$page=1;
		
		$current_status = $wgRequest->getVal("status");
		if( !$current_status ) $current_status = "all";
		
		$limit=$per_page;

		if ($limit > 0) {
				$limitvalue = 0;
				if($page)$limitvalue = $page * $limit - ($limit); 
				$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}
		
		//safelinks
		$random_poll_link = Title::makeTitle(NS_SPECIAL, "RandomPoll");
		
		$nav = array(
				"all" => wfMsg("poll_admin_viewall"),
				"open" => wfMsg("poll_admin_open"),
				"closed" => wfMsg("poll_admin_closed"),
				"flagged" => wfMsg("poll_admin_flagged")
		);
				
		$output .= "
		<div class=\"view-poll-top-links\">
			<a href=\"javascript:history.go(-1);\">" . wfMsg( 'poll_take_button' ) . "</a>
		</div>
		
		<div class=\"view-poll-navigation\">
			<h2>" . wfMsgForContent( 'poll_admin_status_nav' ) . "</h2>";
		
			foreach( $nav as $status => $title){
				
				$output .= "<p>";
				if( $current_status != $status ){
					$output .= "<a href=\"" . Title::makeTitle( NS_SPECIAL, "AdminPoll")->escapeFullURL("status={$status}") . "\">{$title}</a>";
				}else{
					$output .= "<b>{$title}</b>";
				}
				
				$output .= "</p>";
			}
			
		
		$output .= "</div>";
		
		$wgOut->setPageTitle( wfMsg( 'poll_admin_title' , $nav[$current_status] ) );
		
		$dbr =& wfGetDB( DB_MASTER );

		$params['ORDER BY'] = "poll_date desc";
		if($limit)$params['LIMIT'] = $limit;
		if($page)$params["OFFSET"] = $page * $limit - ($limit); 
		
		$status_int = -1;
		switch ($current_status){
			case "open":
				$status_int = 1;
				break;
			case "closed":
				$status_int = 0;
				break;
			case "flagged":
				$status_int = 2;
				break;
		}
		if( $status_int > -1 ){
			$where["poll_status"] = $status_int;
		}
	
		$dbr =& wfGetDB( DB_MASTER );
		$res = $dbr->select( '`poll_question` INNER JOIN page ON poll_page_id=page_id', 
				array(
					'poll_id', 'poll_user_id', 'UNIX_TIMESTAMP(poll_date) as poll_time', 'poll_status',
					'poll_vote_count', 'poll_user_name','poll_text', 'poll_page_id', 'page_id'
				
				),
			$where, __METHOD__, 
			$params
		);
		
		if( $status_int > -1 ){
			$where["poll_status"] = $status;
		}
		
		$s = $dbr->selectrow( '`poll_question` ', 
				array('count(*) as count'
				),
			$where, __METHOD__, 
			$params
		);
		
		$total = $s->count;
		
		
		$output .= "<div class=\"view-poll\">";
		
			
			$x = (($page-1)*$per_page) + 1; 
			
			
			while ( $row = $dbr->fetchObject($res) ) {
				
				$user_create = $row->poll_user_name;
				$user_id = $row->poll_user_id;
				$avatar = new wAvatar($user_id,"m");
				$poll_title = $row->poll_text;
				$poll_date = $row->poll_time;
				$poll_answers = $row->poll_vote_count;
				$row_id = "poll-row-{$x}";
				$title = Title::makeTitle(NS_POLL,  $poll_title ) ;
				
				$p = new Poll();
				$poll_choices = $p->get_poll_choices( $row->poll_id );
				
				if (($x < $dbr->numRows($res) ) && ($x%$per_page != 0)) {
					$output .= "<div class=\"view-poll-row\" id=\"{$row_id}\" \">";
				} else {
					$output .= "<div class=\"view-poll-row-bottom\" id=\"{$row_id}\"  \">";
				}
				
					$output .= "<div class=\"view-poll-number\">{$x}.</div>
					<div class=\"view-poll-user-image\"><img src=\"{$wgUploadPath}/avatars/{$avatar->getAvatarImage()}\" /></div>
					<div class=\"view-poll-user-name\">{$user_create}</div>
					<div class=\"view-poll-text\">
					<p><b><a href=\"{$title->escapeFullURL()}\">{$poll_title}</a></b></p>
					<p>";
					foreach($poll_choices as $choice){
						$output .= "{$choice["choice"]}<br>";
					}
					$output .= "</p>
						<p class=\"view-poll-num-answers\">" . wfMsgForContent( 'poll_view_answered' ) . " {$poll_answers} " .  wfMsgExt( 'poll_view_times', 'parsemag', $poll_answers) . "</p>
						<p class=\"view-poll-time\">(".get_time_ago($poll_date)."ago)</p>
						<div id=\"poll-{$row->poll_id}-controls\">";
						if( $row->poll_status == 2 ){
							$output .= "<a href=\"javascript:void(0)\" onclick=\"poll_admin_status({$row->poll_id},1);\">" . wfMsg("poll_unflag_poll") . "</a>";
						}
						if( $row->poll_status == 0 ){
							$output .= " <a href=\"javascript:void(0)\" onclick=\"poll_admin_status({$row->poll_id},1);\">" . wfMsg("poll_open_poll") . "</a>";
						}
						if( $row->poll_status == 1 ){
							$output .= " <a href=\"javascript:void(0)\" onclick=\"poll_admin_status({$row->poll_id},0);\">" . wfMsg("poll_close_poll") . "</a>";
						}
						$output .= " <a href=\"javascript:void(0)\" onclick=\"poll_delete({$row->poll_id});\">" . wfMsg("poll_delete_poll") . "</a>
						</div>
					</div>
					<div class=\"cleared\"></div>
				</div>";
				
				$x++;
			}
		
		$output .= "</div>
		<div class=\"cleared\"></div>";
		
		$numofpages = $total / $per_page; 
		
		if($numofpages>1){
			$output .= "<div class=\"view-poll-page-nav\">";
			if($page > 1){ 
				$output .= "<a href=\"/index.php?title=Special:ViewPoll&type=most{$user_link}&page=" . ($page-1) . "\">prev</a> ";
			}
			
			
			if(($total % $per_page) != 0)$numofpages++;
			if($numofpages >=9 && $page < $total)$numofpages=9+$page;
			if($numofpages >= ($total / $per_page) )$numofpages = ($total / $per_page)+1;
			
			for($i = 1; $i <= $numofpages; $i++){
				if($i == $page){
				    $output .=($i." ");
				}else{
				    $output .="<a href=\"/index.php?title=Special:ViewPoll&type=most{$user_link}&page=$i\">$i</a> ";
				}
			}
	
			if(($total - ($per_page * $page)) > 0){
				$output .=" <a href=\"/index.php?title=Special:ViewPoll&type=most{$user_link}&page=" . ($page+1) . "\">next</a>"; 
			}
			$output .= "</div>";
		}
		
		$wgOut->addHTML($output);
	
	}
  
 
	
}

SpecialPage::addPage( new AdminPoll );

 


}

?>