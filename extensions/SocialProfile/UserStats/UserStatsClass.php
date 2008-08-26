<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

$wgUserStatsTrackWeekly = false;
$wgUserStatsTrackMonthly = false;

$wgUserStatsPointValues['edit'] = 50;
$wgUserStatsPointValues['vote'] = 0;
$wgUserStatsPointValues['comment'] = 0;
$wgUserStatsPointValues['comment_plus'] = 0;
$wgUserStatsPointValues['comment_ignored'] = 0;
$wgUserStatsPointValues['opinions_created'] = 0;
$wgUserStatsPointValues['opinions_pub'] = 0;
$wgUserStatsPointValues['referral_complete'] = 0;
$wgUserStatsPointValues['friend'] = 0;
$wgUserStatsPointValues['foe'] = 0;
$wgUserStatsPointValues['gift_rec'] = 0;
$wgUserStatsPointValues['gift_sent'] = 0;
$wgUserStatsPointValues['points_winner_weekly'] = 0;
$wgUserStatsPointValues['points_winner_monthly'] = 0;
$wgUserStatsPointValues['user_image'] = 1000;
$wgUserStatsPointValues['poll_vote'] = 0;
$wgUserStatsPointValues['quiz_points'] = 0;
$wgUserStatsPointValues['quiz_created'] = 0;
$wgNamespacesForEditPoints = array(0);

class UserStatsTrack {
	//for referencing purposes
	var $stats_fields = array(
		"edit" => "stats_edit_count",
		"vote" => "stats_vote_count",
		"comment" => "stats_comment_count",
		"comment_plus" => "stats_comment_score_positive_rec",
		"comment_neg" => "stats_comment_score_negative_rec",
		"comment_give_plus" => "stats_comment_score_positive_given",
		"comment_give_neg" => "stats_comment_score_negative_given",
		"comment_ignored" => "stats_comment_blocked",
		"opinions_created" => "stats_opinions_created",
		"opinions_pub" => "stats_opinions_published",
		"referral_complete" => "stats_referrals_completed",
		"friend" => "stats_friends_count",
		"foe" => "stats_foe_count",
		"gift_rec" => "stats_gifts_rec_count",
		"gift_sent" => "stats_gifts_sent_count",
		"challenges" => "stats_challenges_count",
		"challenges_won" => "stats_challenges_won",
		"challenges_rating_positive" => "stats_challenges_rating_positive",
		"challenges_rating_negative" => "stats_challenges_rating_negative",
		"points_winner_weekly" => "stats_weekly_winner_count",
		"points_winner_monthly" => "stats_monthly_winner_count",
		"total_points" => "stats_total_points",
		"user_image" => "stats_user_image_count",
		"user_board_count" => "user_board_count",
		"user_board_count_priv" => "user_board_count_priv",
		"user_board_sent" => "user_board_sent",
		"picturegame_created" => "stats_picturegame_created",
		"picturegame_vote" => "stats_picturegame_votes",
		"poll_vote" => "stats_poll_votes",
		"user_status_count" => "user_status_count",
		"quiz_correct" => "stats_quiz_questions_correct",
		"quiz_answered" => "stats_quiz_questions_answered",
		"quiz_created" => "stats_quiz_questions_created",
		"quiz_points" => "stats_quiz_points",
		"currency" => "stats_currency",
		"links_submitted" => "stats_links_submitted",
		"links_approved" => "stats_links_approved"
	);

	function UserStatsTrack( $user_id, $user_name = ""){
		global $wgUserStatsPointValues;

		$this->user_id = $user_id;
		if(!$user_name){
			$user = User::newFromId($this->user_id);
			$user->loadFromDatabase();
			$user_name = $user->getName();
		}

		$this->user_name = $user_name;
		$this->point_values = $wgUserStatsPointValues;
		$this->initStatsTrack();
	}

	function initStatsTrack(){
		global $wgDBprefix;
		$dbr = wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow( 'user_stats', array( 'stats_user_id' ), array('stats_user_id' => $this->user_id ), __METHOD__ );

		if ( $s === false ) {
			$this->addStatRecord();
		}
	}

