<?php

class UserProfilePage extends Article{

	public $title = null;
	public $is_owner = false;

	function __construct (&$title){
		global $wgUser;
		parent::__construct($title);

		$this->user_name = $title->getText();
		$this->user_id = User::idFromName($this->user_name);
		$this->user = User::newFromId($this->user_id);
		$this->user->loadFromDatabase();

		if( $this->user_name == $wgUser->getName() ){
			$this->is_owner = true;
		}
		$profile = new UserProfile( $this->user_name );
		$this->profile_data = $profile->getProfile();
	}

	function isOwner(){
		return $this->is_owner;
	}

	function view(){
		global $wgOut, $wgUser, $wgRequest, $wgTitle, $wgSitename, $wgUserProfileScripts, $wgUseNewAnswersSkin;

		$sk = $wgUser->getSkin();
		$wgOut->setHTMLTitle(  $wgTitle->getPrefixedText() );
		$wgOut->setPageTitle(  $wgTitle->getPrefixedText() );

		# No need to display noarticletext, we use our own message
		if ( !$this->user_id ) {
			parent::view();
			$wgOut->addHTML( wfMsg( 'user-no-profile' ) );
			return "";
		}

		$wgOut->addHTML("<div id=\"profile-top\">");
		$wgOut->addHTML($this->getProfileTop($this->user_id, $this->user_name));
		$wgOut->addHTML("<div class=\"cleared\"></div></div>");

		//User does not want social profile for User:user_name, so we just show header + page content
		if( $wgTitle->getNamespace() == NS_USER && $this->profile_data["user_id"] && $this->profile_data["user_page_type"] == 0 ){
			global $wgShowAds;
			$wgShowAds = false;
			parent::view();
			return "";
		}

		//left side
		$wgOut->addHTML("<div id=\"user-page-left\" class=\"clearfix\">");

		if ( ! wfRunHooks( 'UserProfileBeginLeft', array( &$this  ) ) ) {
			wfDebug( __METHOD__ . ": UserProfileBeginLeft messed up profile!\n" );
		}

		$wgOut->addHTML($this->getRelationships($this->user_name, 1) );
		$wgOut->addHTML($this->getRelationships($this->user_name, 2) );
		$wgOut->addHTML($this->getGifts($this->user_name) );
		$wgOut->addHTML( $this->getAwards($this->user_name) );
		$wgOut->addHTML( $this->getCustomInfo($this->user_name) );

		// RT #44324
		if (!empty($wgUseNewAnswersSkin)) {
			$wgOut->addHTML( $this->getPersonalInfo($this->user_id, $this->user_name) );
		}

		$wgOut->addHTML( $this->getInterests($this->user_name) );
		$wgOut->addHTML($this->getFanBoxes($this->user_name) );
		$wgOut->addHTML( $this->getUserStats($this->user_id, $this->user_name) );

		if ( ! wfRunHooks( 'UserProfileEndLeft', array( &$this  ) ) ) {
			wfDebug( __METHOD__ . ": UserProfileEndLeft messed up profile!\n" );
		}

		$wgOut->addHTML("</div>");

		wfDebug("profile start right\n");

		//right side

		$wgOut->addHTML("<div id=\"user-page-right\" class=\"clearfix\">");

		if ( ! wfRunHooks( 'UserProfileBeginRight', array( &$this  ) ) ) {
			wfDebug( __METHOD__ . ": UserProfileBeginRight messed up profile!\n" );
		}

		// RT #44324
		if (empty($wgUseNewAnswersSkin)) {
			$wgOut->addHTML( $this->getPersonalInfo($this->user_id, $this->user_name) );
		}

		$wgOut->addHTML( $this->getActivity($this->user_name) );
		$wgOut->addHTML( $this->getArticles($this->user_name) );
		$wgOut->addHTML( $this->getMiniGallery($this->user_name) );
		$wgOut->addHTML( $this->getCasualGames($this->user_id, $this->user_name) );
		$wgOut->addHTML( $this->getUserBoard($this->user_id, $this->user_name) );

		if ( ! wfRunHooks( 'UserProfileEndRight', array( &$this  ) ) ) {
			wfDebug( __METHOD__ . ": UserProfileEndRight messed up profile!\n" );
		}

		$wgOut->addHTML("</div><div class=\"cleared\"></div>");

		//$content = parent::getContent();
		//$wgOut->addWikiText($content);

	}

	function getUserStatsRow($label,$value) {
		global $wgUser, $wgTitle, $wgOut;

		$output = "";
		if ($value!=0) {
			$output = "<div>
					<b>{$label}</b>
					{$value}
			</div>";
		}

		return $output;

	}

	function getUserStats($user_id, $user_name) {

		global $wgUser, $wgTitle, $IP, $wgUserProfileDisplay;

		if ($wgUserProfileDisplay['stats'] == false) {
			return "";
		}

		$stats = new UserStats($user_id, $user_name);
		$stats_data = $stats->getUserStats();

		$total_value = $stats_data["edits"] . $stats_data["votes"] . $stats_data["comments"] . $stats_data["recruits"] . $stats_data["poll_votes"] . $stats_data["picture_game_votes"] . $stats_data["quiz_points"];
		$output = "";
		if ($total_value!=0) {
			$output .= "<div class=\"user-section-heading\">
				<div class=\"user-section-title\">
					".wfMsg("user-stats-title")."
				</div>
				<div class=\"user-section-actions\">
					<div class=\"action-right\">
					</div>
					<div class=\"action-left\">
					</div>
					<div class=\"cleared\"></div>
				</div>
			</div>
			<div class=\"cleared\"></div>
			<div class=\"profile-info-container bold-fix\">".
				$this->getUserStatsRow(wfMsg("user-stats-edits"),$stats_data["edits"]).
				$this->getUserStatsRow(wfMsg("user-stats-votes"),$stats_data["votes"]).
				$this->getUserStatsRow(wfMsg("user-stats-comments"),$stats_data["comments"]).
				$this->getUserStatsRow(wfMsg("user-stats-recruits"),$stats_data["recruits"]).
				$this->getUserStatsRow(wfMsg("user-stats-poll-votes"),$stats_data["poll_votes"]).
				$this->getUserStatsRow(wfMsg("user-stats-picture-game-votes"),$stats_data["picture_game_votes"]).
				$this->getUserStatsRow(wfMsg("user-stats-quiz-points"),$stats_data["quiz_points"]);
				if($stats_data["currency"]!="10,000")$output .= $this->getUserStatsRow(wfMsg("user-stats-pick-points"),$stats_data["currency"]);
			$output .= "</div>";
		}

		return $output;
	}

	function getArticles($user_name) {

		global $wgUser, $wgTitle, $wgOut, $wgUserProfileDisplay, $wgMemc, $wgBlogCategory;

		if ($wgUserProfileDisplay['articles'] == false) {
			return "";
		}

		$output = "";

		$dbr =& wfGetDB( DB_SLAVE );

		//try cache first
		$key = wfMemcKey( 'user', 'profile', 'articles', $this->user_id );
		$data = $wgMemc->get( $key );
		$articles = array();
		if( $data != ""){
			wfDebug("Got UserProfile articles for user {$user_name} from cache\n");
			$articles = $data;
		}else{
			wfDebug("Got UserProfile articles for user {$user_name} from db\n");
			$category_title = Title::newFromText("$wgBlogCategory by User {$user_name}");
			$params['LIMIT'] = "5";
			$params['ORDER BY'] = "page_id desc";
			$res = $dbr->select( '`page`
				INNER JOIN `categorylinks` on cl_from=page_id
				LEFT JOIN `wikia_page_stats` on cl_from=ps_page_id'
				, array('page_title', 'page_namespace', 'vote_count', 'comment_count'),

				/*where*/ array( 'cl_to' => array( $category_title->getDBKey() )  ), __METHOD__,
					$params
			);

			while( $row = $dbr->fetchObject($res) ){
				 $articles[] = array(  "page_title" => $row->page_title,
					 		"page_namespace" => $row->page_namespace,
							"vote_count" => $row->vote_count,
							"comment_count" => $row->comment_count
							);
			}
			$wgMemc->set( $key, $articles, 60);
		}

		//load opinion count via user stats;
		$stats = new UserStats($this->user_id, $this->user_name);
		$stats_data = $stats->getUserStats();
		$article_count = $stats_data["opinions_created"];

		$article_link = Title::Maketitle(NS_CATEGORY, "Opinions by User {$user_name}");

		if ( count($articles) > 0) {

			$output .= "<div class=\"user-section-heading\">
				<div class=\"user-section-title\">
					".wfMsg("user-articles-title")."
				</div>
				<div class=\"user-section-actions\">
					<div class=\"action-right\">";
						if($article_count>5)$output .= "<a href=\"".$article_link->escapeFullURL()."\" rel=\"nofollow\">".wfMsg("user-view-all")."</a>";
					$output .= "</div>
					<div class=\"action-left\">";
					if($article_count>5) {
						$output .= "5 ".wfMsg("user-count-separator")." {$article_count}";
					} else {
						$output .= "{$article_count} ".wfMsg("user-count-separator")." {$article_count}";
					}
					$output .= "</div>
					<div class=\"cleared\"></div>
				</div>
			</div>
			<div class=\"cleared\"></div>
			<div class=\"user-articles-container\">";

			$x=1;

			foreach($articles as $article){

				$article_title = Title::makeTitle( $article["page_namespace"] , $article["page_title"] );

				$output .= "<div class=\"".(($x==1)?"article-item-top":"article-item")."\">
					<div class=\"number-of-votes\">
						<div class=\"vote-number\">{$article["vote_count"]}</div>
						<div class=\"vote-text\">".wfMsg("user-articles-votes")."</div>
					</div>
					<div class=\"article-title\">
						<a href=\"".$article_title->escapeFullURL()."\">{$article_title->getText()}</a>
						<span class=\"item-small\">".wfMsgExt('user-article-comment', 'parsemag', $article["comment_count"] )."</span>
					</div>
					<div class=\"cleared\"></div>
				</div>";

				$x++;
			}

			$output .= "</div>";

		}


		return $output;

	}

