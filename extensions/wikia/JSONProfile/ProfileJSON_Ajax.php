<?php
/*
 * Ajax Functions used by JSON Profile
 */
 

$wgAjaxExportList [] = 'wfProfileJSON';

function wfProfileJSON($user_name, $r_user_name="") {
	global $IP, $wgUserProfileDisplay, $wgBlogCategory, $wgMemc, $wgUploadPath, $wgUserLevels, $wgUser;

		//INITIALIZE USER FOR PROFILE BEING DISPLAYED
		$user = User::newFromName($user_name);
		if( is_object( $user ) ){
			$user->load();
			$user_id = $user->getID();
		}
		
		$profile_JSON_array["info"] = array(
			"user_name" => $user_name
		);
		
		if( $user_id  == 0 && !User::isIP($user_name) ){
			$privacy["type"] = "noexist";
			$profile_JSON_array["privacy"] = $privacy;
			$profile_JSON_array["error"] = 1;
			$profile_JSON_array["message"] = "Sorry, that user does not exist!";
			
			return "var json_profile=" . jsonify($profile_JSON_array) . ";\n\nprofile_from_JSON(json_profile);";
		}
		
		if (!is_object( $user ) ) {
			
			$privacy["type"] = "anon";
			$profile_JSON_array["privacy"] = $privacy;
			$profile_JSON_array["error"] = 1;
			$profile_JSON_array["message"] = "";
			$profile_JSON_array["activity"] = array(
					"time" => time(),
					"title"=>wfMsg("user-recent-activity-title"),
					"activity"=>array(),
			);
			
			return "var json_profile=" . jsonify($profile_JSON_array) . ";\n\nprofile_from_JSON(json_profile);";
		}
		
		$user_name = $user->getName();
		$user_id = $user->getID();
		
		$profile_JSON_array = array();

		$profile_JSON_array["time"] = time();
		
		$privacy = array();
		
		//LOGGED IN USER IS VIEWING SOMEONE ELSE'S PROFILE,
		//SO WE NEED TO SET UP THE PRIVACY CHECKS BAESD ON THE USERS SETTINGS
		if( $user->getID() != $wgUser->getID() ){
		
			//SET UP PRIVACY
			$p = new ProfilePrivacy();
			$p->loadPrivacyForUser( $user->getName() );
			
			$wgUserProfileDisplay["friends"] = $p->getPrivacyCheckForUser("VIEW_FRIENDS");
			$wgUserProfileDisplay["activity"] = $p->getPrivacyCheckForUser("VIEW_BULLETINS");
			$wgUserProfileDisplay["board"] = $p->getPrivacyCheckForUser("VIEW_WHITEBOARD");
			$wgUserProfileDisplay["work"] = $p->getPrivacyCheckForUser("VIEW_WORK_PROFILE");
			$wgUserProfileDisplay["status"] = $p->getPrivacyCheckForUser("VIEW_STATUS_HISTORY");
			$wgUserProfileDisplay["personal"] = $p->getPrivacyCheckForUser("VIEW_PERSONAL_PROFILE");
			
			$privacy["link"] = ProfileLink::getLinkType( $user->getID() );
			
			$relationship = UserRelationship::getUserRelationshipByID($user->getID(),$wgUser->getID());
			
			//PROFILE USER DOES NOT WANT ANYONE TO SEE THEIR PROFILE, OR THEY HAVE THE LOGGED IN USER BLOCKED
			if( !$p->getPrivacyCheckForUser("VIEW_FULL") ||  $privacy["link"] < 0 ){
				$privacy["type"] = "private";
				$profile_JSON_array["privacy"] = $privacy;
				$profile_JSON_array["info"] = array(
					"real_name" => $user->getRealName(),
					"user_name" => $user->getName(),
					"user_id" => $user->getID(),
					"relationship" => $relationship,
					"user_add_friend"=>wfMsg("user-add-friend"),
					"user_remove_friend"=>wfMsg("user-remove-friend")
				);
				
				//load gender
				$dbr =& wfGetDB( DB_SLAVE );
				$sql = "SELECT up_gender from user_profile where up_user_id={$user->getID()}";
				$gender_res = $dbr->query($sql);
				if ($gender_row = $dbr->fetchObject($gender_res)) $gender = $gender_row->up_gender;
		
				$profile_JSON_array["messages"] = array(
					"private" => user_name_display($user->getID(), $user->getName()) . " elected to make " . (( $gender == 0 )?"his":"her") . " profile private."
				);
				
				//bulletins placeholder (blank)
				$display_title = wfMsg("user-recent-activity-title"); 
				$bulletins = array();
				
				$p = new ProfilePhoto( $user->getID() );
				
				$profile_JSON_array["activity"] = array(
					"time" => time(),
					"user_name_display"=>user_name_display($user->getID(), $user->getName()),
					"avatar_l"=>$p->getProfileImageURL("l"),
					"title"=>wfMsg("user-recent-activity-title"),
					"activity"=>$bulletins,
				);
			
				return "var json_profile=" . jsonify($profile_JSON_array) . ";\n\nprofile_from_JSON(json_profile);";
			}
			
			$privacy["POST_WHITEBOARD"] = (( $p->getPrivacyCheckForUser("POST_WHITEBOARD") )?1:0);
			$privacy["POKE"] = (( $p->getPrivacyCheckForUser("POKE") )?1:0);	
			
		}
		$privacy["type"] = "public";	

		$profile_JSON_array["privacy"] = $privacy;
			
	
		//USER STATS
		$stats = new UserStats($user_id, $user_name);
		$stats_data = $stats->getUserStats();
		$profile_JSON_array["stats"] = $stats_data;
		
		$user_level = new UserLevel($stats_data["points"]);
		$profile_JSON_array["info"] = array(
			"user_name"=>$user_name,
			"user_id"=>$user_id,
			"user_level"=>$user_level->getLevelName(),
			);
		
		$profile_JSON_array["display"] = $wgUserProfileDisplay;
		$profile_JSON_array["display"]["user_levels"] = $wgUserLevels;

		//$avatar = new wAvatar($user_id,"l");
		$p = new ProfilePhoto( $user_id );
		
		$avatar_title = Title::makeTitle( NS_SPECIAL , "UploadAvatar");
	
		$profile = new UserProfile($user_name);
		$profile_data = $profile->getProfile();
		
		//warning: hack
		//also check if they have other albums from alpha.search
		$albums = false;
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "Select count(*) as count from user_photo_album where photo_album_user_id = {$user_id} and photo_album_name!='Profile Photos'";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if( $row->count > 0 ){
			$albums = true;
		}
		$profile_JSON_array["albums"] = $albums;
		//end hack
		
		
		$level_link = Title::makeTitle(NS_HELP,"User Levels")->escapeFullUrl();
		$profile_JSON_array["avatar"] = array(
			"url"=>$p->getProfileImageURL("p"),
			"link"=>$edit_info_link = "editpicture.html",
			"level_link"=>$level_link,
			);
		
	
		if($r_user_name== "" && $wgUser->isLoggedIn()) {
			$r_user_name = $wgUser->getName();
		}
		
		if($r_user_name != "") {
			$r_user = User::newFromName($r_user_name);
			$r_user_name = $r_user->getName();
			$r_user_id = $r_user->getId();
			$r_logged_in = true;
		}
		else {
			$r_user_name = "";
			$r_user_id = "";
			$r_logged_in = false;
		}
		
		$relationship = UserRelationship::getUserRelationshipByID($user_id,$r_user_id);
		
		$profile_JSON_array["requester"] = array(
			"r_user_name"=>$r_user_name,
			"r_user_id"=>$r_user_id,
			"r_logged_in"=>$r_logged_in,
			"relationship"=>$relationship,
			);
	
		
		$user_safe = urlencode($user_name);
		//safe urls
		
		
		$add_relationship_1 = Title::makeTitle(NS_SPECIAL, "AddRelationship")->escapeFullUrl('user='.$user_safe.'&rel_type=1');
		$add_relationship_2 = Title::makeTitle(NS_SPECIAL, "AddRelationship")->escapeFullUrl('user='.$user_safe.'&rel_type=2');
		$remove_relationship = Title::makeTitle(NS_SPECIAL, "RemoveRelationship")->escapeFullUrl('user='.$user_safe);
		$give_gift = Title::makeTitle(NS_SPECIAL, "GiveGift")->escapeFullUrl('user='.$user_safe);
		$friends_activity = Title::makeTitle(NS_SPECIAL, "UserActivity")->escapeFullUrl();
		$send_board_blast = Title::makeTitle(NS_SPECIAL, "SendBoardBlast")->escapeFullUrl();
		$similar_fans = Title::makeTitle(NS_SPECIAL, "SimilarFans")->escapeFullUrl();
		$update_profile = Title::makeTitle(NS_SPECIAL, "UpdateProfile")->escapeFullUrl();
		$watchlist = Title::makeTitle(NS_SPECIAL,"Watchlist")->escapeFullUrl();
		$contributions = Title::makeTitle(NS_SPECIAL, "Contributions")->escapeFullUrl();
		$send_message = Title::makeTitle(NS_SPECIAL, "UserBoard")->escapeFullUrl('user='.$r_user_name.'&conv='.$user_safe);
		$upload_avatar = Title::makeTitle(NS_SPECIAL,"UploadAvatar")->escapeFullUrl();
		$user_page = Title::makeTitle(NS_USER,$user_safe)->escapeFullUrl();
		$user_social_profile = Title::makeTitle(NS_USER_PROFILE,$user_safe)->escapeFullUrl();
		$user_wiki = Title::makeTitle(NS_USER_WIKI,$user_safe)->escapeFullUrl();
		
		
		$links_array = array(
			"add_relationship_1"=>$add_relationship_1,
			"add_relationship_2"=>$add_relationship_2,
			"remove_relationship"=>$remove_relationship,
			"give_gift"=>$give_gift,
			"friends_activity"=>$friends_activity,
			"send_board_blast"=>$send_board_blast,
			"similar_fans"=>$similar_fans,
			"update_profile"=>$update_profile,
			"watchlist"=>$watchlist,
			"contributions"=>$contributions,
			"send_message"=>$send_message,
			"upload_avatar"=>$upload_avatar,
			"user_page"=>$user_page,
			"user_social_profile"=>$user_social_profile,
			"user_wiki"=>$user_wiki,
		);
		
		
		$top_messages = array(
			"user_edit_profile"=>wfMsg("user-edit-profile"),
			"user_upload_avatar"=>wfMsg("user-upload-avatar"),
			"user_watchlist"=>wfMsg("user-watchlist"),
			"user_friends_activity"=>wfMsg("user-friends-activity"),
			"real_name_nudge"=>user_name_display($user_id, $user_name),
			"user_add_friend"=>wfMsg("user-add-friend"),
			"user_add_foe"=>wfMsg("user-add-foe"),
			"user_remove_friend"=>wfMsg("user-remove-friend"),
			"user_remove_foe"=>wfMsg("user-remove-foe"),
			"user_send_message"=>wfMsg("user-send-message"),
			"user_send_gift"=>wfMsg("user-send-gift"),
			"user_contributions"=>wfMsg("user-contributions"),
			"user_page_link"=>wfMsg("user-page-link"),
			"user_social_profile_link"=>wfMsg("user-social-profile-link"),
			"user_wiki_link"=>wfMsg("user-wiki-link"),
		);
		
		$profile_JSON_array["links"] = $links_array;
		$profile_JSON_array["top_messages"] = $top_messages;

		if ($wgUserProfileDisplay['personal'] != false) {
	
			$stats = new UserStats($user_id,$user_name);
			$stats_data = $stats->getUserStats();
			$user_level = new UserLevel($stats_data["points"]);
			$level_link = Title::makeTitle(NS_HELP,"User Levels");
			
			$location = $profile_data["location_city"] . ", " . $profile_data["location_state"];
			if($profile_data["location_country"]!="United States"){
				//$location = "";
				$location = ($profile_data["location_city"] ? $profile_data["location_city"] . ", " : "");
				$location .= $profile_data["location_country"];
			}	
			
			if($location==", ")$location="";
			
			$hometown = $profile_data["hometown_city"] . ", " . $profile_data["hometown_state"];
			if($profile_data["hometown_country"]!="United States"){
				//$hometown = "";
				$hometown = ($profile_data["hometown_city"] ? $profile_data["hometown_city"] . ", " : "");
				$hometown .= $profile_data["hometown_country"];
			}
			if($hometown==", ")$hometown="";
			
			//$edit_info_link = Title::MakeTitle(NS_SPECIAL,"UpdateProfile")->escapeFullUrl();
			$edit_info_link = "editprofile.html";
			
			$profile_JSON_array["personal"] = array(
				"real_name"=>user_name_display($user_id, $user_name),
				"gender"=>$profile_data["gender"],
				"location"=>ucwords($location),
				"hometown"=>ucwords($hometown),
				"birthday"=>$profile_data["birthday"],
				"birthyear"=>$profile_data["birthyear"],
				"occupation"=>$profile_data["occupation"],
				"websites"=>$profile_data["websites"],
				"places_lived"=>$profile_data["places_lived"],
				"schools"=>$profile_data["schools"],
				"about"=>$profile_data["about"],
				"edit_info_link"=>$edit_info_link,
				"edit_info_message"=>wfMsg("user-edit-this"),
				"title"=>wfMsg("user-personal-info-title"),
				"no_info"=>wfMsg("user-no-personal-info"),
				);
		}
	
		if ($wgUserProfileDisplay['interests'] != false) {
			
			
			
			//$edit_info_link = Title::MakeTitle(NS_SPECIAL,"UpdateProfile")->escapeFullURL();
			$edit_info_link = "editprofile.html?section=personal";

			
			$profile_JSON_array["interests"] = array(
				"movies"=>$profile_data["movies"],
				"tv"=>$profile_data["tv"],
				"music"=>$profile_data["music"],
				"books"=>$profile_data["books"],
				"video_games"=>$profile_data["video_games"],
				"magazines"=>$profile_data["magazines"],
				"drinks"=>$profile_data["drinks"],
				"snacks"=>$profile_data["snacks"],
				"interests"=>$profile_data["interests"],
				"activities"=>$profile_data["activities"],
				"skills"=>$profile_data["skills"],
				"edit_info_link"=>$edit_info_link,
				"edit_info_message"=>wfMsg("user-edit-this"),
				"title"=>wfMsg("other-info-title"),
				"no_info"=>wfMsg("other-no-info"),
				);
			
			
		}

		if ($wgUserProfileDisplay['work'] != false) {
			$edit_info_link = "editprofile.html?section=work";

			$profile_JSON_array["work"] = array(
				"edit_info_link"=>$edit_info_link,
				"edit_info_message"=>wfMsg("user-edit-this"),
				"title"=>wfMsg("user-work-title"),
				"no_info"=>wfMsg("user-no-work-info"),
				"jobs" => $profile_data["work"]
			);
		}
		
		if ($wgUserProfileDisplay['pictures'] != false) {
			 
			$pictures["list"] = array();
			
			//try cache
			$key = wfMemcKey( 'user', 'profile', 'pictures', $user_id );
			//$data = $wgMemc->get( $key );
			
			if( $data ){
				wfDebug( "Got user profile pictures for {$user_name} from cache\n" );
				$pictures = $data;
			} else{
				wfDebug( "Got user profile pictures for {$user_name} from db\n" );
				
				$dbr =& wfGetDB( DB_SLAVE );
				
				//database calls
				$sql = "SELECT img_name, img_user, img_user_text, img_timestamp FROM image INNER JOIN categorylinks on replace(cl_sortkey,' ','_')=concat('Image:',img_name) WHERE img_user_text='" . addslashes($user_name) . "' AND cl_to = 'Profile_Pictures' ORDER BY img_timestamp DESC LIMIT 0,8;";
				$res = $dbr->query($sql);
				 
				$sql_count = "SELECT COUNT(img_name) as total FROM image INNER JOIN categorylinks on replace(cl_sortkey,' ','_')=concat('Image:',img_name) WHERE img_user_text='" . addslashes($user_name) . "' AND cl_to = 'Profile_Pictures'";
				$res_count = $dbr->query($sql_count);
				$row_count = $dbr->fetchObject( $res_count );
				
				$pictures["total_count"] = $row_count->total;
				while ($row = $dbr->fetchObject( $res ) ) {
					$pictures["list"][] = array(
							"name" => $row->img_name
						);
				} 
				$wgMemc->set($key,$pictures);
			}
			
			
			$picture_count = $pictures["total_count"];
			
			$pictures_all = array();
			

			foreach( $pictures["list"] as $picture ){

				$picture["url"] = "{$wgUploadPath}/{$picture["name"]}";
				$pictures_all[]=$picture;

			}
			
			$picture_link = Title::MakeTitle(NS_SPECIAL, "UserSlideShow")->escapeFullURL('user='.$user_name.'&picture=0');
			$empty_imageLink = Title::MakeTitle(NS_IMAGE, "")->escapeFullURL();
						
			$profile_JSON_array["pictures"] = array(
				"title"=>wfMsg("user-pictures-title"),
				"picture_link"=>$picture_link,
				"slideshow_user"=>$user_name,
				"link"=>$picture_link,
				"empty_link"=>trim($empty_imagelink),
				"count"=>$picture_count,
				"upload_path"=>$wgUploadPath,
				"upload_text"=>wfMsg("user-upload-image"),
				"view_all_text"=>wfMsg("user-view-all"),
				"pictures"=>$pictures_all,
				);
			
		}
		
		if ($wgUserProfileDisplay['friends'] != false) {
			
			$rel_type=1;
			
			$count = 8;
			$rel = new UserRelationship($user_name);
			$friends = $rel->getRandomRelationships( $count );
			
			if( $user_name != $wgUser->getName() ) {
				$complete_friends = $rel->getAllRelationships();
				
				$rel_current_user = new UserRelationship( $wgUser->getName() );
				$complete_friends_current_user = $rel_current_user->getAllRelationships();
				
				$mutual_friends = array_intersect_key($complete_friends_current_user, $complete_friends);
				
				$count= 4;
				if( $count > count( $mutual_friends ) ){
					$count = count( $mutual_friends );
				}
				
				$rel_randomized_keys = array_rand( $mutual_friends, $count );
				if( $count == 1 ){ //if one array_rand just returns index
					$mutual_friends_randomized[] = $mutual_friends[$rel_randomized_keys];
				}else{
					foreach( $rel_randomized_keys as $random ){
						$mutual_friends_randomized[] = $mutual_friends[ $random ];
					}
				}
				$friends_full = array();
				foreach ($mutual_friends_randomized as $friend) {
				
					$user =  Title::makeTitle( NS_USER  , $friend["user_name"]  );
					$p = new ProfilePhoto( $friend["user_id"] );
					
					$friend["avatar"] = $p->getProfileImageURL("l");
					$friend["friend_display"] = user_name_display($friend["user_id"], $friend["user_name"]);
					$friend["link"] = $user->escapeFullUrl();
					$friends_full[] = $friend;
				}
			
				$profile_JSON_array["mutual_friends"] = array(
				"count"=>count($mutual_friends) . "", //make sure to force string
				"title"=>"Mutual Friends",
				"view_all_text"=>wfMsg("user-view-all"),
				"mutual_friends"=>$friends_full,
			);
		
			}
			
			$user_safe = urlencode(   $user_name  );
			$view_all_title = Title::makeTitle(NS_SPECIAL,"ViewRelationships")->escapeFullURL('user='.$user_name.'&rel_type='.$rel_type);
			
			$relationship_count = $stats_data["friend_count"];
			$relationship_title = wfMsg("user-friends-title");
			
			$friends_full = array();
			
			foreach ($friends as $friend) {
				
				$user =  Title::makeTitle( NS_USER  , $friend["user_name"]  );
				$p = new ProfilePhoto( $friend["user_id"] );
				
				$friend["avatar"] = $p->getProfileImageURL("l");
				$friend["link"] = $user->escapeFullUrl();
				$friend["friend_display"] = user_name_display($friend["user_id"], $friend["user_name"]);
				$friends_full[] = $friend;
			}
			
			
			$profile_JSON_array["friends"] = array(
				"count"=>$relationship_count,
				"title"=>$relationship_title,
				"view_all"=>$view_all_title,
				"view_all_text"=>wfMsg("user-view-all"),
				"friends"=>$friends_full,
			);
			
			
		}
		
		
		if ($wgUserProfileDisplay['foes'] != false) {
			
			$rel_type=2;
	
			$count = 8;
			$rel = new UserRelationship($user_name);		
			$key = wfMemcKey( 'relationship', 'profile', "{$user_id}-{$rel_type}" );
			$wgMemc->delete($key);
			$data = $wgMemc->get( $key );
		 
			//try cache
			if(!$data) {
				$friends = $rel->getRelationshipList($rel_type,$count);
				$wgMemc->set( $key, $friends );
			} else {
				wfDebug( "Got profile relationship type {$rel_type} for user {$user_name} from cache\n" );
				$friends = $data;
			}
			
			$user_safe = urlencode(   $user_name  );
			$view_all_title = Title::makeTitle(NS_SPECIAL,"ViewRelationships")->escapeFullURL('user='.$user_name.'&rel_type='.$rel_type);
			
			$relationship_count = $stats_data["foe_count"];
			$relationship_title = wfMsg("user-foes-title");


			$friends_full = array();
			
			foreach ($friends as $friend) {
				$user =  Title::makeTitle( NS_USER  , $friend["user_name"]  );
				$avatar = new wAvatar($friend["user_id"],"ml");
				
				$friend["avatar"] = "{$wgUploadPath}/avatars/" . $avatar->getAvatarImage();
				$friend["link"] = $user->escapeFullUrl();
				$friends_full[] = $friend;
			}
			
			$profile_JSON_array["foes"] = array(
				"count"=>$relationship_count,
				"title"=>$relationship_title,
				"view_all"=>$view_all_title,
				"view_all_text"=>wfMsg("user-view-all"),
				"foes"=>$friends_full,
			);
			
			
		}

		if($wgUserProfileDisplay['gifts'] != false){
	
			
			//USER TO USER GIFTS
			$g = new UserGifts($user_name);
			$user_safe = urlencode($user_name);
			
			//try cache
			$key = wfMemcKey( 'user', 'profile', 'gifts', "{$g->user_id}" );
			$data = $wgMemc->get( $key );
			
			if( !$data ){
				wfDebug( "Got profile gifts for user {$user_name} from db\n" );
				$gifts = $g->getUserGiftList(0,4);
				$wgMemc->set( $key, $gifts );
			} else {
				wfDebug( "Got profile gifts for user {$user_name} from cache\n" );
				$gifts = $data;
			}
			
			$gift_count = $g->getGiftCountByUsername($user_name);
			$gift_link = Title::Maketitle(NS_SPECIAL, "ViewGifts");
			
			$gift_title = wfMsg("user-gifts-title");
			$view_all_link = $gift_link->escapeFullURL('user='.$user_safe);
			
			$x = 1;
			
			$gifts_full = array();
			
			foreach ($gifts as $gift) {

				$status = $gift["status"];
				// need to add logic for user that is making the request
				if($gift["status"] == 1 && $user_name==$wgUser->getName() ){
					$g->clearUserGiftStatus($gift["id"]);
					$wgMemc->delete( $key );
					$g->decNewGiftCount( $wgUser->getID() );
				}

				$user =  Title::makeTitle( NS_USER  , $gift["user_name_from"]  );
				$gift["gift_image"] = "{$wgUploadPath}/awards/" . Gifts::getGiftImage($gift["gift_id"],"ml");
				$gift["gift_link"] = Title::makeTitle( NS_SPECIAL  , "ViewGift"  )->escapeFullURL('gift_id='.$gift["id"])."\" ".(($gift["status"] == 1)?"class=\"user-page-new\"":"");
				
				$x++;	

				$gifts_full[] = $gift;
			}
			
			$profile_JSON_array["gifts"] = array(
				"count"=>$gift_count,
				"title"=>$gift_title,
				"view_all_text"=>wfMsg("user-view-all"),
				"view_all"=>$view_all_link,
				"gifts"=>$gifts_full,
				//"gift_image"=>$gift_image,
				//"gift_link"=>$gift_link,
				//"status"=>$status,
			);
			
		}
		
		if ($wgUserProfileDisplay['custom'] != false) {
		
			$custom_info_title = wfMSg("custom-info-title");
			//$edit_info_link = Title::MakeTitle(NS_SPECIAL,"UpdateProfile")->escapeFullUrl();
			$edit_info_link = "editprofile.html?section=custom";
			//$edit_msg = wfMsg("user-edit-this");
			/*
			$custom_fields = array(
				wfMSg("custom-info-field1")=>$profile_data["custom_1"],
				wfMSg("custom-info-field2")=>$profile_data["custom_2"],
				wfMSg("custom-info-field3")=>$profile_data["custom_3"],
				wfMSg("custom-info-field4")=>$profile_data["custom_4"],
			);
			*/
			
			$custom_fields = array(
				"field_1_title"=>wfMSg("custom-info-field1"),
				"field_1_value"=>$profile_data["custom_1"],
				"field_2_title"=>wfMSg("custom-info-field2"),
				"field_2_value"=>$profile_data["custom_2"],
				"field_3_title"=>wfMSg("custom-info-field3"),
				"field_3_value"=>$profile_data["custom_3"],
				"field_4_title"=>wfMSg("custom-info-field4"),
				"field_4_value"=>$profile_data["custom_4"],
			);
			
			$profile_JSON_array["custom"] = array(
				"title"=>$custom_info_title,
				"edit_info_link"=>$edit_info_link,
				"edit_info_message"=>wfMsg("user-edit-this"),
				"fields"=>$custom_fields,
				"other_no_info"=>wfMsg("other-no-info"),
			);
					
		}
		
		
		if($wgUserProfileDisplay['activity'] != false){
			
			$display_title = wfMsg("user-recent-activity-title"); 
	
			$b = new UserBulletinList( $user_name );
			$bulletins = $b->getList("",12);
			
			$profile_JSON_array["activity"] = array(
				"time" => time(),
				"title"=>$display_title,
				"activity"=>$bulletins,
			);
			
		}
		
		
		if($wgUserProfileDisplay['awards'] != false){
				
			$system_gifts_all = array();
	
			//SYSTEM GIFTS
			$sg = new UserSystemGifts($user_name);
			$user_safe = urlencode($user_name);
			
			//try cache
			$sg_key = wfMemcKey( 'user', 'profile', 'system_gifts', "{$sg->user_id}" );
			$data = $wgMemc->get( $sg_key );
			if( !$data ){
				wfDebug( "Got profile awards for user {$user_name} from db\n" );
				$system_gifts = $sg->getUserGiftList(0,4);
				$wgMemc->set( $sg_key, $system_gifts );
			}else{
				wfDebug( "Got profile awards for user {$user_name} from cache\n" );
				$system_gifts = $data;
			}
			
			$system_gift_count = $sg->getGiftCountByUsername($user_name);
			$system_gift_link = Title::Maketitle(NS_SPECIAL, "ViewSystemGifts");
			
			$system_gift_title = wfMsg("user-awards-title");
			$view_all_link = $system_gift_link->escapeFullURL('user='.$user_safe);
			$per_row = 4;
		
			if ($system_gifts) {
				
				foreach ($system_gifts as $gift) {

					if($gift["status"] == 1 && $user_name==$wgUser->getName() ){
						$sg->clearUserGiftStatus($gift["id"]);
						$wgMemc->delete( $sg_key );
						$sg->decNewSystemGiftCount( $wgUser->getID() );
					}
					
					$gift["gift_image"] = "{$wgUploadPath}/awards/" . SystemGifts::getGiftImage($gift["gift_id"],"ml");
					$gift["gift_link"] =  Title::makeTitle( NS_SPECIAL  , "ViewSystemGift"  )->escapeFullURL('gift_id='.$gift["id"]);
					

					$system_gifts_all[] = $gift;
					
				}
				
			}
			
			$profile_JSON_array["awards"] = array(
				"count"=>$system_gift_count,
				"title"=>$system_gift_title,
				"view_all"=>$view_all_link,
				"view_all_text"=>wfMsg("user-view-all"),
				"awards"=>$system_gifts_all,
				//"gift_image"=>$gift_image,
				//"gift_link"=>$gift_link,
				//"status"=>$status,
			);
		}
		
		if ($wgUserProfileDisplay['board'] != false) {
	
			$rel = new UserRelationship($user_name);
			$friends = $rel->getRelationshipList(1,4);
			
			$user_safe = str_replace("&","%26",$user_name);
			$total = $stats_data["user_board"];
			if($r_user_name == $user_name)$total=$total+$stats_data["user_board_priv"];
			$right_action_link = "";
			$right_action_text = "";
			$right_action_link_2 = "";
			$right_action_text_2 = "";
			$slashed_user_name = "";
			
			$separator = wfMsg("user-count-separator");
			$check_count = 10;
			
			if($r_user_name == $user_name) {
				if($friends) {
					$right_action_link .= UserBoard::getBoardBlastURL();
					$right_action_text .= wfMsg("user-send-board-blast");
				}
			}
			 
			if($total>10) {
				$right_action_link_2 .= UserBoard::getUserBoardURL($user_name);
				$right_action_text_2 .= wfMsg("user-view-all");
			}
			
			
			$login_link = "";
			$login_text = "";
					
			if($r_user_name !== $user_name){
				//if($r_logged_in && !$r_user->isBlocked()){
				if($r_user_name !== ""){
					$slashed_user_name .= addslashes($user_name);
				} else {
					
					$login_link = Title::makeTitle(NS_SPECIAL, "Login")->escapeFullURL();
					
					$login_text = wfMsg("user-board-login-message", $login_link);
				}
			}
			else {
				$slashed_user_name .= addslashes($user_name);
			}
			 
			$b = new UserBoard();
			$messages = $b->getUserBoardMessages($user_id,0,10);
			
			$messages_full = array();
		
			
			$messages_full = process_messages_forJSON($messages, $r_user_name);
			
			
			$profile_JSON_array["board"] = array(
				"title"=>wfMsg("user-board-title"),
				"total"=>$total,
				"right_action_link"=>$right_action_link,
				"right_action_text"=>$right_action_text,
				"right_action_link_2"=>$right_action_link_2,
				"right_action_text_2"=>$right_action_text_2,
				"slashed_user_name"=>$slashed_user_name,
				"separator"=>$separator,
				"check_count"=>$check_count,
				"login_link"=>$login_link,
				"login_text"=>$login_text,
				"messages"=>$messages_full,
			);
		
		}
		
		$profile_JSON_array["pokes"] = wfOutstandingPokesJSON($user_name, $r_user_name);
		
		if ($user_name==$r_user_name) {
			$profile_JSON_array["relrequests"] = wfdoViewRelationshipRequestsJSON();
		}
		else {
			$profile_JSON_array["relrequests"] = array();
		}
		
		// Education stuff
		
		$schools = getSchoolsInfo($user_id);
		
		
		$profile_JSON_array["education"] = array(
			"title" => wfMsg("user-profile-education"),
			"schools" => $schools,
			"edit_info_link" => "editprofile.html?section=education",
			"edit_info_message"=>wfMsg("user-edit-this"),
			"no_info"=>wfMsg("user-profile-education-no-info"),
		);
		
		
		
		//try cache
		$key = wfMemcKey( 'user', 'profile', 'background', $user_id );
		$data = $wgMemc->get( $key );
		
		$background = array();
		if( $data ){
			wfDebug( "Got user profile background for {$user_name} from cache\n" );
			$background = $data;
		} else{
			wfDebug( "Got user profile background for {$user_name} from db\n" );
			
			$dbr =& wfGetDB( DB_SLAVE );
			
			//database calls
			$sql = "SELECT * FROM profile_background WHERE user_name='" . addslashes($user_name) . "'";
			$res = $dbr->query($sql);
			 
			if ($row = $dbr->fetchObject( $res ) ) {
				$background = array(
						"background_css" => ($row->background_css ? 1 : 0),
						"scroll" => $row->scroll
				);
				
				$wgMemc->set($key,$background);
			} 
			
		}
		
		$profile_JSON_array["background"] = $background;
		
		
		// End Education Stuff

		return "var json_profile=" . jsonify($profile_JSON_array) . ";\n\nprofile_from_JSON(json_profile);";
	}