	function addStatRecord(){
		global $wgDBprefix;
		$dbr = wfGetDB( DB_MASTER );
		$fname = $wgDBprefix.'user_stats::addToDatabase';
		$dbr->insert( 'user_stats',

		array(
			'stats_year_id' => 0,
			'stats_user_id' => $this->user_id,
			'stats_user_name' => $this->user_name,
			'stats_total_points' => 1000
			), $fname
		);

	}

	function clearCache(){
		global $wgMemc;

		//clear stats cache for current user
		$key = wfMemcKey( 'user', 'stats', $this->user_id );
		$wgMemc->delete( $key );
	}

	function incStatField( $field, $val = 1 ){
		global $wgUser, $IP, $wgDBprefix, $wgMemc, $wgSitename, $wgSystemGifts, $wgUserStatsTrackWeekly, $wgUserStatsTrackMonthly, $wgUserStatsPointValues;
		if( !$wgUser->isBot() && !$wgUser->isAnon() && $this->stats_fields[$field]) {
			$dbw = wfGetDB( DB_MASTER );
			$dbw->update( 'user_stats',
				array( $this->stats_fields[$field]."=".$this->stats_fields[$field]."+{$val}" ),
				array( 'stats_user_id' => $this->user_id  ),
				__METHOD__ );
			$this->updateTotalPoints();

			$this->clearCache();

			//update weekly/monthly points
			if($this->point_values[$field]){
				if($wgUserStatsTrackWeekly)$this->updateWeeklyPoints($this->point_values[$field]);
				if($wgUserStatsTrackMonthly)$this->updateMonthlyPoints($this->point_values[$field]);
			}

			if($wgSystemGifts){
				$s = $dbw->selectRow( 'user_stats', array($this->stats_fields[$field]), array( 'stats_user_id' => $this->user_id ), __METHOD__ );
				$stat_field = $this->stats_fields[$field];
				$field_count = $s->$stat_field;

				$key = wfMemcKey( 'system_gift', 'id', $field."-".$field_count );
				$data = $wgMemc->get( $key );

				if($data){
					wfDebug( "Got system gift id from cache\n" );
					$system_gift_id = $data;
				} else {
					$g = new SystemGifts();
					$system_gift_id = $g->doesGiftExistForThreshold($field, $field_count);
					if($system_gift_id){
						$wgMemc->set( $key, $system_gift_id, 60 * 30 );
					}
				}

				if( $system_gift_id ){
					$sg = new UserSystemGifts($this->user_name);
					$sg->sendSystemGift($system_gift_id);
				}
			}
		}
	}

	function decStatField($field, $val = 1){
		global $wgUser, $wgUserStatsTrackWeekly, $wgUserStatsTrackMonthly, $wgDBprefix;
		if(  !$wgUser->isBot() && !$wgUser->isAnon() && $this->stats_fields[$field]) {
			$dbw = wfGetDB( DB_MASTER );
			$dbw->update( 'user_stats',
				array( $this->stats_fields[$field]."=".$this->stats_fields[$field]."-{$val}" ),
				array( 'stats_user_id' => $this->user_id ),
				__METHOD__ );

			if($this->point_values[$field]){
				$this->updateTotalPoints();
				if($wgUserStatsTrackWeekly)$this->updateWeeklyPoints(0-($this->point_values[$field]));
				if($wgUserStatsTrackMonthly)$this->updateMonthlyPoints(0-($this->point_values[$field]));
			}

			$this->clearCache();
		}
	}

	function updateCommentCount(){
		global $wgUser, $wgDBprefix;
		if( !$wgUser->isAnon() ) {
			$dbr = wfGetDB( DB_MASTER );
			$sql = "update ".$wgDBprefix."user_stats set ";
			$sql .= 'stats_comment_count=';
			$sql .= "(SELECT COUNT(*) as CommentCount FROM Comments WHERE  Comment_user_id = " . $this->user_id;
			$sql .= ")";
			$sql .= " WHERE stats_user_id = " . $this->user_id;
			$res = $dbr->query($sql);

			$this->clearCache();
		}
	}