	/**
	*
	*/
	function getMiniGallery($user_name){

		global $IP, $wgUser, $wgTitle, $wgUserProfileDisplay, $wgMemc, $wgUploadPath;

		if ($wgUserProfileDisplay['pictures'] == false) {
			return "";
		}

		$output = "";

		$pictures["list"] = array();

		//try cache
		$key = wfMemcKey( 'user', 'profile', 'pictures', $this->user_id );
		//$data = $wgMemc->get( $key );

		if( $data ){
			wfDebug( "Got user profile pictures for {$this->user_name} from cache\n" );
			$pictures = $data;
		} else{
			wfDebug( "Got user profile pictures for {$this->user_name} from db\n" );

			$dbr =& wfGetDB( DB_SLAVE );

			//database calls
			$category_title = Title::newFromText("Profile Pictures by User " . $this->user_name);

			$params['ORDER BY'] = 'page_id';
			if($limit)$params['LIMIT'] = 8;
			$res = $dbr->select( '`page` INNER JOIN `categorylinks` on cl_from=page_id', 'page_title',
				array( 'cl_to' => array($category_title->getDBKey()), 'page_namespace' => NS_IMAGE ), __METHOD__,
				$params
			);


			$sql_count = "SELECT count(page_title) as total from page INNER JOIN categorylinks on cl_from=page_id WHERE cl_to = '" . addslashes($category_title->getDBKey()) . "' and page_namespace=" . NS_IMAGE . "  ORDER BY page_id DESC";
			$res_count = $dbr->query($sql_count);
			$row_count = $dbr->fetchObject( $res_count );

			$pictures["total_count"] = $row_count->total;
			while ($row = $dbr->fetchObject( $res ) ) {
				$pictures["list"][] = array(
						"name" => $row->page_title
					);
			}
			$wgMemc->set($key,$pictures);
		}


		$picture_count = $pictures["total_count"];

		$picture_link = Title::MakeTitle(NS_SPECIAL, "UserSlideShow");
		$empty_imageLink = Title::MakeTitle(NS_IMAGE, "");
		$output .= "<script type=\"text/javascript\"><!--//<![CDATA[\n_DELETE_CONFIRM='Are you sure you want to delete this image from your profile?'\n__slideshow_user='{$user_name}';\n__image_prefix='" . trim($empty_imageLink->getFullUrl()) . "'\n//]]>--></script>";

		$upload_picture_title = Title::makeTitle(NS_SPECIAL,"MiniAjaxUpload");

		if ($picture_count>0) {

			//output mini gallery
			$output .= "<div class=\"user-section-heading\">
				<div class=\"user-section-title\">
					".wfMsg("user-pictures-title")."
				</div>
				<div class=\"user-section-actions\">
					<div class=\"action-right\">";
						if ($wgUser->getName()==$user_name) {
							$output .= "<a href=\"javascript:showUploadFrame();\">".wfMsg("user-upload-image")."</a>";
							if ($picture_count>8)$output .= " | ";
						}

						if($picture_count>8)$output .= "<a href=\"".$picture_link->escapeFullURL('user='.$user_name.'&picture=0')."\" rel=\"nofollow\">".wfMsg("user-view-all")."</a>";

					$output .= "</div>
					<div class=\"action-left\">";
					if($picture_count>8) {
						$output .= "8 ".wfMsg("user-count-separator")." {$picture_count}";
					} else {
						$output .= "{$picture_count} ".wfMsg("user-count-separator")." {$picture_count}";
					}
					$output .= "</div>
					<div class=\"cleared\"></div>
				</div>
			</div>
			<div class=\"cleared\"></div>
			<div class=\"picture-unit-container clearfix\">
			<div class=\"picture-container\">";

					$x=1;

					foreach( $pictures["list"] as $picture ){

						$image_path = $picture["name"];
						$image = Image::newFromName($image_path);
						$thumb = $image->getThumbnail(75);
						$thumbnail = $thumb->toHtml();

						$image_link = Title::MakeTitle(NS_IMAGE, $image_path);

						$output .= "<div id=\"mini-gallery-" . ($x-1) . "\" class=\"mini-image\"><a href=\"".$image_link->escapeFullURL()."\">{$thumbnail}</a>" . (( $this->isOwner() )?"<div class=\"picture-delete\"><a href=\"javascript:delete_image('{$image_path}')\">(" . wfMsg("delete") . "</a>":"") . ")</div></div>";

						if($x==4)$output .= "<div class=\"cleared\"></div>";

						$x++;

					}

					for($i=$x-1; $i<8; $i++){

						$output .= "<div id=\"mini-gallery-{$i}\" class=\"mini-image\"></div>";

						if( ($i+1)%4 == 0 ) {

							$output .= "<div class=\"cleared\"></div>";
						}
					}

			$output .= "<div class=\"cleared\"></div>
		</div>
		<div id=\"upload-frame-errors\" style=\"display:none;\" class=\"upload-frame-errors\"></div>
		<div id=\"upload-container\" style=\"display:none;\" class=\"upload-container\">
			<iframe id=\"imageUpload-frame\" class=\"imageUpload-frame\" width=\"410\"
				scrolling=\"no\" frameborder=\"0\" src=\"".$upload_picture_title->escapeFullURL('wpThumbWidth=75&wpCategories=Profile Pictures|Profile Pictures by User ' . $wgUser->getName() )."\">
			</iframe>
		</div>
		</div>";

		} else if ( $this->isOwner() ) {
			$output .= "<div class=\"user-section-heading\">
				<div class=\"user-section-title\">
					".wfMsg("user-pictures-title")."
				</div>
				<div class=\"user-section-actions\">
					<div class=\"action-right\">
						<a href=\"javascript:showUploadFrame();\">
							".wfMsg("user-upload-image")."
						</a>
					</div>
					<div class=\"action-left\">
					</div>
					<div class=\"cleared\"></div>
				</div>
			</div>
			<div class=\"cleared\"></div>
			<div class=\"picture-unit-container clearfix\">
			<div id=\"pictures-containers\" class=\"picture-container\" style=\"display:none;\">";
				for($i=0; $i<8; $i++){
					$output .= "<div id=\"mini-gallery-{$i}\" class=\"mini-image\"></div>";

					if( ($i+1)%4 == 0 ) {
						$output .= "<div class=\"cleared\"></div>";
					}
				}
			$output .= "<div class=\"cleared\"></div>
			</div>
			<div id=\"no-pictures-containers\" class=\"no-pictures-container\">
				".wfMsg("user-no-images")."
			</div>
			<div id=\"upload-frame-errors\" style=\"display:none;\" class=\"upload-frame-errors\"></div>
			<div id=\"upload-container\" style=\"display:none;\" class=\"upload-container\">
				<iframe id=\"imageUpload-frame\" class=\"imageUpload-frame\" width=\"410\"
					scrolling=\"no\" frameborder=\"0\" src=\"".$upload_picture_title->escapeFullURL('wpThumbWidth=75&wpCategories=Profile Pictures|Profile Pictures by User ' . $wgUser->getName() )."\">
				</iframe>
			</div>
		</div>";
		}

		return $output;
	}

	function getUserPolls(){
		global $wgMemc;

		$polls = array();

		//try cache
		$key = wfMemcKey( 'user', 'profile', 'polls' , $this->user_id);
		$data = $wgMemc->get( $key );

		if( $data ){
			wfDebug( "Got profile polls for user {$this->user_id} from cache\n" );
			$polls = $data;
		}else{
			wfDebug( "Got profile polls for user {$this->user_id} from db\n" );
			$dbr =& wfGetDB( DB_SLAVE );
			$params['LIMIT'] = "3";
			$params['ORDER BY'] = "poll_id desc";
			$res = $dbr->select( '`poll_question`
				INNER JOIN page on page_id=poll_page_id'
				, array('page_title', 'UNIX_TIMESTAMP(poll_date) as poll_date'),
				/*where*/ array( 'poll_user_id' => $this->user_id  ), __METHOD__,
					$params
			);
			while( $row = $dbr->fetchObject($res) ) {
				$polls[] = array (
					"title"=>$row->page_title,
					"timestamp"=>$row->poll_date
				);
			}
			$wgMemc->set( $key, $polls );
		}
		return $polls;
	}