//block user
$wgAjaxExportList [] = 'wfProfileBlockJSON';
function wfProfileBlockJSON( $user_id ) {

	$l = new ProfileLink();
	$l->setLink( $user_id, -1 );

	return "window.location='avoid.html'";	
}
	
$wgAjaxExportList [] = 'wfGetProfileBlocksJSON';
function wfGetProfileBlocksJSON( $callback="showUsers" ){  
	global $IP, $wgUser;
	
	
	$l = new ProfileLink();
	$list = $l->getLinkList( $wgUser->getName() );
				
	$avoid_message = ((sizeof($list)>0)?"Below is a list of users that you have select to avoid.  Click \"Unavoid\" to allow them to see your profile information.":"There are no avoided users to list.");
				
	$profile_JSON_array  = array(
			"time" => time(),
			"remove_text" => "Unavoid",
			"avoid_message"=> $avoid_message,
			"page_title"=>"Avoided Users",
			"users"=>$list,
	);	
	
	return "var json_blocked=" . jsonify($profile_JSON_array) . ";\n\n{$callback}(json_blocked);";

}

$wgAjaxExportList [] = 'wfDeleteProfileBlocksJSON';
function wfDeleteProfileBlocksJSON( $user_id ){  
	global $wgUser;
	
	$dbr =& wfGetDB( DB_MASTER );
		
	//clear if old
	$dbr->delete( 'user_profile_link',array( 'pl_user_id' =>  $wgUser->getID(), 'pl_user_id_to' => $user_id ),__METHOD__ );
	$dbr->commit();
	return "window.location.reload();";
}