	function updateCommentIgnored(){
		global $wgUser, $wgDBprefix;
		if( !$wgUser->isAnon() ) {
			$dbr = wfGetDB( DB_MASTER );
			$sql = "update ".$wgDBprefix."user_stats set ";
			$sql .= 'stats_comment_blocked=';
			$sql .= "(SELECT COUNT(*) as CommentCount FROM Comments_block WHERE  cb_user_id_blocked = " . $this->user_id;
			$sql .= ")";
			$sql .= " WHERE stats_user_id = " . $this->user_id;
			$res = $dbr->query($sql);

			$this->clearCache();
		}
	}

	function updateEditCount(){
		global $wgUser, $wgDBprefix;
		if( !$wgUser->isAnon() ) {
			$dbr = wfGetDB( DB_MASTER );
			$sql = "update ".$wgDBprefix."user_stats set ";
			$sql  .= 'stats_edit_count=';
			$sql .= "(SELECT count(*) as EditsCount FROM {$dbr->tableName( 'revision' )} WHERE rev_user = {$this->user_id} ";
			$sql .=	 ")";
			$sql .= " WHERE stats_user_id = " . $this->user_id;
			$res = $dbr->query($sql);

			$this->clearCache();
		}
	}

	function updateVoteCount(){
		global $wgUser, $wgDBprefix;
		if( !$wgUser->isAnon() ) {
			$dbr = wfGetDB( DB_MASTER );
			$sql = "update ".$wgDBprefix."user_stats set ";
			$sql  .= 'stats_vote_count=';
			$sql .= "(SELECT count(*) as VoteCount FROM Vote WHERE vote_user_id = {$this->user_id} ";
			$sql .= ")";
			$sql .= " WHERE stats_user_id = " . $this->user_id;
			$res = $dbr->query($sql);

			$this->clearCache();
		}
	}

	function updateCommentScoreRec($vote_type){
		global $wgUser, $wgDBprefix;
		if( $this->user_id != 0 ) {
			$dbr = wfGetDB( DB_MASTER );
			$sql = "update ".$wgDBprefix."user_stats set ";
			if($vote_type==1){
				$sql  .= 'stats_comment_score_positive_rec=';
			} else {
				$sql  .= 'stats_comment_score_negative_rec=';
			}
			$sql .= "(SELECT COUNT(*) as CommentVoteCount FROM Comments_Vote WHERE Comment_Vote_ID IN (select CommentID FROM Comments WHERE Comment_user_id = " . $this->user_id . ") AND Comment_Vote_Score=" . $vote_type;
			$sql .= ")";
			$sql .= " WHERE stats_user_id = " . $this->user_id;
			$res = $dbr->query($sql);

			$this->clearCache();
		}
	}

	function updateCreatedOpinionsCount(){
		global $wgUser, $wgOut, $wgDBprefix;
		if( !$wgUser->isAnon() && $this->user_id) {
			$ctg = "Opinions by User " .  ($this->user_name);
			$parser = new Parser();
			$CtgTitle = Title::newFromText( $parser->transformMsg(trim($ctg), $wgOut->parserOptions() ) );
			$CtgTitle = $CtgTitle->getDbKey();
			$dbr = wfGetDB( DB_MASTER );
			$sql = "update ".$wgDBprefix."user_stats set stats_opinions_created=";
			$sql .= "(SELECT count(*) as CreatedOpinions FROM {$dbr->tableName( 'page' )} INNER JOIN {$dbr->tableName( 'categorylinks' )} ON page_id = cl_from WHERE  (cl_to) = " . $dbr->addQuotes($CtgTitle) . " ";
			$sql .= ")";
			$sql .= " WHERE stats_user_id = " . $this->user_id;

			$res = $dbr->query($sql);

			$this->clearCache();
		}
	}

	function updatePublishedOpinionsCount(){
		global $wgUser, $wgOut, $wgDBprefix;
		$parser = new Parser();
		$dbr = wfGetDB( DB_MASTER );
		$ctg = "Opinions by User " . ($this->user_name);
		$CtgTitle = Title::newFromText( $parser->transformMsg(trim($ctg), $wgOut->parserOptions()) );
		$CtgTitle = $CtgTitle->getDbKey();
		$sql = "UPDATE ".$wgDBprefix."user_stats SET stats_opinions_published = ";
		$sql .= "(SELECT count(*) as PromotedOpinions FROM {$dbr->tableName( 'page' )} INNER JOIN {$dbr->tableName( 'categorylinks' )} ON page_id = cl_from INNER JOIN published_page ON page_id=published_page_id WHERE  (cl_to) = " . $dbr->addQuotes($CtgTitle) . " AND published_type=1 " . " " . $timeSQL;
		$sql .= ")";
		$sql .= " WHERE stats_user_id = " . $this->user_id;
		$res = $dbr->query($sql);

		$this->clearCache();
	}

