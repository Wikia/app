<?php
define( 'NS_LINK', 700 );
define( 'LINK_APPROVED_STATUS', 1 );
define( 'LINK_OPEN_STATUS', 0 );
define( 'LINK_REJECTED_STATUS', 2 );

$wgAutoloadClasses["Link"] = "{$wgLinkFilterDirectory}/LinkClass.php";
$wgAutoloadClasses["LinkList"] = "{$wgLinkFilterDirectory}/LinkClass.php";

//Special Pages
$wgAutoloadClasses['LinksHome'] = "{$wgLinkFilterDirectory}/SpecialLinksHome.php";
$wgSpecialPages['LinksHome'] = 'LinksHome';

$wgAutoloadClasses['LinkSubmit'] = "{$wgLinkFilterDirectory}/SpecialLinkSubmit.php";
$wgSpecialPages['LinkSubmit'] = 'LinkSubmit';

$wgAutoloadClasses['LinkRedirect'] = "{$wgLinkFilterDirectory}/SpecialLinkRedirect.php";
$wgSpecialPages['LinkRedirect'] = 'LinkRedirect';

$wgAutoloadClasses['LinkApprove'] = "{$wgLinkFilterDirectory}/SpecialLinkApprove.php";
$wgSpecialPages['LinkApprove'] = 'LinkApprove';

$wgAutoloadClasses['LinkEdit'] = "{$wgLinkFilterDirectory}/SpecialLinkEdit.php";
$wgSpecialPages['LinkEdit'] = 'LinkEdit';

require_once ("{$wgLinkFilterDirectory}/LinkFilter_AjaxFunctions.php" );

//default setup for displaying sections
$wgLinkPageDisplay['leftcolumn'] = true;
$wgLinkPageDisplay['rightcolumn'] = false;
$wgLinkPageDisplay['author'] = true;
$wgLinkPageDisplay['author_articles'] = false;
$wgLinkPageDisplay['recent_editors'] = false;
$wgLinkPageDisplay['recent_voters'] = false;
$wgLinkPageDisplay['left_ad'] = false;
$wgLinkPageDisplay['popular_articles'] = false;
$wgLinkPageDisplay['in_the_news'] = false;
$wgLinkPageDisplay['comments_of_day'] = true;
$wgLinkPageDisplay['games'] = true;
$wgLinkPageDisplay['new_links'] = false;

$wgGroupPermissions['linkadmin']["read"]  = true;

$wgAvailableRights[] = 'linkadmin';
$wgGroupPermissions['staff']['linkadmin'] = true;
$wgGroupPermissions['sysop']['linkadmin'] = true;
$wgGroupPermissions['helper']['linkadmin'] = true;

$wgHooks['TitleMoveComplete'][] = 'fnUpdateLinkFilter';
function fnUpdateLinkFilter(&$title, &$newtitle, &$user, $oldid, $newid) {
	if($title->getNamespace() == NS_LINK){
		$dbr =& wfGetDB( DB_MASTER );
		$dbr->update( 'link',
		array( 'link_name' => $newtitle->getText() ),
		array( 'link_page_id' => $oldid ),
		__METHOD__ );
	}
	return true;
}

$wgHooks['ArticleDelete'][] = 'fnDeleteLinkFilter';
function fnDeleteLinkFilter(&$article, &$user, $reason) {
	global $wgTitle;
	if($wgTitle->getNamespace() == NS_LINK){
		//delete link recorda
		$dbr =& wfGetDB( DB_MASTER );
		$dbr->update( '`link`',
		array( /* SET */
			'link_status' => LINK_REJECTED_STATUS
			), array( /* WHERE */
			'link_page_id' => $article->getID()
			), ""
		);
	
	}
	return true;
}

$wgLinkFilterAdminPointsRequirement = 75000;
$wgHooks['ArticleFromTitle'][] = 'wfLinkFromTitle';

