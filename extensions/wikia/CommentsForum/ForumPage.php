<?php

class ForumPage extends Article {
	var $title = null;
	var $authors = array();

	function __construct ( &$title ) {
		parent::__construct( &$title );
		$this->setContent();
		$this->getAuthors();

		wfLoadExtensionMessages( 'CommentsForum' );
	}

	function setContent() {
		// get the page content for later use
		$this->pageContent = $this->getContent();

		// if its a redirect, in order to get the *real* content for later use,
		// we have to load the text for the real page
		// Note: If $this->getContent is called anywhere before parent:view, the real article text won't get loaded
		//	on the page
		if ( $this->isRedirect( $this->pageContent ) ) {
			wfDebug( "blogpage::isRedirect\n" );

			$target =  $this->followRedirect();
			$rarticle = new Article( $target );
			$this->pageContent = $rarticle->getContent();

			$this->clear(); // if we don't clear, the pageconent will be [[redirect-blah]], and not actual page
		}
	}

	function view() {
		global $wgOut, $wgUser, $wgRequest, $wgTitle, $wgForumPageDisplay, $wgFloa;

		$sk = $wgUser->getSkin();

		$wgOut->setHTMLTitle( $wgTitle->getText() );

		$wgOut->addHTML( "<div id=\"forum-page-container\">" );

		if ( $wgForumPageDisplay['leftcolumn'] == true ) {
			$wgOut->addHTML( "<div id=\"forum-page-left\">" );

				$wgOut->addHTML( "<div class=\"forum-left-units\">" );
				$wgOut->addHTML( "<div class=\"forum-container\"><h2>" . wfMsg( "forum_about_title" ) . "</h2>" );
				$wgOut->addHTML( "<div>" . wfMsgExt( "forum_about_text", "parse" ) . "</div></div>" );
				$wgOut->addHTML( $this->getCommentsOfTheDay() );
				$wgOut->addHTML( "</div>" );

				$wgOut->addHTML( $this->leftAdUnit() );
		}
		$wgOut->addHTML( "</div>" );

		$wgOut->addHTML( "<div id=\"forum-page-middle\">" );

		global $wgUseEditButtonFloat;
		if ( $wgUseEditButtonFloat == true )$wgOut->addHTML( $sk->editMenu() );

		$wgOut->addHTML( "<h1 class=\"page-title\">{$wgTitle->getText()}</h1>" );
		// $wgOut->addHTML( $this->getByLine());

		$this->getForumContent();

		$wgOut->addHTML( "<!--start parent::view-->" );

		// get categories
		$cat = $sk->getCategoryLinks();
		if ( $cat ) {
			$wgOut->addHTML( "<div id=\"categories\">{$cat}</div>" );
		}

		$wgOut->addHTML( "<!--end parent::view-->" );

		$wgOut->addHTML( "</div>" );

		if ( $wgForumPageDisplay['rightcolumn'] == true ) {
			$wgOut->addHTML( "<div id=\"forum-page-right\">" );

				$wgOut->addHTML( $this->getNewArticles() );
				$wgOut->addHTML( $this->getInTheNews() );
				$wgOut->addHTML( $this->getRandomCasualGame() );


			$wgOut->addHTML( "</div>" );
		}

		$wgOut->addHTML( "<div class=\"cleared\"></div>" );
		$wgOut->addHTML( "</div>" );

	}

	function getInTheNews() {
		global $wgForumCategory, $wgMemc, $wgOut;

		if ( $wgForumCategory['in_the_news'] == false ) {
			return "";
		}

		$news_array = explode( "\n\n", wfMsg( "inthenews" ) );
		$news_item = $news_array[ array_rand( $news_array ) ];
		$output = "<div class=\"forum-container\">
			<h2>" . wfMsg( "forum_inthenews" ) . "</h2>
			<div>" . $wgOut->parse( $news_item, false ) . "</div>
		</div>";

		return $output;
	}

