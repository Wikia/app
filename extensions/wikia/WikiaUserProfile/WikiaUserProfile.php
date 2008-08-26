<?php
define ("MEM_CACHE_TIME", 900);

require_once($GLOBALS['IP']."/includes/Article.php");

/*
 *
 * User's relationship classes
 *
 */
require_once($GLOBALS['IP']."/extensions/wikia/UserRelationship/SpecialViewRelationships.php");
require_once($GLOBALS['IP']."/extensions/wikia/UserRelationship/SpecialAddRelationship.php");
require_once($GLOBALS['IP']."/extensions/wikia/UserRelationship/SpecialRemoveRelationship.php");
require_once($GLOBALS['IP']."/extensions/wikia/UserRelationship/SpecialViewRelationshipRequests.php");
require_once($GLOBALS['IP']."/extensions/wikia/UserRelationship/SpecialUserRelationshipAction.php");
require_once($GLOBALS['IP']."/extensions/wikia/UserRelationship/UserRelationshipClass.php");

/*
 *
 * User's gift classes
 *
 */
require_once($GLOBALS['IP']."/extensions/wikia/UserGifts/GiftsClass.php");
require_once($GLOBALS['IP']."/extensions/wikia/UserGifts/SpecialGiveGift.php");
require_once($GLOBALS['IP']."/extensions/wikia/UserGifts/SpecialViewGifts.php");
require_once($GLOBALS['IP']."/extensions/wikia/UserGifts/SpecialViewGift.php");
require_once($GLOBALS['IP']."/extensions/wikia/UserGifts/SpecialGiftManager.php");
require_once($GLOBALS['IP']."/extensions/wikia/UserGifts/SpecialGiftManagerLogo.php");
require_once($GLOBALS['IP']."/extensions/wikia/UserGifts/SpecialRemoveGift.php");

/*
 *
 * User profile
 *
 */
require_once($GLOBALS['IP']."/extensions/wikia/WikiaAvatar/SpecialWikiaAvatar.php");
require_once($GLOBALS['IP']."/extensions/wikia/WikiaAvatar/SpecialWikiaRemoveAvatar.php");
require_once($GLOBALS['IP']."/extensions/wikia/UserProfile/SpecialUpdateProfile.php");
require_once($GLOBALS['IP']."/extensions/wikia/UserProfile/UserProfileClass.php");

/*
 *
 * User statistics & activity
 *
 */
require_once($GLOBALS['IP']."/extensions/wikia/WikiaUserProfile/WikiaUserProfileStats.php");
require_once($GLOBALS['IP']."/extensions/wikia/WikiaUserProfile/WikiaUserProfileActivity.php");

/**
 * SpecialInvite
 */
require_once($GLOBALS['IP']."/extensions/wikia/Invite/SpecialInviteContactsCSV.php");
require_once($GLOBALS['IP']."/extensions/wikia/Invite/SpecialInviteContacts.php");
require_once($GLOBALS['IP']."/extensions/wikia/Invite/SpecialInviteEmail.php");

$wgExtensionCredits['other'][] = array(
    'name' => 'WikiaUserProfile',
    'author' => 'NYC Team, Piotr Molski',
    'version' => 0.1,
    'url' => 'http://www.wikia.com/',
    'description' => "social tools"
);

$wgHooks['ArticleFromTitle'][] = 'wfUserProfileFromTitle';
$wgHooks['PersonalUrls'][] = 'wfUserProfilePersonalUrl';
$wgHooks['SkinTemplateTabs'][] = 'wfUserProfileExtensionTab';
$wgHooks['SkinAfterBottomScripts'][] = 'wfUserProfileActivityScript';

$wgHooks['UserToggles'][] = 'wfUserProfilePreferencesToggle';

// read file with languages
$wgExtensionFunctions[] = 'wfWikiaUserProfileReadLang';


function wfWikiaUserProfileReadLang()
{
	global $wgMessageCache, $wgExtraNamespaces;
	
	require_once ( dirname( __FILE__ ) . '/WikiaUserProfile.i18n.php' );
	foreach( efWikiaUserProfile() as $lang => $messages )
	{
		$wgMessageCache->addMessages( $messages, $lang );
	}

	$wgExtraNamespaces[NS_USER_PROFILE] = "User_profile";	
}

function wfCorrectUserName($user_name) {
	if (!empty($user_name)) {
		$userParams = explode("/", $user_name);
		$user_name = (!empty($userParams)) ? $userParams[0] : $user_name;
	}	
	return $user_name;
}

function wfUserProfileFromTitle( &$title, &$article ) {
    global $wgUser, $wgRequest;

    if ( NS_USER_PROFILE == $title->getNamespace() && !$wgUser->isBlocked() ) {
    	$article = new SkinUserProfile (&$title, wfCorrectUserName($title->getBaseText()));
    }

    if ( (NS_USER == $title->getNamespace() || NS_USER_TALK == $title->getNamespace()) && !$wgUser->isBlocked() ) {
    	$article = new WikiaProfileUserTitle (&$title, wfCorrectUserName($title->getBaseText()));
    }

    return true;
}

function wfUserProfileActivityScript($this, $bottomScriptText) {
    global $wgStyleVersion, $wgTitle, $wgUser;
    
    if ( NS_USER_PROFILE == $wgTitle->getNamespace() && !$wgUser->isBlocked() ) {
        $bottomScriptText .= '<script type="text/javascript" src="/extensions/wikia/WikiaUserProfile/js/user_activity.js?'.$wgStyleVersion.'"></script>';
    }
    
    return true;
}

