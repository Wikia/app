<?php
/**#@+
 * User profile Wiki Page
 *
 * @package MediaWiki
 * @subpackage Article
 *
 * @author David Pean <david.pean@gmail.com>
 * @copyright Copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class UserProfilePage extends Article {

	var $title = null;

	function __construct (&$title){
		global $wgUser;
		parent::__construct($title);
		$this->user_name = $title->getText();
		$this->user_id = User::idFromName($this->user_name);
		$this->user = User::newFromId($this->user_id);
		$this->user->loadFromDatabase();

		$this->is_owner = ( $this->user_name == $wgUser->getName() );

		$profile = new UserProfile( $this->user_name );
		$this->profile_data = $profile->getProfile();
	}

	function isOwner(){
		return $this->is_owner;
	}

	function view(){
		global $wgOut, $wgUser, $wgRequest, $wgTitle, $wgContLang, $wgSitename;

		$sk = $wgUser->getSkin();

		$wgOut->setPageTitle( $this->mTitle->getPrefixedText() );

		# No need to display noarticletext, we use our own message
		if ( !$this->user_id ) {
			parent::view();
			return "";
		}

		$wgOut->addHTML("<div id=\"profile-top\">");
		$wgOut->addHTML($this->getProfileTop($this->user_id, $this->user_name));
		$wgOut->addHTML("<div class=\"cleared\"></div></div>");

		//User does not want social profile for User:user_name, so we just show header + page content
		if( $wgTitle->getNamespace() == NS_USER && $this->profile_data["user_id"] && $this->profile_data["user_page_type"] == 0 ){
			parent::view();
			return "";
		}

		//left side
		$wgOut->addHTML("<div id=\"user-page-left\" class=\"clearfix\">");

		if ( ! wfRunHooks( 'UserProfileBeginLeft', array( &$this  ) ) ) {
			wfDebug( __METHOD__ . ": UserProfileBeginLeft messed up profile!\n" );
		}

		$wgOut->addHTML( $this->getRelationships($this->user_name, 1) );
		$wgOut->addHTML( $this->getRelationships($this->user_name, 2) );
		$wgOut->addHTML( $this->getCustomInfo($this->user_name) );
		$wgOut->addHTML( $this->getInterests($this->user_name) );
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

		$wgOut->addHTML( $this->getPersonalInfo($this->user_id, $this->user_name) );
		$wgOut->addHTML( $this->getUserBoard($this->user_id, $this->user_name) );

		if ( ! wfRunHooks( 'UserProfileEndRight', array( &$this  ) ) ) {
			wfDebug( __METHOD__ . ": UserProfileEndRight messed up profile!\n" );
		}

		$wgOut->addHTML("</div><div class=\"cleared\"></div>");
	}

	function getUserStatsRow($label, $value) {
		global $wgUser, $wgTitle, $wgOut;

		if ($value != 0) {
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

		if ($total_value!=0) {
			$output .= "<div class=\"user-section-heading\">
				<div class=\"user-section-title\">
					".wfMsg('user-stats-title')."
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
				$this->getUserStatsRow(wfMsg('user-stats-edits'), $stats_data["edits"]).
				$this->getUserStatsRow(wfMsg('user-stats-votes'), $stats_data["votes"]).
				$this->getUserStatsRow(wfMsg('user-stats-comments'), $stats_data["comments"]).
				$this->getUserStatsRow(wfMsg('user-stats-recruits'), $stats_data["recruits"]).
				$this->getUserStatsRow(wfMsg('user-stats-poll-votes'), $stats_data["poll_votes"]).
				$this->getUserStatsRow(wfMsg('user-stats-picture-game-votes'), $stats_data["picture_game_votes"]).
				$this->getUserStatsRow(wfMsg('user-stats-quiz-points'), $stats_data["quiz_points"]);
				if($stats_data["currency"]!="10,000")$output .= $this->getUserStatsRow(wfMsg('user-stats-pick-points'), $stats_data["currency"]);
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

	function getProfileSection($label, $value, $required = true){
		global $wgUser, $wgTitle, $wgOut;

		$output = '';
		if($value || $required) {
			if(!$value) {
				if ( $wgUser->getName() == $wgTitle->getText()  ) {
					$value = wfMsg( 'profile-updated-personal' );
				} else {
					$value = wfMsg( 'profile-not-provided' );
				}
			}

			$value = $wgOut->parse( trim($value), false );

			$output = "<div><b>{$label}</b>{$value}</div>";
		}
		return $output;
	}

	function getPersonalInfo($user_id, $user_name) {
		global $IP, $wgTitle, $wgUser, $wgMemc, $wgUserProfileDisplay;

		if ($wgUserProfileDisplay['personal'] == false) {
			return "";
		}

		$stats = new UserStats($user_id, $user_name);
		$stats_data = $stats->getUserStats();
		$user_level = new UserLevel($stats_data["points"]);
		$level_link = Title::makeTitle(NS_HELP, wfMsgHtml('user-profile-userlevels-link') );

		if( !$this->profile_data ){
			$profile = new UserProfile($user_name);
			$this->profile_data = $profile->getProfile();
		}
		$profile_data = $this->profile_data;

		$location = $profile_data["location_city"] . ", " . $profile_data["location_state"];
		if($profile_data["location_country"]!="United States"){
			$location = "";
			$location .= $profile_data["location_country"];
		}

		if($location==", ")$location = "";

		$hometown = $profile_data["hometown_city"] . ", " . $profile_data["hometown_state"];
		if($profile_data["hometown_country"]!="United States"){
			$hometown = "";
			$hometown .= $profile_data["hometown_country"];
		}
		if($hometown==", ") $hometown = "";

		$joined_data = $profile_data["real_name"] . $location.$hometown . $profile_data["birthday"] . $profile_data["occupation"] . $profile_data["websites"] . $profile_data["places_lived"] . $profile_data["schools"] . $profile_data["about"];
		$edit_info_link = Title::MakeTitle(NS_SPECIAL, "UpdateProfile");

		$output = '';
		if ($joined_data) {
			$output .= "<div class=\"user-section-heading\">
				<div class=\"user-section-title\">
					".wfMsg("user-personal-info-title")."
				</div>
				<div class=\"user-section-actions\">
					<div class=\"action-right\">";
					if ($wgUser->getName()==$user_name) $output .= "<a href=\"".$edit_info_link->escapeFullURL()."\">".wfMsg("user-edit-this")."</a>";
					$output .= "</div>
					<div class=\"cleared\"></div>
				</div>
			</div>
			<div class=\"cleared\"></div>
			<div class=\"profile-info-container\">".
				$this->getProfileSection(wfMsg("user-personal-info-real-name"),$profile_data["real_name"], false).
				$this->getProfileSection(wfMsg("user-personal-info-location"),$location, false).
				$this->getProfileSection(wfMsg("user-personal-info-hometown"),$hometown, false).
				$this->getProfileSection(wfMsg("user-personal-info-birthday"),$profile_data["birthday"], false).
				$this->getProfileSection(wfMsg("user-personal-info-occupation"),$profile_data["occupation"], false).
				$this->getProfileSection(wfMsg("user-personal-info-websites"),$profile_data["websites"], false).
				$this->getProfileSection(wfMsg("user-personal-info-places-lived"),$profile_data["places_lived"],false).
				$this->getProfileSection(wfMsg("user-personal-info-schools"),$profile_data["schools"],false).
				$this->getProfileSection(wfMsg("user-personal-info-about-me"),$profile_data["about"],false).
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

		if( !$this->profile_data ){
			$profile = new UserProfile($user_name);
			$this->profile_data = $profile->getProfile();
		}
		$profile_data = $this->profile_data;

		$joined_data = $profile_data["custom_1"] . $profile_data["custom_2"] . $profile_data["custom_3"] . $profile_data["custom_4"];
		$edit_info_link = Title::MakeTitle(NS_SPECIAL, "UpdateProfile");

		$output = '';
		if ($joined_data) {
			$output .= "<div class=\"user-section-heading\">
				<div class=\"user-section-title\">
					".wfMsg('custom-info-title')."
				</div>
				<div class=\"user-section-actions\">
					<div class=\"action-right\">";
						if ($wgUser->getName()==$user_name)$output .= "<a href=\"".$edit_info_link->escapeFullURL()."/custom\">".wfMsg('user-edit-this')."</a>";
					$output .= "</div>
					<div class=\"cleared\"></div>
				</div>
			</div>
			<div class=\"cleared\"></div>
			<div class=\"profile-info-container\">".
				$this->getProfileSection(wfMsg("custom-info-field1"), $profile_data["custom_1"], false).
				$this->getProfileSection(wfMsg("custom-info-field2"), $profile_data["custom_2"], false).
				$this->getProfileSection(wfMsg("custom-info-field3"), $profile_data["custom_3"], false).
				$this->getProfileSection(wfMsg("custom-info-field4"), $profile_data["custom_4"], false).
			"</div>";
		} else if ($wgUser->getName()==$user_name) {
			$output .= "<div class=\"user-section-heading\">
				<div class=\"user-section-title\">
					".wfMsg('custom-info-title')."
				</div>
				<div class=\"user-section-actions\">
					<div class=\"action-right\">
						<a href=\"".$edit_info_link->escapeFullURL()."/custom\">
							".wfMsg('user-edit-this')."
						</a>
					</div>
					<div class=\"cleared\"></div>
				</div>
			</div>
			<div class=\"cleared\"></div>
			<div class=\"no-info-container\">
				".wfMsg("custom-no-info")."
			</div>";
		}

		return $output;
	}

	function getInterests($user_name) {
		global $IP, $wgTitle, $wgUser, $wgMemc, $wgUserProfileDisplay;

		if ($wgUserProfileDisplay['interests'] == false) {
			return "";
		}

		if( !$this->profile_data ){
			$profile = new UserProfile($user_name);
			$this->profile_data = $profile->getProfile();
		}
		$profile_data = $this->profile_data;
		$joined_data = $profile_data["movies"] . $profile_data["tv"] . $profile_data["music"] . $profile_data["books"] . $profile_data["video_games"] . $profile_data["magazines"] . $profile_data["drinks"] . $profile_data["snacks"];
		$edit_info_link = Title::MakeTitle(NS_SPECIAL, "UpdateProfile");

		$output = '';
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
				$this->getProfileSection(wfMsg("other-info-movies"), $profile_data["movies"], false).
				$this->getProfileSection(wfMsg("other-info-tv"), $profile_data["tv"], false).
				$this->getProfileSection(wfMsg("other-info-music"), $profile_data["music"], false).
				$this->getProfileSection(wfMsg("other-info-books"), $profile_data["books"], false).
				$this->getProfileSection(wfMsg("other-info-video-games"), $profile_data["video_games"], false).
				$this->getProfileSection(wfMsg("other-info-magazines"), $profile_data["magazines"], false).
				$this->getProfileSection(wfMsg("other-info-snacks"), $profile_data["snacks"], false).
				$this->getProfileSection(wfMsg("other-info-drinks"), $profile_data["drinks"], false).
			"</div>";

		} else if ($wgUser->getName()==$user_name) {
			$output .= "<div class=\"user-section-heading\">
				<div class=\"user-section-title\">
					".wfMsg('other-info-title')."
				</div>
				<div class=\"user-section-actions\">
					<div class=\"action-right\">
						<a href=\"".$edit_info_link->escapeFullURL()."/personal\">".wfMsg('user-edit-this')."</a>
					</div>
					<div class=\"cleared\"></div>
				</div>
			</div>
			<div class=\"cleared\"></div>
			<div class=\"no-info-container\">
					".wfMsg('other-no-info')."
			</div>";
		}
		return $output;
	}

	function getProfileTop($user_id, $user_name) {
		global $IP, $wgTitle, $wgUser, $wgMemc, $wgUploadPath;

		$stats = new UserStats($user_id,$user_name);
		$stats_data = $stats->getUserStats();
		$user_level = new UserLevel($stats_data["points"]);
		$level_link = Title::makeTitle(NS_HELP, wfMsgHtml('user-profile-userlevels-link') );

		if( !$this->profile_data ){
			$profile = new UserProfile($user_name);
			$this->profile_data = $profile->getProfile();
		}
		$profile_data = $this->profile_data;

		//variables and other crap
		$page_title = $wgTitle->getText();
		$title_parts = explode("/", $page_title);
		$user = $title_parts[0];
		$id = User::idFromName($user);
		$user_safe = urlencode($user);

		//safe urls
		$add_relationship = Title::makeTitle(NS_SPECIAL, "AddRelationship");
		$remove_relationship = Title::makeTitle(NS_SPECIAL, "RemoveRelationship");
		$give_gift = Title::makeTitle(NS_SPECIAL, "GiveGift");
		$friends_activity = Title::makeTitle(NS_SPECIAL, "UserActivity");
		$send_board_blast = Title::makeTitle(NS_SPECIAL, "SendBoardBlast");
		$similar_fans = Title::makeTitle(NS_SPECIAL, "SimilarFans");
		$update_profile = Title::makeTitle(NS_SPECIAL, "UpdateProfile");
		$watchlist = Title::makeTitle(NS_SPECIAL, "Watchlist");
		$contributions = Title::makeTitle(NS_SPECIAL, "Contributions");
		$send_message = Title::makeTitle(NS_SPECIAL, "UserBoard");
		$upload_avatar = Title::makeTitle(NS_SPECIAL, "UploadAvatar");
		$user_page = Title::makeTitle(NS_USER, $user);
		$user_social_profile = Title::makeTitle(NS_USER_PROFILE, $user);
		$user_wiki = Title::makeTitle(NS_USER_WIKI, $user);

		if($id!=0) $relationship = UserRelationship::getUserRelationshipByID($id, $wgUser->getID());
		$avatar = new wAvatar($this->user_id, "l");

		wfDebug("profile type" . $profile_data["user_page_type"] . "\n");
		$output = '';
		if ( $this->isOwner() ) {
			$toggle_title = Title::makeTitle(NS_SPECIAL, "ToggleUserPage");
			$output .= "<div id=\"profile-toggle-button\"><a href=\"".$toggle_title->escapeFullURL()."\" rel=\"nofollow\">". (( $this->profile_data["user_page_type"] == 1 )? wfMsg("user-type-toggle-old"):wfMsg("user-type-toggle-new") ) ."</a></div>";
		}

		$output .= "<div id=\"profile-image\">
		<img src=\"{$wgUploadPath}/avatars/".$avatar->getAvatarImage()."\" alt=\"\" border=\"0\"/>
		</div>";

		$output .= "<div id=\"profile-right\">";

			$output .= "<div id=\"profile-title-container\">
				<div id=\"profile-title\">
					{$user_name}
				</div>";
				global $wgUserLevels;
				if( $wgUserLevels ){
					$output .= "<div id=\"points-level\">
					<a href=\"{$level_link->escapeFullURL()}\">{$stats_data["points"]}".wfMsg('user-profile-points')."</a>
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
			<a href=\"".$update_profile->escapeFullURL()."\">".wfMsg('user-edit-profile')."</a> |
			<a href=\"".$upload_avatar->escapeFullURL()."\">".wfMsg('user-upload-avatar')."</a> |
			<a href=\"".$watchlist->escapeFullURL()."\">".wfMsg('user-watchlist')."</a> |
			";
		} else if ($wgUser->isLoggedIn()) {
			if($relationship==false) {
				$output .= "<a href=\"".$add_relationship->escapeFullURL('user='.$user_safe.'&rel_type=1')."\" rel=\"nofollow\">".wfMsg('user-add-friend')."</a> |
				<a href=\"".$add_relationship->escapeFullURL('user='.$user_safe.'&rel_type=2')."\" rel=\"nofollow\">".wfMsg('user-add-foe')."</a> | ";
			} else {
				if ($relationship==1)$output .= "<a href=\"".$remove_relationship->escapeFullURL('user='.$user_safe)."\">".wfMsg('user-remove-friend')."</a> | ";
				if ($relationship==2)$output .= "<a href=\"".$remove_relationship->escapeFullURL('user='.$user_safe)."\">".wfMsg('user-remove-foe')."</a> | ";
			}

			global $wgUserBoard;
			if( $wgUserBoard ){
				$output .= "<a href=\"".$send_message->escapeFullURL('user='.$wgUser->getName().'&conv='.$user_safe)."\" rel=\"nofollow\">".wfMsg('user-send-message')."</a> | ";
			}
		}

		$output .= "<a href=\"".$contributions->escapeFullURL()."/{$user_safe}\" rel=\"nofollow\">".wfMsg('user-contributions')."</a> ";

		//Links to User:user_name  from User_profile:
		if( $wgTitle->getNamespace() == NS_USER_PROFILE && $this->profile_data["user_id"] && $this->profile_data["user_page_type"] == 0){
			$output .= "| <a href=\"".$user_page->escapeFullURL()."\" rel=\"nofollow\">".wfMsg('user-page-link')."</a> ";
		}
		//Links to User:user_name  from User_profile:
		if( $wgTitle->getNamespace() == NS_USER && $this->profile_data["user_id"] && $this->profile_data["user_page_type"] == 0){
			$output .= "| <a href=\"".$user_social_profile->escapeFullURL()."\" rel=\"nofollow\">".wfMsg('user-social-profile-link')."</a> ";
		}

		if( $wgTitle->getNamespace() == NS_USER && ( !$this->profile_data["user_id"] || $this->profile_data["user_page_type"] == 1) ){
			$output .= "| <a href=\"".$user_wiki->escapeFullURL()."\" rel=\"nofollow\">".wfMsg('user-wiki-link')."</a>";
		}

		$output .= "</div>

		</div>";

		return $output;
	}

	function getProfileImage($user_name){
		global $wgUser, $wgUploadPath;

		$avatar = new wAvatar($this->user_id, "l");
		$avatar_title = Title::makeTitle(NS_SPECIAL, "UploadAvatar");

		$output .= "<div class=\"profile-image\">";
			if ($wgUser->getName()==$this->user_name) {
				$output .= "<a href=\"{$avatar->escapeFullURL()}\" rel=\"nofollow\">
					<img src=\"{$wgUploadPath}/avatars/".$avatar->getAvatarImage()."\" alt=\"\" border=\"0\"/><br />
					(".((strpos($avatar->getAvatarImage(), 'default_')!=false)?"upload image":"new image").")
				</a>";
			} else {
				$output .= "<img src=\"{$wgUploadPath}/avatars/".$avatar->getAvatarImage()."\" alt=\"\" border=\"0\"/>";
			}
		$output .= "</div>";

		return $output;
	}

	function getRelationships($user_name, $rel_type){
		global $IP, $wgMemc, $wgUser, $wgTitle, $wgUserProfileDisplay, $wgUploadPath;

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

		$stats = new UserStats($rel->user_id, $user_name);
		$stats_data = $stats->getUserStats();
		$user_safe = urlencode( $user_name );
		$view_all_title = Title::makeTitle(NS_SPECIAL, "ViewRelationships");

		if ($rel_type==1) {
			$relationship_count = $stats_data["friend_count"];
			$relationship_title = wfMsg('user-friends-title');

		} else {
			$relationship_count = $stats_data["foe_count"];
			$relationship_title = wfMsg('user-foes-title');
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
					$user =  Title::makeTitle( NS_USER, $friend["user_name"] );
					$avatar = new wAvatar($friend["user_id"], "ml");
					$avatar_img = "<img src=\"{$wgUploadPath}/avatars/" . $avatar->getAvatarImage() . "\" alt=\"\" border=\"0\"/>";

					//chop down username that gets displayed
					$user_name = substr($friend["user_name"], 0, 9);
					if($user_name!=$friend["user_name"])$user_name.= "..";

					$output .= "<a href=\"".$user->escapeFullURL()."\" title=\"{$friend["user_name"]}\" rel=\"nofollow\">
						{$avatar_img}<br />
						{$user_name}
					</a>";
					if($x==count($friends) || $x!=1 && $x%$per_row ==0)$output.="<div class=\"cleared\"></div>";
					$x++;
				}
			$output .= "</div>";
		}
		return $output;
	}

	function getUserBoard($user_id, $user_name){
		global $IP, $wgMemc, $wgUser, $wgTitle, $wgOut, $wgUserProfileDisplay, $wgUserProfileScripts;
		if($user_id == 0)return "";

		if ($wgUserProfileDisplay['board'] == false) {
			return "";
		}

		$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgUserProfileScripts}/UserProfilePage.js\"></script>\n");

		$rel = new UserRelationship($user_name);
		$friends = $rel->getRelationshipList(1, 4);

		$user_safe = str_replace("&", "%26", $user_name);
		$stats = new UserStats($user_id, $user_name);
		$stats_data = $stats->getUserStats();
		$total = $stats_data["user_board"];

		if($wgUser->getName() == $user_name)$total=$total+$stats_data["user_board_priv"];

		$output .= "<div class=\"user-section-heading\">
			<div class=\"user-section-title\">
				".wfMsg("user-board-title")."
			</div>
			<div class=\"user-section-actions\">
				<div class=\"action-right\">";
					if($wgUser->getName() == $user_name) {
						if($friends)$output .= "<a href=\"" . UserBoard::getBoardBlastURL()."\">".wfMsg('user-send-board-blast')."</a>";
						if($total>10)$output .= " | ";
					}
					if($total>10)$output .= "<a href=\"".UserBoard::getUserBoardURL($user_name)."\">".wfMsg('user-view-all')."</a>";
				$output .= "</div>
				<div class=\"action-left\">";
					if($total>10) {
						$output .= "10 ".wfMsg('user-count-separator')." {$total}";
					} else if ($total>0) {
						$output .= "{$total} ".wfMsg('user-count-separator')." {$total}";
					}
				$output .= "</div>
				<div class=\"cleared\"></div>
			</div>
		</div>
		<div class=\"cleared\"></div>";

		if($wgUser->getName() !== $user_name){
			if($wgUser->isLoggedIn() && !$wgUser->isBlocked()){
				// Some nice message in a other part of the extension :)
				wfLoadExtensionMessages( 'SocialProfileUserBoard' );
				$output .= "<div class=\"user-page-message-form\">
						<input type=\"hidden\" id=\"user_name_to\" name=\"user_name_to\" value=\"" . addslashes($user_name)."\"/>
						<span style=\"color:#797979;\">" . wfMsgHtml( 'userboard_messagetype' ) . "</span> <select id=\"message_type\"><option value=\"0\">" . wfMsgHtml( 'userboard_public' ) . "</option><option value=\"1\">" . wfMsgHtml( 'userboard_private' ) . "</option></select><p>
						<textarea name=\"message\" id=\"message\" cols=\"43\" rows=\"4\"/></textarea>
						<div class=\"user-page-message-box-button\">
							<input type=\"button\" value=" . wfMsg('userboard_sendbutton') . " class=\"site-button\" onclick=\"javascript:send_message();\">
						</div>
					</div>";
			} else {
				$login_link = Title::makeTitle(NS_SPECIAL, 'UserLogin');

				$output .= "<div class=\"user-page-message-form\">
						".wfMsg('user-board-login-message', $login_link->escapeFullURL())."
				</div>";
			}
		}
		$output .= "<div id=\"user-page-board\">";
		$b = new UserBoard();
		$output .= $b->displayMessages($user_id, 0, 10);

		$output .= "</div>";

		return $output;
	}
}
