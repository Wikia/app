<?php
/**
 * User profile Wiki Page
 *
 * @file
 * @ingroup Extensions
 * @author David Pean <david.pean@gmail.com>
 * @copyright Copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class UserProfilePage extends Article {

	var $title = null;

	/**
	 * Constructor
	 */
	function __construct( &$title ){
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
			return '';
		}

		$wgOut->addHTML('<div id="profile-top">');
		$wgOut->addHTML( $this->getProfileTop($this->user_id, $this->user_name) );
		$wgOut->addHTML('<div class="cleared"></div></div>');

		// User does not want social profile for User:user_name, so we just show header + page content
		if( $wgTitle->getNamespace() == NS_USER && $this->profile_data['user_id'] && $this->profile_data['user_page_type'] == 0 ){
			parent::view();
			return '';
		}

		// Left side
		$wgOut->addHTML('<div id="user-page-left" class="clearfix">');

		if ( !wfRunHooks( 'UserProfileBeginLeft', array( &$this  ) ) ) {
			wfDebug( __METHOD__ . ": UserProfileBeginLeft messed up profile!\n" );
		}

		$wgOut->addHTML( $this->getRelationships($this->user_name, 1) );
		$wgOut->addHTML( $this->getRelationships($this->user_name, 2) );
		$wgOut->addHTML( $this->getGifts($this->user_name) );
		$wgOut->addHTML( $this->getAwards($this->user_name) );
		$wgOut->addHTML( $this->getCustomInfo($this->user_name) );
		$wgOut->addHTML( $this->getInterests($this->user_name) );
		$wgOut->addHTML( $this->getFanBoxes($this->user_name) );
		$wgOut->addHTML( $this->getUserStats($this->user_id, $this->user_name) );

		if ( !wfRunHooks( 'UserProfileEndLeft', array( &$this  ) ) ) {
			wfDebug( __METHOD__ . ": UserProfileEndLeft messed up profile!\n" );
		}

		$wgOut->addHTML('</div>');

		wfDebug("profile start right\n");

		// Right side
		$wgOut->addHTML('<div id="user-page-right" class="clearfix">');

		if ( !wfRunHooks( 'UserProfileBeginRight', array( &$this  ) ) ) {
			wfDebug( __METHOD__ . ": UserProfileBeginRight messed up profile!\n" );
		}

		$wgOut->addHTML( $this->getPersonalInfo($this->user_id, $this->user_name) );
		$wgOut->addHTML( $this->getUserBoard($this->user_id, $this->user_name) );

		if ( !wfRunHooks( 'UserProfileEndRight', array( &$this  ) ) ) {
			wfDebug( __METHOD__ . ": UserProfileEndRight messed up profile!\n" );
		}

		$wgOut->addHTML('</div><div class="cleared"></div>');
	}

	function getUserStatsRow( $label, $value ) {
		global $wgUser, $wgTitle, $wgOut;

		$output = ''; // Prevent E_NOTICE

		if( $value != 0 ) {
			$output = "<div>
					<b>{$label}</b>
					{$value}
			</div>";
		}

		return $output;
	}

	function getUserStats( $user_id, $user_name ) {
		global $wgUser, $wgTitle, $IP, $wgUserProfileDisplay;

		// Load messages, we're gonna need 'em
		wfLoadExtensionMessages( 'SocialProfileUserProfile' );

		if( $wgUserProfileDisplay['stats'] == false ) {
			return '';
		}

		$output = ''; // Prevent E_NOTICE

		$stats = new UserStats($user_id, $user_name);
		$stats_data = $stats->getUserStats();

		$total_value = $stats_data['edits'] . $stats_data['votes'] . $stats_data['comments'] . $stats_data['recruits'] . $stats_data['poll_votes'] . $stats_data['picture_game_votes'] . $stats_data['quiz_points'];

		if( $total_value != 0 ) {
			$output .= '<div class="user-section-heading">
				<div class="user-section-title">
					'.wfMsg('user-stats-title').'
				</div>
				<div class="user-section-actions">
					<div class="action-right">
					</div>
					<div class="action-left">
					</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
			<div class="profile-info-container bold-fix">'.
				$this->getUserStatsRow(wfMsg('user-stats-edits'), $stats_data['edits']).
				$this->getUserStatsRow(wfMsg('user-stats-votes'), $stats_data['votes']).
				$this->getUserStatsRow(wfMsg('user-stats-comments'), $stats_data['comments']).
				$this->getUserStatsRow(wfMsg('user-stats-recruits'), $stats_data['recruits']).
				$this->getUserStatsRow(wfMsg('user-stats-poll-votes'), $stats_data['poll_votes']).
				$this->getUserStatsRow(wfMsg('user-stats-picture-game-votes'), $stats_data['picture_game_votes']).
				$this->getUserStatsRow(wfMsg('user-stats-quiz-points'), $stats_data['quiz_points']);
				if( $stats_data['currency'] != '10,000' )
					$output .= $this->getUserStatsRow( wfMsg('user-stats-pick-points'), $stats_data['currency'] );
			$output .= '</div>';
		}

		return $output;
	}

	function sortItems( $x, $y ){
		if ( $x['timestamp'] == $y['timestamp'] )
			return 0;
		else if ( $x['timestamp'] > $y['timestamp'] )
			return -1;
		else
			return 1;
	}

	function getProfileSection( $label, $value, $required = true ){
		global $wgUser, $wgTitle, $wgOut;

		// Load messages, we're gonna need 'em
		wfLoadExtensionMessages( 'SocialProfileUserProfile' );

		$output = '';
		if( $value || $required ) {
			if( !$value ) {
				if ( $wgUser->getName() == $wgTitle->getText() ) {
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

	function getPersonalInfo( $user_id, $user_name ) {
		global $IP, $wgTitle, $wgUser, $wgMemc, $wgUserProfileDisplay;

		// Load messages, we're gonna need 'em
		wfLoadExtensionMessages( 'SocialProfileUserProfile' );

		if( $wgUserProfileDisplay['personal'] == false ) {
			return '';
		}

		$stats = new UserStats($user_id, $user_name);
		$stats_data = $stats->getUserStats();
		$user_level = new UserLevel($stats_data['points']);
		$level_link = Title::makeTitle( NS_HELP, wfMsgHtml('user-profile-userlevels-link') );

		if( !$this->profile_data ){
			$profile = new UserProfile($user_name);
			$this->profile_data = $profile->getProfile();
		}
		$profile_data = $this->profile_data;

		$location = $profile_data['location_city'] . ", " . $profile_data['location_state'];
		if( $profile_data['location_country'] != 'United States' ){
			$location = '';
			$location .= $profile_data['location_country'];
		}

		if( $location == ", " ) $location = '';

		$hometown = $profile_data['hometown_city'] . ", " . $profile_data['hometown_state'];
		if( $profile_data['hometown_country'] != 'United States' ){
			$hometown = '';
			$hometown .= $profile_data['hometown_country'];
		}
		if( $hometown == ", " ) $hometown = '';

		$joined_data = $profile_data['real_name'] . $location. $hometown . $profile_data['birthday'] . $profile_data['occupation'] . $profile_data['websites'] . $profile_data['places_lived'] . $profile_data['schools'] . $profile_data['about'];
		$edit_info_link = SpecialPage::getTitleFor( 'UpdateProfile' );

		$output = '';
		if( $joined_data ) {
			$output .= '<div class="user-section-heading">
				<div class="user-section-title">
					'.wfMsg('user-personal-info-title').'
				</div>
				<div class="user-section-actions">
					<div class="action-right">';
					if( $wgUser->getName() == $user_name ) {
						$output .= '<a href="'.$edit_info_link->escapeFullURL().'">'.wfMsg('user-edit-this').'</a>';
					}
					$output .= '</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
			<div class="profile-info-container">'.
				$this->getProfileSection(wfMsg('user-personal-info-real-name'), $profile_data['real_name'], false).
				$this->getProfileSection(wfMsg('user-personal-info-location'), $location, false).
				$this->getProfileSection(wfMsg('user-personal-info-hometown'), $hometown, false).
				$this->getProfileSection(wfMsg('user-personal-info-birthday'), $profile_data['birthday'], false).
				$this->getProfileSection(wfMsg('user-personal-info-occupation'), $profile_data['occupation'], false).
				$this->getProfileSection(wfMsg('user-personal-info-websites'), $profile_data['websites'], false).
				$this->getProfileSection(wfMsg('user-personal-info-places-lived'), $profile_data['places_lived'], false).
				$this->getProfileSection(wfMsg('user-personal-info-schools'), $profile_data['schools'], false).
				$this->getProfileSection(wfMsg('user-personal-info-about-me'), $profile_data['about'], false).
			"</div>";
		} else if( $wgUser->getName() == $user_name ) {
			$output .= '<div class="user-section-heading">
				<div class="user-section-title">
					'.wfMsg('user-personal-info-title').'
				</div>
				<div class="user-section-actions">
					<div class="action-right">
						<a href="'.$edit_info_link->escapeFullURL().'">'
							.wfMsg('user-edit-this').
						'</a>
					</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
			<div class="no-info-container">
				'.wfMsg('user-no-personal-info').'
			</div>';
		}

		return $output;
	}

	function getCustomInfo( $user_name ) {
		global $IP, $wgTitle, $wgUser, $wgMemc, $wgUserProfileDisplay;

		if( $wgUserProfileDisplay['custom'] == false ) {
			return '';
		}

		if( !$this->profile_data ){
			$profile = new UserProfile($user_name);
			$this->profile_data = $profile->getProfile();
		}
		$profile_data = $this->profile_data;

		$joined_data = $profile_data['custom_1'] . $profile_data['custom_2'] . $profile_data['custom_3'] . $profile_data['custom_4'];
		$edit_info_link = SpecialPage::getTitleFor( 'UpdateProfile' );

		$output = '';
		if( $joined_data ) {
			$output .= '<div class="user-section-heading">
				<div class="user-section-title">
					'.wfMsg('custom-info-title').'
				</div>
				<div class="user-section-actions">
					<div class="action-right">';
						if( $wgUser->getName() == $user_name ) {
							$output .= '<a href="'.$edit_info_link->escapeFullURL().'/custom">'.wfMsg('user-edit-this').'</a>';
						}
					$output .= '</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
			<div class="profile-info-container">'.
				$this->getProfileSection(wfMsg('custom-info-field1'), $profile_data['custom_1'], false).
				$this->getProfileSection(wfMsg('custom-info-field2'), $profile_data['custom_2'], false).
				$this->getProfileSection(wfMsg('custom-info-field3'), $profile_data['custom_3'], false).
				$this->getProfileSection(wfMsg('custom-info-field4'), $profile_data['custom_4'], false).
			"</div>";
		} else if( $wgUser->getName() == $user_name ) {
			$output .= '<div class="user-section-heading">
				<div class="user-section-title">
					'.wfMsg('custom-info-title').'
				</div>
				<div class="user-section-actions">
					<div class="action-right">
						<a href="'.$edit_info_link->escapeFullURL().'/custom">
							'.wfMsg('user-edit-this').'
						</a>
					</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
			<div class="no-info-container">
				'.wfMsg('custom-no-info').'
			</div>';
		}

		return $output;
	}

	function getInterests( $user_name ) {
		global $IP, $wgTitle, $wgUser, $wgMemc, $wgUserProfileDisplay;

		// Load messages, we're gonna need 'em
		wfLoadExtensionMessages( 'SocialProfileUserProfile' );

		if( $wgUserProfileDisplay['interests'] == false ) {
			return '';
		}

		if( !$this->profile_data ){
			$profile = new UserProfile($user_name);
			$this->profile_data = $profile->getProfile();
		}
		$profile_data = $this->profile_data;
		$joined_data = $profile_data['movies'] . $profile_data['tv'] . $profile_data['music'] . $profile_data['books'] . $profile_data['video_games'] . $profile_data['magazines'] . $profile_data['drinks'] . $profile_data['snacks'];
		$edit_info_link = SpecialPage::getTitleFor( 'UpdateProfile' );

		$output = '';
		if( $joined_data ) {

			$output .= '<div class="user-section-heading">
				<div class="user-section-title">
					'.wfMsg('other-info-title').'
				</div>
				<div class="user-section-actions">
					<div class="action-right">';
						if( $wgUser->getName() == $user_name ) {
							$output .= '<a href="'.$edit_info_link->escapeFullURL().'/personal">'.wfMsg('user-edit-this').'</a>';
						}
					$output .= '</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
			<div class="profile-info-container">'.
				$this->getProfileSection(wfMsg('other-info-movies'), $profile_data['movies'], false).
				$this->getProfileSection(wfMsg('other-info-tv'), $profile_data['tv'], false).
				$this->getProfileSection(wfMsg('other-info-music'), $profile_data['music'], false).
				$this->getProfileSection(wfMsg('other-info-books'), $profile_data['books'], false).
				$this->getProfileSection(wfMsg('other-info-video-games'), $profile_data['video_games'], false).
				$this->getProfileSection(wfMsg('other-info-magazines'), $profile_data['magazines'], false).
				$this->getProfileSection(wfMsg('other-info-snacks'), $profile_data['snacks'], false).
				$this->getProfileSection(wfMsg('other-info-drinks'), $profile_data['drinks'], false).
			'</div>';

		} else if( $wgUser->getName() == $user_name ) {
			$output .= '<div class="user-section-heading">
				<div class="user-section-title">
					'.wfMsg('other-info-title').'
				</div>
				<div class="user-section-actions">
					<div class="action-right">
						<a href="'.$edit_info_link->escapeFullURL().'/personal">'.wfMsg('user-edit-this').'</a>
					</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
			<div class="no-info-container">
					'.wfMsg('other-no-info').'
			</div>';
		}
		return $output;
	}

	function getProfileTop( $user_id, $user_name ) {
		global $IP, $wgTitle, $wgUser, $wgMemc, $wgUploadPath;

		// Load messages, we're gonna need 'em
		wfLoadExtensionMessages( 'SocialProfileUserProfile' );

		$stats = new UserStats($user_id, $user_name);
		$stats_data = $stats->getUserStats();
		$user_level = new UserLevel($stats_data['points']);
		$level_link = Title::makeTitle( NS_HELP, wfMsgHtml('user-profile-userlevels-link') );

		if( !$this->profile_data ){
			$profile = new UserProfile($user_name);
			$this->profile_data = $profile->getProfile();
		}
		$profile_data = $this->profile_data;

		// Variables and other crap
		$page_title = $wgTitle->getText();
		$title_parts = explode("/", $page_title);
		$user = $title_parts[0];
		$id = User::idFromName($user);
		$user_safe = urlencode($user);

		// Safe urls
		$add_relationship = SpecialPage::getTitleFor( 'AddRelationship' );
		$remove_relationship = SpecialPage::getTitleFor( 'RemoveRelationship' );
		$give_gift = SpecialPage::getTitleFor( 'GiveGift' );
		$friends_activity = SpecialPage::getTitleFor( 'UserActivity' );
		$send_board_blast = SpecialPage::getTitleFor( 'SendBoardBlast' );
		$similar_fans = SpecialPage::getTitleFor( 'SimilarFans' );
		$update_profile = SpecialPage::getTitleFor( 'UpdateProfile' );
		$watchlist = SpecialPage::getTitleFor( 'Watchlist' );
		$contributions = SpecialPage::getTitleFor( 'Contributions', $user );
		$send_message = SpecialPage::getTitleFor( 'UserBoard' );
		$upload_avatar = SpecialPage::getTitleFor( 'UploadAvatar' );
		$user_page = Title::makeTitle( NS_USER, $user );
		$user_social_profile = Title::makeTitle( NS_USER_PROFILE, $user );
		$user_wiki = Title::makeTitle( NS_USER_WIKI, $user );

		if( $id != 0 ) $relationship = UserRelationship::getUserRelationshipByID( $id, $wgUser->getID() );
		$avatar = new wAvatar($this->user_id, 'l');

		wfDebug("profile type" . $profile_data['user_page_type'] . "\n");
		$output = '';
		if ( $this->isOwner() ) {
			$toggle_title = SpecialPage::getTitleFor( 'ToggleUserPage' );
			$output .= '<div id="profile-toggle-button"><a href="'.$toggle_title->escapeFullURL().'" rel="nofollow">'. ( ( $this->profile_data['user_page_type'] == 1 ) ? wfMsg('user-type-toggle-old') : wfMsg('user-type-toggle-new') ) .'</a></div>';
		}

		$output .= '<div id="profile-image">
		<img src="'.$wgUploadPath.'/avatars/'.$avatar->getAvatarImage().'" alt="" border="0"/>
		</div>';

		$output .= '<div id="profile-right">';

			$output .= '<div id="profile-title-container">
				<div id="profile-title">
					'.$user_name.'
				</div>';
				global $wgUserLevels;
				if( $wgUserLevels ){
					$output .= "<div id=\"points-level\">
					<a href=\"{$level_link->escapeFullURL()}\">{$stats_data["points"]}".wfMsg('user-profile-points')."</a>
					</div>
					<div id=\"honorific-level\">
						<a href=\"{$level_link->escapeFullURL()}\" rel=\"nofollow\">({$user_level->getLevelName()})</a>
					</div>";
				}
				$output .= '<div class="cleared"></div>
			</div>
			<div class="profile-actions">';

		if ( $this->isOwner() ) {
			$output .= '
			<a href="'.$update_profile->escapeFullURL().'">'.wfMsg('user-edit-profile').'</a> |
			<a href="'.$upload_avatar->escapeFullURL().'">'.wfMsg('user-upload-avatar').'</a> |
			<a href="'.$watchlist->escapeFullURL().'">'.wfMsg('user-watchlist').'</a> |
			';
		} else if( $wgUser->isLoggedIn() ) {
			if( $relationship == false ) {
				$output .= '<a href="'.$add_relationship->escapeFullURL('user='.$user_safe.'&rel_type=1').'" rel="nofollow">'.wfMsg('user-add-friend').'</a> |
				<a href="'.$add_relationship->escapeFullURL('user='.$user_safe.'&rel_type=2').'" rel="nofollow">'.wfMsg('user-add-foe').'</a> | ';
			} else {
				if( $relationship == 1 ) $output .= '<a href="'.$remove_relationship->escapeFullURL('user='.$user_safe).'">'.wfMsg('user-remove-friend').'</a> | ';
				if( $relationship == 2 ) $output .= '<a href="'.$remove_relationship->escapeFullURL('user='.$user_safe).'">'.wfMsg('user-remove-foe').'</a> | ';
			}

			global $wgUserBoard;
			if( $wgUserBoard ){
				$output .= '<a href="'.$send_message->escapeFullURL('user='.$wgUser->getName().'&conv='.$user_safe).'" rel="nofollow">'.wfMsg('user-send-message').'</a> | ';
			}
			$output .= '<a href="'.$give_gift->escapeFullURL('user='.$user_safe).'" rel="nofollow">'.wfMsg('user-send-gift').'</a> |';
		}

		$output .= '<a href="'.$contributions->escapeFullURL().'" rel="nofollow">'.wfMsg('user-contributions').'</a> ';

		// Links to User:user_name from User_profile:
		if( $wgTitle->getNamespace() == NS_USER_PROFILE && $this->profile_data['user_id'] && $this->profile_data['user_page_type'] == 0 ){
			$output .= '| <a href="'.$user_page->escapeFullURL().'" rel="nofollow">'.wfMsg('user-page-link').'</a> ';
		}

		// Links to User:user_name from User_profile:
		if( $wgTitle->getNamespace() == NS_USER && $this->profile_data['user_id'] && $this->profile_data['user_page_type'] == 0 ){
			$output .= '| <a href="'.$user_social_profile->escapeFullURL().'" rel="nofollow">'.wfMsg('user-social-profile-link').'</a> ';
		}

		if( $wgTitle->getNamespace() == NS_USER && ( !$this->profile_data['user_id'] || $this->profile_data['user_page_type'] == 1 ) ){
			$output .= '| <a href="'.$user_wiki->escapeFullURL().'" rel="nofollow">'.wfMsg('user-wiki-link').'</a>';
		}

		$output .= '</div>

		</div>';

		return $output;
	}

	function getProfileImage( $user_name ){
		global $wgUser, $wgUploadPath;

		$avatar = new wAvatar($this->user_id, 'l');
		$avatar_title = SpecialPage::getTitleFor( 'UploadAvatar' );

		$output .= '<div class="profile-image">';
			if( $wgUser->getName() == $this->user_name ) {
				$output .= "<a href=\"{$avatar->escapeFullURL()}\" rel=\"nofollow\">
					<img src=\"{$wgUploadPath}/avatars/".$avatar->getAvatarImage()."\" alt=\"\" border=\"0\"/><br />
					(".( ( strpos( $avatar->getAvatarImage(), 'default_' ) != false ) ? "upload image" : "new image" ).")
				</a>";
			} else {
				$output .= '<img src="'.$wgUploadPath.'/avatars/'.$avatar->getAvatarImage().'" alt="" border="0"/>';
			}
		$output .= '</div>';

		return $output;
	}

	function getRelationships( $user_name, $rel_type ){
		global $IP, $wgMemc, $wgUser, $wgTitle, $wgUserProfileDisplay, $wgUploadPath;

		// Load messages, we're gonna need 'em
		wfLoadExtensionMessages( 'SocialProfileUserProfile' );

		// If not enabled in site settings, don't display
		if( $rel_type == 1 ) {
			if( $wgUserProfileDisplay['friends'] == false ) {
				return '';
			}
		} else {
			if( $wgUserProfileDisplay['foes'] == false ) {
				return '';
			}
		}

		$output = ''; // Prevent E_NOTICE

		$count = 4;
		$rel = new UserRelationship($user_name);
		$key = wfMemcKey( 'relationship', 'profile', "{$rel->user_id}-{$rel_type}" );
		$data = $wgMemc->get( $key );

		// Try cache
		if( !$data ) {
			$friends = $rel->getRelationshipList($rel_type,$count);
			$wgMemc->set( $key, $friends );
		} else {
			wfDebug( "Got profile relationship type {$rel_type} for user {$user_name} from cache\n" );
			$friends = $data;
		}

		$stats = new UserStats($rel->user_id, $user_name);
		$stats_data = $stats->getUserStats();
		$user_safe = urlencode( $user_name );
		$view_all_title = SpecialPage::getTitleFor( 'ViewRelationships' );

		if( $rel_type == 1 ) {
			$relationship_count = $stats_data['friend_count'];
			$relationship_title = wfMsg('user-friends-title');

		} else {
			$relationship_count = $stats_data['foe_count'];
			$relationship_title = wfMsg('user-foes-title');
		}

		if( count($friends) > 0 ) {
			$x = 1;
			$per_row = 4;

			$output .= '<div class="user-section-heading">
				<div class="user-section-title">'.$relationship_title.'</div>
				<div class="user-section-actions">
					<div class="action-right">';
						if( intval( str_replace( ",", "", $relationship_count ) ) > 4 ) {
							$output .= '<a href="'.$view_all_title->escapeFullURL('user='.$user_name.'&rel_type='.$rel_type).'" rel="nofollow">'.wfMsg('user-view-all').'</a>';
						}
					$output .= '</div>
					<div class="action-left">';
						if( intval( str_replace( ",", "", $relationship_count ) ) > 4 ) {
							$output .= "{$per_row} ".wfMsg('user-count-separator')." {$relationship_count}";
						} else {
							$output .= "{$relationship_count} ".wfMsg('user-count-separator')." {$relationship_count}";
						}
					$output .= '</div>
				</div>
				<div class="cleared"></div>
			</div>
			<div class="cleared"></div>
			<div class="user-relationship-container">';

				foreach( $friends as $friend ) {
					$user = Title::makeTitle( NS_USER, $friend['user_name'] );
					$avatar = new wAvatar( $friend['user_id'], 'ml' );
					$avatar_img = '<img src="'.$wgUploadPath.'/avatars/' . $avatar->getAvatarImage() . '" alt="" border="0"/>';

					// Chop down username that gets displayed
					$user_name = substr($friend['user_name'], 0, 9);
					if( $user_name != $friend['user_name'] ) $user_name.= '..';

					$output .= "<a href=\"".$user->escapeFullURL()."\" title=\"{$friend["user_name"]}\" rel=\"nofollow\">
						{$avatar_img}<br />
						{$user_name}
					</a>";
					if( $x == count($friends) || $x != 1 && $x%$per_row == 0 ) $output.= '<div class="cleared"></div>';
					$x++;
				}
			$output .= '</div>';
		}
		return $output;
	}

	function getGifts( $user_name ){
		global $IP, $wgUser, $wgTitle, $wgMemc, $wgUserProfileDisplay, $wgUploadPath;

		// Load messages, we're gonna need 'em
		wfLoadExtensionMessages( 'SocialProfileUserProfile' );

		// If not enabled in site settings, don't display
		if( $wgUserProfileDisplay['gifts'] == false ){
			return '';
		}

		$output = '';

		// USER TO USER GIFTS
		$g = new UserGifts($user_name);
		$user_safe = urlencode($user_name);

		// Try cache
		$key = wfMemcKey( 'user', 'profile', 'gifts', "{$g->user_id}" );
		$data = $wgMemc->get( $key );

		if( !$data ){
			wfDebug( "Got profile gifts for user {$user_name} from DB\n" );
			$gifts = $g->getUserGiftList(0, 4);
			$wgMemc->set( $key, $gifts, 60 * 60 * 4 );
		} else {
			wfDebug( "Got profile gifts for user {$user_name} from cache\n" );
			$gifts = $data;
		}

		$gift_count = $g->getGiftCountByUsername($user_name);
		$gift_link = SpecialPage::getTitleFor( 'ViewGifts' );
		$per_row = 4;

		if( $gifts ) {

			$output .= '<div class="user-section-heading">
				<div class="user-section-title">
					'.wfMsg('user-gifts-title').'
				</div>
				<div class="user-section-actions">
					<div class="action-right">';
						if( $gift_count > 4 ) {
							$output .= '<a href="'.$gift_link->escapeFullURL('user='.$user_safe).'" rel="nofollow">'.wfMsg('user-view-all').'</a>';
						}
					$output .= '</div>
					<div class="action-left">';
						if( $gift_count > 4 ) {
							$output .= "4 ".wfMsg('user-count-separator')." {$gift_count}";
						} else {
							$output .= "{$gift_count} ".wfMsg('user-count-separator')." {$gift_count}";
						}
					$output .= '</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
			<div class="user-gift-container">';

				$x = 1;

				foreach( $gifts as $gift ) {

					if( $gift['status'] == 1 && $user_name == $wgUser->getName() ){
						$g->clearUserGiftStatus($gift['id']);
						$wgMemc->delete( $key );
						$g->decNewGiftCount( $wgUser->getID() );
					}

					$user = Title::makeTitle( NS_USER, $gift['user_name_from'] );
					$gift_image = '<img src="'.$wgUploadPath.'/awards/' . Gifts::getGiftImage( $gift['gift_id'], 'ml' ) . '" border="0" alt="" />';
					$gift_link = $user = SpecialPage::getTitleFor( 'ViewGift' );
					$output .= "<a href=\"".$gift_link->escapeFullURL('gift_id='.$gift['id'])."\" ".( ( $gift['status'] == 1 ) ? 'class="user-page-new"' : '' )." rel=\"nofollow\">{$gift_image}</a>";
					if( $x == count($gifts) || $x != 1 && $x%$per_row == 0 ) $output .= '<div class="cleared"></div>';
					$x++;

				}

			$output .= '</div>';
		} 

		return $output;
	}

	function getAwards( $user_name ){
		global $IP, $wgUser, $wgTitle, $wgMemc, $wgUserProfileDisplay, $wgUploadPath;

		// Load messages, we're gonna need 'em
		wfLoadExtensionMessages( 'SocialProfileUserProfile' );

		// If not enabled in site settings, don't display
		if( $wgUserProfileDisplay['awards'] == false ){
			return '';
		}
 
		$output = '';

		// SYSTEM GIFTS
		$sg = new UserSystemGifts($user_name);

		// Try cache
		$sg_key = wfMemcKey( 'user', 'profile', 'system_gifts', "{$sg->user_id}" );
		$data = $wgMemc->get( $sg_key );
		if( !$data ){
			wfDebug( "Got profile awards for user {$user_name} from DB\n" );
			$system_gifts = $sg->getUserGiftList(0, 4);
			$wgMemc->set( $sg_key, $system_gifts, 60 * 60 * 4 );
		} else {
			wfDebug( "Got profile awards for user {$user_name} from cache\n" );
			$system_gifts = $data;
		}

		$system_gift_count = $sg->getGiftCountByUsername($user_name);
		$system_gift_link = SpecialPage::getTitleFor( 'ViewSystemGifts' );
		$per_row = 4;
	
		if( $system_gifts ) {
			$x = 1;

			$output .= '<div class="user-section-heading">
				<div class="user-section-title">
					'.wfMsg('user-awards-title').'
				</div>
				<div class="user-section-actions">
					<div class="action-right">';
						if( $system_gift_count > 4 ) {
							$output .= '<a href="'.$system_gift_link->escapeFullURL('user='.$user_name).'" rel="nofollow">'.wfMsg('user-view-all').'</a>';
						}
					$output .= '</div>
					<div class="action-left">';
						if( $system_gift_count > 4 ) {
							$output .= "4 ".wfMsg('user-count-separator')." {$system_gift_count}";
						} else {
							$output .= "{$system_gift_count}&nbsp;".wfMsg('user-count-separator')."&nbsp;{$system_gift_count}";
						}
					$output .= "</div>
					<div class=\"cleared\"></div>
				</div>
			</div>
			<div class=\"cleared\"></div>
			<div class=\"user-gift-container\">";

				foreach( $system_gifts as $gift ) {

					if( $gift['status'] == 1 && $user_name == $wgUser->getName() ){
						$sg->clearUserGiftStatus($gift['id']);
						$wgMemc->delete( $sg_key );
						$sg->decNewSystemGiftCount( $wgUser->getID() );
					}

					$gift_image = '<img src="'.$wgUploadPath.'/awards/' . SystemGifts::getGiftImage( $gift['gift_id'], 'ml' ) . '" border="0" alt="" />';
					$gift_link = $user = SpecialPage::getTitleFor( 'ViewSystemGift' );

					$output .= "<a href=\"".$gift_link->escapeFullURL('gift_id='.$gift['id'])."\" ".( ( $gift['status'] == 1 ) ? 'class="user-page-new"' : '' )." rel=\"nofollow\">
						{$gift_image}
					</a>";

					if( $x == count($system_gifts) || $x != 1 && $x%$per_row == 0 ) $output .= '<div class="cleared"></div>';
					$x++;	
				}

			$output .= '</div>';
		}

		return $output;
	}

	function getUserBoard( $user_id, $user_name ){
		global $IP, $wgMemc, $wgUser, $wgTitle, $wgOut, $wgUserProfileDisplay, $wgUserProfileScripts;

		// Load messages, we're gonna need 'em
		wfLoadExtensionMessages( 'SocialProfileUserProfile' );

		if( $user_id == 0 ) return '';

		if( $wgUserProfileDisplay['board'] == false ) {
			return '';
		}

		$output = ''; // Prevent E_NOTICE

		$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgUserProfileScripts}/UserProfilePage.js\"></script>\n");

		$rel = new UserRelationship($user_name);
		$friends = $rel->getRelationshipList(1, 4);

		$user_safe = str_replace("&", "%26", $user_name);
		$stats = new UserStats($user_id, $user_name);
		$stats_data = $stats->getUserStats();
		$total = $stats_data['user_board'];

		if( $wgUser->getName() == $user_name ) $total = $total+$stats_data['user_board_priv'];

		$output .= '<div class="user-section-heading">
			<div class="user-section-title">
				'.wfMsg("user-board-title").'
			</div>
			<div class="user-section-actions">
				<div class="action-right">';
					if( $wgUser->getName() == $user_name ) {
						if( $friends ) $output .= '<a href="' . UserBoard::getBoardBlastURL().'">'.wfMsg('user-send-board-blast').'</a>';
						if( $total > 10 ) $output .= ' | ';
					}
					if( $total > 10 ) $output .= '<a href="'.UserBoard::getUserBoardURL($user_name).'">'.wfMsg('user-view-all').'</a>';
				$output .= '</div>
				<div class="action-left">';
					if( $total > 10 ) {
						$output .= "10 ".wfMsg('user-count-separator')." {$total}";
					} else if( $total > 0 ) {
						$output .= "{$total} ".wfMsg('user-count-separator')." {$total}";
					}
				$output .= '</div>
				<div class="cleared"></div>
			</div>
		</div>
		<div class="cleared"></div>';

		if( $wgUser->getName() !== $user_name ){
			if( $wgUser->isLoggedIn() && !$wgUser->isBlocked() ){
				// Some nice message in a other part of the extension :)
				wfLoadExtensionMessages( 'SocialProfileUserBoard' );
				$output .= '<div class="user-page-message-form">
						<input type="hidden" id="user_name_to" name="user_name_to" value="' . addslashes($user_name).'"/>
						<span style="color:#797979;">' . wfMsgHtml( 'userboard_messagetype' ) . '</span>
						<select id="message_type">
							<option value="0">' . wfMsgHtml( 'userboard_public' ) . '</option>
							<option value="1">' . wfMsgHtml( 'userboard_private' ) . '</option>
						</select><p>
						<textarea name="message" id="message" cols="43" rows="4"/></textarea>
						<div class="user-page-message-box-button">
							<input type="button" value="' . wfMsg('userboard_sendbutton') . '" class="site-button" onclick="javascript:send_message();">
						</div>
					</div>';
			} else {
				$login_link = SpecialPage::getTitleFor( 'UserLogin' );

				$output .= '<div class="user-page-message-form">
						'.wfMsg( 'user-board-login-message', $login_link->escapeFullURL() ).'
				</div>';
			}
		}
		$output .= '<div id="user-page-board">';
		$b = new UserBoard();
		$output .= $b->displayMessages($user_id, 0, 10);

		$output .= '</div>';

		return $output;
	}

	/**
	 * Gets the user's fanboxes if $wgEnableUserBoxes = true; and $wgUserProfileDisplay['userboxes'] = true;
	 * and FanBoxes extension is installed.
	 */
	function getFanBoxes( $user_name ){
		global $wgOut, $IP, $wgUser, $wgTitle, $wgMemc, $wgUserProfileDisplay, $wgFanBoxScripts, $wgFanBoxDirectory, $wgEnableUserBoxes;

		if ( !$wgEnableUserBoxes || $wgUserProfileDisplay['userboxes'] == false ) {
			return '';
		}

		$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgFanBoxScripts}/FanBoxes.js\"></script>\n");
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgFanBoxScripts}/FanBoxes.css\"/>\n");

		wfLoadExtensionMessages('FanBox');

		$f = new UserFanBoxes($user_name);
		$user_safe = ($user_name);

		// Try cache
		//$key = wfMemcKey( 'user', 'profile', 'fanboxes', "{$f->user_id}" );
		//$data = $wgMemc->get( $key );

		//if( !$data ){
		//	wfDebug( "Got profile fanboxes for user {$user_name} from db\n" );
		//	$fanboxes = $f->getUserFanboxes(0,10);
		//	$wgMemc->set( $key, $fanboxes );
		//} else {
		//	wfDebug( "Got profile fanboxes for user {$user_name} from cache\n" );
		//	$fanboxes = $data;
		//}

		$fanboxes = $f->getUserFanboxes(0, 10);

		$fanbox_count = $f->getFanBoxCountByUsername($user_name);
		$fanbox_link = SpecialPage::getTitleFor( 'ViewUserBoxes' );
		$per_row = 1;

		if ( $fanboxes ) {

			$output .= '<div class="user-section-heading">
				<div class="user-section-title">
					'.wfMsg('user-fanbox-title').'
				</div>
				<div class="user-section-actions">
					<div class="action-right">';
						if( $fanbox_count > 10 ) $output .= '<a href="'.$fanbox_link->escapeFullURL('user='.$user_safe).'" rel="nofollow">'.wfMsg('user-view-all').'</a>';
					$output .= '</div>
					<div class="action-left">';
						if( $fanbox_count > 10 ) {
							$output .= "10 ".wfMsg('user-count-separator')." {$fanbox_count}";
						} else {
							$output .= "{$fanbox_count} ".wfMsg('user-count-separator')." {$fanbox_count}";
						}
					$output .= '</div>
					<div class="cleared"></div>

				</div>
			</div>
			<div class="cleared"></div>

			<div class="user-fanbox-container clearfix">';

				$x = 1;
				$tagParser = new Parser();
				foreach( $fanboxes as $fanbox ) {

					$check_user_fanbox = $f->checkIfUserHasFanbox($fanbox['fantag_id']);

					if( $fanbox['fantag_image_name'] ){
						$fantag_image_width = 45;
						$fantag_image_height = 53;
						$fantag_image = Image::newFromName( $fanbox['fantag_image_name'] );
						$fantag_image_url = $fantag_image->createThumb($fantag_image_width, $fantag_image_height);
						$fantag_image_tag = '<img alt="" src="' . $fantag_image_url . '"/>';
					};

					if ( $fanbox['fantag_left_text'] == '' ){
						$fantag_leftside = $fantag_image_tag;
					} else {
						$fantag_leftside = $fanbox['fantag_left_text'];
						$fantag_leftside = $tagParser->parse( $fantag_leftside, $wgTitle, $wgOut->parserOptions(), false );
						$fantag_leftside = $fantag_leftside->getText();
					}

					if ( $fanbox['fantag_left_textsize'] == 'mediumfont' ) {
						$leftfontsize = '11px';
					}

					if ( $fanbox['fantag_left_textsize'] == 'bigfont' ) {
						$leftfontsize = '15px';
					}

					if ( $fanbox['fantag_right_textsize'] == 'smallfont' ) {
						$rightfontsize = '10px';
					}

					if ( $fanbox['fantag_right_textsize'] == 'mediumfont' ) {
						$rightfontsize = '11px';
					}

					// Get permalink
					$fantag_title = Title::makeTitle( NS_FANTAG, $fanbox['fantag_title'] );
					$right_text = $fanbox['fantag_right_text'];
					$right_text = $tagParser->parse( $right_text, $wgTitle, $wgOut->parserOptions(), false );
					$right_text = $right_text->getText();

					// Output fanboxes
					$output .= "<div class=\"fanbox-item\">
						<div class=\"individual-fanbox\" id=\"individualFanbox".$fanbox['fantag_id']."\">
							<div class=\"show-message-container-profile\" id=\"show-message-container".$fanbox['fantag_id']."\">
								<a class=\"perma\" style=\"font-size:8px; color:".$fanbox['fantag_right_textcolor']."\" href=\"".$fantag_title->escapeFullURL()."\" title=\"{$fanbox["fantag_title"]}\">".wfMsg('fanbox-perma')."</a>
								<table  class=\"fanBoxTableProfile\" onclick=\"javascript:openFanBoxPopup('fanboxPopUpBox{$fanbox["fantag_id"]}', 'individualFanbox{$fanbox["fantag_id"]}')\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >
									<tr>
										<td id=\"fanBoxLeftSideOutputProfile\" style=\"color:".$fanbox['fantag_left_textcolor']."; font-size:$leftfontsize\" bgcolor=\"".$fanbox['fantag_left_bgcolor']."\">".$fantag_leftside."</td> 
										<td id=\"fanBoxRightSideOutputProfile\" style=\"color:".$fanbox['fantag_right_textcolor']."; font-size:$rightfontsize\" bgcolor=\"".$fanbox['fantag_right_bgcolor']."\">".$right_text."</td>
									</tr>
								</table>
							</div>
						</div>";

				 		if( $wgUser->isLoggedIn() ) {
							if( $check_user_fanbox == 0 ) {
							$output .= "<div class=\"fanbox-pop-up-box-profile\" id=\"fanboxPopUpBox".$fanbox['fantag_id']."\">
								<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" >
									<tr>
										<td style=\"font-size:10px\">". wfMsgForContent( 'fanbox-add-fanbox' ) ."</td>
									</tr>
									<tr>
										<td align=\"center\">
										<input type=\"button\" value=\"".wfMsg('fanbox-add')."\" size=\"10\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$fanbox["fantag_id"]}', 'individualFanbox{$fanbox["fantag_id"]}'); showAddRemoveMessageUserPage(1, {$fanbox["fantag_id"]}, 'show-addremove-message-half')\" />
										<input type=\"button\" value=\"".wfMsg('cancel')."\" size=\"10\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$fanbox["fantag_id"]}', 'individualFanbox{$fanbox["fantag_id"]}')\" />
										</td>
									</tr>
								</table>
							</div>";
						} else {
							$output .= "<div class=\"fanbox-pop-up-box-profile\" id=\"fanboxPopUpBox".$fanbox['fantag_id']."\">
								<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\">
									<tr>
										<td style=\"font-size:10px\">". wfMsgForContent( 'fanbox-remove-fanbox' ) ."</td>
									</tr>
									<tr>
										<td align=\"center\">
											<input type=\"button\" value=\"".wfMsg('fanbox-remove')."\" size=\"10\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$fanbox["fantag_id"]}', 'individualFanbox{$fanbox["fantag_id"]}'); showAddRemoveMessageUserPage(2, {$fanbox["fantag_id"]}, 'show-addremove-message-half')\" />
											<input type=\"button\" value=\"".wfMsg('cancel')."\" size=\"10\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$fanbox["fantag_id"]}', 'individualFanbox{$fanbox["fantag_id"]}')\" />
										</td>
									</tr>
								</table>
							</div>";
						}
					}

					if( $wgUser->getID() == 0 ) {
						$login = SpecialPage::getTitleFor( 'UserLogin' );
						$output .= "<div class=\"fanbox-pop-up-box-profile\" id=\"fanboxPopUpBox".$fanbox['fantag_id']."\">
							<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\">
								<tr>
									<td style=\"font-size:10px\">". wfMsgForContent( 'fanbox-add-fanbox-login' ) ."<a href=\"{$login->getFullURL()}\">". wfMsgForContent( 'fanbox-login' ) ."</a></td>
								</tr>
								<tr>
									<td align=\"center\">
										<input type=\"button\" value=\"".wfMsg('cancel')."\" size=\"10\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$fanbox["fantag_id"]}', 'individualFanbox{$fanbox["fantag_id"]}')\" />
									</td>
								</tr>
							</table>
						</div>";
					}

				$output .= '</div>';

				$x++;
			}
			$output .= '</div>';
		}

		return $output;
	}
}