function wfUserProfileExtensionTab( &$skin, &$content_actions )
{
	/* FIXME hrefs should go through Linker to properly distinguish blue and red links */
	global $wgTitle;

	wfProfileIn( __METHOD__ );

	if ($skin->iscontent)
	{
		/* this is true only on NS_USER* ! */
		$username = $skin->mTitle->getBaseText();

		switch ($skin->mTitle->getNamespace())
		{
		case NS_USER:
		case NS_USER_TALK:

			$new_content_actions = array();

			$tab_no = 0;
			foreach ($content_actions as $name => $action)
			{
				$tab_no++;

				/* put the link to User_profile into the *third* tab */
				/* similar code one more time in this file */
				if (3 == $tab_no)
				{
					$new_content_actions['userprofile'] = array
					(
						'class' => false,
						'text' => wfMsg('profile'),
						'href' => Title::makeTitle(NS_USER_PROFILE, $username)->getLocalURL(),
					);
				}

				$new_content_actions[$name] = $action;
			}

			$content_actions = $new_content_actions;

			break;

		case NS_USER_PROFILE:

			/* FIXME just get rid of the tabs and make them from the beginning. Hackish... */
			$content_actions = array
			(
				'nstab-user' => array
				(
					'class' => false,
					'text' => wfMsg('nstab-user'),
					'href' => Title::makeTitle(NS_USER, $username)->getLocalURL(),
				),
				'talk' => array
				(
					'class' => false,
					'text' => wfMsg('talk'),
					'href' => Title::makeTitle(NS_USER_TALK, $username)->getLocalURL(),
				),
				'userprofile' => array
				(
					'class' => 'selected',
					'text' => wfMsg('profile'),
					'href' => Title::makeTitle(NS_USER_PROFILE, $username)->getLocalURL(),
				),
			);

			break;
		}
	}

	wfProfileOut( __METHOD__ );


	return true;
}

function wfUserProfilePersonalUrl(&$personal_urls, &$wgTitle) {
	global $wgUser;

	wfProfileIn( __METHOD__ );

	if( $wgUser->isLoggedIn() ) {
		$href = Title::makeTitle(NS_USER_PROFILE, $wgUser->getName());
		$tab_no = 0;
		foreach( $personal_urls as $key=>$val )
		{
			$tab_no++;

			/* put the link to User_profile into the *third* tab */
			/* similar code one more time in this file */
			if (3 == $tab_no)
			{
				$new_personal_urls['userprofile'] = array('text' => wfMsg('my_profile'), 'href' => $href->getFullURL(), 'active' => '');
			}
			$new_personal_urls[$key] = $val;
		}
		$personal_urls = $new_personal_urls;
	}

	wfProfileOut( __METHOD__ );

	return true;
}

/**
 *
 * Add "turn off avatars" option to the toggles in the user's prefs.
 * Run by wgHook['UserToggles'].
 *
 */
function wfUserProfilePreferencesToggle(&$togs)
{
	global $wgMessageCache;
	wfProfileIn( __METHOD__ );
	#$wgMessageCache->addMessages(array('tog-avatarsoffonuserandtalk' => 'Turn off avatars on User and User_talk pages'));

	$togs[] = 'avatarsoffonuserandtalk';

	wfProfileOut( __METHOD__ );
	return true;
}

class WikiaProfileUserTitle extends Article{
	var $userName = null;
	var $title = null;

	function __construct (&$title, $user_name)
	{
		$this->userName = $user_name;
		parent::__construct(&$title);
	}

	function view()
	{
		global $wgOut, $wgUser, $wgScriptPath, $wgStyleVersion;
		
		wfProfileIn( __METHOD__ );
		
		/* FIXME 99% copy of "Error message for username that does not exist" snippet from SpecialViewRelationships.php */
		/* There is one more copy in this file. */
		global $wgUser;
		$user_name = $this->userName;
		$user_id = User::idFromName($user_name);
		$user =  Title::makeTitle( NS_USER  , $user_name  );

		/*/
		/* Error message for username that does not exist (from URL)
		/*/
		if ($user_id == 0) {
			$wgOut->setPagetitle( wfMsg('woops_wrong_turn') );
			$out .= "<!-s:1--><div class=\"relationship-request-message\">".wfMsg('user_not_exist')."</div><!-e:1-->";
			$out .= "<!-s:2--><div class=\"relationship-request-buttons\">";
			$out .= "<input type=\"button\" class=\"relationship-request-button\" value=\"".wfMsg('home')."\" onclick=\"window.location='/index.php?title=Main_Page'\"/>";
			if ( $wgUser->isLoggedIn() )
			{
				$out .= " <input type=\"button\" class=\"relationship-request-button\" value=\"".wfMsg('your_user_page')."\" onclick=\"window.location='/index.php?title=User:{$wgUser->getName()}'\"/>";
			}
            $out .= "</div><!-e:2-->";
			$wgOut->addHTML($out);
		/* end of copy */
		}
        else {
			$text =	'<style type="text/css">/*<![CDATA[*/ @import "'.$wgScriptPath.'/extensions/wikia/WikiaUserProfile/css/userprofile.css?'.$wgStyleVersion.'"; /*]]>*/</style>'."\n";
			if (!$wgUser->getOption('avatarsoffonuserandtalk'))
			{
				$text .=	'<style type="text/css">/*<![CDATA[*/ @import "'.$wgScriptPath.'/extensions/wikia/WikiaUserProfile/css/avatar.css?'.$wgStyleVersion.'"; /*]]>*/</style>'."\n";
			}
			$wgOut->addHTML($text);
            $wgOut->addHTML($this->getUserPageMenu ($this->userName));
		}

		wfProfileOut( __METHOD__ );
		parent::view();
	}

