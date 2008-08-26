<?php

class LinksHome extends UnlistedSpecialPage {

	function LinksHome(){
		UnlistedSpecialPage::UnlistedSpecialPage("LinksHome");
	}

	function getInTheNews(){
		global $wgLinkPageDisplay, $wgMemc, $wgOut;
		
		if ($wgLinkPageDisplay['in_the_news'] == false) {
			return "";
		}
		
		$news_array = explode( "\n\n", wfMsg("inthenews") );
		$news_item = $news_array[ array_rand( $news_array ) ];
		$output = "<div class=\"link-container border-fix\">
			<h2>".wfMsg("linkfilter_inthenews")."</h2>
			<div>" . $wgOut->parse( $news_item, false ) . "</div>
		</div>";
		
		return $output;
		
	}

	function getPopularArticles(){
		global $wgOut, $wgMemc, $wgBlogCategory, $wgLinkPageDisplay;
		if ($wgLinkPageDisplay['popular_articles'] == false) {
			return "";
		}	
		$listpages = "<listpages>
				category={$wgBlogCategory}
				order=PublishedDate
				Published=Yes
				Level=1
				count=7
				showblurb=off
				showstats=no
				showdate=no
				ShowPicture=No
				Nav=No
			</listpages>";
			
		$output = "<div class=\"link-container\">
			<h2>".wfMsg("linkfilter_popular_articles")."</h2>
			<div>".$wgOut->parse($listpages, false)."</div>
		</div>";
		
		return $output;	
	}
	
	function getRandomCasualGame(){
		global $IP, $wgMemc;
		return wfGetRandomGameUnit();
	}
	
	function getAdUnit(){	
		global $wgLinkPageDisplay;
		if ($wgLinkPageDisplay['left_ad'] == false) {
			return "";
		}	
		$output = "<div class=\"article-ad\">
		
			<!-- FM Skyscraper Zone -->\n
			<script type='text/javascript'>\n
			var federated_media_section = '';\n
			</script>\n
			<script type='text/javascript' src='http://static.fmpub.net/zone/817'></script>\n
			<!-- FM Skyscraper Zone -->\n

			<script type='text/javascript'>\n
			var federated_media_section = '';\n
			</script>\n
			<script type='text/javascript' src='http://static.fmpub.net/zone/859'></script>\n
		
		
		</div>";
		return $output;
	}
	
