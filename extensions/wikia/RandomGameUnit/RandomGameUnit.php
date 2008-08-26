<?php

$wgRandomGameDisplay['random_poll'] = true;
$wgRandomGameDisplay['random_quiz'] = true;
$wgRandomGameDisplay['random_picturegame'] = true;
$wgRandomImageSize = 50;

$wgExtensionFunctions[] = "wfRandomCasualGame";
function wfRandomCasualGame() {
    global $wgParser, $wgOut, $wgRandomImageSize;
    $wgParser->setHook( "randomgameunit", "wfGetRandomGameUnit" );
}

function wfGetRandomGameUnit( $input = "", $argsv = array() ){
	global $wgRandomGameDisplay, $IP, $wgMessageCache, $wgMemc;
	
	
	//temp hack
	/*
	global $wgUploadPath;
	$wgUploadPathOld = $wgUploadPath;
	$wgUploadPath = "http://fp016.sjc.wikia-inc.com/images/";
	*/
	
	require_once ( "$IP/extensions/wikia/RandomGameUnit/RandomGameUnit.i18n.php" );
	foreach( efWikiaRandomGameUnit() as $lang => $messages ){
		$wgMessageCache->addMessages( $messages, $lang );
	}
	
	$random_games = array();
	$custom_fallback = "";
	
	if ($wgRandomGameDisplay['random_poll'] == true) {
		$random_games[] = "poll";
	}
	if ($wgRandomGameDisplay['random_quiz'] == true) {
		$random_games[] = "quiz";
	}
	if ($wgRandomGameDisplay['random_picturegame'] == true) {
		$random_games[] = "picgame";
	}
	
	if ( ! wfRunHooks( 'RandomGameUnit', array( &$random_games, &$custom_fallback ) ) ) {
		wfDebug( __METHOD__ . ": RandomGameUnit messed up the page!\n" );
	}
 
	if( count( $random_games ) == 0 ){
		return "";
	}
	
	$random_category = $random_games[ array_rand( $random_games, 1) ];
	$count = 10;
	switch($random_category){
		case "poll":
			$polls = Poll::getPollList( $count );
			if( $polls ){
				$random_poll = $polls[ array_rand( $polls ) ];
				return wfDisplayPoll( $random_poll );
			}
		break;
		case "quiz":
			$quiz = array();
			//try cache
			$key = wfMemcKey( 'quiz', 'order', 'q_id' , 'count', $count );
			//$wgMemc->delete( $key );
			$data = $wgMemc->get( $key );
			if( $data ){
				wfDebug( "Got quiz list ($count) ordered by {$order} from cache\n" );
				$quiz = $data;
			}else{
				wfDebug( "Got quiz list ($count) ordered by q_id from db\n" );
				$dbr =& wfGetDB( DB_SLAVE );
				$params['LIMIT'] = $count;
				$params['ORDER BY'] = "q_id desc";
				$res = $dbr->select( '`quizgame_questions`'
					, array('q_id', 'q_text', 'q_picture', 'UNIX_TIMESTAMP(q_date) as quiz_date'), 
					/*where*/ "" , __METHOD__, 
						$params
				);
				while( $row = $dbr->fetchObject($res) ) {
					$quiz[] = array (
						"id"=>$row->q_id,
						"text"=>$row->q_text,
						"image" => $row->q_picture,
						"timestamp"=>$row->quiz_date
					);				
				}
				$wgMemc->set( $key, $quiz, 60 * 10 );
			}
			$random_quiz = $quiz[ array_rand( $quiz ) ];
			if( $random_quiz ){
				return wfDisplayQuiz( $random_quiz );
			}
		break;
		case "picgame":
			//try cache
			$pics = array();
			$data = $wgMemc->get( $key );
			if( $data ){
				wfDebug( "Got picture game list ($count) ordered by id from cache\n" );
				$pics = $data;
			}else{
				wfDebug( "Got picture game list ($count) ordered by id from db\n" );	
				$dbr =& wfGetDB( DB_SLAVE );
				$params['LIMIT'] = $count;
				$params['ORDER BY'] = "id desc";
				$res = $dbr->select( '`picturegame_images`'
					, array('id', 'title', 'img1', 'img2', 'UNIX_TIMESTAMP(pg_date) as pic_game_date'), 
					/*where*/ "flag<>'FLAGGED'" , __METHOD__, 
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
				$wgMemc->set( $key, $pics, 60 * 10 );
			}
			$random_picgame = $pics[ array_rand( $pics ) ];
			if( $random_picgame ){
				return wfDisplayPictureGame( $random_picgame );
			}
		
		break;
		case "custom":
			if( $custom_fallback ){
				return call_user_func( $custom_fallback, $count );
			}
		break;
	}
	
	//tmp hack
	//$wgUploadPath = $wgUploadPathOld;
}

function wfDisplayPoll( $poll ){
	global $wgContLang, $wgRandomImageSize;
	
	$poll_link = Title::makeTitle(NS_POLL, $poll["title"]);
	$output .= "<div class=\"game-unit-container\">
			<h2>" . wfMsg("game_unit_poll_title") . "</h2>
			<div class=\"poll-unit-title\">{$poll_link->getText()}</div>";
			
	if( $poll["image"]){
		$poll_image_width = $wgRandomImageSize;
		$poll_image = Image::newFromName( $poll["image"] );
		$poll_image_url = $poll_image->createThumb( $poll_image_width );
		$poll_image_tag = "<img width=\"" . ($poll_image->getWidth() >= $poll_image_width ? $poll_image_width : $poll_image->getWidth()) . "\" alt=\"\" src=\"". $poll_image_url . "\"/>";
		$output .= "<div class=\"poll-unit-image\">{$poll_image_tag}</div>";
	}
	$output .= "<div class=\"poll-unit-choices\">";
		foreach($poll["choices"] as $choice){
			$output .= "<a href=\"".$poll_link->escapeFullURL()."\" rel=\"nofollow\">
				<input id=\"poll_choice\" type=\"radio\" value=\"10\" name=\"poll_choice\" onclick=\"location.href='".$poll_link->escapeFullURL()."'\" /> {$choice["choice"]}
			</a>";
	}
	$output .= "</div>
	</div>";
	return $output;
}

function wfDisplayQuiz( $quiz ){
	
	global $wgRandomImageSize;
	
	$quiz_title = Title::makeTitle( NS_SPECIAL, "QuizGameHome");
	$output = "";
	$output .= "<div class=\"game-unit-container\">
			<h2>" . wfMsg("game_unit_quiz_title") . "</h2>
			<div class=\"quiz-unit-title\"><a href=\"".$quiz_title->escapeFullURL("questionGameAction=renderPermalink&permalinkID={$quiz["id"]}")."\" rel=\"nofollow\">{$quiz["text"]}</a></div>";
		
			if( $quiz["image"] ){
				$quiz_image_width = $wgRandomImageSize;
				$quiz_image = Image::newFromName( $quiz["image"] );
				$quiz_image_url = $quiz_image->createThumb($quiz_image_width);
				$quiz_image_tag = "<a href=\"".$quiz_title->escapeFullURL("questionGameAction=renderPermalink&permalinkID={$quiz["id"]}")."\" rel=\"nofollow\"><img width=\"".($quiz_image->getWidth() >= $quiz_image_width ? $quiz_image_width : $quiz_image->getWidth())."\" alt=\"\" src=\"".$quiz_image_url."\"/></a>";
				
				$output .= "<div class=\"quiz-unit-image\">{$quiz_image_tag}</div>";
			}
			
	$output .= "</div>";		
	return $output;
}

function wfDisplayPictureGame( $picturegame ){
	
	global $wgRandomImageSize;
	
	if( !$picturegame["img1"]  || ! $picturegame["img2"] ) return "";
	
	$img_width = $wgRandomImageSize;
	$title_text = ($picturegame["title"] == substr($picturegame["title"], 0, 48) ) ? $picturegame["title"] : ( substr( $picturegame["title"] , 0, 48) . "..."); 
	
	$img_one = Image::newFromName( $picturegame["img1"] );
	$thumb_one_url = $img_one->createThumb( $img_width );
	$imgOne = "<img width=\"".($img_one->getWidth() >= $img_width ? $img_width : $img_one->getWidth())."\" alt=\"\" src=\"".$thumb_one_url."?".time()."\"/>";

	$img_two = Image::newFromName( $picturegame["img2"]  );
	$thumb_two_url = $img_two->createThumb( $img_width );
	$imgTwo = "<img width=\"".($img_two->getWidth() >= $img_width ? $img_width : $img_two->getWidth())."\" alt=\"\" src=\"".$thumb_two_url."?".time()."\"/>";

	$pic_game_link = Title::makeTitle(NS_SPECIAL, "PictureGameHome");

	$output = "<div class=\"game-unit-container\">
			<h2>" . wfMsg("game_unit_picturegame_title") . "</h2>
			<div class=\"pg-unit-title\">{$title_text}</div>
			<div class=\"pg-unit-pictures\">
				<div onmouseout=\"\$El(this).setStyle('background-color', '');\" onmouseover=\"\$El(this).setStyle('background-color', '#4B9AF6');\">
					<a href=\"".$pic_game_link->escapeFullURL('picGameAction=renderPermalink&id='.$picturegame["id"].'&voteID='.$picturegame["id"].'&voteImage=1&key='.$key)."\">{$imgOne}</a>
				</div>
				<div onmouseout=\"\$El(this).setStyle('background-color', '');\" onmouseover=\"\$El(this).setStyle('background-color', '#FF0000');\">
					<a href=\"".$pic_game_link->escapeFullURL('picGameAction=renderPermalink&id='.$picturegame["id"].'&voteID='.$picturegame["id"].'&voteImage=1&key='.$key)."\">{$imgTwo}</a>
				</div>
			</div>
			<div class=\"cleared\"></div>
		</div>";
		
	return $output;
}
	
?>
