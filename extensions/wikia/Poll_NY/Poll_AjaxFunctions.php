<?php
$wgAjaxExportList [] = 'wfPollTitleExists';
function wfPollTitleExists($page_name){ 
	
	//construct page title object to convert to Database Key
	$page_title =  Title::makeTitle( NS_MAIN  , urldecode($page_name) );
	$db_key = $page_title->getDBKey();
	
	//Database key would be in page title if the page already exists
	$dbr =& wfGetDB( DB_MASTER );
	$s = $dbr->selectRow( 'page', array( 'page_id' ), array( 'page_title' => $db_key , 'page_namespace'=>NS_POLL),"" );
	if ( $s !== false ) {
		return "Page exists";
	} else {
		return "OK";
	}
}

$wgAjaxExportList [] = 'wfPollVote';
function wfPollVote($poll_id,$choice_id){ 
	global $IP, $wgMemc, $wgUser;
	 
	$p = new Poll();
	if(! $p->user_voted( $wgUser->getName(), $poll_id ) ){
		$p->add_poll_vote($poll_id,$choice_id);
	}
	return "ok";
}

$wgAjaxExportList [] = 'wfGetRandomPoll';
function wfGetRandomPoll(){ 
	global $IP, $wgMemc, $wgUser;
	 
	$p = new Poll();

	$poll_page = $p->get_random_poll_url( $wgUser->getName() );
	return $poll_page;
}

$wgAjaxExportList [] = 'wfUpdatePollStatus';
function wfUpdatePollStatus($poll_id,$status){ 
	global $IP, $wgMemc, $wgUser;
	 
	$p = new Poll();
	if( $status == 2 || $p->does_user_own_poll($wgUser->getID(),$poll_id) || $wgUser->isAllowed("protect") ){
		$p->update_poll_status($poll_id,$status );
		return "Status successfully changed";
	}else{
		return "error";
	}
}

$wgAjaxExportList [] = 'wfDeletePoll';
function wfDeletePoll( $poll_id ){ 
	global $IP, $wgMemc, $wgUser;
	
	if( ! $wgUser->isAllowed('protect') ){
		return "";
	}
	
	$dbr =& wfGetDB( DB_MASTER );
	
	if( $poll_id > 0 ){
		$s = $dbr->selectRow( '`poll_question`', array( 'poll_page_id' ), array('poll_id'=>$poll_id ), $fname );
			
		if( $s!==false){
			
			$dbr->delete( 'poll_user_vote',
			array( 'pv_poll_id' =>  $poll_id  ),
			__METHOD__ );
						
			$dbr->delete( 'poll_choice',
			array( 'pc_poll_id' =>  $poll_id  ),
			__METHOD__ );
					
			$dbr->delete( 'poll_question',
			array( 'poll_page_id' => $s->poll_page_id ),
			__METHOD__ );
			
			$poll_title = Title::newFromId( $s->poll_page_id );
			$article = new Article($poll_title);
			$article->doDeleteArticle( "delete poll");
		}
	}
	return "ok";
}


$wgAjaxExportList [] = 'wfGetPollResults';
function wfGetPollResults($page_id){ 
	global $IP, $wgMemc, $wgUser, $wgUploadPath, $wgPollDirectory, $wgMessageCache;
	
	require_once ( "{$wgPollDirectory}/Poll.i18n.php" );
	foreach( efWikiaPoll() as $lang => $messages ){
		$wgMessageCache->addMessages( $messages, $lang );
	}
		
	$p = new Poll();
	$poll_info = $p->get_poll($page_id);
	$x = 1;
	
	$output = "";
	foreach($poll_info["choices"] as $choice){
		//$percent = round( $choice["votes"] / $poll_info["votes"]  * 100 );
		if( $poll_info["votes"] > 0 ){
			$bar_width = floor( 480 * ( $choice["votes"] / $poll_info["votes"] ) );
		}
		$bar_img = "<img src=\"{$wgUploadPath}/common/vote-bar-{$x}.gif\"  border=\"0\" class=\"image-choice-{$x}\" style=\"width:{$choice["percent"]}%;height:12px;\"/>";
		
		$output .= "<div class=\"poll-choice\">
		<div class=\"poll-choice-left\">{$choice["choice"]} ({$choice["percent"]}%)</div>";
		
		$output .= "<div class=\"poll-choice-right\">{$bar_img} <span class=\"poll-choice-votes\">".(($choice["votes"] > 0)?"{$choice["votes"]}":"0")." " . wfMsgExt( 'poll_votes' , "parsemag",  $choice["votes"] ) ."</span></div>";
		$output .= "</div>";
		
		$x++;
	}
	return $output;
}
?>