	function updateRelationshipCount($rel_type){
		global $wgUser, $wgDBprefix;
		if( !$wgUser->isAnon() ) {
			$dbr = wfGetDB( DB_MASTER );
			if($rel_type == 1){
				$col = "stats_friends_count";
			} else {
				$col = "stats_foe_count";
			} //Where is low_priority? where was this table created?
			$sql = "UPDATE low_priority ".$wgDBprefix."user_stats SET {$col}=
					(SELECT COUNT(*) as rel_count FROM user_relationship WHERE
						r_user_id = {$this->user_id} AND r_type={$rel_type}
						)
				WHERE stats_user_id = {$this->user_id}";
			$res = $dbr->query($sql);
		}
	}

	function updateGiftCountRec(){
		global $wgUser, $wgStatsStartTimestamp, $wgDBprefix;
		if( !$wgUser->isAnon() ) {
			$dbr = wfGetDB( DB_MASTER );
			$sql = "UPDATE low_priority ".$wgDBprefix."user_stats SET stats_gifts_rec_count=
					(SELECT COUNT(*) as gift_count FROM user_gift WHERE
						ug_user_id_to = {$this->user_id}
						)
				WHERE stats_user_id = {$this->user_id}";

			$res = $dbr->query($sql);
		}
	}

	function updateGiftCountSent(){
		global $wgUser, $wgDBprefix;
		if( !$wgUser->isAnon() ) {
			$dbr = wfGetDB( DB_MASTER );
			$sql = "UPDATE low_priority ".$wgDBprefix."user_stats SET stats_gifts_sent_count=
					(SELECT COUNT(*) as gift_count FROM user_gift WHERE
						ug_user_id_from = {$this->user_id}
						)
				WHERE stats_user_id = {$this->user_id} ";

			$res = $dbr->query($sql);
		}
	}

	public function updateReferralComplete(){
		global $wgUser, $wgStatsStartTimestamp, $wgDBprefix;
		if( !$wgUser->isAnon() ) {
			$dbr = wfGetDB( DB_MASTER );
			$sql = "UPDATE low_priority ".$wgDBprefix."user_stats SET stats_referrals_completed=
					(SELECT COUNT(*) as thecount FROM user_register_track WHERE
						ur_user_id_referral = {$this->user_id} and ur_user_name_referral<>'DNL'
						)
				WHERE stats_user_id = {$this->user_id} ";

			$res = $dbr->query($sql);
		}
	}

	public function updateWeeklyPoints($points){
		$dbr = wfGetDB( DB_MASTER );
		$sql = "SELECT up_user_id FROM user_points_weekly WHERE up_user_id = {$this->user_id}"; //where is the table set for this one?
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );

