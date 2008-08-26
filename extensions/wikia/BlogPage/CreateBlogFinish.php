<?php

$wgHooks['ArticleInsertComplete'][] = 'wfCreateBlogCheck';
$wgHooks['OutputPageBeforeHTML'][] = 'wfFinishCreateBlog';


function wfCreateBlogCheck(&$article, &$user, &$text, &$summary, &$minoredit, &$watchthis, &$sectionanchor, &$flags){
	global $wgOut, $wgTitle, $wgArticle, $wgUser, $wgRequest, $wgSendNewArticleToFriends, $wgEnableFacebook, $wgBlogCategory;

	//If the user has created a new opinion, we want to turn on a session flag
	if( $wgTitle->getNamespace() == NS_BLOG ){
		 $_SESSION["new_opinion"] = str_replace("?","%3F",$wgTitle->getPrefixedText());
	}
	
	return true;
}

function wfFinishCreateBlog(){
	global $wgOut, $wgTitle, $wgArticle, $wgUser, $wgRequest, $IP, $wgVoteDirectory, $wgSendNewArticleToFriends, $wgEnableFacebook;
	
	if(isset($_SESSION["new_opinion"])){	
		
		wfVoteForPageOnCreate();
		
		$stats = new UserStatsTrack($wgUser->getID(), $wgUser->getName());
		$stats->updateWeeklyPoints($stats->point_values["opinions_created"]);
		$stats->updateMonthlyPoints($stats->point_values["opinions_created"]);
		
		if($wgEnableFacebook)wfFacebookUpdateProfile();		
		if($wgSendNewArticleToFriends)wfInviteRedirect();
		
		unset($_SESSION["new_opinion"]);
	}
	return true;
}

function wfVoteForPageOnCreate(){
	global $IP, $wgUser, $wgTitle;
	
	$Vote = new Vote( $wgTitle->getArticleID() );
	$Vote->insert(1);
}

function wfFacebookUpdateProfile(){
	global $wgUser, $IP, $wgTitle;
	//check if the current user has the app installed
	$dbr =& wfGetDB( DB_MASTER );
	$s = $dbr->selectRow( '`fb_link_view_opinions`', array( 'fb_user_id','fb_user_session_key' ), array( 'fb_user_id_wikia' => $wgUser->getID() ), $fname );
	if ( $s !== false ) {
		require_once "$IP/extensions/wikia/Facebook/appinclude.php";
		$facebook = new Facebook($appapikey, $appsecret);
		//$facebook->api_client->auth_getSession("QR1YVV");
		//$facebook->api_client->session_key = "QR1YVV";
	
		////update facebook profile
		try{
			$facebook->api_client->session_key = $infinite_session_key;
			$facebook->api_client->fbml_refreshRefUrl("http://sports.box8.tpa.wikia-inc.com/index.php?title=Special:FacebookGetOpinions&id={$s->fb_user_id}");
		}catch(exception $ex){
		
		}
		
		
		$feed_title = '<fb:userlink uid="'.$s->fb_user_id.'" /> wrote a new article on <a href=\"http://www.armchairgm.com\">ArmchairGM.com</a>';
		$feed_body = "<a href=\"{$wgTitle->getFullURL()}\">{$wgTitle->getText()}</a>";
		try{
			$facebook->api_client->feed_publishActionOfUser($feed_title, $feed_body);
		}catch(exception $ex){
		 
		}
		
	}
	return true;
}

function wfInviteRedirect(){
	global $wgOut;
	$invite =  Title::makeTitle( NS_SPECIAL  , "EmailNewArticle"  );
	$wgOut->redirect( $invite->getFullURL("page=" . $_SESSION["new_opinion"]) );
}
?>