	function getForumContent() {
		global $wgOut, $wgAnonName, $wgTitle, $wgUploadPath;

		$avatar_img = "";
		if ( isset( $this->authors ) && is_array( $this->authors ) && !empty( $this->authors[0]["user_id"] ) ) {
			$avatar = new wAvatar( $this->authors[0]["user_id"] , "ml" );
			$avatar_img = "<img src=\"{$wgUploadPath}/avatars/" . $avatar->getAvatarImage() . "\" alt=\"\" border=\"0\"/>";
		}

		$output = "<p>";
		$output .= "<div class=\"fc-item\">";
		$output .= 	"<div class=\"fc-avatar\">" . ( ( isset( $avatar_img ) ) ? $avatar_img : "" ) . "</div>";
		$output .= 		"<div class=\"fc-container\">";
		$output .= 			"<div class=\"fc-user\">";

		if ( isset( $this->authors ) && is_array( $this->authors ) && !empty( $this->authors[0]["user_id"] ) ) {
			$user_title = Title::makeTitle( NS_USER, $this->authors[0]["user_name"] );
			$CommentPoster = "<a href=\"" . $user_title->escapeFullURL() . "\" rel=\"nofollow\">{$this->authors[0]["user_name"]}</a>";
		} else {
			$CommentPoster = $wgAnonName;
		}

		$output .= wfMsg( "forum_by", $CommentPoster );


		$output .= 	"<div class=\"fc-time\">" . get_time_ago( $this->getCreateDate( $wgTitle->getArticleID() ) ) . " " . wfMsg( "time_ago" ) . "</div>";
		$output .= 	"</div></div><div class=\"cleared\"></div></div>";
		$output .= "<div  class=\"fc-text\">";

		$wgOut->addHTML( $output );

		parent::view();

		$output = "</div><p>";

		$wgOut->addWikiText( "<comments></comments>" );

		$wgOut->addHTML( $output );
	}

	function getAuthors() {
		global $wgContLang, $wgForumCategory, $wgTitle;

		$article_text = $this->pageContent;
		$category_name = $wgContLang->getNsText( NS_CATEGORY );

		preg_match_all( "/\[\[{$category_name}:\s?" . wfMsg( "forum_by_user_category", $wgForumCategory ) . " (.*)\]\]/i", $article_text, $matches );
		$authors = $matches[1];

		foreach ( $authors as $author ) {
			$author_user_id = User::idFromName( $author );
			$this->authors[] = array(
						"user_name" => trim( $author ),
						"user_id" => $author_user_id
						);
		}
	}

	function getCreateDate( $pageid ) {
		global $wgMemc;

		$key = wfMemcKey( 'page', 'create_date', $pageid );
		$data = $wgMemc->get( $key );
		if ( !$data ) {
			$dbr =& wfGetDB( DB_SLAVE );
			$sqlc = "select UNIX_TIMESTAMP(rev_timestamp) as create_date from {$dbr->tableName( 'revision' )} where rev_page=" . $pageid . " order by rev_timestamp asc limit 1";
			$res = $dbr->query( $sqlc );
			$row = $dbr->fetchObject( $res );
			if ( $row ) {
				$create_date = $row->create_date;
			}
			$wgMemc->set( $key, $create_date );
		} else {
			wfDebug( "loading create_date for page {$pageid} from cache\n" );
			$create_date = $data;
		}
		return $create_date;
	}