	private function getUserPageMenu($user_name)
	{
		global $wgUser, $wgTitle, $wgMemc;
		global $wgEnableEmail, $wgEnableUserEmail;

		wfProfileIn( __METHOD__ );

		if (empty($user_name))
		{		
			$page_title = $wgTitle->getText();
			$title_parts = explode("/",$page_title);
			$user_name = $title_parts[0];
		}

		$id = User::idFromName($user_name);
		$key = wfMemcKey( "userprofile", "wikia" , intval($id), $wgUser->getID() );
		$menu = $wgMemc->get( $key );

		if (empty($menu)) {
			$newUser = User::newFromId($id);
			#---
			$userAvatar = new WikiaAvatar($id, "l");
			#---
			$menu = '<!-s:3--><div class="user-feed-title">';

			if (!$wgUser->getOption('avatarsoffonuserandtalk')) 
				$menu .= '<span class="user-image-avatar">' . $userAvatar->getAvatarImageLink("l") . '</span>';

			$menu .= '<span class="user-feed-menu">';

			if ( ($wgUser->getID() != $id) || (($id == 0) && ($wgUser->getID() == 0)) ) {
				$relationship = UserRelationship::getUserRelationshipByID($id,$wgUser->getID());				
				if ((!($relationship==2)) && ($relationship == false)) {
					$menu .= '<a href="/index.php?title=Special:AddRelationship&user='.$wgTitle->getBaseText().'&rel_type=1">'.wfMsg('friendme').'</a> - ';
				}

				/*
				 * FOE OFF !
				if (!($relationship==1) && ($relationship == false)) {
					$menu .= '<a href="/index.php?title=Special:AddRelationship&user='.$wgTitle->getBaseText().'&rel_type=2">'.wfMsg('foeme').'</a> - ';
				}*/
				if ($relationship==true) {
					#---
					if ($relationship == 1) 
						$menu .= '<b>'.wfMsg('yourfriend').'</b> - ';
					/*
					 * FOE OFF !
					if ($relationship == 2) {
						$menu .= '<b>'.wfMsg('yourfoe').'</b> - ';
					}
					*/
				}
				#---
				$menu .= '<a href="/index.php?title=Special:GiveGift&user='.$wgTitle->getBaseText().'">'.wfMsg('giveusergift').'</a>';
				if ($wgEnableEmail && $wgEnableUserEmail && $wgUser->isLoggedIn() && $newUser->canSendEmail() && $newUser->canReceiveEmail()) 
					$menu .= ' - <a href="/wiki/Special:Emailuser/'.$wgTitle->getBaseText().'">'.wfMsg('sendmessageemail').'</a>';
				elseif ($wgUser->isLoggedIn()) 
					$menu .= ' - <a href="/index.php?title=User_talk:'.$wgTitle->getBaseText().'&action=edit&section=new">'.wfMsg('sendmessage').'</a>';
				#---	
			} else 
				$menu .= '<a href="/index.php?title=Special:InviteContacts">'.wfMsg('invitecontact').'</a>';
			#---
			$menu .= '</span>';

			# relationship requests
			if ( ($wgUser->getID() != $id) || (($id == 0) && ($wgUser->getID() == 0)) ) 
				$menu .= '</div><!-e:3-->';
			else {
				$relFriendCount = UserRelationship::getOpenRequestCount($wgUser->getID(), 1 /*friend*/);
				if (!empty($relFriendCount))
					$menu .= '<span id="requestsMsg"><a href="/index.php?title=Special:ViewRelationshipRequests">'.wfMsg(($relFriendCount == 1)?'userhasrelrequest':'userhasrelrequests', $relFriendCount, wfMsg('friendlink')).'</a></span>';
				/*
				 * FOE OFF !
				$relFoeCount = UserRelationship::getOpenRequestCount($wgUser->getID(), 2);
				if (!empty($relFoeCount))
				{
					$menu .= '<span id=""><a href="/index.php?title=Special:ViewRelationshipRequests">'.wfMsg(($relFriendCount == 1)?'userhasrelrequest' : 'userhasrelrequests', $relFoeCount, wfMsg('foelink')).'</a></span>';
				}
				*/
				$menu .= '</div>';
			}

			$menu .= '<!-s:4--><div class="cleared"></div><!-e:4-->';
			#---
			$wgMemc->set( $key, $menu, MEM_CACHE_TIME );
		}

		wfProfileOut( __METHOD__ );

		return $menu;
	}
}

class SkinUserProfile extends Article {
	const PER_ROW = 3;
	const FRIEND = 1;
	const FOE = 2;

	var $userProfiles = array();
	var $userName = null;
	/*
	 *
	 * available functions:
	 *  - RelationShips
	 * 	- Gifts
	 *
	 */

	function __construct (&$title, $user_name)
	{
		global $wgGiftImageUploadPath, $wgGiftImagePath, $wgUploadDirectory, $wgUploadPath;

		if (empty($wgGiftImageUploadPath)) {
			wfDebug( __METHOD__.": wgGiftImageUploadPath is empty, taking default ".$wgUploadDirectory."/awards\n" );
			$wgGiftImageUploadPath = $wgUploadDirectory."/awards";
		}
		if (empty($wgGiftImagePath)) {
			wfDebug( __METHOD__.": wgGiftImagePath is empty, taking default ".$wgUploadPath."/awards\n" );
			$wgGiftImagePath = $wgUploadPath."/awards";
		}

		$this->userName = $user_name;
		parent::__construct(&$title);
	}