	function getUserQuiz(){
		global $wgMemc;

		$quiz = array();

		//try cache
		$key = wfMemcKey( 'user', 'profile', 'quiz' , $this->user_id);
		$data = $wgMemc->get( $key );
		if( $data ){
			wfDebug( "Got profile quizzes for user {$this->user_id} from cache\n" );
			$quiz = $data;
		}else{
			wfDebug( "Got profile quizzes for user {$this->user_id} from db\n" );
			$dbr =& wfGetDB( DB_SLAVE );
			$params['LIMIT'] = "3";
			$params['ORDER BY'] = "q_id desc";
			$res = $dbr->select( '`quizgame_questions`'
				, array('q_id', 'q_text', 'UNIX_TIMESTAMP(q_date) as quiz_date'),
				/*where*/ array( 'q_user_id' => $this->user_id, 'q_flag' => 'NONE'  ), __METHOD__,
					$params
			);
			while( $row = $dbr->fetchObject($res) ) {
				$quiz[] = array (
					"id"=>$row->q_id,
					"text"=>$row->q_text,
					"timestamp"=>$row->quiz_date
				);
			}
			$wgMemc->set( $key, $quiz );
		}
		return $quiz;
	}

	function getUserPicGames(){
		global $wgMemc;

		$pics = array();

		//try cache
		$key = wfMemcKey( 'user', 'profile', 'picgame' , $this->user_id);
		$data = $wgMemc->get( $key );
		if( $data ){
			wfDebug( "Got profile picgames for user {$this->user_id} from cache\n" );
			$pics = $data;
		}else{
			wfDebug( "Got profile picgames for user {$this->user_id} from db\n" );
			$dbr =& wfGetDB( DB_SLAVE );
			$params['LIMIT'] = "3";
			$params['ORDER BY'] = "id desc";
			$res = $dbr->select( '`picturegame_images`'
				, array('id', 'title', 'img1', 'img2', 'UNIX_TIMESTAMP(pg_date) as pic_game_date'),
				/*where*/ array( 'userid' => $this->user_id, 'flag'=>'NONE'  ), __METHOD__,
					$params
			);
			while( $row = $dbr->fetchObject($res) ) {
				$pics[] = array (
					"id"=>$row->id,
					"title"=>$row->title,
					"img1"=>$row->img1,
					"img2"=>$row->img2,
					"timestamp"=>$row->pic_game_date
				);
			}
			$wgMemc->set( $key, $pics );
		}
		return $pics;
	}

	function getCasualGames($user_id, $user_name) {

		global $wgUser, $wgTitle, $wgOut, $wgUserProfileDisplay;

		if ($wgUserProfileDisplay['games'] == false) {
			return "";
		}

		$output = "";

		//safe titles
		$quiz_title = Title::makeTitle(NS_SPECIAL,"QuizGameHome");
		$pic_game_title = Title::makeTitle(NS_SPECIAL, "PictureGameHome");

		//combine the queries

		$combined_array = array();

		$quizzes = $this->getUserQuiz();
		foreach( $quizzes as $quiz){
			$combined_array[] = array (
				"type"=>"Quiz",
				"id"=>$quiz["id"],
				"text"=>$quiz["text"],
				"timestamp"=>$quiz["timestamp"]
			);
		}

		$polls = $this->getUserPolls();
		foreach( $polls as $poll){
			$combined_array[] = array (
				"type"=>"Poll",
				"title"=>$poll["title"],
				"timestamp"=>$poll["timestamp"]
			);
		}

		$pics = $this->getUserPicGames();
		foreach( $pics as $pic){
			$combined_array[] = array (
				"type"=>"Picture Game",
				"id"=>$pic["id"],
				"title"=>$pic["title"],
				"img1"=>$pic["img1"],
				"img2"=>$pic["img2"],
				"timestamp"=>$pic["timestamp"]
			);
		}

		usort($combined_array, array('UserProfilePage','sortItems'));

		if (count($combined_array)>0) {

			$output .= "<div class=\"user-section-heading\">
				<div class=\"user-section-title\">
					".wfMsg("casual-games-title")."
				</div>
				<div class=\"user-section-actions\">
					<div class=\"action-right\">
					</div>
					<div class=\"action-left\">
					</div>
					<div class=\"cleared\"></div>
				</div>
			</div>
			<div class=\"cleared\"></div>
			<div class=\"casual-game-container\">";

				$x = 1;

				foreach($combined_array as $item) {

					$output .= (($x==1)?"<p class=\"item-top\">":"<p>");

					if ($item["type"]=="Poll") {
						$poll_title = Title::makeTitle(300,$item["title"]);
						$casual_game_title = wfMsg("casual-game-poll");
						$output .= "<a href=\"".$poll_title->escapeFullURL()."\" rel=\"nofollow\">
							{$poll_title->getText()}
						</a>
						<span class=\"item-small\">{$casual_game_title}</span>";
					}

					if ($item["type"]=="Quiz") {
						$casual_game_title = wfMsg("casual-game-quiz");
						$output .= "<a href=\"".$quiz_title->escapeFullURL('questionGameAction=renderPermalink&permalinkID='.$item["id"])."\" rel=\"nofollow\">
							{$item["text"]}
						</a>
						<span class=\"item-small\">{$casual_game_title}</span>";
					}

					if ($item["type"]=="Picture Game") {
						if( $item["img1"] != "" && $item["img2"] != ""){
							$render_1 = Image::newFromName ($item["img1"]);
							$thumb_1 = $render_1->getThumbNail(25);
							$image_1 = $thumb_1->toHtml();

							$render_2 = Image::newFromName ($item["img2"]);
							$thumb_2 = $render_2->getThumbNail(25);
							$image_2 = $thumb_2->toHtml();

							$casual_game_title = wfMsg("casual-game-picture-game");

							$output .= "<a href=\"".$pic_game_title->escapeFullURL('picGameAction=renderPermalink&id='.$item["id"])."\" rel=\"nofollow\">
								{$image_1}
								{$image_2}
								{$item["title"]}
							</a>
							<span class=\"item-small\">{$casual_game_title}</span>";
						}
					}

					$output .= "</p>";

					$x++;

				}

			$output .= "</div>";

		}

		return $output;

	}

	function sortItems($x, $y){
		if ( $x["timestamp"] == $y["timestamp"] )
		 return 0;
		else if ( $x["timestamp"] > $y["timestamp"] )
		 return -1;
		else
		 return 1;
	}

	function getProfileSection($label,$value,$required=true){
		global $wgUser, $wgTitle, $wgOut;

		$output = "";
		if($value || $required) {
			if(!$value) {
				if ( $wgUser->getName() == $wgTitle->getText()  ) {
					$value = 'Update Your Profile';
				} else {
					$value = 'Not Provided';
				}
			}

			$value = $wgOut->parse( "<b>{$label}</b>\n" . trim( $value ), true );
			$output = "<div>
				$value
			</div>";
		}

		return $output;

	}

	function getPersonalInfo($user_id, $user_name) {
		global $IP, $wgTitle, $wgUser, $wgMemc, $wgUserProfileDisplay;

		if ($wgUserProfileDisplay['personal'] == false) {
			return "";
		}

		$output = "";

		$stats = new UserStats($user_id,$user_name);
		$stats_data = $stats->getUserStats();
		$user_level = new UserLevel($stats_data["points"]);
		$level_link = Title::makeTitle(NS_HELP,"User Levels");

		if( !$this->profile_data ){
			$profile = new UserProfile($user_name);
			$this->profile_data = $profile->getProfile();
		}
		$profile_data = $this->profile_data;

		$location = (isset($profile_data["location_city"])) ? $profile_data["location_city"] . ", " . ((isset($profile_data["location_state"])) ? $profile_data["location_state"] : "") : "";
		if ( isset($profile_data["location_country"]) && ($profile_data["location_country"]!="United States") ) {
			$location = "";
			$location .= $profile_data["location_country"];
		}

		if($location==", ")$location="";

		$hometown = (isset($profile_data["hometown_city"])) ? $profile_data["hometown_city"] . ", " . ((isset($profile_data["hometown_state"])) ? $profile_data["hometown_state"] : "") : "";
		if ( isset($profile_data["hometown_country"]) && ($profile_data["hometown_country"]!="United States") ) {
			$hometown = "";
			$hometown .= $profile_data["hometown_country"];
		}
		if ($hometown==", ") {
			$hometown="";
		}

		$joined_data = "";
		if (isset($profile_data["real_name"])) {
			$joined_data .= $profile_data["real_name"];
		}
		$joined_data .= $location.$hometown;
		if (isset($profile_data["birthday"])) {
			$joined_data .= $profile_data["birthday"];
		}
		if (isset($profile_data["occupation"])) {
			$joined_data .= $profile_data["occupation"];
		}
		if (isset($profile_data["websites"])) {
			$joined_data .= $profile_data["websites"];
		}
		if (isset($profile_data["places_lived"])) {
			$joined_data .= $profile_data["places_lived"];
		}
		if (isset($profile_data["schools"])) {
			$joined_data .= $profile_data["schools"];
		}
		if (isset($profile_data["about"])) {
			$joined_data .= $profile_data["about"];
		}

		$edit_info_link = Title::MakeTitle(NS_SPECIAL,"UpdateProfile");

		if ($joined_data) {
			$output .= "<div class=\"user-section-heading\">
				<div class=\"user-section-title\">
					".wfMsg("user-personal-info-title")."
				</div>
				<div class=\"user-section-actions\">
					<div class=\"action-right\">";
					if ($wgUser->getName()==$user_name)$output .= "<a href=\"".$edit_info_link->escapeFullURL()."\">".wfMsg("user-edit-this")."</a>";
					$output .= "</div>
					<div class=\"cleared\"></div>
				</div>
			</div>
			<div class=\"cleared\"></div>
			<div class=\"profile-info-container\">".
				$this->getProfileSection(wfMsg("user-personal-info-real-name"),$profile_data["real_name"], false).
				$this->getProfileSection(wfMsg("user-personal-info-location"),$location, false).
				$this->getProfileSection(wfMsg("user-personal-info-hometown"),$hometown, false).
				$this->getProfileSection(wfMsg("user-personal-info-birthday"),(isset($profile_data["birthday"])) ? $profile_data["birthday"] : "", false).
				$this->getProfileSection(wfMsg("user-personal-info-occupation"), (isset($profile_data["occupation"])) ? $profile_data["occupation"] : "", false).
				$this->getProfileSection(wfMsg("user-personal-info-websites"), (isset($profile_data["websites"])) ? $profile_data["websites"] : "", false).
				$this->getProfileSection(wfMsg("user-personal-info-places-lived"), (isset($profile_data["places_lived"])) ? $profile_data["places_lived"] : "",false).
				$this->getProfileSection(wfMsg("user-personal-info-schools"), (isset($profile_data["schools"])) ? $profile_data["schools"] : "",false).
				$this->getProfileSection(wfMsg("user-personal-info-about-me"), (isset($profile_data["about"])) ? $profile_data["about"] : "",false).
			"</div>";
		} else if ($wgUser->getName()==$user_name) {
			$output .= "<div class=\"user-section-heading\">
				<div class=\"user-section-title\">
					".wfMsg("user-personal-info-title")."
				</div>
				<div class=\"user-section-actions\">
					<div class=\"action-right\">
						<a href=\"".$edit_info_link->escapeFullURL()."\">"
							.wfMsg("user-edit-this").
						"</a>
					</div>
					<div class=\"cleared\"></div>
				</div>
			</div>
			<div class=\"cleared\"></div>
			<div class=\"no-info-container\">
				".wfMsg("user-no-personal-info")."
			</div>";
		}

		return $output;
	}