	function getCommentsOfTheDay() {
		global $wgUploadPath, $wgMemc;

		$comments = array();
		$output	= "";

		// try cache first
		$key = wfMemcKey( 'comments-forum', 'plus', '24hours' );
		$wgMemc->delete( $key );
		$data = $wgMemc->get( $key );

		if ( $data != "" ) {
			wfDebug( "Got comments of the day from cache\n" );
			$comments = $data;
		} else {

			wfDebug( "Got comments of the day from db\n" );
			$sql = "SELECT Comment_Username,comment_ip, comment_text,comment_date,Comment_user_id,
				CommentID,IFNULL(Comment_Plus_Count - Comment_Minus_Count,0) as Comment_Score,
				Comment_Plus_Count as CommentVotePlus,
				Comment_Minus_Count as CommentVoteMinus,
				Comment_Parent_ID, page_title, page_namespace
				FROM Comments c, page p
				where c.comment_page_id=page_id
				AND page_namespace = " . NS_COMMENT_FORUM . "
				AND UNIX_TIMESTAMP(comment_date) > " . ( time() - ( 60 * 60 * 24 ) ) . "
				ORDER BY (Comment_Plus_Count) DESC LIMIT 0,5";

			$dbr =& wfGetDB( DB_SLAVE );
			$res = $dbr->query( $sql );
			while ( $row = $dbr->fetchObject( $res ) ) {
				$comments[] = array(  "user_name" => $row->Comment_Username,
							"user_id" => $row->Comment_user_id,
							"title" => $row->page_title,
							"namespace" => $row->page_namespace,
							"comment_id" => $row->CommentID,
							"plus_count" => $row->CommentVotePlus,
							"comment_text" => $row->comment_text
							);

			}
			$wgMemc->set( $key, $comments, 60 * 15 );
		}

		foreach ( $comments as $comment ) {
			$page_title = Title::makeTitle( $comment["namespace"] , $comment["title"] );

			if ( $comment["user_id"] != 0 ) {
				$title = Title::makeTitle( NS_USER , $comment["user_name"] );
				$CommentPoster_Display = $comment["user_name"];
				$CommentPoster = '<a href="' . $title->escapeFullURL() . '" title="' . $title->getText() . '" rel=\"nofollow\">' . $title->getText() . '</a>';
				$avatar = new wAvatar( $comment["user_id"] , "s" );
				$CommentIcon = $avatar->getAvatarImage();
			} else {
				$CommentPoster_Display = "Anonymous Fanatic";
				$CommentPoster = "Anonymous Fanatic";
				$CommentIcon = "af_s.gif";
			}

			$comment_text = substr(  $comment["comment_text"] , 0, 70 - strlen( $CommentPoster_Display ) );
			if ( $comment_text !=  $comment["comment_text"] ) {
				$comment_text .= "...";
			}
			$output .= "<div class=\"cod-item\">";
			$output .=  "<span class=\"cod-score\">{$comment["plus_count"]}</span> ";
			$output .= " <span class=\"cod-comment\"><a href=\"{$page_title->escapeFullURL()}#comment-{$comment["comment_id"]}\" title=\"{$page_title->getText()}\" >{$comment_text}</a></span>";
			$output .= "</div>";
		}

		if ( count( $comments ) > 0 ) {
			$output = "<div class=\"forum-container bottom-fix\">
				<h2>" . wfMsg( "forum_comments_of_day" ) . "</h2>"
				. $output .
			"</div>";
		}

		return $output;
	}

	function getNewArticles() {
		global $wgOut, $wgBlogPageDisplay, $wgMemc, $wgForumCategory;

		if ( $wgForumCategory['new_articles'] == false ) {
			return "";
		}

		$listpages = "<listpages>
				category={$wgForumCategory}
				order=NEW
				Published=NO
				count=5
				showblurb=off
				showstats=no
				showdate=no
				ShowPicture=No
				Nav=No
			</listpages>";

		$output = "<div class=\"forum-container\">
			<h2>" . wfMsg( "forum_new_articles" ) . "</h2>
			<div>" . $wgOut->parse( $listpages, false ) . "</div>
		</div>";

		return $output;
	}

	function getRandomCasualGame() {
		global $wgForumCategory, $IP, $wgMemc;

		if ( $wgForumCategory['games'] == false ) {
			return "";
		}

		return "<div class=\"bottom-fix\">" . wfGetRandomGameUnit() . "</div>";
	}

	function leftAdUnit() {
		global $wgBlogPageDisplay;
		if ( $wgBlogPageDisplay['left_ad'] == false ) {
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
}