	function view()
	{
		global $wgOut, $wgScriptPath, $wgStyleVersion, $wgRequest;

		wfProfileIn( __METHOD__ );

		/* FIXME 99% copy of "Error message for username that does not exist" snippet from SpecialViewRelationships.php */
		/* There is one more copy in this file. */
		global $wgUser;
		$user_name = $this->userName;
		$user_id = User::idFromName($user_name);
		$user =  Title::makeTitle( NS_USER  , $user_name  );

		/*/
		/* Error message for username that does not exist (from URL)
		/*/
		if ($user_id == 0)
		{
			$wgOut->setPagetitle( wfMsg('woops_wrong_turn') );
			$out .= "<!-s:5--><div class=\"relationship-request-message\">".wfMsg('user_not_exist')."</div><!-e:5-->";
			$out .= "<!-s:6--><div class=\"relationship-request-buttons\">";
			$out .= "<input type=\"button\" class=\"relationship-request-button\" value=\"".wfMsg('home')."\" onclick=\"window.location='/index.php?title=Main_Page'\"/>";
			if ( $wgUser->isLoggedIn() )
			{
				$out .= " <input type=\"button\" class=\"relationship-request-button\" value=\"".wfMsg('your_user_page')."\" onclick=\"window.location='/index.php?title=User:{$wgUser->getName()}'\"/>";
			}
            $out .= "</div><!-e:6-->";
			$wgOut->addHTML($out);
		/* end of copy */
		}
		else
		{
			$wgOut->setPageTitle( $this->mTitle->getPrefixedText() );
			$text =	'<style type="text/css">/*<![CDATA[*/ @import "'.$wgScriptPath.'/extensions/wikia/WikiaUserProfile/css/userprofile.css?'.$wgStyleVersion.'"; /*]]>*/</style>'."\n";
			$text .=	'<style type="text/css">/*<![CDATA[*/ @import "'.$wgScriptPath.'/extensions/wikia/WikiaUserProfile/css/avatar.css?'.$wgStyleVersion.'"; /*]]>*/</style>'."\n";
			$wgOut->addHTML($text);
			$wgOut->addHTML($this->getUserPageMenu ($this->userName));

			#---
			# left panel
			#---
			$wgOut->addHTML("<!-s:7--><div class=\"user-left\">");
			$wgOut->addHTML($this->getUserProfilePage($this->userName));
			$wgOut->addHTML($this->getUserStatsPage($this->userName));
			$wgOut->addHTML($this->getUserActivityPage($this->userName));
			$wgOut->addHTML("</div><!-e:7-->");

			#---
			# right panel
			#---
			$wgOut->addHTML("<!-s:8--><div class=\"user-right\">");
			$wgOut->addHTML($this->getUserPageRelationships ($this->userName, self::FRIEND));
			/*
			 * FOE OFF !
			$wgOut->addHTML($this->getUserPageRelationships($this->userName, self::FOE));
			*/
			$wgOut->addHTML($this->getUserPageGifts ($this->userName));
			$wgOut->addHTML("</div><!-e:8-->");

			$wgOut->addHTML("<div class=\"cleared\"></div>");
		}

		wfProfileOut( __METHOD__ );

		parent::viewUpdates();
		#---
	}

	private function getUserPageRelationships ($user_name,$rel_type) {
		global $IP, $wgMemc, $wgUser, $wgTitle;

		wfProfileIn( __METHOD__ );
		#---
		$output = "";
		#---
		require_once("$IP/extensions/wikia/UserRelationship/UserRelationshipClass.php");

		$rel = new UserRelationship($user_name);

		$key = wfMemcKey( 'relationship', 'profile', intval($rel->user_id)."_".$rel_type );
		$data = $wgMemc->get( $key );

		//try cache
		if(!$data){
			$friends = $rel->getRelationshipList( $rel_type, 12);
			$wgMemc->set( $key, $friends, MEM_CACHE_TIME );
		} else {
			wfDebug( "Got profile relationship type {$rel_type} for user {$user_name} from cache\n" );
			$friends = $data;
		}

		$rel_count = $rel->getRelationshipCountByUsername($user_name);
		$friend_count = $rel_count["friend_count"];
		/*
		 * FOE OFF !
		$foe_count = $rel_count["foe_count"];
		*/

		if($rel_type==1){
			$output = $this->getHtmlPageFriend( $friend_count, $user_name, $rel_type );
		}
		/*
		 * FOE OFF !
		else {
			$output = $this->getHtmlPageFoe($foe_count, $user_name, $rel_type );
		}
		*/
		if ($friends) {
			$x = 1;
			foreach ($friends as $friend) {
				#---
				$user =  Title::makeTitle( NS_USER_PROFILE, $friend["user_name"]  );
				#---
				$line_break = (($x != 1) && (($x % self::PER_ROW) == 0));
				//$page_break = ( ($x == count($friends)) || (($x != 1 && ($x % self::PER_ROW) == 0)) );
				$page_break = false;
				$output .= $this->getHtmlPageAvatar ( $user, $friend, $line_break, $page_break );
				#---
				$x++;
			}
		}
		/*
		 * FOE OFF !
		else {
		    if($rel_type==1) {
		    	#---
			    if ( $wgUser->getName() == $wgTitle->getBaseText() ) {
				    $output .= $this->inviteSomeFriend();
			    } else {
				    $output .= $this->inviteUserAsFriend($wgTitle->getBaseText());
			    }
		    } else {
			    if ( $wgUser->getName() == $wgTitle->getBaseText() ) {
			    	$output .= $this->makeSomeFoe();
			    } else {
				    $output .= $this->makeUserAsFoe($wgTitle->getBaseText());
			    }
		    }
		}
		*/

		if($rel_type==1) {
			$output = $this->getHtmlAllPageFriend( $output );
		}
		/*
		 * FOE OFF !
		else {
			$output = $this->getHtmlAllPageFoe( $output );
		}
		*/

		wfProfileOut( __METHOD__ );

		
		return $output;
	}