$wgAjaxExportList [] = 'wfgetNotificationsJSON';
function wfgetNotificationsJSON($callback="display_notifications") {
	global $wgUser, $IP, $wgMemc;
	
	//if (!$wgUser->isLoggedIn()) return "//not logged in so not doing anything";
	
	$notifications_array = array();
	$notifications_array["notification_count"] = 0;
		
	$user_name = $wgUser->getName();
	$user_id = $wgUser->getId();

	$notifications_array["notification_count"] = 0;
	$notifications_array["types"]=array("pokes"=>"nudge","relrequests"=>"friend request","messages"=>"wall post");
	
	if( $wgUser->isLoggedIn() ){
		$notifications_array["pokes"] = wfOutstandingPokesJSON($user_name);
		$notifications_array["notification_count"] += sizeof($notifications_array["pokes"]);
		$notifications_array["relrequests"] = wfGetRelForNotificationJSON();
		$notifications_array["notification_count"] += sizeof($notifications_array["relrequests"]);
		$new_messages_count = UserBoard::getNewMessageCount($user_id);
	}else{
		$new_messages_count = UserBoard::getNewMessageCount($user_name);
	}
	$notifications_array["notification_count"] += $new_messages_count;
	if ($new_messages_count) { 
		$notifications_array["messages"] = doGetBoardMessagesJSON($user_name, "", $new_messages_count, true);
	}
	else {
		$notifications_array["messages"] = array();
	}
	if (!$notifications_array["notification_count"]) {
		$notifications_array["empty_message"] = wfMsg( 'user-profile-no-notifications' );
	}
	else {
		$notifications_array["empty_message"] = "";
	}
	
	/*
	for ($i=0; $i<$new_messages_count; $i++) {
		$notifications_array["messages"][] = array("message"=>"text");
	}
	*/
	$key = wfMemcKey( 'user', 'profile', 'notifupdated', ($user_id ? $user_id : $user_name) );
	$wgMemc->set($key,true);
	
	return "var notifications=" . jsonify($notifications_array) . ";\n\n{$callback}(notifications);";
	
}

