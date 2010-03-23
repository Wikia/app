<?php

class BlogPage extends Article{


	var $title = null;
	var $authors = array();
	
	function __construct (&$title){
		parent::__construct(&$title);
		$this->setContent();
		$this->getAuthors();
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
		global $wgOut, $wgUser, $wgRequest, $wgTitle, $wgBlogPageDisplay;
		
		wfProfileIn(__METHOD__);
		
		$sk = $wgUser->getSkin();
	
		wfDebug("blogpageview\n");
	
		$wgOut->setHTMLTitle( $wgTitle->getText() );
		
		
		$wgOut->addHTML("<div id=\"blog-page-container\">");
		
		if ( $wgBlogPageDisplay['leftcolumn'] == true ) {
			$wgOut->addHTML("<div id=\"blog-page-left\">");
			
				$wgOut->addHTML("<div class=\"blog-left-units\">");
				
					$wgOut->addHTML("<h2>".wfMsgExt("blog_author_title", "parsemag", count($this->authors))."</h2>");
		
					//if( count( $this->authors ) > 1 ){
						//$wgOut->addHTML( $this->displayMultipleAuthorsMessage() );
					//}
			 
					//output each author's box in the order that they appear in [[Category:Opinions by X]]
					for($x = 0; $x <= count( $this->authors ); $x++){
						$wgOut->addHTML( $this->displayAuthorBox( $x ) );
					}
					
					$wgOut->addHTML( $this->recentEditors() );
					$wgOut->addHTML( $this->recentVoters() );
					$wgOut->addHTML( $this->embedWidget() );
				
				$wgOut->addHTML("</div>");
			
				$wgOut->addHTML( $this->leftAdUnit() );
		}
		$wgOut->addHTML("</div>");
		
		$wgOut->addHTML("<div id=\"blog-page-middle\">");
			global $wgUseEditButtonFloat;
			if( $wgUseEditButtonFloat == true)$wgOut->addHTML( $sk->editMenu() );
			$wgOut->addHTML( "<h1 class=\"page-title\">{$wgTitle->getText()}</h1>" );
			$wgOut->addHTML( $this->getByLine());
			
			$wgOut->addHTML("<!--start parent::view-->");
			parent::view();
			
			//get categories
			$cat=$sk->getCategoryLinks();
			if($cat){
				$wgOut->addHTML("<div id=\"categories\">{$cat}</div>");
			}
		
			$wgOut->addHTML("<!--end parent::view-->");
			
		$wgOut->addHTML("</div>");
		
		if ( $wgBlogPageDisplay['rightcolumn'] == true ) {
			$wgOut->addHTML("<div id=\"blog-page-right\">");
	
				$wgOut->addHTML( $this->getPopularArticles() );
				$wgOut->addHTML( $this->getInTheNews() );
				$wgOut->addHTML( $this->getCommentsOfTheDay() );
				$wgOut->addHTML( $this->getRandomCasualGame() );
				$wgOut->addHTML( $this->getNewArticles() );
			
			$wgOut->addHTML("</div>");
		}
		$wgOut->addHTML("<div class=\"cleared\"></div>");
		$wgOut->addHTML("</div>");
		
		wfProfileOut(__METHOD__);

	}
	
	function getAuthors(){
		global $wgContLang, $wgBlogCategory, $wgTitle;
		 
		$article_text = $this->pageContent;
		$category_name = $wgContLang->getNsText( NS_CATEGORY );
		
		preg_match_all("/\[\[{$category_name}:\s?" . wfMsg("blog_by_user_category", $wgBlogCategory) . " (.*)\]\]/", $article_text, $matches );
		$authors = $matches[1];
		
		foreach( $authors as $author ){
			$author_user_id = User::idFromName( $author );
			$this->authors[] = array( 
						"user_name" => trim($author),
						"user_id" => $author_user_id
						);
		}
	}
	