	function getUserPageGifts($user_name){
		global $IP, $wgUser, $wgTitle, $wgMemc;

		wfProfileIn( __METHOD__ );
		#---
		require_once("$IP/extensions/wikia/UserGifts/UserGiftsClass.php");
		require_once("$IP/extensions/wikia/UserGifts/GiftsClass.php");

		$g = new UserGifts($user_name);

		//try cache
		$key = wfMemcKey( 'gifts', 'profile', intval($g->user_id) );
		$data = $wgMemc->get( $key );

		if(!$data){
			$gifts = $g->getUserGiftList(0,12);
			$wgMemc->set( $key, $gifts, MEM_CACHE_TIME );
		}else{
			wfDebug( "Got profile gifts for user {$user_name} from cache\n" );
			$gifts = $data;
		}

		$gift_count = $g->getGiftCountByUsername($user_name);

		$output = $this->getHtmlPageGift($gift_count, $user_name);

		if($gifts){
			$x = 1;
			foreach ($gifts as $gift) {
				#---
				if ($gift["status"] == 1) {
					$g->clearUserGiftStatus($gift["id"]);
				}

				#---
				$user =  Title::makeTitle ( NS_USER  , $gift['user_name_from'] );
				#---
				//$page_break = ( ($x == count($gifts)) || (($x != 1 && ($x % self::PER_ROW) == 0)) );
				$page_break = false;
				$gift_img = Gifts::getGiftImage($gift["gift_id"],"l");
				#---
				$output .= $this->getHtmlPageImgGifts ( $gift, $gift_img, $page_break );
				#---
				$x++;
			}
		} else {
			if ( $wgUser->getName() == $wgTitle->getBaseText() ) {
				$output .= $this->addHtmlSomeoneGifts();
			 } else {
				$output .= $this->addHtmlUserGifts($wgTitle->getBaseText());
			 }
		}

		$output = $this->getHtmlAllPageGift($output);

		wfProfileOut( __METHOD__ );
		#---
		return $output;
	}

	private function getUserProfilePage($user_name)
	{
		global $wgUser, $wgTitle, $IP, $wgMemc;

		wfProfileIn( __METHOD__ );
		
		//try cache first
        $profile = new UserProfile($user_name);
		$id = User::idFromName($user_name);
		$key = wfMemcKey( 'user', 'profilepage', intval($id), $wgUser->getID() );
		$data = $wgMemc->get( $key );
		if (!empty($data)) {
			#---
			wfDebug( "Got user profile info for {$user_name} from cache\n");
			$output = $data;
			#---
		} else {
			#---
			$profile_data = $profile->getProfile();
			#---
			$output = "<!-s:9--><div class=\"user-profile\">";
			#---
			$states = $profile->getStates();
			$countries = $profile->getCountries();
			#---
			if ( $wgUser->getName() == $wgTitle->getBaseText()  )
				$message = "<a href=\"/index.php?title=Special:UpdateProfile\">".wfMsg('updateyourprofile')."</a>";
			else
				$message = wfMsg('notprovided');

			#---
			$output .= $this->getHtmlPageProfile( $wgUser, $wgTitle );
			#---
			$output .= "<!-e:10--><div class=\"user-profile-data\"><b>".wfMsg('username')."</b> ";
			if($user_name)
				$output .= htmlspecialchars($user_name);
			else
				$output .= htmlspecialchars($message);
			#---
			$output .= "</div><!-e:10-->";
			#---
			$output .= "<!-s:11--><div class=\"user-profile-data\"><b>".wfMsg('location')."</b> ";
			if($profile_data["location_city"]) {
				$state = (!empty($states[$profile_data["location_country"]][$profile_data["location_state"]])) ?
							", " . $states[$profile_data["location_country"]][$profile_data["location_state"]] :
							"";
				$output .= htmlspecialchars($profile_data["location_city"]) . htmlspecialchars($state) . ", " . htmlspecialchars($countries[$profile_data["location_country"]]);
			} else
				$output .= $message;
			#---
			$output .= "</div><!-e:11-->";
			#---
			$output .= "<!-s:12--><div class=\"user-profile-data\"><b>".wfMsg('hometown')."</b> ";
			if($profile_data["hometown_city"]) {
				$state = (!empty($states[$profile_data["hometown_country"]][$profile_data["hometown_state"]])) ?
							", " . $states[$profile_data["hometown_country"]][$profile_data["hometown_state"]] :
							"";
				$output .= htmlspecialchars($profile_data["hometown_city"]) . htmlspecialchars($state) . ", " . htmlspecialchars($countries[$profile_data["hometown_country"]]);
			} else
				$output .= $message;
			#---
			$output .= "</div><!-e:12-->";
			
			#---
			$output .= "<!-s:13--><div class=\"user-profile-data\"><b>".wfMsg('birthday')."</b> ";
			if ($profile_data["birthday"]) 
				$output .= htmlspecialchars($profile_data["birthday"]);
			else
				$output .= $message;
			$output .= "</div><!-e:13-->";
			$output .= "</div><!-e:9-->";
			#---
			$wgMemc->set( $key, $output, MEM_CACHE_TIME );
		}
		
		wfProfileOut( __METHOD__ );
		#---		
		return $output;
	}

	private function getUserStatsPage($user_name)
	{
		global $wgUser, $wgTitle, $IP, $wgMemc;

		wfProfileIn( __METHOD__ );

		//try cache first
		$id = User::idFromName($user_name);
		$key = wfMemcKey( 'user', 'profile_stats', intval($id) );
		$data = $wgMemc->get( $key );
		if($data)
		{
			wfDebug( "Got  user stats info for {$user_name} from cache\n" );
			$stats_data = $data;
		}
		else
		{
			$stats = new WikiaUserProfileStats($user_name);
			$stats_data = $stats->getUserStats();
			$wgMemc->set( $key, $stats_data, MEM_CACHE_TIME );
		}

		$output = "<div class=\"user-profile\">";
		#---
		$output .= $this->getHtmlPageUserStats();
		#---
		$average = ($stats_data["votes"]->avg_vote) ? $stats_data["votes"]->avg_vote : 0;
		$output .= "<div class=\"user-profile-data\">
			<div class=\"user-stats-data\"><b>".wfMsg('numberofvotes')."</b>: {$stats_data["votes"]->count_vote} (".wfMsg('average').": {$average})</div>
			<div class=\"cleared\"></div>
			<div class=\"user-stats-data\"><b>".wfMsg('numberpageedits')."</b>: {$stats_data["edits"]->cnt_edit}</div>
			<div class=\"cleared\"></div>
			<div class=\"user-stats-data\"><b>".wfMsg('numbercreatedpages')."</b>: {$stats_data["create_pages"]->cnt_new}</div>
			<div class=\"cleared\"></div>
			</div>";
		$output .= "</div>";
		
		wfProfileOut( __METHOD__ );

		return $output;
	}

