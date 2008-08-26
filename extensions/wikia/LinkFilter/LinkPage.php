<?php

class LinkPage extends Article{


	var $title = null;
	
	function __construct (&$title){
		parent::__construct(&$title);
		$this->setContent();
		$l = new Link();
		$this->link = $l->getLinkByPageID( $title->getArticleID() );

	}

	function setContent(){
		//get the page content for later use
		$this->pageContent = $this->getContent();
	 
		//if its a redirect, in order to get the *real* content for later use,
		//we have to load the text for the real page
		//Note: If $this->getContent is called anywhere before parent:view, the real article text won't get loaded
		//	on the page
		if( $this->isRedirect( $this->pageContent ) ){
			wfDebug("blogpage::isRedirect\n");
			
			$target =  $this->followRedirect();
			$rarticle = new Article( $target );
			$this->pageContent = $rarticle->getContent();
			
			$this->clear(); //if we don't clear, the pageconent will be [[redirect-blah]], and not actual page
		}
	}
	
	function view(){
		global $wgOut, $wgUser, $wgRequest, $wgTitle, $wgLinkPageDisplay;
		
		global $wgShowAds;
		$wgShowAds = false;
		
		$sk = $wgUser->getSkin();
	
		$wgOut->setHTMLTitle( $wgTitle->getText() );
		$wgOut->setPageTitle( $wgTitle->getText() );
		
		$wgOut->addHTML("<div id=\"link-page-container\" class=\"clearfix\">");
		
		if ( $wgLinkPageDisplay['leftcolumn'] == true ) {
			$wgOut->addHTML("<div id=\"link-page-left\">");
			$wgOut->addHTML("<div class=\"link-left-units\">");
				
				$wgOut->addHTML( $this->displaySubmitterBox( $x ) );
			$wgOut->addHTML("</div>");
			$wgOut->addHTML( $this->leftAdUnit() );
			$wgOut->addHTML("</div>");
		}
		
		
		$wgOut->addHTML("<div id=\"link-page-middle\">");
			
			
			$wgOut->addHTML( $this->displayLink() );
			//get categories
			$cat=$sk->getCategoryLinks();
			if($cat){
				$wgOut->addHTML("<div id=\"categories\">{$cat}</div>");
			}
		
			$wgOut->addWikiText( "<comments></comments>" );
			
		$wgOut->addHTML("</div>");
		
		if ( $wgLinkPageDisplay['rightcolumn'] == true ) {
			$wgOut->addHTML("<div id=\"link-page-right\">");
	
				$wgOut->addHTML( $this->getNewLinks() );
				$wgOut->addHTML( $this->getInTheNews() );
				$wgOut->addHTML( $this->getCommentsOfTheDay() );
				$wgOut->addHTML( $this->getRandomCasualGame() );
				
			
			$wgOut->addHTML("</div>");
		}
		$wgOut->addHTML("<div class=\"cleared\"></div>");
		$wgOut->addHTML("</div>");
		
	}
	
	function displayLink(){
		
		global $wgTitle;
		
		$output = "";
		if( Link::isURL( $this->link["url"] ) ){
			$url = parse_url( $this->link["url"] );
			$domain = $url["host"];
		}
		
		$create_date = date("F d, Y", $this->getCreateDate($wgTitle->getArticleID()));
		$link_redirect = Title::makeTitle( NS_SPECIAL, "LinkRedirect");
		$output .= "<div class=\"link-container\">
				<div class=\"link-url\">
					<span class=\"link-type\">
						".$this->link["type_name"]."
					</span>
					<a href=\"" . $link_redirect->escapeFullURL("link=true") . "&url=" . urlencode($this->link["url"]) . "\" target=new>{$this->link["title"]}</a>
				</div>
				<div class=\"link-date\">(" . wfMsg("linkfilter-submitted") . " " . "{$create_date})</div>
				<div class=\"link-description\">
					{$this->link["description"]}
				</div>
				<div class=\"link-domain\">{$domain}</div>
				</div>";
				
		return $output;
	}
	