	function getCustomInfo($user_name) {
		global $IP, $wgTitle, $wgUser, $wgMemc, $wgUserProfileDisplay;

		if ($wgUserProfileDisplay['custom'] == false) {
			return "";
		}

		$output = "";

		if( !$this->profile_data ){
			$profile = new UserProfile($user_name);
			$this->profile_data = $profile->getProfile();
		}
		$profile_data = $this->profile_data;

		$joined_data = "";
		if (isset($profile_data["custom_1"])) {
			$joined_data .= $profile_data["custom_1"];
		}
		if (isset($profile_data["custom_2"])) {
			$joined_data .= $profile_data["custom_2"];
		}
		if (isset($profile_data["custom_3"])) {
			$joined_data .= $profile_data["custom_3"];
		}
		if (isset($profile_data["custom_4"])) {
			$joined_data .= $profile_data["custom_4"];
		}
		$edit_info_link = Title::MakeTitle(NS_SPECIAL,"UpdateProfile");

		/*
		if ($joined_data) {
			$output .= "<div class=\"user-section-heading\">
				<div class=\"user-section-title\">
					".wfMSg("custom-info-title")."
				</div>
				<div class=\"user-section-actions\">
					<div class=\"action-right\">";
						if ($wgUser->getName()==$user_name)$output .= "<a href=\"".$edit_info_link->escapeFullURL()."/custom\">".wfMsg("user-edit-this")."</a>";
					$output .= "</div>
					<div class=\"cleared\"></div>
				</div>
			</div>
			<div class=\"cleared\"></div>
			<div class=\"profile-info-container\">".
				$this->getProfileSection(wfMsg("custom-info-field1"),$profile_data["custom_1"],false).
				$this->getProfileSection(wfMsg("custom-info-field2"),$profile_data["custom_2"],false).
				$this->getProfileSection(wfMsg("custom-info-field3"),$profile_data["custom_3"],false).
				$this->getProfileSection(wfMsg("custom-info-field4"),$profile_data["custom_4"],false).
			"</div></span>";
		} else if ($wgUser->getName()==$user_name) {
			$output .= "<div class=\"user-section-heading\">
				<span id=\"user-section-custom\">???
				<div class=\"user-section-title\">
					".wfMSg("custom-info-title")."
				</div>
				<div class=\"user-section-actions\">
					<div class=\"action-right\">
						<a href=\"".$edit_info_link->escapeFullURL()."/custom\">
							".wfMSg("user-edit-this")."
						</a>
					</div>
					<div class=\"cleared\"></div>
				</div>
			</div>
			<div class=\"cleared\"></div>
			<div class=\"no-info-container\">
				".wfMSg("custom-no-info")."
			</div></span>";
		}
		*/

		return $output;
	}


	function getInterests($user_name) {
		global $IP, $wgTitle, $wgUser, $wgMemc, $wgUserProfileDisplay;

		if ($wgUserProfileDisplay['interests'] == false) {
			return "";
		}

		$output = "";

		if( !$this->profile_data ){
			$profile = new UserProfile($user_name);
			$this->profile_data = $profile->getProfile();
		}
		$profile_data = $this->profile_data;

		$joined_data = "";
		if (isset($profile_data["movies"])) {
			$joined_data .= $profile_data["movies"];
		}
		if (isset($profile_data["tv"])) {
			$joined_data .= $profile_data["tv"];
		}
		if (isset($profile_data["music"])) {
			$joined_data .= $profile_data["music"];
		}
		if (isset($profile_data["books"])) {
			$joined_data .= $profile_data["books"];
		}
		if (isset($profile_data["video_games"])) {
			$joined_data .= $profile_data["video_games"];
		}
		if (isset($profile_data["magazines"])) {
			$joined_data .= $profile_data["magazines"];
		}
		if (isset($profile_data["drinks"])) {
			$joined_data .= $profile_data["drinks"];
		}
		if (isset($profile_data["snacks"])) {
			$joined_data .= $profile_data["snacks"];
		}

		$edit_info_link = Title::MakeTitle(NS_SPECIAL,"UpdateProfile");

		if ($joined_data) {

			$output .= "<div class=\"user-section-heading\">
				<div class=\"user-section-title\">
					".wfMsg("other-info-title")."
				</div>
				<div class=\"user-section-actions\">
					<div class=\"action-right\">";
						if ($wgUser->getName()==$user_name)$output .= "<a href=\"".$edit_info_link->escapeFullURL()."/personal\">".wfMsg("user-edit-this")."</a>";
					$output .= "</div>
					<div class=\"cleared\"></div>
				</div>
			</div>
			<div class=\"cleared\"></div>
			<div class=\"profile-info-container\">".
				$this->getProfileSection(wfMsg("other-info-movies"),$profile_data["movies"],false).
				$this->getProfileSection(wfMsg("other-info-tv"),$profile_data["tv"],false).
				$this->getProfileSection(wfMsg("other-info-music"),$profile_data["music"],false).
				$this->getProfileSection(wfMsg("other-info-books"),$profile_data["books"],false).
				$this->getProfileSection(wfMsg("other-info-video-games"),$profile_data["video_games"],false).
				$this->getProfileSection(wfMsg("other-info-magazines"),$profile_data["magazines"],false).
				$this->getProfileSection(wfMsg("other-info-snacks"),$profile_data["snacks"],false).
				$this->getProfileSection(wfMsg("other-info-drinks"),$profile_data["drinks"],false).
			"</div>";

		} else if ($wgUser->getName()==$user_name) {
			$output .= "<div class=\"user-section-heading\">
				<div class=\"user-section-title\">
					".wfMsg("other-info-title")."
				</div>
				<div class=\"user-section-actions\">
					<div class=\"action-right\">
						<a href=\"".$edit_info_link->escapeFullURL()."/personal\">".wfMsg("user-edit-this")."</a>
					</div>
					<div class=\"cleared\"></div>
				</div>
			</div>
			<div class=\"cleared\"></div>
			<div class=\"no-info-container\">
					".wfMsg("other-no-info")."
			</div>";
		}

		return $output;
	}