	private function getUserActivityPage($user_name)
	{
		global $wgUser, $wgTitle, $IP, $wgMemc, $wgOut, $wgStyleVersion, $wgImageCommonPath;

		wfProfileIn( __METHOD__ );

		//try cache first
		#---
		//$wgOut->addScript('<script type="text/javascript" src="/extensions/wikia/WikiaUserProfile/js/user_activity.js?'.$wgStyleVersion.'"></script>');
		#---

		$output = "";
		$id = User::idFromName($user_name);
		$key = wfMemcKey( 'user', 'profile_activity', intval($id) );
		$data = $wgMemc->get( $key );
		if(!empty($data))
		{
			wfDebug( "Got user activity info for {$user_name} from cache\n" );
			$output = $data;
		}
		else
		{
			$activity = new WikiaUserProfileActivity($user_name, "user", 10);
			#---
			$activity_data = $activity->getActivityList();
			#---
			$items = $activity_data[0]; $types = $activity_data[1];

			$output = "<div class=\"user-profile\">";
			#---
			$output .= $this->getHtmlPageUserActivity($types, $activity);
			#---
			$output .= "<div class=\"user-profile-data\" id=\"activity-data\">";

			$loop = 1;
			$count = count($items);
			if (!empty($items))
			{
				foreach ($items as $id => $item)
				{
					$div_class = ($count != $loop) ? "user-feed-item" : "user-feed-item-no-border";
					#--
					$title = $activity->getTypeTitle($item['type'], $item);

					$output .= "<div class=\"{$div_class}\">";
					$output .= "<div class=\"user-feed-item-icon\"><img src={$wgImageCommonPath}/" . $activity->getTypeIcon($item['type']) . " alt=\"" . $activity->getTypeIcon($item['type']) . "\" border='0'></div>";
					$output .= "<div class=\"user-feed-item-activity\">".$activity->getTypeActivityTitle($item['type'], $item['namespace'], $item['pagetitle'], $item['username'], $item['userid'], $item['city'])."</div>";
					$output .= "<div class=\"cleared\"></div>";
					$output .= "<div class=\"user-feed-item-time\">".$activity->getTimeAgo($item["timestamp"])." ago</div>";
					$output .= "<div class=\"cleared\"></div>";
					$output .= $activity->getTypeActivityInfo($item['type'], $item);
					$output .= "</div>";

					$loop++;
				}
			}
			else
			{
				if ( $wgUser->getName() == $wgTitle->getBaseText() )
				{
					$output .= "<p>".wfMsg('questionfornothing')." ";
					$output .= "<a href='/index.php?title=Special:InviteContacts'>".wfMsg('invitesomefriend')."</a>, ";
					$output .= "<a href='/index.php?title=Create_Opinion'>".wfMsg('writearticle')."</a>, ".wfMsg('ortext')." ";
					$output .= "<a href='/index.php?title=Special:Randompage'>".wfMsg('editrandompage')."</a>.</p>";
				}
				else
				{
					$output .= "<p>".wfMsg('userhasnoactivity', $wgTitle->getBaseText())."</p>";
				}
			}

			$output .= "</div>";
			$output .= "</div>";
			#---
			$wgMemc->set( $key, $output, MEM_CACHE_TIME );
		}
		
		wfProfileOut( __METHOD__ );

		return $output;
	}


	/*
	 *
	 * Template's functions
	 *
	 */

