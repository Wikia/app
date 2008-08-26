<?php

$wgExtensionFunctions[] = 'wfSpecialUpdateProfile';

function wfSpecialUpdateProfile()
{
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");

	$real_name = $email = $old_email = $email_authenticated = null;

	class UpdateProfile extends SpecialPage
	{
		var $db_name;
		var $location_city;
		var $location_state;
		var $hometown_city;
		var $hometown_state;
		var $birthday;
		var $id;
		
		function UpdateProfile(){
			global $wgMessageCache;
			global $wgSharedUserProfile, $wgSharedDB, $wgDBname;
			UnlistedSpecialPage::UnlistedSpecialPage("UpdateProfile");

			$this->db_name = ($wgSharedUserProfile)?$wgSharedDB:$wgDBname;

			require_once ( dirname( __FILE__ ) . '/UserProfile.i18n.php' );
			foreach( efUserProfile() as $lang => $messages )
			{
				$wgMessageCache->addMessages( $messages, $lang );
			}
		}

		function execute()
		{
			global $IP, $wgUser, $wgOut, $wgRequest, $wgSiteView, $wgStyleVersion, $wgEmailAuthentication;
			global $wgContLang, $wgLang, $wgScriptPath;
			#---
			global $wgCountriesList, $wgStateList;
			#---
			$fname = "UpdateProfile:execute";
			$wgOut->setPagetitle( wfMsg('updateyourprofile') );

			#---
			$this->setHometownCountry(219);
			$this->setLocationCountry(219);

			$text =	'<style type="text/css">/*<![CDATA[*/ @import "'.$wgScriptPath.'/extensions/wikia/UserProfile/css/userprofile.css?'.$wgStyleVersion.'"; /*]]>*/</style>'."\n";
			$wgOut->addHTML($text);

			if( !$wgUser->isLoggedIn() )
			{
				$wgOut->setPagetitle( wfMsg('woopserror') );
				$wgOut->addHTML("<div class=\"user-profile-message\">".wfMsg('usermustlogin')."</div>");
				return;
			}

			#---
			# make state's list
			#---
			require_once "$IP/extensions/wikia/UserProfile/countries/countries.php";

			#---
			$langCode = (isset($wgContLang->mCode))?$wgContLang->mCode:$wgLang->mCode;
			$states = $wgStateList[$langCode];
			if (empty($states)) #defualt
			{
				$states = $wgStateList['en'];
			}

			$states_js = "";
			if (!empty($states))
			{
				$loop = 0;
				foreach ($states as $cid => $state_list)
				{
					$states_js .= "countries[".$loop."] = {country: \"{$cid}\", name:\"".wfMsg('state_select')."\", sections:[";
					$states_js .= "\"".implode("\",\"", $state_list)."\"";
					$states_js .= "]}\n";
					$loop++;
				}
			}

			$wgOut->addHTML("<script type=\"text/javascript\">var countries =  new Array();\n{$states_js}\n</script>");
			$wgOut->addHTML("<script type=\"text/javascript\" src=\"/extensions/wikia/UserProfile/UpdateProfile.js\"></script>\n");
			$this->loadFromDatabase();

	 		if ($wgRequest->wasPosted())
	 		{
				#$this->setRealName($wgRequest->getVal("real_name"));
				#$this->setEmail($wgRequest->getVal("email"));
				$this->setLocationCity(htmlspecialchars($wgRequest->getVal("location_city")));
				$this->setLocationState($wgRequest->getVal("location_state"));
				$this->setLocationCountry($wgRequest->getVal("location_country"));

				$this->setHometownCity(htmlspecialchars($wgRequest->getVal("hometown_city")));
				$this->setHometownState($wgRequest->getVal("hometown_state"));
				$this->setHometownCountry($wgRequest->getVal("hometown_country"));

				$this->setBirthday($wgRequest->getVal("birthday"));

				#---
				$dbr =& wfGetDB( DB_MASTER );
				$s = $dbr->selectRow( "`{$this->db_name}`.`user_profile`", array( 'up_user_id' ), array( 'up_user_id' => $wgUser->getID() ), $fname );
				if ( $s === false )
					$this->addProfile();
				else
					$this->saveProfile();

				$key = wfMemcKey( 'user', 'profilepage', $wgUser->getID(), $wgUser->getID() );
				global $wgMemc;
				$wgMemc->delete($key);

				#---
				$notify_friend = $wgRequest->getVal("notify_friend");
				$notify_gift = $wgRequest->getVal("notify_gift");
				if ($notify_friend=="")
				{
					$notify_friend = 0;
				}
				if ($notify_gift == "")
				{
					$notify_gift = 0;
				}

				$wgUser->setOption( 'notifygift', $notify_gift );
				$wgUser->setOption( 'notifyfriendrequest', $notify_friend );
				/*$wgUser->setRealName($wgRequest->getVal("real_name"));
				$wgUser->setEmail($wgRequest->getVal("email"));
				if ( $this->old_email != $wgRequest->getVal("email"))
				{
					$wgUser->mEmailAuthenticated = null; # but flag as "dirty" = unauthenticated
				}

				if ($wgEmailAuthentication && !$wgUser->mEmailAuthenticated)
				{
					# Mail a temporary password to the dirty address.
					# User can come back through the confirmation URL to re-enable email.
					$result = $wgUser->sendConfirmationMail();
					if( WikiError::isError( $result ) )
					{
						$error = wfMsg( 'mailerror', htmlspecialchars( $result->getMessage() ) );
					}
					else
					{
						$error = wfMsg( 'eauthentsent', $wgUser->getName() );
					}
				}*/
				$wgUser->saveSettings();
				$wgOut->addHTML("<div class='user-profile-message'>".wfMsg('yourprofilesaved')."</div><br />");
			}

			$wgOut->addHTML($this->displayForm());
		}

		function setLocationCity($city){ $this->location_city = $city;}
		function setLocationState($state){ $this->location_state = $state;}
		function setLocationCountry($country){ $this->location_country = $country;}

		function setHometownCity($city){ $this->hometown_city = $city;}
		function setHometownState($state){ $this->hometown_state = $state;}
		function setHometownCountry($country){ $this->hometown_country = $country;}
		function setBirthday($birthday){ $this->birthday = $birthday;}

		function formatBirthdayDB($birthday)
		{
			$dob = explode('/', $birthday);
			if(count($dob) == 2)
			{
				$year = 4; // Year 4 is a leap year so Feb 29th will be allowed
				$month = $dob[0];
				$day = $dob[1];
				$birthday_date = $year . "-" . $month . "-" . $day;

				// no validation because mysql (or MW's DB driver?) will validate a date... not very nice, though
			}
			return $birthday_date;
		}

		function formatBirthday($birthday)
		{
			$dob = explode('-', $birthday);
			if(count($dob) == 3){
				$year = 0000;
				$month = $dob[1];
				$day = $dob[2];
				$birthday_date = $month . "/" . $day; // . "/" . $year;

				// '0000-00-00' comes from the DB if user set a wrong date
				if (('00' == $month) || ('00' == $day))
				{
					$birthday_date = '';
				}
			}
			return $birthday_date;
		}

		function setRealName($name){$this->real_name = $name;}
		function setEmail($email){$this->email = $email;}


		function saveProfile()
		{
			global $wgUser, $wgMemc;

			$dbw =& wfGetDB( DB_MASTER );
			$dbw->update( "`{$this->db_name}`.`user_profile`",
				array( /* SET */
					'up_location_city' => $this->location_city,
					'up_location_state' => $this->location_state,
					'up_location_country' => $this->location_country,

					'up_hometown_city' => $this->hometown_city,
					'up_hometown_state' => $this->hometown_state,
					'up_hometown_country' => $this->hometown_country,

					'up_birthday' => $this->formatBirthdayDB($this->birthday)

				), array( /* WHERE */
					'up_user_id' => $wgUser->getID()
				), ""
				);
			$wgMemc->delete( wfMemcKey( 'user', 'profile', $wgUser->getName() ) );
		}

		function addProfile()
		{
			global $wgUser;
			$fname = 'user_profile::addToDatabase';
			$dbw =& wfGetDB( DB_MASTER );
			$dbw->insert( "`{$this->db_name}`.`user_profile`",
				array(
					'up_user_id' => $wgUser->getID(),
					'up_location_city' => $this->location_city,
					'up_location_state' => $this->location_state,
					'up_location_country' => $this->location_country,

					'up_hometown_city' => $this->hometown_city,
					'up_hometown_state' => $this->hometown_state,
					'up_hometown_country' => $this->hometown_country,

					'up_birthday' => $this->formatBirthdayDB($this->birthday)
				), $fname
			);
		}


		function loadFromDatabase()
		{
			global $wgUser;
			$dbr =& wfGetDB( DB_MASTER );
			$s = $dbr->selectRow( "`{$this->db_name}`.`user_profile`",
				array ('up_location_city', 'up_location_state', 'up_location_country',
					'up_hometown_city', 'up_hometown_state', 'up_hometown_country', 'up_birthday'),
				array( 'up_user_id' => $wgUser->getID() ), ""
			);

			if ( $s !== false )
			{
				$this->location_city = $s->up_location_city;
				$this->location_state = $s->up_location_state;
				$this->location_country = $s->up_location_country;

				$this->hometown_city = $s->up_hometown_city;
				$this->hometown_state = $s->up_hometown_state;
				$this->hometown_country = $s->up_hometown_country;

				$this->birthday = $this->formatBirthday($s->up_birthday);

				$this->id = $s->up_user_id;
			}

			$s = $dbr->selectRow( 'user', array('user_real_name', 'user_email', 'user_email_authenticated'), array( 'user_id' => $wgUser->getID() ), "");

			if ( $s !== false )
			{
				$this->real_name = $s->user_real_name;
				$this->email = $s->user_email;
				$this->old_email = $s->user_email;
				$this->email_authenticated = $s->user_email_authenticated;
			}
		}

		private function returnPage()
		{
			global $wgUser;
			
			$out = "";
			$out .= "<div class=\"profile-update-links\">";
			$out .= "<a href=\"" . Title::makeTitle(NS_USER_PROFILE, $wgUser->getName())->getLocalURL() . "\">< ".wfMsg('back_to_yout_profile')."</a>";
			$out .= "</div>";

			return $out;
		}

		function displayForm()
		{
			global $IP, $wgRequest, $wgSiteView, $wgUser, $wgContLang, $wgLang;
			global $wgCountriesList, $wgOut;

			#---
			$langCode = (isset($wgContLang->mCode))?$wgContLang->mCode:$wgLang->mCode;
			$countries = $wgCountriesList[$langCode];
			if (empty($countries)) #defualt
			{
				$countries = $wgCountriesList['en'];
			}

            $oAvatar = new WikiaAvatar($wgUser->getID());
            $sAvatarLink = $oAvatar->getAvatarImageLink("l");

			$form =  $this->returnPage();

			$form .= '<form action="/index.php?title=Special:UpdateProfile" method=post enctype="multipart/form-data" name=profile>';
			$form .= "<div class=\"profile-update\">";
            $form .= "<div class=\"profile-update-title\">{$sAvatarLink}</div>";
            
            #$form .= '				<input type="text" size="25" name="real_name" id="real_name" value="'. $this->real_name . '"/>';
			$form .= '<p class="profile-update-title">'.wfMsg('info_title').'</p>
			<p class="profile-update-unit-left">'.wfMsg('yourrealname').'</p>
			<p class="profile-update-unit"><span style="padding-right:3px; font-size:1.1em;">'.$this->real_name.'</span><br />';
			$form .= " <a style=\"font-size:0.85em;\" href=\"".Title::makeTitle(NS_SPECIAL, "Preferences")->getFullURL()."\">".wfMsg('changeuserprefenrences', wfMsg('allmessagesname'))."</a>";

			#$form .= '<input type="text" size="25" name="email" id="email" value="'. $this->email . '"/>';
			$form .= '</p>
			<div class="cleared"></div>
			<p class="profile-update-unit-left">'.wfMsg('email').'</p>
			<p class="profile-update-unit"><span style="padding-right:3px; font-size:1.1em;">'.$this->email.'</span><br />';
			$form .= " <a style=\"font-size:0.85em;\" href=\"".Title::makeTitle(NS_SPECIAL, "Preferences")->getFullURL()."\">".wfMsg('changeuserprefenrences', wfMsg('email'))."</a>";
			$form .= '</p>
			<div class="cleared"></div>';

			/*
			if(!$this->email_authenticated)
			{
				$confirm = Title::makeTitle( NS_SPECIAL  , "Confirmemail"  );
				$form .= " <a href=\"{$confirm->getFullURL()}\">".wfMsg('confirm_email')."</a>";
			}
			$form .= '</p>
			<div class="cleared"></div>';

			if(!$this->email_authenticated)
			{
				$form  .= '<p class="profile-update-unit-left"></p>
				<p class="profile-update-unit-small">('.wfMsg('email_need_auth').')</p>';
			}
			else
			{
				$form .= '</p>';
			}
			$form .='
			<div class="cleared"></div>';
			*/
			
			$form .='
			</div>
			<div class="cleared"></div>';

			$form .= '<div class="profile-update">
			<p class="profile-update-title">'.wfMsg('location_title').'</p>
			<p class="profile-update-unit-left">'.wfMsg('city_title').'</p>
			<p class="profile-update-unit"><input type="text" size="25" name="location_city" id="location_city" value="'. $this->location_city . '"/></p>
			<div class="cleared"></div>
			<p class="profile-update-unit-left" id="location_state_label">'.wfMsg('select_region_title').'</p>';
			$form .= '<p class="profile-update-unit">';
			$form .= '<span id="location_state_form">';
			$form .= "</span>
			<script>
				displaySection(\"location_state\",\"" . $this->location_country . "\",\"" . $this->location_state . "\")
			</script>";
			$form .= '</p>
			<div class="cleared"></div>
			<p class="profile-update-unit-left">'.wfMsg('country_title').'</p>
			<p class="profile-update-unit">';
			$form .= "<select name=\"location_country\" id=\"location_country\" onChange=displaySection('location_state',this.value,'')><option></option>";

			for ($i=0;$i<count($countries);$i++)
			{
				$form .= "<option value=\"{$i}\" " . (($i == $this->location_country)?'selected':'') . ">";
				$form .= $countries[$i] . "</option>";
			}

			$form .=  '</select>
			</p>
			</div>
			<div class="cleared"></div>';

			$form .= '<div class="profile-update">
			<p class="profile-update-title">'.wfMsg('hometown_title').'</p>
			<p class="profile-update-unit-left">'.wfMsg('city_title').'</p>
			<p class="profile-update-unit"><input type="text" size="25" name="hometown_city" id="hometown_city" value="'. $this->hometown_city . '"/></p>
			<div class="cleared"></div>
			<p class="profile-update-unit-left" id="hometown_state_label">'.wfMsg('select_region_title').'</p>
			<p class="profile-update-unit">';

			$form .= '<span id="hometown_state_form">';
			$form .= "</span>
			<script>
				displaySection(\"hometown_state\",\"" . $this->hometown_country . "\",\"" . $this->hometown_state . "\")
			</script>";
			$form .= '</p>
			<div class="cleared"></div>
			<p class="profile-update-unit-left">'.wfMsg('country_title').'</p>
			<p class="profile-update-unit">';
			$form .= "<select name=\"hometown_country\" id=\"hometown_country\" onChange=displaySection('hometown_state',this.value,'')><option></option>";

			for($i=0;$i<count($countries);$i++)
			{
				$form .= "<option value=\"{$i}\" " . (($i == $this->hometown_country)?'selected':'') . ">";
				$form .= $countries[$i] . "</option>";
			}

			$form .= '</select></p>
			</div>
			<div class="cleared"></div>';

			$form .= '<div class="profile-update">
			<p class="profile-update-title">'.wfMsg('birthday_title').'</p>
			<p class="profile-update-unit-left">'.wfMsg('display_date_mm_yy').'</p><p class="profile-update-unit"><input type="text" size="25" name="birthday" id="birthday" value="'. $this->birthday . '"/></p>
			<div class="cleared"></div>
			</div><div class="cleared"></div>';

			$form .= '<div class="profile-update">
			<p class="profile-update-title">'.wfMsg('email_notification').'</p>
			<p class="profile-update-row">'.wfMsg('relationship_notification').' <input type="checkbox" size="25" class="createbox" name="notify_friend" id="notify_friend" value="1"' . (($wgUser->getIntOption( 'notifyfriendrequest',1) == 1)?'checked':'') . '/></p>
			<p class="profile-update-row">'.wfMsg('notify_receive_gift').' <input type="checkbox" size="25" name="notify_gift" id="notify_gift" value="1"' . (($wgUser->getIntOption( 'notifygift',1 ) == 1)?'checked':'') . '/></p>
			</div><div class="cleared"></div>';

			$form .= '<input type="hidden" value="' . $this->id . '">
			<input type="button" value="'.wfMsg('submit_btn').'" size="20" onclick="document.profile.submit()" name="submitProfile" />
			</form>';

			return $form;
		}
	}

	SpecialPage::addPage( new UpdateProfile );
	global $wgMessageCache,$wgOut;

	$wgMessageCache->addMessage( 'viewmanager', 'just a test extension' );
}

?>