		if(!$row){
			$this->addWeekly();
		}
		$dbr->update( 'user_points_weekly',
		array( 'up_points=up_points+'.$points),
		array( 'up_user_id' => $this->user_id ),
		__METHOD__ );
	}

	public function addWeekly(){
		$dbr = wfGetDB( DB_MASTER );
		$fname = 'user_points_weekly::addToDatabase';
		$dbr->insert( '`user_points_weekly`',
		array(
			'up_user_id' => $this->user_id,
			'up_user_name' => $this->user_name
			), $fname
		);
	}

	public function updateMonthlyPoints($points){
		$dbr = wfGetDB( DB_MASTER );
		$sql = "SELECT up_user_id from user_points_monthly where up_user_id = {$this->user_id}";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if(!$row){
			$this->addMonthly();
		}

		$dbr->update( 'user_points_monthly',
		array( 'up_points=up_points+'.$points),
		array( 'up_user_id' => $this->user_id ),
		__METHOD__ );
	}

	public function addMonthly(){
		$dbr = wfGetDB( DB_MASTER );
		$fname = 'user_points_monthly::addToDatabase';
		$dbr->insert( '`user_points_monthly`',
		array(
			'up_user_id' => $this->user_id,
			'up_user_name' => $this->user_name
			), $fname
		);
	}

	public function updateTotalPoints(){
		global $wgEnableFacebook, $wgUserLevels, $wgDBprefix;

		if( $this->user_id == 0 )return "";

		if( is_array( $wgUserLevels ) ){
			//Load points before update
			$stats = new UserStats($this->user_id, $this->user_name);
			$stats_data = $stats->getUserStats();
			$points_before = $stats_data["points"];

			//Load Honorific Level before update
			$user_level = new UserLevel($points_before);
			$level_number_before = $user_level->getLevelNumber();
		}

		$dbr = wfGetDB( DB_MASTER );
		$sql = "SELECT *
			FROM ".$wgDBprefix."user_stats WHERE stats_user_id =  " . $this->user_id;
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			//recaculate point total
			$new_total_points = 1000;
			foreach($this->point_values as $point_field => $point_value){
				if($this->stats_fields[$point_field]){
					$field = $this->stats_fields[$point_field];
					$new_total_points += $point_value * $row->$field;
				}
			}
			if($wgEnableFacebook){
				$s = $dbr->selectRow( '`fb_link_view_opinions`', array( 'fb_user_id','fb_user_session_key' ), array( 'fb_user_id_wikia' => $this->user_id ), $fname );
				if ( $s !== false ) {
					$new_total_points += $this->point_values["facebook"];
				}
			}

			$dbr->update( 'user_stats',
			array( 'stats_total_points' => $new_total_points),
			array( 'stats_user_id' => $this->user_id ),
			__METHOD__ );

			//If user levels is in settings, check to see if user advanced with update
			if( is_array( $wgUserLevels ) ){
				//Get New Honorific Level
				$user_level = new UserLevel($new_total_points);
				$level_number_after = $user_level->getLevelNumber();

				//Check if user advanced on this update
				/*if($level_number_after > $level_number_before){
					$m = new UserSystemMessage();
					$m->addMessage($this->user_name, 2, "advanced to level <span style=\"font-weight:800;\">{$user_level->getLevelName()}</span>");
					$m->sendAdvancementNotificationEmail($this->user_id, $user_level->getLevelName());
				}*/
			}
			$this->clearCache();
		}
		return $stats_data;
	}
}

class UserStats {
	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct($user_id, $user_name) {
		$this->user_id = $user_id;
		if(!$user_name){
			$user = User::newFromId($this->user_id);
			$user->loadFromDatabase();
			$user_name = $user->getName();
		}
		$this->user_name = $user_name;
	}

	static $stats_name = array(
		"monthly_winner_count" => "Monthly Wins",
		"weekly_winner_count" => "Weekly Wins",
		"vote_count" => "Votes",
		"edit_count" => "Edits",
		"comment_count" => "Comments",
		"referrals_completed" => "Referrals",
		"friends_count" => "Friends",
		"foe_count" => "Foes",
		"opinions_published" => "Published Opinions",
		"opinions_created" => "Opinions",
		"comment_score_positive_rec" => "Thumbs Up",
		"comment_score_negative_rec" => "Thumbs Down",
		"comment_score_positive_given" => "Thumbs Up Given",
		"comment_score_negative_given" => "Thumbs Down Given",
		"gifts_rec_count" => "Gifts Received",
		"gifts_sent_count" => "Gifts Sent"
	);

	public function getUserStats(){
		$stats = $this->getUserStatsCache();
		if( !$stats ){
			$stats = $this->getUserStatsDB();
		}
		return $stats;
	}

	public function getUserStatsCache(){
		global $wgMemc;
		$key = wfMemcKey( 'user', 'stats', $this->user_id );
		$data = $wgMemc->get( $key );
		if ( $data ) {
			wfDebug( "Got user stats  for {$this->user_name} from cache\n" );
			return $data;
		}
	}