	private function getUserPageMenu($user_name) {
		global $wgUser, $wgTitle, $wgEnableEmail, $wgEnableUserEmail;
		global $wgMemc;

		wfProfileIn( __METHOD__ );
		
		if (empty($user_name))
		{
			$page_title = $wgTitle->getBaseText();
			$title_parts = explode("/",$page_title);
			$user_name = $title_parts[0];
		}

		$id = User::idFromName($user_name);
		$key = wfMemcKey( "userprofile", "skin" , intval($id), $wgUser->getID() );
		$menu = $wgMemc->get( $key );

		if (empty($menu)) {
			#---
			$id = User::idFromName($user_name);
			$newUser = User::newFromId($id);
			#---
			$userAvatar = new WikiaAvatar($id, "l");
			#---
			$menu = '<div class="user-feed-title">
			<span class="user-image-avatar">' . $userAvatar->getAvatarImageLink("l") . '</span>
			<span class="user-feed-menu"> ';

			#---
			if ( ($wgUser->getID() != $id) || (($id == 0) && ($wgUser->getID() == 0)) ) {
				#----
				$relationship = UserRelationship::getUserRelationshipByID($id,$wgUser->getID());
				#---
				if ((!($relationship==2)) && ($relationship == false)) 
					$menu .= '<a href="/index.php?title=Special:AddRelationship&user='.$wgTitle->getBaseText().'&rel_type=1">'.wfMsg('friendme').'</a> - ';

				/*
				 * FOE OFF !
				if (!($relationship==1) && ($relationship == false)) {
					$menu .= '<a href="/index.php?title=Special:AddRelationship&user='.$wgTitle->getBaseText().'&rel_type=2">'.wfMsg('foeme').'</a> - ';
				}
				*/
				if ($relationship==true) {
					#---
					if ($relationship == 1) 
						$menu .= '<b>'.wfMsg('yourfriend').'</b> - ';
					/*
					 * FOE OFF !
					if ($relationship == 2) {
						$menu .= '<b>'.wfMsg('yourfoe').'</b> - ';
					}
					*/
				}
				#---
				$menu .= '<a href="/index.php?title=Special:GiveGift&user='.$wgTitle->getBaseText().'">'.wfMsg('giveusergift').'</a>';
				#---
				if ($wgEnableEmail && $wgEnableUserEmail && $wgUser->isLoggedIn() && $newUser->canSendEmail() && $newUser->canReceiveEmail())
					$menu .= ' - <a href="/wiki/Special:Emailuser/'.$wgTitle->getBaseText().'">'.wfMsg('sendmessageemail').'</a>';
				elseif ($wgUser->isLoggedIn())
					$menu .= ' - <a href="/index.php?title=User_talk:'.$wgTitle->getBaseText().'&action=edit&section=new">'.wfMsg('sendmessage').'</a>';

				#--- add to staff link to remove user avatars
				if ($this->is_array_in_array(array('staff', 'sysop'), $wgUser->getGroups()) && in_array('giftmanage', $wgUser->getRights()))
					$menu .= ' - <a href="/index.php?title=Special:AvatarRemove&action=search_user&av_user='.$wgTitle->getBaseText().'">'.wfMsg('remove_user_avatar').'</a>';
			}
			else
				$menu .= '<a href="/index.php?title=Special:InviteContacts">'.wfMsg('invitecontact').'</a>';
			#---
			$menu .= '</span>';

			# relationship requests
			if ( ($wgUser->getID() != $id) || (($id == 0) && ($wgUser->getID() == 0)) )
				$menu .= '</div>';
			else {
				$relFriendCount = UserRelationship::getOpenRequestCount($wgUser->getID(), 1 /*friend*/);
				if (!empty($relFriendCount))
					$menu .= '<span id="requestsMsg"><a href="/index.php?title=Special:ViewRelationshipRequests">'.wfMsg(($relFriendCount == 1)?'userhasrelrequest':'userhasrelrequests', $relFriendCount, wfMsg('friendlink')).'</a></span>';
				/*
				 * FOE OFF !
				$relFoeCount = UserRelationship::getOpenRequestCount($wgUser->getID(), 2);
				if (!empty($relFoeCount))
				{
					$menu .= '<span id=""><a href="/index.php?title=Special:ViewRelationshipRequests">'.wfMsg(($relFriendCount == 1)?'userhasrelrequest' : 'userhasrelrequests', $relFoeCount, wfMsg('foelink')).'</a></span>';
				}
				*/
				$menu .= '</div>';
			}
			$menu .= '<!-s:4--><div class="cleared"></div><!-e:4-->';
			#---
			$wgMemc->set( $key, $menu, MEM_CACHE_TIME );
		}

		wfProfileOut( __METHOD__ );

		return $menu;
	}

	private function is_array_in_array($search, $target)
	{
		wfProfileIn( __METHOD__ );
		
		if(!is_array($search))
		{
			$search = array($search);
		}
		foreach($search as $s)
		{
			if(in_array($s, $target)) return true;
		}
		wfProfileOut( __METHOD__ );
    	return FALSE;
	}

	private function getHtmlAllPageFriend ($output) {
		return "<div class=\"user-page-friends\">".$output. $this->getHtmlEmptyLine()."</div>";
	}

	private function getHtmlAllPageFoe ($output) {
		return "<div class=\"user-page-foes\">".$output.$this->getHtmlEmptyLine()."</div>";
	}

	private function getHtmlPageFriend( $friend_count, $user_name, $rel_type ) {
		wfProfileIn( __METHOD__ );
		$output = "<div class=\"user-title-bar\">
			<div class=\"user-title-bar-title\"><a href=\"/index.php?title=Special:ViewRelationships&user={$user_name}&rel_type={$rel_type}\">".wfMsg('friends')." ({$friend_count})</a></div>
        ";
		$output .= $this->getHtmlEmptyLine();
		$output .= "</div>";
		wfProfileOut( __METHOD__ );
		return $output;
	}

	private function getHtmlPageProfile( $user, $title )
	{
		wfProfileIn( __METHOD__ );
		$output = "";
		#---
		if ($user->getName() == $title->getBaseText()) {
    		$output .= "<div class=\"user-title-bar\">
			<div class=\"user-title-bar-title\"><a href=\"/index.php?title=Special:UpdateProfile\">".wfMsg('myprofile')."</a></div>";
		}
        else {
    		$output .= "<div class=\"user-title-bar\">
			<div class=\"user-title-bar-title\">".wfMsg('myprofile')."</div>";
        }
		$output .= $this->getHtmlEmptyLine();
		$output .= "</div>";
		wfProfileOut( __METHOD__ );
		return $output;
	}

	private function getHtmlPageUserStats() {
		wfProfileIn( __METHOD__ );
		$output = "<div class=\"user-title-bar\">
		<div class=\"user-title-bar-title\">".wfMsg('mystatsmenu')."</div>";
		$output .= $this->getHtmlEmptyLine();
		$output .= "</div>";
		wfProfileOut( __METHOD__ );
		return $output;
	}