	function getProfileTop($user_id, $user_name) {

		global $IP, $wgTitle, $wgUser, $wgMemc, $wgUploadPath, $wgDisableFoeing;

		$output = "";

		$stats = new UserStats($user_id,$user_name);
		$stats_data = $stats->getUserStats();
		$user_level = new UserLevel($stats_data["points"]);
		$level_link = Title::makeTitle(NS_HELP,"User Levels");

		if( !$this->profile_data ){
			$profile = new UserProfile($user_name);
			$this->profile_data = $profile->getProfile();
		}
		$profile_data = $this->profile_data;

		//variables and other crap
		$page_title = $wgTitle->getText();
		$title_parts = explode("/",$page_title);
		$user = $title_parts[0];
		$id=User::idFromName($user);
		$user_safe = urlencode($user);

		//safe urls
		$add_relationship = Title::makeTitle(NS_SPECIAL, "AddRelationship");
		$remove_relationship = Title::makeTitle(NS_SPECIAL, "RemoveRelationship");
		$give_gift = Title::makeTitle(NS_SPECIAL, "GiveGift");
		$friends_activity = Title::makeTitle(NS_SPECIAL, "UserActivity");
		$send_board_blast = Title::makeTitle(NS_SPECIAL, "SendBoardBlast");
		$similar_fans = Title::makeTitle(NS_SPECIAL, "SimilarFans");
		$update_profile = Title::makeTitle(NS_SPECIAL, "UpdateProfile");
		$watchlist = Title::makeTitle(NS_SPECIAL,"Watchlist");
		$contributions = SpecialPage::getTitleFor('Contributions', $user);
		$send_message = Title::makeTitle(NS_SPECIAL, "UserBoard");
		$upload_avatar = Title::makeTitle(NS_SPECIAL,"UploadAvatar");
		$user_page = Title::makeTitle(NS_USER,$user);
		$user_social_profile = Title::makeTitle(NS_USER_PROFILE,$user);
		$user_wiki = Title::makeTitle(NS_USER_WIKI,$user);

		if($id!=0) $relationship = UserRelationship::getUserRelationshipByID($id,$wgUser->getID());
		$avatar = new wAvatar($this->user_id,"l");

		wfDebug("profile type" . $profile_data["user_page_type"] . "\n");
		if ( $this->isOwner() ) {
			$toggle_title = Title::makeTitle(NS_SPECIAL, "ToggleUserPage");
			$output .= "<div id=\"profile-toggle-button\"><a href=\"".$toggle_title->escapeFullURL()."\" rel=\"nofollow\">". (( $this->profile_data["user_page_type"] == 1 )? wfMsg("user-type-toggle-old"):wfMsg("user-type-toggle-new") ) ."</a></div>";
		}

		$output .= "<div id=\"profile-image\">
		<img src=\"{$wgUploadPath}/avatars/".$avatar->getAvatarImage()."\" alt=\"\" border=\"0\"/>
		</div>";

		$output .= "<div id=\"profile-right\">";

			global $wgEnableAnswers;
			if (!empty($wgEnableAnswers)) {
				$points = AttributionCache::getInstance()->getUserEditPoints($user_id);

				$editPoints = Xml::element('span', array('class' => 'profile-title-points'),
					'(' . wfMsgExt('profile_edit_points', array('parsemag'), array($points)) . ')');
			}
			else {
				$editPoints = '';
			}

			$output .= "<div id=\"profile-title-container\">
				<div id=\"profile-title\">
					{$user_name}{$editPoints}
				</div>";
				global $wgUserLevels;
				if( $wgUserLevels ){
					$output .= "<div id=\"points-level\">
					<a href=\"{$level_link->escapeFullURL()}\">{$stats_data["points"]} points</a>
					</div>
					<div id=\"honorific-level\">
						<a href=\"{$level_link->escapeFullURL()}\" rel=\"nofollow\">({$user_level->getLevelName()})</a>
					</div>";
				}
				$output .= "<div class=\"cleared\"></div>
			</div>
			<div class=\"profile-actions\">";

		if ( $this->isOwner() ) {
			$output .= "
			<a href=\"".$update_profile->escapeFullURL()."\">".wfMsg("user-edit-profile")."</a> |
			<a href=\"".$upload_avatar->escapeFullURL()."\">".wfMsg("user-upload-avatar")."</a> |
			<a href=\"".$watchlist->escapeFullURL()."\">".wfMsg("user-watchlist")."</a> |";
			//"<a href=\"".$friends_activity->escapeFullURL()."\">".wfMsg("user-friends-activity")."</a> |";
		} else if ($wgUser->isLoggedIn()) {
			if($relationship==false) {
				$output .= "<a href=\"".$add_relationship->escapeFullURL('user='.$user_safe.'&rel_type=1')."\" rel=\"nofollow\">".wfMsg("user-add-friend")."</a> |";
				if( ! $wgDisableFoeing  ) $output .= "<a href=\"".$add_relationship->escapeFullURL('user='.$user_safe.'&rel_type=2')."\" rel=\"nofollow\">".wfMsg("user-add-foe")."</a> |";
			} else {
				if ($relationship==1)$output .= "<a href=\"".$remove_relationship->escapeFullURL('user='.$user_safe)."\">".wfMsg("user-remove-friend")."</a> |";
				if ($relationship==2 && !$wgDisableFoeing )$output .= "<a href=\"".$remove_relationship->escapeFullURL('user='.$user_safe)."\">".wfMsg("user-remove-foe")."</a> |";
			}

			global $wgUserBoard, $wgEnableGifts;
			if( $wgUserBoard ){
				$output .= "<a href=\"".$send_message->escapeFullURL('user='.$wgUser->getName().'&conv='.$user_safe)."\" rel=\"nofollow\">".wfMsg("user-send-message")."</a> | ";
			}
			if( $wgEnableGifts ){
			$output .= "<a href=\"".$give_gift->escapeFullURL('user='.$user_safe)."\" rel=\"nofollow\">".wfMsg("user-send-gift")."</a> |";
			}
		}

			$output .= "<a href=\"".$contributions->escapeFullURL()."\" rel=\"nofollow\">".wfMsg("user-contributions")."</a>";

			//Links to User:user_name  from User_profile:
			if( $wgTitle->getNamespace() == NS_USER_PROFILE && $this->profile_data["user_id"] && $this->profile_data["user_page_type"] == 0){
				$output .= "| <a href=\"".$user_page->escapeFullURL()."\" rel=\"nofollow\">".wfMsg("user-page-link")."</a>";
			}
			//Links to User:user_name  from User_profile:
			if( $wgTitle->getNamespace() == NS_USER && $this->profile_data["user_id"] && $this->profile_data["user_page_type"] == 0){
				$output .= "| <a href=\"".$user_social_profile->escapeFullURL()."\" rel=\"nofollow\">".wfMsg("user-social-profile-link")."</a>";
			}

			if( $wgTitle->getNamespace() == NS_USER && ( !$this->profile_data["user_id"] || $this->profile_data["user_page_type"] == 1) ){
				$output .= "| <span id=\"profile-actions-wikiuserpage\"><a href=\"".$user_wiki->escapeFullURL()."\" rel=\"nofollow\">".wfMsg("user-wiki-link")."</a></span>";
			}


		$output .= "</div>

		</div>";

		return $output;

	}

	function getProfileImage($user_name){

		global $wgUser, $wgUploadPath;

		$output = "";

		$avatar = new wAvatar($this->user_id,"l");
		$avatar_title = Title::makeTitle( NS_SPECIAL , "UploadAvatar");

		$output .= "<div class=\"profile-image\">";
			if ($wgUser->getName()==$this->user_name) {
				$output .= "<a href=\"{$avatar->escapeFullURL()}\" rel=\"nofollow\">
					<img src=\"{$wgUploadPath}/avatars/".$avatar->getAvatarImage()."\" alt=\"\" border=\"0\"/><br/>
					(".((strpos($avatar->getAvatarImage(), 'default_')!=false)?"upload image":"new image").")
				</a>";
			} else {
				$output .= "<img src=\"{$wgUploadPath}/avatars/".$avatar->getAvatarImage()."\" alt=\"\" border=\"0\"/>";
			}
		$output .= "</div>";

		return $output;
	}

	function getRelationships($user_name,$rel_type){
		global $IP, $wgMemc, $wgUser, $wgTitle, $wgUserProfileDisplay, $wgUploadPath;

		$output = "";

		//If not enabled in site settings, don't display
		if ($rel_type == 1) {
			if ($wgUserProfileDisplay['friends'] == false) {
				return "";
			}
		} else {
			if ($wgUserProfileDisplay['foes'] == false) {
				return "";
			}
		}

		$count = 4;
		$rel = new UserRelationship($user_name);
		$key = wfMemcKey( 'relationship', 'profile', "{$rel->user_id}-{$rel_type}" );
		$data = $wgMemc->get( $key );

		//try cache
		if(!$data) {
			$friends = $rel->getRelationshipList($rel_type,$count);
			$wgMemc->set( $key, $friends );
		} else {
			wfDebug( "Got profile relationship type {$rel_type} for user {$user_name} from cache\n" );
			$friends = $data;
		}

		$stats = new UserStats($rel->user_id,$user_name);
		$stats_data = $stats->getUserStats();
		$user_safe = urlencode(   $user_name  );
		$view_all_title = Title::makeTitle(NS_SPECIAL,"ViewRelationships");

		if (isset($stats_data["friend_count"])){
                    if ($rel_type==1) {
                            $relationship_count = $stats_data["friend_count"];
                            $relationship_title = wfMsg("user-friends-title");

                    } else {
                            $relationship_count = $stats_data["foe_count"];
                            $relationship_title = wfMsg("user-foes-title");
                    }
                }else{
                    $relationship_count = 0;
                }

		if (count($friends)>0) {
			$x = 1;
			$per_row = 4;

			$output .= "<div class=\"user-section-heading\">
				<div class=\"user-section-title\">{$relationship_title}</div>
				<div class=\"user-section-actions\">
					<div class=\"action-right\">";
						if (intval(str_replace(",", "", $relationship_count))>4)$output .= "<a href=\"".$view_all_title->escapeFullURL('user='.$user_name.'&rel_type='.$rel_type)."\" rel=\"nofollow\">".wfMsg('user-view-all')."</a>";
					$output .= "</div>
					<div class=\"action-left\">";
						if(intval(str_replace(",", "", $relationship_count))>4) {
							$output .= "{$per_row} ".wfMsg('user-count-separator')." {$relationship_count}";
						} else {
							$output .= "{$relationship_count} ".wfMsg('user-count-separator')." {$relationship_count}";
						}
					$output .= "</div>
				</div>
				<div class=\"cleared\"></div>
			</div>
			<div class=\"cleared\"></div>
			<div class=\"user-relationship-container\">";

				foreach ($friends as $friend) {
					$user =  Title::makeTitle( NS_USER  , $friend["user_name"]  );
					$avatar = new wAvatar($friend["user_id"],"ml");
					$avatar_img = "<img src=\"{$wgUploadPath}/avatars/" . $avatar->getAvatarImage() . "\" alt=\"\" border=\"0\"/>";

					//chop down username that gets displayed
					$user_name = mb_substr($friend["user_name"],0,9);
					if($user_name!=$friend["user_name"])$user_name.= "..";

					$output .= "<a href=\"".$user->escapeFullURL()."\" title=\"{$friend["user_name"]}\" rel=\"nofollow\">
						{$avatar_img}<br/>
						{$user_name}
					</a>";
					if($x==count($friends) || $x!=1 && $x%$per_row ==0)$output.="<div class=\"cleared\"></div>";
					$x++;
				}

			$output .= "</div>";
		}

		return $output;
	}

