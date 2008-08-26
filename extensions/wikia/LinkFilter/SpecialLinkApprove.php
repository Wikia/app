<?php
class LinkApprove extends UnlistedSpecialPage {

	function LinkApprove(){
		UnlistedSpecialPage::UnlistedSpecialPage("LinkApprove");
	}

	function canAccess(){
		global $wgUser;

		if( $wgUser->isAllowed("linkadmin") || in_array( "linkadmin", $wgUser->getGroups() ) ){
			return true;
		}
		
		return false;
	}
	
	function execute(){
		
		global $IP, $wgUser, $wgOut, $wgRequest, $wgSitename, $wgMessageCache, $wgFriendingEnabled, $wgLinkFilterScripts; 
		global $max_link_text_length;
		$max_link_text_length = 60;
		
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgLinkFilterScripts}/LinkFilter.css?{$wgStyleVersion}\"/>\n");
		$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgLinkFilterScripts}/LinkFilter.js?{$wgStyleVersion}\"></script>\n");
		
		
		//language messages
		require_once ( "LinkFilter.i18n.php" );
		foreach( efWikiaLinkFilter() as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}

		if( !$this->canAccess() ){
			$wgOut->errorpage( 'error', 'badaccess' );
			return true;	
		}
		
		$wgOut->addHTML("<script type=\"text/javascript\">
			var _ACCEPT_SUCCESS = \"" . wfMsg( 'linkfilter-admin-accept-success' ) . "\"
			var _REJECT_SUCESS = \"" . wfMsg( 'linkfilter-admin-reject-success' ) . "\"
		</script>
		");
		$wgOut->setPageTitle( wfMsg('linkfilter-approve-title') );
		
		$output .= "<div class=\"lr-left\">";
		
		$l = new LinkList();
	
		$links = $l->getLinkList(LINK_OPEN_STATUS,$type, 0,0);
		$links_count = count($links);
		$x=1;
		
		
		foreach($links as $link){
			
			$submitter = Title::makeTitle( NS_USER, $link["user_name"] );
			
			$link_text = preg_replace_callback( "/(<a[^>]*>)(.*?)(<\/a>)/i",'cut_link_text',"<a href=\"{$link["url"]}\" target=new>{$link["url"]}</a>");
			
			if ($links_count==$x) {
				$border_fix = "border-fix";
			} else {
				$border_fix = "";
			}
			
			$output .= "<div class=\"admin-link {$border_fix}\">
					<div class=\"admin-title\"><b>" . wfMsg("linkfilter-title") . "</b>: {$link["title"]}</div>
					<div class=\"admin-desc\"><b>" . wfMsg("linkfilter-description") . "</b>: {$link["description"]}</div>
					<div class=\"admin-url\"><b>" . wfMsg("linkfilter-url") . "</b>: <a href=\"{$link["url"]}\" target=new>{$link_text}</a></div>
					<div class=\"admin-submitted\"><b>" . wfMsg("linkfilter-submittedby") . "</b>: <a href=\"{$submitter->escapeFullURL()}\">{$link["user_name"]}</a> " . get_time_ago($link["timestamp"]) . " " . wfMsg("time_ago") . " under <i>" . Link::getLinkType($link["type"]) . "</i></div>
					<div id=\"action-buttons-{$link["id"]}\" class=\"action-buttons\">
						<a href=\"javascript:link_action(1,{$link["id"]})\" class=\"action-accept\">" . wfMsg("linkfilter-admin-accept") . "</a>
						<a href=\"javascript:link_action(2,{$link["id"]})\" class=\"action-reject\">" . wfMsg("linkfilter-admin-reject") . "</a>
						<div class=\"cleared\"></div>
					</div>
					";
			$output .= 	"</div>";
			
			$x++;
			
		}
		$output .= 	"</div>";
		$output .= "<div class=\"lr-right\">
			<div class=\"admin-link-instruction\">
				".wfMsgExt("linkfilter-admin-instructions","parse")."
			</div>
			<div class=\"approved-link-container\">
				<h3>" . wfMsg("linkfilter-admin-recent") . "</h2>";
			
				$l = new LinkList();
				$links = $l->getLinkList(LINK_APPROVED_STATUS,$type,10,0,"link_approved_date");
			
				foreach($links as $link){
					$output .= "<div class=\"approved-link\">
						<a href=\"{$link["url"]}\" target=new>{$link["title"]}</a> <span class=\"approve-link-time\">".get_time_ago($link["approved_timestamp"])." ".wfMsg("time_ago")."</span>";
					$output .= 	"</div>";
				}
			
				$output .= "</div>
			</div>
			<div class=\"cleared\"></div>";
		
		$wgOut->addHTML($output);
		
	}

}
?>