	private function getHtmlPageUserActivity($keys, &$activity)
	{
		global $wgImageCommonPath;
		wfProfileIn( __METHOD__ );
		$output = "<div class=\"user-title-bar\">
		<input type=\"hidden\" id=\"activity-user\" value=\"{$this->userName}\">
		<div class=\"user-title-bar-title\">".wfMsg('mylastestactivity')."</div>";
		//$output .= $this->getHtmlEmptyLine();
		$output .= "<div class=\"user-title-bar-tab-large\">";
		$output .= "<span class=\"user-feed-icons\">\n";
		$output .= "<a href=\"javascript:void(0);\" id=\"wk-activity-all\" title=\"".wfMsg('viewall')."\">";
		$output .= "<img src=\"{$wgImageCommonPath}/".$activity->getTypeIcon("all")."\" border=\"0\"></a></span> ";
		if (!empty($keys))
		{
			$loop = 1;
			foreach ($keys as $id => $action)
			{
				#---
				$class = ($loop != count($keys)) ? "user-feed-icons" : "user-feed-icons-no-padding";
				#---
				$output .= "<span class=\"{$class}\">";
				$output .= "<a href=\"javascript:void(0);\" id=\"wk-activity-{$action}\" title=\"".wfMsg("title_{$action}")."\">";
				$output .= "<img src=\"{$wgImageCommonPath}/".$activity->getTypeIcon($action)."\" border=\"0\">";
				$output .= "</a></span>\n";
				#---
				$loop++;
			}
		}
		$output .= "</div>";
		$output .= $this->getHtmlEmptyLine();
		$output .= "</div>";
		wfProfileOut( __METHOD__ );
		return $output;
	}

	private function getHtmlPageFoe( $foe_count, $user_name, $rel_type ) {
		wfProfileIn( __METHOD__ );
		$output = "<div class=\"user-title-bar\">
		<div class=\"user-title-bar-title\"><a href=\"/index.php?title=Special:ViewRelationships&user={$user_name}&rel_type={$rel_type}\">".wfMsg('foes')." ({$foe_count})</a></div>
        ";
		$output .= $this->getHtmlEmptyLine();
		$output .= "</div>";
		wfProfileOut( __METHOD__ );
		return $output;
	}

	private function getHtmlPageAvatar ($user, $friend, $line_break, $page_break) {
		#--- get avatar image
		wfProfileIn( __METHOD__ );
		$avatar = new WikiaAvatar($friend["user_id"], "l");

		$output = "<div class=\"user-page-rel\">
		<div class=\"user-page-rel-image\"><a href=\"{$user->getFullURL()}\">{$avatar->getAvatarImageTag("l")}</a></div>
		<div class=\"user-page-rel-info\"><a href=\"{$user->getFullURL()}\">{$friend["user_name"]}</a></div>";
		if ( $line_break ) {
			$output .= $this->getHtmlEmptyLine();
		}
		$output .= "</div>";
		if ( $page_break ) {
			$output .= $this->getHtmlEmptyLine();
		}
		wfProfileOut( __METHOD__ );
		return $output;
	}

	private function getHtmlPageImgGifts ($gift, $gift_img, $page_break) {
		global $wgGiftImagePath;

		wfProfileIn( __METHOD__ );
		#---
		$gift_image_path = "<img src=\"".$wgGiftImagePath . "/" . $gift_img . "\" border=\"0\" alt=\"gift\" />";
		#---
		$gift_class = ($gift["status"] == 1) ? "class=\"user-page-gift-image-new\"" : "class=\"user-page-gift-image\"";

		$output = "<div class=\"user-page-gift\">
			<div " . $gift_class . "><a href=\"/index.php?title=Special:ViewGift&gift_id={$gift["id"]}\">{$gift_image_path}</a></div>
		</div>";

		if($page_break) {
			$output .= "<div class=\"cleared\"></div>";
		}
		wfProfileOut( __METHOD__ );

		return $output;
	}

	private function getHtmlAllPageGift($output) {
		#---
		return "<div class=\"user-page-gifts\">".$output.$this->getHtmlEmptyLine()."</div>";
	}

	private function getHtmlPageGift ($gift_count, $user_name)
    {
		global $wgUser;
		wfProfileIn( __METHOD__ );

		$output = "<div class=\"user-title-bar\">
		<div class=\"user-title-bar-title\"><a href=\"/index.php?title=Special:ViewGifts&user={$user_name}\">".wfMsg('gitfs')." ({$gift_count})</a></div>";
		$output .= $this->getHtmlEmptyLine();
		$output .= "</div>";

		wfProfileOut( __METHOD__ );
		return $output;
	}

	private function getHtmlEmptyLine() {
		return "<div class=\"cleared\"></div>";
	}

	private function inviteSomeFriend() {
		//No friends.  No worries . . .
		return "<p class=\"user-profile-message\">".wfMsg('nofriendstext', "<a href='/index.php?title=Special:InviteContacts'>".wfMsg('invitesome')."</a>")."</p>";
	}

	private function inviteUserAsFriend($user_name) {
		#-
		return "<p class=\"user-profile-message\">".wfMsg('userhasnofriends', $user_name, "<a href=\"/index.php?title=Special:AddRelationship&user={$user_name}&rel_type=1\">".wfMsg('friendlink')."</a>")."</p>";
	}

	private function makeSomeFoe() {
		return "<p class=\"user-profile-message\">".wfMsg('nofoestext', "<a href='/index.php?title=Special:InviteContacts'>".wfMsg('startwar')."</a>")."</p>";
	}

	private function makeUserAsFoe($user_name) {
		return "<p class=\"user-profile-message\">".wfMsg('userhasnofoes', $user_name, "<a href=\"/index.php?title=Special:AddRelationship&user={$user_name}&rel_type=2\">".wfMsg('foelink')."</a>")."</p>";
	}

	private function addHtmlSomeoneGifts() {
		return "<p class=\"user-profile-message\">".wfMsg('userhasnogifts', "<a href='/index.php?title=Special:GiveGift'>", "</a>")."</p>";
	}

	private function addHtmlUserGifts($user_name) {
		return "<p class=\"user-profile-message\">".wfMsg('giveusergifttext', $user_name, "<a href=\"/index.php?title=Special:GiveGift&user={$user_name}\">", "</a>")."</p>";
	}
}