	function getCreateDate($pageid) {
		global $wgMemc;
		
		$key = wfMemcKey( 'page', 'create_date', $pageid );
		$data = $wgMemc->get( $key );
		if( !$data){
			$dbr =& wfGetDB( DB_MASTER);
			$sqlc = "select UNIX_TIMESTAMP(rev_timestamp) as create_date from {$dbr->tableName( 'revision' )} where rev_page=" . $pageid . " order by rev_timestamp asc limit 1";
			$res = $dbr->query($sqlc);
			$row = $dbr->fetchObject( $res );
			if($row){
				$create_date = $row->create_date;
			}
			$wgMemc->set( $key, $create_date );
		}else{
			wfDebug( "loading create_date for page {$pageid} from cache\n" );
			$create_date = $data;
		}
		return $create_date;
	}
	
	
	function displaySubmitterBox(  ){
		global $wgOut, $IP, $wgUploadPath, $wgLinkPageDisplay, $wgBlogCategory, $wgUploadPath;
		
		if ( $wgLinkPageDisplay['author'] == false ) {
			return "";
		}

		$author_user_name =  $this->link["user_name"];
		$author_user_id = $this->link["user_id"];
		
		if( !$author_user_id ){
			return "";
		}
		
		$author_title = Title::makeTitle( NS_USER, $author_user_name );
		
		$stats = new UserStats( $author_user_id , $author_user_name);
		$stats_data = $stats->getUserStats();
		$user_level = new UserLevel( $stats_data["points"] );
		$level_link = Title::makeTitle(NS_HELP,"User Levels");
		
		$profile = new UserProfile( $author_user_name );
		$profile_data = $profile->getProfile();
		
		$avatar = new wAvatar( $author_user_id ,"m");
		
		$css_fix = "author-container-fix";
		$output .= "<h2>".wfMsg("linkfilter-about-submitter")."</h2>";
		$output .= "<div class=\"author-container $css_fix\">
			<div class=\"author-info\">
				<a href=\"".$author_title->escapeFullURL()."\" rel=\"nofollow\">
					<img src=\"{$wgUploadPath}/avatars/".$avatar->getAvatarImage()."\" alt=\"\" border=\"0\"/>
				</a>
				<div class=\"author-title\">
					<a href=\"".$author_title->escapeFullURL()."\" rel=\"nofollow\">{$author_user_name}</a>
				</div>";
				if($profile_data["about"])$output .= $wgOut->parse($profile_data["about"], false);
			$output .= "</div>
			<div class=\"cleared\"></div>
		</div>
		";
		
		return $output;
		 
	}
	
	
	function leftAdUnit(){
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
	
	function getInTheNews(){
		global $wgLinkPageDisplay, $wgMemc, $wgOut;
		
		if ($wgLinkPageDisplay['in_the_news'] == false) {
			return "";
		}
		
		$news_array = explode( "\n\n", wfMsg("inthenews") );
		$news_item = $news_array[ array_rand( $news_array ) ];
		$output = "<div class=\"link-container\">
			<h2>".wfMsg("linkfilter-in-the-news")."</h2>
			<div>" . $wgOut->parse( $news_item, false ) . "</div>
		</div>";
		
		return $output;
		
	}
	

	
	function getNewLinks(){
		global $IP, $wgOut, $wgLinkPageDisplay, $wgMemc, $wgBlogCategory;
		
		if ($wgLinkPageDisplay['new_links'] == false) {
			return "";
		}	
		
		$link_redirect = Title::makeTitle( NS_SPECIAL, "LinkRedirect");
		$l = new LinkList();
		$links = $l->getLinkList(LINK_APPROVED_STATUS, "", 7, 0);
		foreach($links as $link){
			$output .= "<div class=\"link-recent\"><a href=\"" . $link_redirect->escapeFullURL("url={$link["url"]}") . "\" target=new>{$link["title"]}</a></div>";
		}
		$output = "<div class=\"link-container\">
			<h2>".wfMsg("linkfilter-new-links-title")."</h2>
			<div>". $output ."</div>
		</div>";
		
		return $output;	
	}
	
	function getRandomCasualGame(){
		global $wgLinkPageDisplay, $IP, $wgMemc;
		
		if ($wgLinkPageDisplay['games'] == false) {
			return "";
		}
		
		return wfGetRandomGameUnit();
	}
	
	function getCommentsOfTheDay(){
		global $wgLinkPageDisplay, $wgUploadPath, $wgMemc;
		
		if ($wgLinkPageDisplay['comments_of_day'] == false) {
			return "";
		}
		
		$comments = array();
		
		//try cache first
		$key = wfMemcKey( 'comments-link', 'plus', '24hours' );
		$wgMemc->delete( $key );
		$data = $wgMemc->get( $key );
		if( $data != ""){
			wfDebug("Got comments of the day from cache\n");
			$comments = $data;
		}else{
			wfDebug("Got comments of the day from db\n");
			$sql = "SELECT Comment_Username,comment_ip, comment_text,comment_date,Comment_user_id,
				CommentID,IFNULL(Comment_Plus_Count - Comment_Minus_Count,0) as Comment_Score,
				Comment_Plus_Count as CommentVotePlus, 
				Comment_Minus_Count as CommentVoteMinus,
				Comment_Parent_ID, page_title, page_namespace
				FROM Comments c, page p where c.comment_page_id=page_id 
				AND UNIX_TIMESTAMP(comment_date) > " . ( time() - (60 * 60 * 24 ) ) . "
				AND page_namespace = " . NS_LINK . "
				ORDER BY (Comment_Plus_Count) DESC LIMIT 0,5";
			
			$dbr =& wfGetDB( DB_MASTER );
			$res = $dbr->query($sql);
			while ($row = $dbr->fetchObject( $res ) ) {
				$comments[] = array(  "user_name" => $row->Comment_Username,
							"user_id" => $row->Comment_user_id,
							"title" => $row->page_title,
							"namespace" => $row->page_namespace,
							"comment_id" => $row->CommentID,
							"plus_count" => $row->CommentVotePlus,
							"comment_text" => $row->comment_text
							);			  
			  
			}
			$wgMemc->set( $key, $comments, 60 * 15);
		}
		
		foreach( $comments as $comment ){
			$page_title = Title::makeTitle( $comment["namespace"] , $comment["title"]);
		
			if( $comment["user_id"] != 0 ){
				$title = Title::makeTitle( NS_USER , $comment["user_name"] );
				$CommentPoster_Display = $comment["user_name"];
				$CommentPoster = '<a href="' . $title->escapeFullURL() . '" title="' . $title->getText() . '" rel=\"nofollow\">' . $title->getText() . '</a>';
				$avatar = new wAvatar( $comment["user_id"] , "s" );
				$CommentIcon = $avatar->getAvatarImage();
			}else{
				$CommentPoster_Display = "Anonymous Fanatic";
				$CommentPoster = "Anonymous Fanatic";
				$CommentIcon = "af_s.gif";
			}
			
			$comment_text = substr(  $comment["comment_text"] ,0,70 - strlen($CommentPoster_Display) );
			if($comment_text !=  $comment["comment_text"]){
				$comment_text .= "...";
			}
			$output .= "<div class=\"cod-item\">";
			$output .=  "<span class=\"cod-score\">{$comment["plus_count"]}</span> ";
			$output .= " <span class=\"cod-comment\"><a href=\"{$page_title->escapeFullURL()}#comment-{$comment["comment_id"]}\" title=\"{$page_title->getText()}\" >{$comment_text}</a></span>";
			$output .= "</div>";
		}
		
		if (count($comments)>0) {
			
			$output = "<div class=\"link-container\">
				<h2>".wfMsg("linkfilter-comments-of-day")."</h2>"
				.$output.
			"</div>";
			
		}
		
		
		
		return $output;
	}
}


?>