	public function getUserStatsDB(){
		global $wgMemc, $wgDBprefix;

		wfDebug( "Got user stats  for {$this->user_name} from DB\n" );
		$dbr = wfGetDB( DB_MASTER );
		$sql = "SELECT *
			FROM ".$wgDBprefix."user_stats
			WHERE stats_user_id = {$this->user_id} LIMIT 0,1";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		$stats["edits"] = number_format( isset( $row->stats_edit_count ) ? $row->stats_edit_count : 0 );
		$stats["votes"] = number_format( isset( $row->stats_vote_count ) ? $row->stats_vote_count : 0 );
		$stats["comments"] = number_format( isset( $row->stats_comment_count ) ? $row->stats_comment_count : 0 );
		$stats["comment_score_plus"] = number_format( isset( $row->stats_comment_score_positive_rec ) ? $row->stats_comment_score_positive_rec : 0 );
		$stats["comment_score_minus"] = number_format( isset( $row->stats_comment_score_negative_rec ) ? $row->stats_comment_score_negative_rec : 0 );
		$stats["comment_score"] = number_format( $stats["comment_score_plus"] - $stats["comment_score_minus"] );
		$stats["opinions_created"] = isset( $row->stats_opinions_created ) ? $row->stats_opinions_created : 0;
		$stats["opinions_published"] = isset( $row->stats_opinions_published ) ? $row->stats_opinions_published : 0;
		$stats["points"] = number_format( isset( $row->stats_total_points ) ? $row->stats_total_points : 0 );
		$stats["recruits"] = number_format( isset( $row->stats_referrals_completed ) ? $row->stats_referrals_completed : 0 );
		$stats["challenges_won"] = number_format( isset( $row->stats_challenges_won ) ? $row->stats_challenges_won : 0 );
		$stats["friend_count"] = number_format( isset( $row->stats_friends_count ) ? $row->stats_friends_count : 0 );
		$stats["foe_count"] = number_format( isset( $row->stats_foe_count ) ? $row->stats_foe_count : 0 );
		$stats["user_board"] = number_format( isset( $row->user_board_count ) ? $row->user_board_count : 0 );
		$stats["user_board_priv"] = number_format( isset( $row->user_board_count_priv ) ? $row->user_board_count_priv : 0 );
		$stats["user_board_sent"] = number_format( isset( $row->user_board_sent ) ? $row->user_board_sent : 0);
		$stats["weekly_wins"] = number_format( isset( $row->stats_weekly_winner_count ) ? $row->stats_weekly_winner_count : 0);
		$stats["monthly_wins"] = number_format( isset( $row->stats_monthly_winner_count ) ? $row->stats_monthly_winner_count : 0);
		$stats["poll_votes"] = number_format( isset( $row->stats_poll_votes ) ? $row->stats_poll_votes : 0 );
		$stats["currency"] = number_format( isset( $row->stats_currency ) ? $row->stats_currency : 0 );
		$stats["picture_game_votes"] = number_format( isset( $row->stats_picturegame_votes ) ? $row->stats_picturegame_votes : 0 );
		$stats["quiz_created"] = number_format( isset( $row->stats_quiz_questions_created ) ? $row->stats_quiz_questions_created : 0 );
		$stats["quiz_answered"] = number_format( isset( $row->stats_quiz_questions_answered ) ? $row->stats_quiz_questions_answered : 0 );
		$stats["quiz_correct"] = number_format( isset( $row->stats_quiz_questions_correct ) ? $row->stats_quiz_questions_correct : 0);
		$stats["quiz_points"] = number_format( isset( $row->stats_quiz_points ) ? $row->stats_quiz_points : 0 );
		$stats["quiz_correct_percent"] = number_format( ( isset( $row->stats_quiz_questions_correct_percent ) ? $row->stats_quiz_questions_correct_percent : 0 ) *100,2);
		$stats["user_status_count"] = number_format( isset( $row->user_status_count ) ? $row->user_status_count : 0 );
		if( !$row ){
			$stats["points"] = "1,000";
		}

		$key = wfMemcKey( 'user', 'stats', $this->user_id );
		$wgMemc->set( $key, $stats );
		return $stats;
	}