	function getActivity($user_name){
		global $IP, $wgUser, $wgTitle, $wgUserProfileDisplay, $wgUploadPath;

		//If not enabled in site settings, don't display
		if($wgUserProfileDisplay['activity'] == false){
			return "";
		}

		$output = "";

		require_once("$IP/extensions/wikia/UserActivity/UserActivityClass.php");

		$limit = 8;
		$rel = new UserActivity($user_name,"user",$limit);
		$rel->setActivityToggle("show_votes",0);
		$rel->setActivityToggle("show_gifts_sent",1);


			/*
			Get all relationship activity
			*/
			$activity = $rel->getActivityList();

			if ($activity) {

				$output .= "<div class=\"user-section-heading\">
					<div class=\"user-section-title\">
						".wfMsg("user-recent-activity-title")."
					</div>
					<div class=\"user-section-actions\">
						<div class=\"action-right\">
						</div>
						<div class=\"cleared\"></div>
					</div>
				</div>
				<div class=\"cleared\"></div>";

				$x = 1;

				if (count($activity)<$limit) {
					$style_limit = count($activity);
				} else {
					$style_limit = $limit;
				}

				foreach ($activity as $item) {

					$item_html = "";
					$title = Title::makeTitle( $item["namespace"]  , $item["pagetitle"]  );
					$user_title = Title::makeTitle( NS_USER  , $item["username"]  );
					$user_title_2 = Title::makeTitle( NS_USER  , $item["comment"]  );

					if($user_title_2)$user_link_2 = "<a href=\"".$user_title_2->escapeFullURL()."\" rel=\"nofollow\">{$item["comment"]}</a>";

					$avatar = new wAvatar($item["userid"],"s");
					$CommentIcon = $avatar->getAvatarImage();



					$comment_url = "";
					if($item["type"] == "comment") $comment_url = "#comment-{$item["id"]}";

					$page_link = "<b><a href=\"" . $title->escapeFullURL() . "{$comment_url}\">" . $title->getPrefixedText() . "</a></b> ";
					$item_time = "<span class=\"item-small\">" . get_time_ago($item["timestamp"]) . " " .wfMsg("user-time-ago")."</span>";

					if ($x<$style_limit) {
						$item_html .= "<div class=\"activity-item\">
									<img src=\"{$wgUploadPath}/common/" . UserActivity::getTypeIcon($item["type"]) . "\" alt=\"\" border=\"0\"/>";
					} else {
						$item_html .= "<div class=\"activity-item-bottom\">
									<img src=\"{$wgUploadPath}/common/" . UserActivity::getTypeIcon($item["type"]) . "\" alt=\"\" border=\"0\"/>";
					}



					switch ($item["type"]) {
						case "edit":
							$item_html .= wfMsg("user-recent-activity-edit")." {$page_link} {$item_time}
								<div class=\"item\">";
									if ($item["comment"])$item_html .= "\"{$item["comment"]}\"";
								$item_html .= "</div>";
							break;
						case "vote":
							$item_html .= wfMsg("user-recent-activity-vote") . " {$page_link} {$item_time}";
							break;
						case "comment":
							$item_html .= wfMsg("user-recent-activity-comment") . " {$page_link} {$item_time}
								<div class=\"item\">
									\"{$item["comment"]}\"
								</div>";
							break;
						case "gift-sent":
							$gift_image = "<img src=\"{$wgUploadPath}/awards/" . Gifts::getGiftImage($item["namespace"],"m") . "\" border=\"0\" alt=\"\" />";
							$item_html .= wfMsg("user-recent-activity-gift-sent") . " {$user_link_2} {$item_time}
							<div class=\"item\">
								<a href=\"/index.php?title=Special:ViewGift&gift_id={$item["id"]}\" rel=\"nofollow\">
									{$gift_image}
									{$item["pagetitle"]}
								</a>
							</div>";
							break;
						case "gift-rec":
							$gift_image = "<img src=\"{$wgUploadPath}/awards/" . Gifts::getGiftImage($item["namespace"],"m") . "\" border=\"0\" alt=\"\" />";
							$item_html .= wfMsg("user-recent-activity-gift-rec") . " {$user_link_2} {$item_time}</span>
									<div class=\"item\">
										<a href=\"/index.php?title=Special:ViewGift&gift_id={$item["id"]}\" rel=\"nofollow\">
											{$gift_image}
											{$item["pagetitle"]}
										</a>
									</div>";
							break;
						case "system_gift":
							$gift_image = "<img src=\"{$wgUploadPath}/awards/" . SystemGifts::getGiftImage($item["namespace"],"m") . "\" border=\"0\" alt=\"\" />";
							$item_html .= wfMsg("user-recent-system-gift") . " {$item_time}
									<div class=\"user-home-item-gift\">
										<a href=\"/index.php?title=Special:ViewSystemGift&gift_id={$item["id"]}\" rel=\"nofollow\">
											{$gift_image}
											{$item["pagetitle"]}
										</a>
									</div>";
							break;
						case "friend":
							$item_html .= wfMsg("user-recent-activity-friend") . " <b>{$user_link_2}</b> {$item_time}";
							break;
						case "foe":
							$item_html .= wfMsg("user-recent-activity-foe") . " <b>{$user_link_2}</b> {$item_time}";
							break;
						case "system_message":
							$item_html .= "{$item["comment"]} {$item_time}";
							break;
						case "user_message":
							$item_html .= wfMsg("user-recent-activity-user-message") . " <b><a href=\"" . UserBoard::getUserBoardURL($user_title_2->getText()) . "\" rel=\"nofollow\">{$item["comment"]}</a></b>  {$item_time}
									<div class=\"item\">
									\"{$item["namespace"]}\"
									</div>";
							break;
						case "network_update":
							$page_link = "" . $item["network"] . "</a> ";
							$network_image = SportsTeams::getLogo($item["sport_id"],$item["team_id"],"s");
							$item_html .= wfMsg("user-recent-activity-network-update") . "
									<div class=\"item\">
										<a href=\"" . SportsTeams::getNetworkURL($item["sport_id"],$item["team_id"]) . "\" rel=\"nofollow\">{$network_image} \"{$item["comment"]}\"</a>
									</div>";
							break;
					}


					$item_html .= "</div>";


					if($x<=$limit){
						$items_html_type["all"][] = $item_html;
					}
					$items_html_type[$item["type"]][] = $item_html;

					$x++;
				}


				$by_type = "";
				foreach($items_html_type["all"] as $item){
					$by_type .= $item;
				}
				$output .= "<div id=\"recent-all\">$by_type</div>";

				$by_type = "";
				if( isset($items_html_type["edit"]) && is_array($items_html_type["edit"]) ){
					foreach($items_html_type["edit"] as $item){
						$by_type .= $item;
					}
				}

				$by_type = "";
				if( isset($items_html_type["comment"]) && is_array($items_html_type["comment"]) ){
					foreach($items_html_type["comment"] as $item){
						$by_type .= $item;
					}
				}

				$by_type = "";
				if( isset($items_html_type["gift-sent"]) && is_array($items_html_type["gift-sent"]) ){
					foreach($items_html_type["gift-sent"] as $item){
						$by_type .= $item;
					}
				}

				$by_type = "";
				if( isset($items_html_type["gift-rec"]) && is_array($items_html_type["gift-rec"]) ){
					foreach($items_html_type["gift-rec"] as $item){
						$by_type .= $item;
					}
				}

				$by_type = "";
				if( isset($items_html_type["system_gift"]) && is_array($items_html_type["system_gift"]) ){
					foreach($items_html_type["system_gift"] as $item){
						$by_type .= $item;
					}
				}

				$by_type = "";
				if ( isset($items_html_type["friend"]) && is_array($items_html_type["friend"]) ){
					foreach($items_html_type["friend"] as $item){
						$by_type .= $item;
					}
				}

				$by_type = "";
				if ( isset($items_html_type["foe"]) && is_array($items_html_type["foe"]) ){
					foreach($items_html_type["foe"] as $item){
						$by_type .= $item;
					}
				}

				$by_type = "";
				if ( isset($items_html_type["system_message"]) && is_array($items_html_type["system_message"]) ){
					foreach($items_html_type["system_message"] as $item){
						$by_type .= $item;
					}
				}

				$by_type = "";
				if ( isset($items_html_type["network_update"]) && is_array($items_html_type["network_update"]) ) {
					foreach($items_html_type["network_update"] as $item){
						$by_type .= $item;
					}
				}

			}

			$output .= "";
		return $output;
	}