//ArticleFromTitle
//Calls VideoPage instead of standard article
function wfLinkFromTitle( &$title, &$article ){
	global $wgUser, $wgRequest, $IP, $wgOut,  $wgTitle, $wgSupressPageTitle, $wgSupressSubTitle, $wgStyleVersion,$wgMessageCache, 
	$wgLinkFilterDirectory, $wgLinkFilterScripts ;
	
	if ( NS_LINK == $title->getNamespace()  ) {
		
		$wgOut->enableClientCache(false);
		
		if( $wgRequest->getVal("action") == "edit" ){
			if( $wgTitle->getArticleID() == 0 ){
				$create = Title::makeTitle( NS_SPECIAL, "LinkSubmit");
				$wgOut->redirect( $create->getFullURL("_title=".$wgTitle->getText() ) );
			}else{
				$update = Title::makeTitle( NS_SPECIAL, "LinkEdit");
				$wgOut->redirect( $update->getFullURL("id=".$wgTitle->getArticleID() ) );
			}
		}
		
		$wgSupressPageTitle = true;
		$wgSupressSubTitle = true;

		global $wgEnableFASTExt;
		$wgEnableFASTExt = false;
		
		require_once( "{$wgLinkFilterDirectory }/LinkPage.php" );
		require_once ( "{$wgLinkFilterDirectory }/LinkFilter.i18n.php" );
		foreach( efWikiaLinkFilter() as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}
		
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgLinkFilterScripts}/LinkFilter.css?{$wgStyleVersion}\"/>\n");
		
		$article = new LinkPage(&$title);
	}

	return true;
}

$wgExtensionFunctions[] = "wfLinkFilterDisplay";

function wfLinkFilterDisplay() {
    global $wgParser, $wgOut;
    $wgParser->setHook( "linkfilter", "wfLinkFilterRender" );
}

function wfLinkFilterRender( $input, $args, &$parser ){
	global $IP, $wgOut, $wgMessageCache, $wgMemc;
		
	//language messages
	require_once ( "$IP/extensions/wikia/LinkFilter/LinkFilter.i18n.php" );
	foreach( efWikiaLinkFilter() as $lang => $messages ){
		$wgMessageCache->addMessages( $messages, $lang );
	}
	
	global $wgHooks;
	$wgHooks["GetHTMLAfterBody"][] = "wfAddLinkFilterScripts";
	
	$parser->disableCache();
	 
	$count = $args["count"];
	if( !$count ){
		$count = 10;
	}
	
	$key = wfMemcKey(  'linkfilter', $count );
	$data = $wgMemc->get( $key );

	if ( $data ){
		wfDebug("loaded mainpage linkfilter from cache\n");
		$links = $data;
	} else {
		wfDebug("loaded mainpage linkfilter from db\n");
		$l = new LinkList();
		$links = $l->getLinkList(LINK_APPROVED_STATUS, "", $count, 1, "link_approved_date");
		$wgMemc->set( $key, $links, 60 * 5 );
	}
	
	$link_redirect = Title::makeTitle( NS_SPECIAL, "LinkRedirect");
	$link_submit = Title::makeTitle(NS_SPECIAL, "LinkSubmit");
	$link_all = Title::makeTitle(NS_SPECIAL, "LinksHome");
	
	$output .= "<div >
			
				<div class=\"linkfilter-links\">
					<a href=\"".$link_submit->escapeFullURL()."\">Submit</a> / <a href=\"".$link_all->escapeFullURL()."\">All</a>";
				
				if( Link::CanAdmin() ){
					$output .= " / <a href=\""  . Link::getLinkAdminURL() . "\">" . wfMsg("linkfilter-approve-links") . "</a>";
				}
				$output .= "</div>
				<div class=\"cleared\"></div>
		";
	
	foreach($links as $link){
		
		$output .= "<div class=\"link-item-hook\">
			<span class=\"link-item-hook-type\">
				{$link["type_name"]}
			</span>
			<span class=\"link-item-hook-url\">
				<a href=\"" . $link["wiki_page"] . "\" rel=\"nofollow\">{$link["title"]}</a>
			</span>
			<span class=\"link-item-hook-page\">
				<a href=\"{$link["wiki_page"]}\">(" . wfMsgExt("linkfilter-comments", "parsemag", $link["comments"] ) . ")</a>
			</span>
		</div>";
	}
	$output .= "</div>";
	
	return $output;

}

function wfAddLinkFilterScripts($tpl, &$html){
	global $wgOut, $wgStyleVersion, $wgStylePath;
	
	if( $tpl->data['linkfilter-scripts-loaded'] != 1 ){
		$html .= "<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/LinkFilter/LinkFilter.css?{$wgStyleVersion}\"/>\n";
		
		$tpl->set( 'linkfilter-scripts-loaded', 1 );
	}
	return true;
}

$wgHooks['UserRename::Local'][] = "LinkFilterUserRenameLocal";

function LinkFilterUserRenameLocal( $dbw, $uid, $oldusername, $newusername, $process, $cityId, &$tasks ) {
	$tasks[] = array(
		'table' => 'link',
		'userid_column' => 'link_submitter_user_id',
		'username_column' => 'link_submitter_user_name',
	);
	return true;
}

?>