	static function getTopFansList( $limit = 10 ){
		$dbr = wfGetDB( DB_MASTER );

		if($limit>0){
			$limitvalue = 0;
			if($page)$limitvalue = $page * $limit - ($limit);
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}

		$sql = "SELECT stats_user_id, stats_user_name, stats_total_points
			FROM user_stats
			WHERE stats_user_id <> 0
			ORDER BY stats_total_points DESC
			{$limit_sql}";

		$list = array();
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$list[] = array(
				"user_id" => $row->stats_user_id, "user_name" => $row->stats_user_name,
				"points" => $row->stats_total_points );
		}
		return $list;
	}

	static function getTopFansListPeriod( $limit = 10, $period = "weekly"){
		$dbr = wfGetDB( DB_SLAVE );

		if($limit>0){
			$limitvalue = 0;
			if($page)$limitvalue = $page * $limit - ($limit);
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}
		if($period=="monthly"){
			$points_table = "user_points_monthly";
		} else {
			$points_table = "user_points_weekly";
		}
		$sql = "SELECT up_user_id, up_user_name, up_points
			FROM {$points_table}
			WHERE up_user_id <> 0
			ORDER BY up_points DESC
			{$limit_sql}";

		$list = array();
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$list[] = array(
				"user_id"=>$row->up_user_id,"user_name"=>$row->up_user_name,
				"points"=>$row->up_points );
		}
		return $list;
	}

	static function getFriendsRelativeToPoints( $user_id, $points, $limit=3, $condition=1 ){
		$dbr = wfGetDB( DB_SLAVE );

		if($limit>0){
			$limitvalue = 0;
			if($page)$limitvalue = $page * $limit - ($limit);
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}

		if($condition == 1){
			$op = ">";
			$sort = "ASC";
		} else {
			$op = "<";
			$sort = "DESC";
		}
		$sql = "SELECT stats_user_id, stats_user_name, stats_total_points
			FROM user_stats
			INNER JOIN user_relationship on stats_user_id = r_user_id_relation
			WHERE r_user_id = {$user_id} and stats_total_points {$op} {$points}
			ORDER BY stats_total_points {$sort}
			{$limit_sql}";

		$list = array();
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$list[] = array(
				"user_id"=>$row->stats_user_id,"user_name"=>$row->stats_user_name,
				"points"=>$row->stats_total_points );
		}
		if($condition==1){
			$list = array_reverse($list);
		}
		return $list;
	}
}

class UserLevel {
	var $level_number = 0;

	/* private */ function __construct($points) {
		global $wgUserLevels;
		$this->levels = $wgUserLevels;
		$this->points = (int)str_replace(",", "", $points);
		if($this->levels)$this->setLevel();
	}

	private function setLevel(){
		$this->level_number = 1;
		foreach($this->levels as $level_name => $level_points_needed){
			if($this->points >= $level_points_needed){
				$this->level_name = $level_name;
				$this->level_number++;
			} else {
				//set next level and what they need to reach
				//check if not already at highest level
				if( ($this->level_number)!=count($this->levels)){
						$this->next_level_name = $level_name;
						$this->next_level_points_needed = ($level_points_needed - $this->points);
						return "";
				}
			}
		}
	}

	public function getLevelName(){ return $this->level_name; }
	public function getLevelNumber(){ return $this->level_number; }
	public function getNextLevelName(){ return $this->next_level_name; }
	public function getPointsNeededToAdvance(){ return number_format($this->next_level_points_needed); }
	public function getLevelMinimum(){ return $this->levels[$this->level_name]; }
}

class UserEmailTrack {

	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct($user_id, $user_name) {
		$this->user_id = $user_id;
		if(!$user_name){
			$user = User::newFromId($this->user_id);
			$user->loadFromDatabase();
			$user_name = $user->getName();
		}
		$this->user_name = $user_name;
	}
	//type
	/*
		1 = Invite - Email Contacts sucker
		2 = Invite -CVS Contacts importer
		3 = Invite -Manually Address enter
		4 = Invite to Read - Manually Address enter
		5 = Invite to Edit - Manually Address enter
		6 = Invite to Rate - Manually Address enter
	*/
	public function track_email($type, $count, $page_title = ""){
		if($this->user_id>0){
			$dbr = wfGetDB( DB_MASTER );
			$fname = 'user_email_track::addToDatabase';
			$dbr->insert( '`user_email_track`',
			array(
				'ue_user_id' => $this->user_id,
				'ue_user_name' => $this->user_name,
				'ue_type' => $type,
				'ue_count' => $count,
				'ue_page_title' => $page_title,
				'ue_date' => date("Y-m-d H:i:s"),
				), $fname
			);
		}
	}
}