	function getGifts($user_name){
		global $IP, $wgUser, $wgTitle, $wgMemc, $wgUserProfileDisplay, $wgUploadPath;

		//If not enabled in site settings, don't display
		if($wgUserProfileDisplay['gifts'] == false){
			return "";
		}

		$output = "";

		//USER TO USER GIFTS
		$g = new UserGifts($user_name);
		$user_safe = urlencode($user_name);

		//try cache
		$key = wfMemcKey( 'user', 'profile', 'gifts', "{$g->user_id}" );
		$data = $wgMemc->get( $key );

		if( !$data ){
			wfDebug( "Got profile gifts for user {$user_name} from db\n" );
			$gifts = $g->getUserGiftList(0,4);
			$wgMemc->set( $key, $gifts, 60 * 60 * 4 );
		} else {
			wfDebug( "Got profile gifts for user {$user_name} from cache\n" );
			$gifts = $data;
		}

		$gift_count = $g->getGiftCountByUsername($user_name);
		$gift_link = Title::Maketitle(NS_SPECIAL, "ViewGifts");
		$per_row = 4;

		if ($gifts) {

			$output .= "<div class=\"user-section-heading\">
				<div class=\"user-section-title\">
					".wfMsg("user-gifts-title")."
				</div>
				<div class=\"user-section-actions\">
					<div class=\"action-right\">";
						if($gift_count>4)$output .= "<a href=\"".$gift_link->escapeFullURL('user='.$user_safe)."\" rel=\"nofollow\">".wfMsg("user-view-all")."</a>";
					$output .= "</div>
					<div class=\"action-left\">";
						if($gift_count>4) {
							$output .= "4 ".wfMsg("user-count-separator")." {$gift_count}";
						} else {
							$output .= "{$gift_count} ".wfMsg("user-count-separator")." {$gift_count}";
						}
					$output .= "</div>
					<div class=\"cleared\"></div>
				</div>
			</div>
			<div class=\"cleared\"></div>
			<div class=\"user-gift-container\">";

				$x = 1;

				foreach ($gifts as $gift) {

					if($gift["status"] == 1 && $user_name==$wgUser->getName() ){
						$g->clearUserGiftStatus($gift["id"]);
						$wgMemc->delete( $key );
						$g->decNewGiftCount( $wgUser->getID() );
					}

					$user =  Title::makeTitle( NS_USER  , $gift["user_name_from"]  );
					$gift_image = "<img src=\"{$wgUploadPath}/awards/" . Gifts::getGiftImage($gift["gift_id"],"ml") . "\" border=\"0\" alt=\"\" />";
					$gift_link = $user =  Title::makeTitle( NS_SPECIAL  , "ViewGift"  );
					$output .= "<a href=\"".$gift_link->escapeFullURL('gift_id='.$gift['id'])."\" ".(($gift["status"] == 1)?"class=\"user-page-new\"":"")." rel=\"nofollow\">{$gift_image}</a>";
					if($x==count($gifts) || $x!=1 && $x%$per_row ==0)$output .= "<div class=\"cleared\"></div>";
					$x++;

				}

			$output .= "</div>";
		}


		return $output;
	}

	function getAwards($user_name){
		global $IP, $wgUser, $wgTitle, $wgMemc, $wgUserProfileDisplay, $wgUploadPath;

		//If not enabled in site settings, don't display
		if($wgUserProfileDisplay['awards'] == false){
			return "";
		}

		$output = "";

		//SYSTEM GIFTS
		$sg = new UserSystemGifts($user_name);

		//try cache
		$sg_key = wfMemcKey( 'user', 'profile', 'system_gifts', "{$sg->user_id}" );
		$data = $wgMemc->get( $sg_key );
		if( !$data ){
			wfDebug( "Got profile awards for user {$user_name} from db\n" );
			$system_gifts = $sg->getUserGiftList(0,4);
			$wgMemc->set( $sg_key, $system_gifts, 60 * 60 * 4 );
		}else{
			wfDebug( "Got profile awards for user {$user_name} from cache\n" );
			$system_gifts = $data;
		}

		$system_gift_count = $sg->getGiftCountByUsername($user_name);
		$system_gift_link = Title::Maketitle(NS_SPECIAL, "ViewSystemGifts");
		$per_row = 4;

		if ($system_gifts) {

			$x = 1;

			$output .= "<div class=\"user-section-heading\">
				<div class=\"user-section-title\">
					".wfMsg("user-awards-title")."
				</div>
				<div class=\"user-section-actions\">
					<div class=\"action-right\">";
						if ($system_gift_count>4)$output .= "<a href=\"".$system_gift_link->escapeFullURL('user='.$user_name)."\" rel=\"nofollow\">".wfMsg("user-view-all")."</a>";
					$output .= "</div>
					<div class=\"action-left\">";
						if($system_gift_count>4) {
							$output .= "4 ".wfMsg("user-count-separator")." {$system_gift_count}";
						} else {
							$output .= "{$system_gift_count}".wfMsg("user-count-separator")."{$system_gift_count}";
						}
					$output .= "</div>
					<div class=\"cleared\"></div>
				</div>
			</div>
			<div class=\"cleared\"></div>
			<div class=\"user-gift-container\">";

				foreach ($system_gifts as $gift) {

					if($gift["status"] == 1 && $user_name==$wgUser->getName() ){
						$sg->clearUserGiftStatus($gift["id"]);
						$wgMemc->delete( $sg_key );
						$sg->decNewSystemGiftCount( $wgUser->getID() );
					}

					$gift_image = "<img src=\"{$wgUploadPath}/awards/" . SystemGifts::getGiftImage($gift["gift_id"],"ml") . "\" border=\"0\" alt=\"\" />";
					$gift_link = $user =  Title::makeTitle( NS_SPECIAL  , "ViewSystemGift"  );

					$output .= "<a href=\"".$gift_link->escapeFullURL('gift_id='.$gift["id"])."\" ".(($gift["status"]==1)?"class=\"user-page-new\"":"")." rel=\"nofollow\">
						{$gift_image}
					</a>";

					if($x==count($system_gifts) || $x!=1 && $x%$per_row ==0)$output .= "<div class=\"cleared\"></div>";
					$x++;
				}

			$output .= "</div>";
		}

		return $output;
	}