$wgAjaxExportList [] = 'wfClearNewMessageCountJSON';
function wfClearNewMessageCountJSON() {
	global $wgUser;

	//$user_id = $wgUser->getId();
	//$user_name = $wgUser->getName();
	
	$b = new UserBoard();
	$b->clearNewMessageCount($wgUser->isAnon() ? $wgUser->getName() : $wgUser->getId());
	
	return "//cleared new message count";

}

$wgAjaxExportList [] = 'wfCheckNewNotificationsJSON';
function wfCheckNewNotificationsJSON() {
	global $wgUser, $wgMemc;

	//if (!$wgUser->isLoggedIn()) return "//not logged in so not doing anything";
	
	$user_id = $wgUser->getId();
	$user_name = $wgUser->getName();
	
	$key = wfMemcKey( 'user', 'profile', 'notifupdated', ($user_id ? $user_id : $user_name) );
	$data = $wgMemc->get( $key );
	
	if (!$data) {
		return  wfgetNotificationsJSON();
	}
	
	return "//no new notifications";

}

$wgAjaxExportList [] = 'wfUpdateProfileBGJSON';
function wfUpdateProfileBGJSON($user_name, $bg, $scroll=0) {
	global $wgUser, $wgMemc;
	//return "blah";
	if (!$wgUser->isLoggedIn()) return "// not logged in"; 
	
	$li_user_name = $wgUser->getName();
	$user_id = $wgUser->getId();
	
	
	//return "//{$bg}";
	
	if ($li_user_name != $user_name) {
		return "//somehow not the same user";
	}
	
	$key = wfMemcKey( 'user', 'profile', 'background', $user_id );
	$data = $wgMemc->get( $key );
	
	$dbw =& wfGetDB( DB_MASTER );
	if( $data ){
		//$sql = "UPDATE profile_background set bg='{$bg}', scroll={$scroll} WHERE user_name='" . addslashes($li_user_name) . "'";
		$dbw->update( '`profile_background`',
			array( /* SET */
				'background_css' => $bg,
				'scroll' => $scroll,
			), array( /* WHERE */
				'user_name' => addslashes($li_user_name),
			), __METHOD__
		);
		$dbw->commit();
	}
	else {
		//$sql = "INSERT INTO profile_background(user_name, bg, scroll) VALUES('" . addslashes($li_user_name) . "', '{$bg}', $scroll)";
		$dbw->insert( '`profile_background`',
			array(
				'user_name' => addslashes($li_user_name),
				'background_css' => $bg,
				'scroll' => $scroll,
			), __METHOD__
		);
	}
	
	$background = array( 
		"background_css"=>$bg,
		"scroll"=>$scroll,
		);
	$wgMemc->delete($key);
	$wgMemc->set($key,$background);
	
	
	
	
	return "//updated background";

}

$wgAjaxExportList [] = 'wfGetURLContents';

function wfGetURLContents($url, $callback) {
	$url = urldecode( $url );
	$html = file_get_contents( $url );
	$html = mb_convert_encoding($html, 'UTF-8',mb_detect_encoding($html, 'UTF-8, ISO-8859-1', true));
	
	preg_match("/<title[^>]*?>(.*?)<\/title>/si", $html, $matches );
	$title = $matches[1];

	preg_match("/<body[^>]*?>(.*?)<\/body>/si", $html, $matches );
	$body = $matches[1];
	$body =  preg_replace('/<script[^>]*?>.*?<\/script>/si', '', $body);
	
	preg_match("/meta name=\"description\" content=\"(.*?)\"/si", $html, $matches );
	$meta_description = $matches[1];
	
	$page = array();
	$page["url"] = $url;
	$page["html"] = $html;
	$page["title"] = $title;
	
	$page["body"] = $body;
	$page["description"] = $meta_description;
	return "var page=" . jsonify($page) . ";\n\n{$callback}(page);";
	
}
?>