	function getCreateDate($pageid) {
		global $wgMemc;
		
		$key = wfMemcKey( 'page', 'create_date', $pageid );
		$data = $wgMemc->get( $key );
		if( !$data){
			$dbr =& wfGetDB( DB_SLAVE);
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
	
	function getByLine() {
		
		global $wgTitle;
		
		$count = 0;
		
		//get date of last edit
		$year = substr($wgTitle->getTouched(), 0, 4);
		$month = substr($wgTitle->getTouched(), 4, 2);
		$day = substr($wgTitle->getTouched(), 6, 2);
		$edit_date = date("F d, Y", mktime(0, 0, 0, $month, $day, $year));
		
		//get date of when article was created
		$create_date = date("F d, Y", $this->getCreateDate($wgTitle->getArticleID()));
		
		$output .= "<div class=\"blog-byline\">" . wfMsg("blog_by") . " ";
		
		foreach($this->authors as $author) {
			$count++;
			$user_title = Title::makeTitle( NS_USER , $author["user_name"]);
			$authors .= (($authors && count( $this->authors ) > 2)?", ":"") . (($count==count( $this->authors ) && $count!=1 )?" " . wfMsg("blog_and") . " ":"") . "<a href=\"{$user_title->escapeFullURL()}\">{$author["user_name"]}</a>";
		}
		
		$output .= $authors;
		
		$output .= "</div>";
		
		if( $create_date != $edit_date ){
			$edit_text = ", " . wfMsg("blog_last_edited") . " {$edit_date}";
		}
		$output .= "<div class=\"blog-byline-last-edited\">" . wfMsg("blog_created") . " {$create_date}{$edit_text}</div>";
		
		return $output;
		
	}
	
	function displayMultipleAuthorsMessage(){
		$count = 0;
		foreach($this->authors as $author){
			$count++;
			$user_title = Title::makeTitle( NS_USER , $author["user_name"]);
			$authors .= (($authors && count( $this->authors ) > 2)?", ":"") . (($count==count( $this->authors ) )?" and ":"") . "<a href=\"{$user_title->escapeFullURL()}\">{$author["user_name"]}</a>";
		}
		$output  = "<div class=\"multiple-authors-message\">
				" . wfMsg( "blog_multiple_authors", $authors) . "
				</div>";
				
		return $output;
	}
	
	function displayAuthorBox( $author_index ){
		global $wgOut, $IP, $wgUploadPath, $wgBlogPageDisplay, $wgBlogCategory;
		
		if ( $wgBlogPageDisplay['author'] == false ) {
			return "";
		}

		$author_user_name =  $this->authors[ $author_index ]["user_name"];
		$author_user_id = $this->authors[ $author_index ]["user_id"];
		
		if( !$author_user_id ){
			return "";
		}
		
		$author_title = Title::makeTitle( NS_USER, $author_user_name );
		
		$stats = new UserStats( $author_user_id , $author_user_name);
		$stats_data = $stats->getUserStats();
		$user_level = new UserLevel( $stats_data["points"] );
		$level_link = Title::makeTitle(NS_HELP,"User Levels");

		require_once("$IP/extensions/wikia/UserProfile_NY/UserProfileClass.php");
		$profile = new UserProfile( $author_user_name );
		$profile_data = $profile->getProfile();
		
		$archive_link = Title::makeTitle( NS_CATEGORY, wfMsg("blog_by_user_category", $wgBlogCategory) . " {$author_user_name}" );
		
		$avatar = new wAvatar( $author_user_id ,"m");
		
		$articles = $this->getAuthorArticles($author_index);
		if(!$articles){
			$css_fix = "author-container-fix";
		}
		$output .= "<div class=\"author-container $css_fix\">
			<div class=\"author-info\">
				<a href=\"".$author_title->escapeFullURL()."\" rel=\"nofollow\">
					<img src=\"{$wgUploadPath}/avatars/".$avatar->getAvatarImage()."\" alt=\"\" border=\"0\"/>
				</a>
				<div class=\"author-title\">
					<a href=\"".$author_title->escapeFullURL()."\" rel=\"nofollow\">".wordwrap($author_user_name, 12, "<br/>\n", true)."</a>
				</div>";
				if($profile_data["about"])$output .= $wgOut->parse($profile_data["about"], false);
			$output .= "</div>
			<div class=\"cleared\"></div>
		</div>
		{$this->getAuthorArticles($author_index)}";
		
		return $output;
		 
	}
	
	function getAuthorArticles( $author_index ){
		global $wgUser, $wgTitle, $wgOut, $wgBlogPageDisplay, $wgMemc, $wgBlogCategory;
		
		if ($wgBlogPageDisplay['author_articles'] == false) {
			return "";
		}		
		
		$user_name =  $this->authors[ $author_index ]["user_name"];
		$user_id = $this->authors[ $author_index ]["user_id"];
		
		$archive_link = Title::makeTitle( NS_CATEGORY, wfMsg("blog_by_user_category", $wgBlogCategory) . " {$user_name}" );
		
		$articles = array();
		
		//try cache first
		$key = wfMemcKey( 'blog', 'author', 'articles', $user_id );
		$wgMemc->delete($key);
		$data = $wgMemc->get( $key );
		
		if ( $data != "") {
			wfDebug("Got blog author articles for user {$user_name} from cache\n");
			$articles = $data;
		} else {
			wfDebug("Got blog author articles for user {$user_name} from db\n");
			$dbr =& wfGetDB( DB_SLAVE );
			$category_title = Title::newFromText( wfMsg("blog_by_user_category", $wgBlogCategory) . " {$user_name}");
			$params['LIMIT'] = "4";
			$params['ORDER BY'] = "page_id desc";
			$res = $dbr->select( '`page` 
				INNER JOIN `categorylinks` on cl_from=page_id
				LEFT JOIN `wikia_page_stats` on cl_from=ps_page_id'
				, array('page_title', 'vote_count', 'comment_count', 'page_id'), 
					
				/*where*/ array( 'cl_to' => array( $category_title->getDBKey() ), 'page_namespace'=> NS_BLOG), __METHOD__, 
					$params
			);
			
			$array_count=0;
			
			while( $row = $dbr->fetchObject($res) ){
				
				if ($row->page_id!=$wgTitle->getArticleID() && $array_count<3) {
				
					
					$articles[] = array(  
						"page_title" => $row->page_title,
						"vote_count" => $row->vote_count,
						"comment_count" => $row->comment_count
					);
					
					$array_count++;
					
				}
				
			}
			
			$wgMemc->set( $key, $articles, 60 * 30);
		}	
		
		if (count($articles)>0) {
		
			$css_fix = "";
			 
			if( count( $this->getVotersList() ) == 0 && count( $this->getEditorsList() ) == 0  ){
				$css_fix = "more-container-fix";
			}
			
			$output .= "<div class=\"more-container {$css_fix}\">
			<h3>" . wfMsg("blog_author_more_by", $user_name) . "</h3>";

			$x=1;

			foreach ($articles as $article) {

				$article_title = Title::makeTitle(NS_BLOG, $article["page_title"] );

				$output .= "<div class=\"author-article-item\">
					<a href=\"".$article_title->escapeFullURL()."\">{$article_title->getText()}</a>
					<div class=\"author-item-small\">".wfMsgExt('blog-author-votes', 'parsemag', $article["vote_count"]).", ".wfMsgExt('blog-author-comments', 'parsemag', $article["comment_count"] )."</div>
				</div>";

				$x++;
			}
			
			$output .= "<div class=\"author-archive-link\">
				<a href=\"".$archive_link->escapeFullURl()."\">".wfMsg("blog_view_archive_link"). "</a>
			</div>
			</div>";
			
		}
			
		return $output;
	}

	function getEditorsList(){
		global $wgMemc, $wgTitle;
		
		$page_title_id = $wgTitle->getArticleID();
		
		//get authors
		foreach($this->authors as $author) {
			$authors .= " and rev_user_text<>'{$author["user_name"]}'";
		}
		
		$key = wfMemcKey( 'recenteditors', 'list', $page_title_id );
		//$wgMemc->delete($key);
		$data = $wgMemc->get( $key );
		$editors = array();
		if(!$data ){
			wfDebug( "loading recent editors for page {$page_title_id} from db\n" );
			$dbr =& wfGetDB( DB_SLAVE );
			$sql = "SELECT DISTINCT rev_user, rev_user_text FROM revision WHERE rev_page = {$page_title_id} and rev_user <> 0 and rev_user_text<>'Mediawiki Default' {$authors} ORDER BY rev_user_text ASC LIMIT 0,8";
			$res = $dbr->query($sql);
			while ($row = $dbr->fetchObject( $res ) ) {
				$editors[] = array( "user_id" => $row->rev_user, "user_name" => $row->rev_user_text);
			}
			$wgMemc->set( $key, $editors, 60 * 5 );
		}else{
			wfDebug( "loading recent editors for page {$page_title_id} from cache\n" );
			$editors = $data;
		}	
		
		return $editors;
	}
	
	function recentEditors() {
		global $IP, $wgUser, $wgTitle, $wgOut,$wgUploadPath, $wgMemc, $wgBlogPageDisplay;
		
		if ($wgBlogPageDisplay['recent_editors'] == false) {
			return "";
		}
		
		$editors = $this->getEditorsList();
		
		$output = "";
		
		if ( count($editors) > 0 ) {
		
			$output .= "<div class=\"recent-container\">
			<h2>".wfMsg("blog-recent-editors")."</h2>
			<div>".wfMsg("blog-recent-editors-message")."</div>";

			foreach($editors as $editor){
				$user_name = ( $editor["user_name"] == substr( $editor["user_name"], 0, 12) ) ?  $editor["user_name"] : ( substr( $editor["user_name"], 0, 12) . "...");
				$avatar = new wAvatar($editor["user_id"],"m");
				$user_title = Title::makeTitle(NS_USER,$editor["user_name"]);

				$output .= "<a href=\"".$user_title->escapeFullURL()."\"><img src=\"{$wgUploadPath}/avatars/{$avatar->getAvatarImage()}\" alt=\"\" border=\"0\"/></a>";

			}

			$output .= "</div>";
			
		}
		
		return $output;
	}
	
	function getVotersList(){
		global $wgMemc, $wgTitle;
		
		//gets the page id for the query
		$page_title_id = $wgTitle->getArticleID();

		//get authors
		foreach($this->authors as $author) {
			$authors .= " and username<>'{$author["user_name"]}'";
		}

		$key = wfMemcKey( 'recentvoters', 'list', $page_title_id );
		$wgMemc->delete( $key );
		$data = $wgMemc->get( $key );
		
		$voters = array();
		if(!$data ){
			wfDebug( "loading recent voters for page {$page_title_id} from db\n" );
			$dbr =& wfGetDB( DB_SLAVE );
			$sql = "SELECT DISTINCT username, vote_user_id, vote_page_id FROM Vote WHERE vote_page_id = {$page_title_id} and vote_user_id <> 0 {$authors} ORDER BY vote_id desc LIMIT 0,8";
			$res = $dbr->query($sql);
			while ($row = $dbr->fetchObject( $res ) ) {
				$voters[] = array( "user_id" => $row->vote_user_id, "user_name" => $row->username);
			}
			$wgMemc->set( $key, $voters, 60 * 5 );
		} else {
			wfDebug( "loading recent voters for page {$page_title_id} from cache\n" );
			$voters = $data;
		}
		
		return $voters;
	}
		
	function recentVoters() {
		global $IP, $wgUser, $wgTitle, $wgOut,$wgUploadPath, $wgMemc, $wgBlogPageDisplay;
		
		if ($wgBlogPageDisplay['recent_voters'] == false) {
			return "";
		}
		
		$voters = $this->getVotersList();
		
		if( count($voters) > 0 ){
			$output = "";
			$output .= "<div class=\"recent-container bottom-fix\">
				<h2>".wfMsg("blog-recent-voters")."</h2>
				<div>".wfMsg("blog-recent-voters-message")."</div>";
				
			foreach($voters as $voter){
				$user_name = ($voter["user_name"] == substr($voter["user_name"], 0, 12) ) ? $voter["user_name"] : ( substr($voter["user_name"], 0, 12) . "...");
				$user_title = Title::makeTitle( NS_USER, $voter["user_name"] );
				$avatar = new wAvatar($voter["user_id"],"m");

				$output .= "<a href=\"".$user_title->escapeFullURL()."\"><img src=\"{$wgUploadPath}/avatars/{$avatar->getAvatarImage()}\" alt=\"\" border=\"0\" /></a>";

			}
			
			$output .= "</div>";	
		}
		
		return $output;
		
	}
	
	function embedWidget() {
		global $IP, $wgUser, $wgTitle, $wgOut, $wgUploadPath, $wgMemc, $wgBlogPageDisplay, $wgServer;
		
		if ($wgBlogPageDisplay['embed_widget'] == false) {
			return "";
		}
		$title = Title::makeTitle($wgTitle->getNamespace(),$wgTitle->getText());

		$output = "";
		$output .= "<div class=\"recent-container bottom-fix\"><h2>Embed This On Your Site</h2>";
		$output .= "<div class='blog-widget-embed'>";
		$output .= "<p><input type='text' size='20' onclick='this.select();' value='" . '<object width="300" height="450" id="content_widget" align="middle"> <param name="movie" value="content_widget.swf" /><embed src="' . $wgServer . '/extensions/wikia/ContentWidget/widget.swf?page=' . urlencode($title->getFullText()) . '" quality="high" bgcolor="#ffffff" width="300" height="450" name="content_widget"type="application/x-shockwave-flash" /> </object>' . "' /></p></div>";
		$output .= "</div>";
		
		return $output;
		
	}
	
	function leftAdUnit(){
		global $wgBlogPageDisplay;
		if ($wgBlogPageDisplay['left_ad'] == false) {
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
		global $wgBlogPageDisplay, $wgMemc, $wgOut;
		
		if ($wgBlogPageDisplay['in_the_news'] == false) {
			return "";
		}
		
		$news_array = explode( "\n\n", wfMsg("inthenews") );
		$news_item = $news_array[ array_rand( $news_array ) ];
		$output = "<div class=\"blog-container\">
			<h2>".wfMsg("blog_inthenews")."</h2>
			<div>" . $wgOut->parse( $news_item, false ) . "</div>
		</div>";
		
		return $output;
		
	}
	
	function getPopularArticles(){
		global $wgOut, $wgBlogPageDisplay, $wgMemc, $wgBlogCategory;
		
		if ($wgBlogPageDisplay['popular_articles'] == false) {
			return "";
		}	
		
		$listpages = "<listpages>
				category={$wgBlogCategory}
				order=PublishedDate
				Published=Yes
				Level=1
				count=5
				showblurb=off
				showstats=no
				showdate=no
				ShowPicture=No
				Nav=No
			</listpages>";
			
		$output = "<div class=\"blog-container\">
			<h2>".wfMsg("blog_popular_articles")."</h2>
			<div>".$wgOut->parse($listpages, false)."</div>
		</div>";
		
		return $output;	
	}
	
	function getNewArticles(){
		global $wgOut, $wgBlogPageDisplay, $wgMemc, $wgBlogCategory;
		
		if ($wgBlogPageDisplay['new_articles'] == false) {
			return "";
		}	
		
		$listpages = "<listpages>
				category={$wgBlogCategory}
				order=NEW
				Published=NO
				count=5
				showblurb=off
				showstats=no
				showdate=no
				ShowPicture=No
				Nav=No
			</listpages>";
			
		$output = "<div class=\"blog-container bottom-fix\">
			<h2>".wfMsg("blog_new_articles")."</h2>
			<div>".$wgOut->parse($listpages, false)."</div>
		</div>";
		
		return $output;	
	}
	
	function getRandomCasualGame(){
		global $wgBlogPageDisplay, $IP, $wgMemc;
		
		if ($wgBlogPageDisplay['games'] == false) {
			return "";
		}
		
		return wfGetRandomGameUnit();
	}
	

	
	function getCommentsOfTheDay(){
		global $wgBlogPageDisplay, $wgUploadPath, $wgMemc;
		
		if ($wgBlogPageDisplay['comments_of_day'] == false) {
			return "";
		}
		
		$comments = array();
		
		//try cache first
		$key = wfMemcKey( 'comments', 'plus', '24hours' );
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
				AND page_namespace = " . NS_BLOG . "
				ORDER BY (Comment_Plus_Count) DESC LIMIT 0,5";
			
			$dbr =& wfGetDB( DB_SLAVE );
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
			$comment["comment_text"] = strip_tags($comment["comment_text"]);
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
			
			$output = "<div class=\"blog-container\">
				<h2>".wfMsg("blog_comments_of_day")."</h2>"
				.$output.
			"</div>";
			
		}
		
		
		
		return $output;
	}
}


?>