	function getUserBoard($user_id,$user_name){
		global $IP, $wgMemc, $wgUser, $wgTitle, $wgOut, $wgUserProfileDisplay, $wgUserProfileScripts, $wgStyleVersion;
		if($user_id == 0)return "";

		if ($wgUserProfileDisplay['board'] == false) {
			return "";
		}

		$output = "";

		$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgUserProfileScripts}/UserProfilePage.js?{$wgStyleVersion}\"></script>\n");

		$rel = new UserRelationship($user_name);
		$friends = $rel->getRelationshipList(1,4);

		$user_safe = str_replace("&","%26",$user_name);
		$stats = new UserStats($user_id, $user_name);
		$stats_data = $stats->getUserStats();

		if ( isset( $stats_data["user_board"] ) ){
                        $total = $stats_data["user_board"];
                } else {
                        $total = 0;
                }

                if ( isset( $stats_data["user_board_priv"] ) ){
                    if( $wgUser->getName() == $user_name ) $total = $total + $stats_data["user_board_priv"];
                }

		$output .= "<div class=\"user-section-heading\">
			<div class=\"user-section-title\">
				".wfMsg("user-board-title")."
			</div>
			<div class=\"user-section-actions\">
				<div class=\"action-right\">";
					if($wgUser->getName() == $user_name) {
						if($friends)$output .= "<a href=\"" . UserBoard::getBoardBlastURL()."\">".wfMsg("user-send-board-blast")."</a>";
						if($total>10)$output .= " | ";
					}
					if($total>10)$output .= "<a href=\"".UserBoard::getUserBoardURL($user_name)."\">".wfMsg("user-view-all")."</a>";
				$output .= "</div>
				<div class=\"action-left\">";
					if($total>10) {
						$output .= "10 ".wfMsg("user-count-separator")." {$total}";
					} else if ($total>0) {
						$output .= "{$total} ".wfMsg("user-count-separator")." {$total}";
					}
				$output .= "</div>
				<div class=\"cleared\"></div>
			</div>
		</div>
		<div class=\"cleared\"></div>";
		if($wgUser->getName() !== $user_name){
			if($wgUser->isLoggedIn() && !$wgUser->isBlocked()){
				$output .= "<div class=\"user-page-message-form\">
						<input type=\"hidden\" id=\"user_name_to\" name=\"user_name_to\" value=\"" . addslashes($user_name)."\"/>
						<span style=\"color:#797979;\">" . wfMsg("userboard_messagetype") . "</span> <select id=\"message_type\"><option value=\"0\">" . wfMsg("userboard_public") . "</option><option value=\"1\">" . wfMsg("userboard_private") . "</option></select><p>
						<textarea name=\"message\" id=\"message\" cols=\"43\" rows=\"4\"/></textarea>
						<div class=\"user-page-message-box-button\">
							<input type=\"button\" value=\"" . wfMsg("userboard_sendbutton") . "\" class=\"site-button\" onclick=\"javascript:send_message();\">
						</div>
					</div>";
			} else {

				$login_link = Title::makeTitle(NS_SPECIAL, "Userlogin");

				$output .= "<div class=\"user-page-message-form\">
						".wfMsg("user-board-login-message", $login_link->escapeFullURL())."
				</div>";
			}
		}
		$output .= "<div id=\"user-page-board\">";

		$b = new UserBoard();
		$output .= $b->displayMessages($user_id,0,10);

		$output .= "</div>";


		return $output;
	}

	function getFanBoxes($user_name){
		global $wgOut, $IP, $wgUser, $wgTitle, $wgMemc, $wgUserProfileDisplay, $wgMessageCache, $wgFanBoxScripts, $wgFanBoxDirectory, $wgEnableUserBoxes;
		global $wgStyleVersion;

		$output = "";
		if (!$wgEnableUserBoxes || $wgUserProfileDisplay['userboxes'] == false) {
			return "";
		}

		$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgFanBoxScripts}/FanBoxes.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgFanBoxScripts}/FanBoxes.css?{$wgStyleVersion}\"/>\n");

		require_once ( "{$wgFanBoxDirectory}/FanBox.i18n.php" );
			foreach( efWikiaFantag() as $lang => $messages ){
				$wgMessageCache->addMessages( $messages, $lang );
			}

		$f = new UserFanBoxes($user_name);
		$user_safe = ($user_name);

		//try cache
		//$key = wfMemcKey( 'user', 'profile', 'fanboxes', "{$f->user_id}" );
		//$data = $wgMemc->get( $key );

		//if( !$data ){
		//	wfDebug( "Got profile gifts for user {$user_name} from db\n" );
		//	$fanboxes = $f->getUserFanboxes(0,10);
		//	$wgMemc->set( $key, $fanboxes );
		//} else {
		//	wfDebug( "Got profile gifts for user {$user_name} from cache\n" );
		//	$fanboxes = $data;
		//}

		$fanboxes = $f->getUserFanboxes(0,10);

		$fanbox_count = $f->getFanBoxCountByUsername($user_name);
		$fanbox_link = Title::Maketitle(NS_SPECIAL, "ViewUserBoxes");
		$per_row = 1;

		if ($fanboxes) {

			$output .= "<div class=\"user-section-heading\">
				<div class=\"user-section-title\">
					".wfMsg("user-fanbox-title")."
				</div>
				<div class=\"user-section-actions\">
					<div class=\"action-right\">";
						if($fanbox_count>10)$output .= "<a href=\"".$fanbox_link->escapeFullURL('user='.$user_safe)."\" rel=\"nofollow\">".wfMsg("user-view-all")."</a>";
					$output .= "</div>
					<div class=\"action-left\">";
						if($fanbox_count>10) {
							$output .= "10 ".wfMsg("user-count-separator")." {$fanbox_count}";
						} else {
							$output .= "{$fanbox_count} ".wfMsg("user-count-separator")." {$fanbox_count}";
						}
					$output .= "</div>
					<div class=\"cleared\"></div>

				</div>
			</div>
			<div class=\"cleared\"></div>

			<div class=\"user-fanbox-container clearfix\" >";

				$x = 1;
				$tagParser = new Parser();
				foreach ($fanboxes as $fanbox) {

					$check_user_fanbox = $f->checkIfUserHasFanbox($fanbox["fantag_id"]);

					if( $fanbox["fantag_image_name"]){
						$fantag_image_width = 45;
						$fantag_image_height = 53;
						$fantag_image = Image::newFromName( $fanbox["fantag_image_name"] );
						$fantag_image_url = $fantag_image->createThumb($fantag_image_width, $fantag_image_height);
						$fantag_image_tag = '<img alt="" src="' . $fantag_image_url . '"/>';
					};

					if ($fanbox["fantag_left_text"] == ""){
						$fantag_leftside = $fantag_image_tag;

					}
					else {
						$fantag_leftside = $fanbox["fantag_left_text"];
						$fantag_leftside  = $tagParser->parse($fantag_leftside, $wgTitle, $wgOut->parserOptions(), false );
						$fantag_leftside  = $fantag_leftside->getText();
					}

					$leftfontsize = "9px";
					if ($fanbox["fantag_left_textsize"] == "mediumfont") {
						$leftfontsize= "11px";
					}

					if ($fanbox["fantag_left_textsize"] == "bigfont") {
						$leftfontsize= "15px";
					}

					$rightfontsize = "8px";
					if ($fanbox["fantag_right_textsize"] == "smallfont") {
						$rightfontsize= "10px";
					}

					if ($fanbox["fantag_right_textsize"] == "mediumfont") {
						$rightfontsize= "11px";
					}


					//get permalink
					$fantag_title =  Title::makeTitle( NS_FANTAG  , $fanbox["fantag_title"]  );
					$right_text = $fanbox["fantag_right_text"];
					$right_text  = $tagParser->parse($right_text, $wgTitle, $wgOut->parserOptions(), false );
					$right_text  = $right_text->getText();

					//output fanboxes

					$output .= "<div class=\"fanbox-item\">
						<div class=\"individual-fanbox\" id=\"individualFanbox".$fanbox["fantag_id"]."\">
							<div class=\"show-message-container-profile\" id=\"show-message-container".$fanbox["fantag_id"]."\">
								<a class=\"perma\" style=\"font-size:8px; color:".$fanbox["fantag_right_textcolor"]."\" href=\"".$fantag_title->escapeFullURL()."\" title=\"{$fanbox["fantag_title"]}\">perma</a>
								<table  class=\"fanBoxTableProfile\" onclick=\"javascript:openFanBoxPopup('fanboxPopUpBox{$fanbox["fantag_id"]}', 'individualFanbox{$fanbox["fantag_id"]}')\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >
									<tr>
										<td id=\"fanBoxLeftSideOutputProfile\" style=\"color:".$fanbox["fantag_left_textcolor"]."; font-size:$leftfontsize\" bgcolor=\"".$fanbox["fantag_left_bgcolor"]."\">".$fantag_leftside."</td>
										<td id=\"fanBoxRightSideOutputProfile\" style=\"color:".$fanbox["fantag_right_textcolor"]."; font-size:$rightfontsize\" bgcolor=\"".$fanbox["fantag_right_bgcolor"]."\">".$right_text."</td>
									</tr>
								</table>
							</div>
						</div>";

				 		if ($wgUser->isLoggedIn()) {

							if ($check_user_fanbox == 0) {

							$output .= "<div class=\"fanbox-pop-up-box-profile\" id=\"fanboxPopUpBox".$fanbox["fantag_id"]."\">
								<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" >
									<tr>
										<td style=\"font-size:10px\">". wfMsgForContent( 'fanbox_add_fanbox' ) ."</td>
									</tr>
									<tr>
										<td align=\"center\">
										<input type=\"button\" value=\"Add\" size=\"10\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$fanbox["fantag_id"]}', 'individualFanbox{$fanbox["fantag_id"]}'); showAddRemoveMessageUserPage(1, {$fanbox["fantag_id"]}, 'show-addremove-message-half')\" />
										<input type=\"button\" value=\"Cancel\" size=\"10\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$fanbox["fantag_id"]}', 'individualFanbox{$fanbox["fantag_id"]}')\" />
										</td>
									</tr>
								</table>
							</div>";

						} else {

							$output .= "<div class=\"fanbox-pop-up-box-profile\" id=\"fanboxPopUpBox".$fanbox["fantag_id"]."\">
								<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\">
									<tr>
										<td style=\"font-size:10px\">". wfMsgForContent( 'fanbox_remove_fanbox' ) ."</td>
									</tr>
									<tr>
										<td align=\"center\">
											<input type=\"button\" value=\"Remove\" size=\"10\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$fanbox["fantag_id"]}', 'individualFanbox{$fanbox["fantag_id"]}'); showAddRemoveMessageUserPage(2, {$fanbox["fantag_id"]}, 'show-addremove-message-half')\" />
											<input type=\"button\" value=\"Cancel\" size=\"10\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$fanbox["fantag_id"]}', 'individualFanbox{$fanbox["fantag_id"]}')\" />
										</td>
									</tr>
								</table>
							</div>";
						}
					}

					if ($wgUser->getID() == 0 ) {

						$login = Title::makeTitle(NS_SPECIAL,"UserLogin");

						$output .= "<div class=\"fanbox-pop-up-box-profile\" id=\"fanboxPopUpBox".$fanbox["fantag_id"]."\">
							<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\">
								<tr>
									<td style=\"font-size:10px\">". wfMsgForContent( 'fanbox_add_fanbox_login' ) ."<a href=\"{$login->getFullURL()}\">". wfMsgForContent( 'fanbox_login' ) ."</a></td>
								</tr>
								<tr>
									<td align=\"center\">
										<input type=\"button\" value=\"Cancel\" size=\"10\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$fanbox["fantag_id"]}', 'individualFanbox{$fanbox["fantag_id"]}')\" />
									</td>
								</tr>
							</table>
						</div>";
					}

				$output .= "</div>";

				$x++;


				}

			$output .= "</div>";
		}

		return $output;
	}



}


?>