	function execute(){
		
		global $IP, $wgUser, $wgOut, $wgRequest, $wgSitename, $wgMessageCache, $wgFriendingEnabled, $wgSupressPageTitle, $wgServer, $wgLinkFilterScripts; 
	
		$wgSupressPageTitle = true;
		
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgLinkFilterScripts}/LinkFilter.css?{$wgStyleVersion}\"/>\n");
		$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgLinkFilterScripts}/LinkFilter.js?{$wgStyleVersion}\"></script>\n");
		
		//language messages
		require_once ( "LinkFilter.i18n.php" );
		foreach( efWikiaLinkFilter() as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}

		
		$per_page = 20;
		$page =  $wgRequest->getVal('page');
		if( ! is_numeric($page) ) $page = 1;
		$link_type =  $wgRequest->getVal('link_type');
		
		if( $link_type ){
			$type_name = Link::$link_types[ $link_type ];
		}else{
			$type_name = "All";
		}
	
		$wgOut->setPageTitle( wfMsg('linkfilter-home-title', $type_name) );
		
		$output = "<div class=\"links-home-left\">";
		$output .= "<h1 class=\"page-title\">" . wfMsg('linkfilter-home-title', $type_name) . "</h1>";
		$output .= "<div class=\"link-home-navigation\">
			<a href=\"" . Link::getSubmitLinkURL() . "\">" . wfMsg("linkfilter-submit-title") . "</a>";
		
		if( Link::CanAdmin() ){
			$output .= " <a href=\""  . Link::getLinkAdminURL() . "\">" . wfMsg("linkfilter-approve-links") . "</a>";
		}
		global $wgRSSDirectory;
		if( $wgRSSDirectory ){
			$output .= " <a href=\"{$wgServer}/rss/links.xml\">RSS</a>";
		}
		$output .= "<div class=\"cleared\"></div></div>";
		$l = new LinkList();
		
		$total = $l->getLinkListCount(LINK_APPROVED_STATUS, $type);
		$links = $l->getLinkList(LINK_APPROVED_STATUS, $type, $per_page, $page, "link_approved_date");
		$link_redirect = Title::makeTitle( NS_SPECIAL, "LinkRedirect");
		$output .= "<div class=\"links-home-container\">";
		$link_count = count($links);
		$x=1;
		
		foreach($links as $link){
		
			if ($link_count == $x) {
				$border_fix = "border-fix";
			} else {
				$border_fix = "";
			}
			
			$border_fix2 = "";
			$date = date( "l, F j, Y", $link["approved_timestamp"]);
			if( $date != $last_date ){
				$border_fix2 = "border-top-fix";
				$output .= "<div class=\"links-home-date\">{$date}</div>";
			}
			$last_date = $date;
			
			$output .= "<div class=\"link-item-container {$border_fix2}\" >
					<div class=\"link-item-type\">
						{$link["type_name"]}
					</div>
					<div class=\"link-item\">
					<div class=\"link-item-url\"><a href=\"" . $link_redirect->escapeFullURL("link=true") . "&url=". urlencode($link["url"]) . "\" target=new>{$link["title"]}</a></div>
						<div class=\"link-item-desc\">{$link["description"]}</div>
					</div>
					<div class=\"link-item-page\">
						<a href=\"{$link["wiki_page"]}\">(" . wfMsgExt("linkfilter-comments", "parsemag", $link["comments"] ) . ")</a>
					</div>
					<div class=\"cleared\"></div>
					";
			$output .= 	"</div>";
			
			$x++;
			
		}
		$output .= 	"</div>";
		
		/*BUILD NEXT/PREV NAV
		**/
		$numofpages = $total / $per_page; 
	
		$page_link = Title::makeTitle(NS_SPECIAL,"LinksHome");
		
		if($numofpages>1) {
			$output .= "<div class=\"page-nav\">";
			if($page>1) { 
				$output .= "<a href=\"".$page_link->escapeFullURL('page='.($page-1))."\">".wfMsg("linkfilter-previous")."</a> ";
			}
			
			
			if(($total % $per_page) != 0)$numofpages++;
			if($numofpages >=9 && $page < $total)$numofpages=9+$page;
			if($numofpages > ($total / $per_page) )$numofpages = ($total / $per_page)+1;
			
			for($i = 1; $i <= $numofpages; $i++){
				if($i == $page) {
				    $output .=($i." ");
				} else {
				    $output .="<a href=\"".$page_link->escapeFullURL('page='.$i)."\">$i</a> ";
				}
			}
	
			if(($total - ($per_page * $page)) > 0){
				$output .=" <a href=\"".$page_link->escapeFullURL('page='.($page+1))."\">".wfMsg("linkfilter-next")."</a>"; 
			}
			$output .= "</div>";
		}
		/**/
		/*BUILD NEXT/PREV NAV
		**/
		$output .= 	"</div>";
		
		
		
		global $wgLinkPageDisplay;
		if( $wgLinkPageDisplay['rightcolumn'] == true ){
			$output .= 	"<div class=\"links-home-right\">";
			$output .= 	"<div class=\"links-home-unit-container\">";
			$output .= $this->getPopularArticles();
			$output .= $this->getInTheNews() ;
			$output .= "</div>";
			
			$output .= $this->getAdUnit() ;
			
			$output .= "</div>";
		}
		$output .= "<div class=\"cleared\"></div>";
		$wgOut->addHTML($output);
		
	}

}

?>