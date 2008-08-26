<?php
class UpdateProfile extends SpecialPage {

	function UpdateProfile(){
		UnlistedSpecialPage::UnlistedSpecialPage("UpdateProfile");
	}
	
	
	function initProfile(){
		global $wgUser;
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( 'user_profile', array( 'up_user_id' ), array( 'up_user_id' => $wgUser->getID() ), $fname );
		if ( $s === false ) {		
			$fname = 'user_profile::addToDatabase';
			$dbw =& wfGetDB( DB_MASTER );
			$dbw->insert( '`user_profile`',
				array(
					'up_user_id' => $wgUser->getID()
				), $fname
			);
			$dbw->commit();
		} 
	}


	function execute($section){
		global $wgUser, $wgOut, $wgRequest, $IP, $wgUserProfileScripts, $wgUpdateProfileInRecentChanges, $wgSupressPageTitle ;
		$wgSupressPageTitle = true;
		$wgOut->setHTMLTitle(   wfMsg('edit-profile-title'));
		$wgOut->setPageTitle(  wfMsg('edit-profile-title'));
		if( !$wgUser->isLoggedIn() ) {
			$wgOut->setPagetitle( wfMsgForContent( 'user-profile-update-notloggedin-title' ) );
			$wgOut->addHTML(  wfMsgForContent(  'user-profile-update-notloggedin-text',  Title::makeTitle(NS_SPECIAL, "Login" . $which)->escapeFullUrl(), Title::makeTitle(NS_SPECIAL, "UserRegister" . $which)->escapeFullUrl() ) );
			return;
		}
		
		if( $wgUser->isBlocked() ){
			$wgOut->blockedPage( false );
			return false;
		}
		
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgUserProfileScripts}/UserProfile.css?{$wgStyleVersion}\"/>\n");
		$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgUserProfileScripts}/UpdateProfile.js\"></script>\n");
		
		if($wgRequest->wasPosted()){
			//$section = $wgRequest->getVal("section");
			if(!$section)$section="basic";
			switch($section){
				case "basic":
					$this->saveProfileBasic();
					$this->saveWikiaSettings_basic();
					break;
				case "personal":
					$this->saveProfilePersonal();
					break;
				case "custom":
					$this->saveProfileCustom();
					break;
				case "preferences":
					$this->saveWikiaSettings_pref();
					break;
			}
			
			UserProfile::clearCache( $wgUser->getID() );
			
			$log = new LogPage( wfMsgForContent( 'user-profile-update-profile' ) );
			if( ! $wgUpdateProfileInRecentChanges ){
				$log->updateRecentChanges = false;
			}
			$log->addEntry( wfMsgForContent( 'user-profile-update-profile' ), $wgUser->getUserPage(), wfMsgForContent( 'user-profile-update-log-section' ) . " '{$section}'" );
			$wgOut->addHTML("<span class='profile-on'>" . wfMsgForContent( 'user-profile-update-saved' ) . "</span><br><br>");
			
			//create user page if not exists
			$title = Title::makeTitle( NS_USER, $wgUser->getName() );
			$article = new Article( $title );
			if( !$article->exists() ){
				$article->doEdit( "", "create user page", EDIT_SUPPRESS_RC );
			}
		}
		
			
			//$section = $wgRequest->getVal("section");
			if(!$section)$section="basic";
			switch($section){
				case "basic":
					$wgOut->addHTML($this->displayBasicForm());
				break;
				case "personal":
					$wgOut->addHTML($this->displayPersonalForm());
				break;
				case "custom":
					$wgOut->addHTML($this->displayCustomForm());
				break;
				case "preferences":
					$wgOut->addHTML($this->displayPreferencesForm());
				break;
			}
	}

	function saveWikiaSettings_basic(){
		global $wgUser, $wgOut, $wgRequest, $wgSiteView;
		
		$wgUser->setRealName( $wgRequest->getVal("real_name") );
		$wgUser->setEmail( $wgRequest->getVal("email") );
	
		if($wgUser->getEmail()!=$wgRequest->getVal("email")){
			$wgUser->mEmailAuthenticated = null; # but flag as "dirty" = unauthenticated
		}
		
		if ($wgEmailAuthentication) {
			# Mail a temporary password to the dirty address.
			# User can come back through the confirmation URL to re-enable email.
			$result = $wgUser->sendConfirmationMail();
			if( WikiError::isError( $result ) ) {
				$error = wfMsg( 'mailerror', htmlspecialchars( $result->getMessage() ) );
			} else {
				$error = wfMsg( 'eauthentsent', $wgUser->getName() );
			}
		}
		$wgUser->saveSettings();
	}

	function saveWikiaSettings_pref(){
		global $wgUser, $wgOut, $wgRequest, $wgSiteView, $wgSitename;
		
		$notify_friend = $wgRequest->getVal("notify_friend");
		$notify_gift = $wgRequest->getVal("notify_gift");
		$notify_challenge = $wgRequest->getVal("notify_challenge");
		$notify_honorifics = $wgRequest->getVal("notify_honorifics");
		$notify_message = $wgRequest->getVal("notify_message");
		if($notify_friend=="")$notify_friend = 0;
		if($notify_gift == "")$notify_gift = 0;
		if($notify_challenge == "")$notify_challenge = 0;
		if($notify_honorifics == "")$notify_honorifics = 0;
		if($notify_message == "")$notify_message = 0;
		$wgUser->setOption( 'notifygift', $notify_gift );
		$wgUser->setOption( 'notifyfriendrequest', $notify_friend );
		$wgUser->setOption( 'notifychallenge', $notify_challenge );
		$wgUser->setOption( 'notifyhonorifics', $notify_honorifics );
		$wgUser->setOption( 'notifymessage', $notify_message );
		$wgUser->saveSettings();
		
		if($wgSitename=="ArmchairGM"){
			$dbr =& wfGetDB( DB_MASTER );
			if($wgRequest->getVal("weeklyemail")==1){
				$s = $dbr->selectRow( '`user_mailing_list`', array( 'um_user_id' ), array( 'um_user_id' => $wgUser->getID()  ), $fname );
				if ( $s === false ){
					$dbr->insert( '`user_mailing_list`',
					array(
						'um_user_id' => $wgUser->getID(),
						'um_user_name' => $wgUser->getName(),
						), $fname
					);
				}
			}else{
				$sql = "DELETE from user_mailing_list where um_user_id = {$wgUser->getID()}";
				$res = $dbr->query($sql);
			}
		}
	}
	
	function formatBirthdayDB($birthday){ 
		$dob = explode('/', $birthday);
		if(count($dob) == 2){
			$year = 2007;
			$month = $dob[0];
			$day = $dob[1];
			$birthday_date = $year . "-" . $month . "-" . $day;
		}
		return ($birthday_date);
	}
	
	function formatBirthday($birthday){
		$dob = explode('-', $birthday);
		if(count($dob) == 3){
			$year = 0000;
			$month = $dob[1];
			$day = $dob[2];
			$birthday_date = $month . "/" . $day; // . "/" . $year;
		}
		return $birthday_date;
	}


	
	function saveProfileBasic(){
		global $wgUser, $wgMemc, $wgRequest, $wgSitename;

		$this->initProfile();
		$dbw =& wfGetDB( DB_MASTER );
			$dbw->update( '`user_profile`',
			array( /* SET */
				'up_location_city' => $wgRequest->getVal("location_city"),
				'up_location_state' => $wgRequest->getVal("location_state"),
				'up_location_country' => $wgRequest->getVal("location_country"),
				
				'up_hometown_city' => $wgRequest->getVal("hometown_city"),
				'up_hometown_state' => $wgRequest->getVal("hometown_state"),
				'up_hometown_country' => $wgRequest->getVal("hometown_country"),
				
				'up_birthday' => $this->formatBirthdayDB($wgRequest->getVal("birthday")),
				'up_about' => $wgRequest->getVal("about"),
				'up_occupation' => $wgRequest->getVal("occupation"),
				'up_schools' => $wgRequest->getVal("schools"),
				'up_places_lived' => $wgRequest->getVal("places"),
				'up_websites' => $wgRequest->getVal("websites"),
				'up_relationship' => $wgRequest->getVal("relationship")
			), array( /* WHERE */
				'up_user_id' => $wgUser->getID()
			), ""
			);
			$dbw->commit();
			
		if($wgSitename == "Wikia Blackbird"){
			$enroll = $wgRequest->getVal("enroll");
			if($enroll=="")$enroll = 0;
			$wgUser->setOption( 'blackbirdenroll', $enroll );
			$wgUser->saveSettings();
		}

	}

	function saveProfileCustom(){
		global $wgUser, $wgMemc, $wgRequest;

		$this->initProfile();
		$dbw =& wfGetDB( DB_MASTER );
			$dbw->update( '`user_profile`',
			array( /* SET */
				'up_custom_1' => $wgRequest->getVal("custom1"),
				'up_custom_2' => $wgRequest->getVal("custom2"),
				'up_custom_3' => $wgRequest->getVal("custom3"),
				'up_custom_4' => $wgRequest->getVal("custom4")
				
			), array( /* WHERE */
				'up_user_id' => $wgUser->getID()
			), ""
			);
			$dbw->commit();

	}
	
	function saveProfilePersonal(){
		global $wgUser, $wgMemc, $wgRequest;

		$this->initProfile();
		$dbw =& wfGetDB( DB_MASTER );
			$dbw->update( '`user_profile`',
			array( /* SET */
				
				'up_companies' => $wgRequest->getVal("companies"),
			
				
				'up_movies' => $wgRequest->getVal("movies"),
				'up_music' => $wgRequest->getVal("music"),
				'up_tv' => $wgRequest->getVal("tv"),
				'up_books' => $wgRequest->getVal("books"),
				'up_magazines' => $wgRequest->getVal("magazines"),
				'up_video_games' => $wgRequest->getVal("videogames"),
				'up_snacks' => $wgRequest->getVal("snacks"),
				'up_drinks' => $wgRequest->getVal("drinks")
			), array( /* WHERE */
				'up_user_id' => $wgUser->getID()
			), ""
			);
			$dbw->commit();
	
	}
	

	function displayBasicForm(){
		global $wgRequest, $wgSiteView, $wgUser;
		
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`user_profile`', 
			array( 
				'up_location_city', 'up_location_state', 'up_location_country',
				'up_hometown_city', 'up_hometown_state', 'up_hometown_country',
				'up_birthday','up_occupation','up_about','up_schools','up_places_lived',
				'up_websites'
			
			),
	
		array( 'up_user_id' => $wgUser->getID() ), "" );

		if ( $s !== false ) {
			$location_city = $s->up_location_city;
			$location_state = $s->up_location_state;
			$location_country = $s->up_location_country;
			$about = $s->up_about;
			$occupation = $s->up_occupation;
			$hometown_city = $s->up_hometown_city;
			$hometown_state = $s->up_hometown_state;
			$hometown_country = $s->up_hometown_country;
			$birthday = $this->formatBirthday($s->up_birthday);
			$schools = $s->up_schools;
			$places = $s->up_places_lived;
			$websites = $s->up_websites;
		
		}
		if(!$location_country)$location_country = wfMsgForContent( 'user-profile-default-country' );
		if(!$hometown_country)$hometown_country = wfMsgForContent( 'user-profile-default-country' );
		
		$s = $dbr->selectRow( 'user', 
			array( 
				'user_real_name', 'user_email', 'user_email_authenticated'
			),
		array( 'user_id' => $wgUser->getID() ), "" );

		if ( $s !== false ) {
			$real_name = $s->user_real_name;
			$email = $s->user_email;
			$old_email = $s->user_email;
			$email_authenticated = $s->user_email_authenticated;
		}
		
		$countries = array("Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Bouvet Island","Brazil","British Indian Ocean Territory","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China","Christmas Island","Cocos Islands","Colombia","Comoros","Congo","Congo, Democratic Republic of the","Cook Islands","Costa Rica","Cote d'Ivoire","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Guiana","French Polynesia","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Heard Island and McDonald Islands","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macao","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Norfolk Island","North Korea","Norway","Oman","Pakistan","Palau","Palestinian Territory","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland","Portugal","Puerto Rico","Qatar","Romania","Russian Federation","Rwanda","Saint Helena","Saint Kitts and Nevis","Saint Lucia","Saint Pierre and Miquelon","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia and Montenegro","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia","South Korea","Spain","Sri Lanka","Sudan","Suriname","Svalbard and Jan Mayen","Swaziland","Sweden","Switzerland","Syrian Arab Republic","Taiwan","Tajikistan","Tanzania","Thailand","Timor-Leste","Togo","Tokelau","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","United States Minor Outlying Islands","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands, British","Virgin Islands, U.S.","Wallis and Futuna","Western Sahara","Yemen","Zambia","Zimbabwe");



		
		$form =  '<h1>'.wfMsg('edit-profile-title').'</h1>';
		
		$form .= UserProfile::getEditProfileNav( wfMsg( 'user-profile-section-personal' ) );
		
		$form .= '<form action="" method=post enctype="multipart/form-data" name=profile>';
		
		$form .= '<div class="profile-info clearfix">';
		
		
		$form .= '<div class="profile-update">
			<p class="profile-update-title">' . wfMsgForContent( 'user-profile-personal-info' ) . '</p>
			<p class="profile-update-unit-left">' . wfMsgForContent( 'user-profile-personal-name' ) . '</p>
			<p class="profile-update-unit"><input type="text" size="25" name="real_name" id="real_name" value="'. $real_name . '"/></p>
			<div class="cleared"></div>
			<p class="profile-update-unit-left">' . wfMsgForContent( 'user-profile-personal-email' ) . '</p>
			<p class="profile-update-unit"><input type="text" size="25" name="email" id="email" value="'. $email . '"/>';
			if(!$wgUser->mEmailAuthenticated){
				$confirm = Title::makeTitle( NS_SPECIAL  , "Confirmemail"  );
				$form .= " <a href=\"{$confirm->getFullURL()}\">" . wfMsgForContent( 'user-profile-personal-confirmemail' ) . "</a>";
			}
			$form .= '</p>
			<div class="cleared"></div>';
			if(!$wgUser->mEmailAuthenticated){
				$form  .= '<p class="profile-update-unit-left"></p><p class="profile-update-unit-small">(your e-mail needs to be authenticated to receive site notifications)</p>';
			}
			$form .='</p>
			<div class="cleared"></div>
		</div>
		<div class="cleared"></div>';
		
		
		
		$form .= '<div class="profile-update">
			<p class="profile-update-title">' . wfMsgForContent( 'user-profile-personal-location' ) . '</p>
			<p class="profile-update-unit-left">' . wfMsgForContent( 'user-profile-personal-city' ) . '</p>
			<p class="profile-update-unit"><input type="text" size="25" name="location_city" id="location_city" value="'. $location_city . '"/></p>
			<div class="cleared"></div>
			<p class="profile-update-unit-left" id="location_state_label">' . wfMsgForContent( 'user-profile-personal-country' ) . '</p>';
			$form .= '<p class="profile-update-unit">';
			$form .= '<span id="location_state_form">';
			$form .= "</span>
				<script>
					displaySection(\"location_state\",\"" . $location_country . "\",\"" . $location_state . "\")
				</script>";
			$form .= "<select name=\"location_country\" id=\"location_country\" onChange=displaySection('location_state',this.value,'')><option></option>";

		for ($i=0;$i<count($countries);$i++) {
			$form .= "<option value=\"{$countries[$i]}\" " . (($countries[$i] == $location_country)?'selected':'') . ">";
			$form .= $countries[$i] . "</option>";
		} 

		$form .=  "</select>";
			$form .= '</p>
			<div class="cleared"></div>
		</div>
		<div class="cleared"></div>';
		
		$form .= '<div class="profile-update">
			<p class="profile-update-title">' . wfMsgForContent( 'user-profile-personal-hometown' ) . '</p>
			<p class="profile-update-unit-left">' . wfMsgForContent( 'user-profile-personal-city' ) . '</p>
			<p class="profile-update-unit"><input type="text" size="25" name="hometown_city" id="hometown_city" value="'. $hometown_city . '"/></p>
			<div class="cleared"></div>
			<p class="profile-update-unit-left" id="hometown_state_label">' . wfMsgForContent( 'user-profile-personal-country' ) . '</p>
			<p class="profile-update-unit">';
			$form .= '<span id="hometown_state_form">';
			$form .= "</span>
				<script>
					displaySection(\"hometown_state\",\"" . $hometown_country . "\",\"" . $hometown_state . "\")
				</script>";
				$form .= "<select name=\"hometown_country\" id=\"hometown_country\" onChange=displaySection('hometown_state',this.value,'')><option></option>";

				for($i=0;$i<count($countries);$i++) {
					$form .= "<option value=\"{$countries[$i]}\" " . (($countries[$i] == $hometown_country)?'selected':'') . ">";
					$form .= $countries[$i] . "</option>";
				}	 

			$form .=  "</select>";
			$form .= '</p>
			<div class="cleared"></div>
			
					
		</div>
		<div class="cleared"></div>';
		
		$form .= '<div class="profile-update">
			<p class="profile-update-title">' . wfMsgForContent( 'user-profile-personal-birthday' ) . '</p>
			<p class="profile-update-unit-left">' . wfMsgForContent( 'user-profile-personal-birthdate' ) . '</p>
			<p class="profile-update-unit"><input type="text" size="25" name="birthday" id="birthday" value="'. $birthday . '"/></p>
			<div class="cleared"></div>
		</div><div class="cleared"></div>';
		
		$form .= "<div class=\"profile-update\">
			<p class=\"profile-update-title\">" . wfMsgForContent( 'user-profile-personal-aboutme' ) . "</p>
			<p class=\"profile-update-unit-left\">" . wfMsgForContent( 'user-profile-personal-aboutme' ) . "</p>
			<p class=\"profile-update-unit\">
				<textarea name=\"about\" id=\"about\" rows=\"3\" cols=\"75\">{$about}</textarea>
			</p>
			<div class=\"cleared\"></div>
		</div>
		<div class=\"cleared\"></div>	
			
		<div class=\"profile-update\">
			<p class=\"profile-update-title\">" . wfMsgForContent( 'user-profile-personal-work' ) . "</p>
			<p class=\"profile-update-unit-left\">" . wfMsgForContent( 'user-profile-personal-occupation' ) . "</p>
			<p class=\"profile-update-unit\">
				<textarea name=\"occupation\" id=\"occupation\" rows=\"2\" cols=\"75\">{$occupation}</textarea>
			</p>
			<div class=\"cleared\"></div>
		</div>
		<div class=\"cleared\"></div>
				
		<div class=\"profile-update\">
			<p class=\"profile-update-title\">" . wfMsgForContent( 'user-profile-personal-education' ) . "</p>
			<p class=\"profile-update-unit-left\">" . wfMsgForContent( 'user-profile-personal-schools' ) . "</p>
			<p class=\"profile-update-unit\">
				<textarea name=\"schools\" id=\"schools\" rows=\"2\" cols=\"75\">{$schools}</textarea>
			</p>
			<div class=\"cleared\"></div>
		</div>
		<div class=\"cleared\"></div>
				
		<div class=\"profile-update\">
			<p class=\"profile-update-title\">" . wfMsgForContent( 'user-profile-personal-places' ) . "</p>
			<p class=\"profile-update-unit-left\">" . wfMsgForContent( 'user-profile-personal-placeslived' ) . "</p>
			<p class=\"profile-update-unit\">
				<textarea name=\"places\" id=\"places\" rows=\"3\" cols=\"75\">{$places}</textarea>
			</p>
			<div class=\"cleared\"></div>
		</div>
		<div class=\"cleared\"></div>	
			
		<div class=\"profile-update\">
			<p class=\"profile-update-title\">" . wfMsgForContent( 'user-profile-personal-web' ) . "</p>
			<p class=\"profile-update-unit-left\">" . wfMsgForContent( 'user-profile-personal-websites' ) . "</p>
			<p class=\"profile-update-unit\">
				<textarea name=\"websites\" id=\"websites\" rows=\"2\" cols=\"75\">{$websites}</textarea>
			</p>
			<div class=\"cleared\"></div>
		</div>		
		<div class=\"cleared\"></div>";
				
		$form .= '
			<input type="button" class="site-button" value="' . wfMsgForContent('user-profile-update-button') . '" size="20" onclick=document.profile.submit() />
			</form>';
		
		$form .= "</div>";
	
			return $form;
	}
	
	function displayPersonalForm(){
		global $wgRequest, $wgSiteView, $wgUser, $wgOut;
	
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`user_profile`', 
			array( 
				'up_about', 'up_places_lived', 'up_websites','up_relationship',
				'up_occupation', 'up_companies', 'up_schools','up_movies','up_tv', 'up_music',
				'up_books','up_video_games','up_magazines','up_snacks','up_drinks'
			
			),
	
		array( 'up_user_id' => $wgUser->getID() ), "" );

		if ( $s !== false ) {
			
			 $places = $s->up_places_lived;
			 $websites = $s->up_websites;
			 $relationship = $s->up_relationship;

			 $companies = $s->up_companies;
			 $schools = $s->up_schools;
			 $movies = $s->up_movies;
			 $tv = $s->up_tv;
			 $music = $s->up_music;
			 $books = $s->up_books;
			 $videogames = $s->up_video_games;
			 $magazines = $s->up_magazines;
			 $snacks = $s->up_snacks;
			 $drinks = $s->up_drinks;
		}
		
		$wgOut->setHTMLTitle( wfMsg('pagetitle', wfMsg('user-profile-section-interests')));
		$form =  '<h1>'.wfMsg('user-profile-section-interests').'</h1>';
		
		$form .= UserProfile::getEditProfileNav( wfMsg( 'user-profile-section-interests' ) );
		
		
		$form .= "<form action=\"\" method=post enctype=\"multipart/form-data\" name=\"profile\"> 
			<div class=\"profile-info clearfix\">";
		
				$form .= "<div class=\"profile-update\">
					<p class=\"profile-update-title\">" . wfMsgForContent( 'user-profile-interests-entertainment' ) . "</p>
					<p class=\"profile-update-unit-left\">" . wfMsgForContent( 'user-profile-interests-movies' ) . "</p>
					<p class=\"profile-update-unit\">
						<textarea name=\"movies\" id=\"movies\" rows=\"3\" cols=\"75\">{$movies}</textarea>
					</p>
					<div class=\"cleared\"></div>
					<p class=\"profile-update-unit-left\">" . wfMsgForContent( 'user-profile-interests-tv' ) . "</p>
					<p class=\"profile-update-unit\">
						<textarea name=\"tv\" id=\"tv\" rows=\"3\" cols=\"75\">{$tv}</textarea>
						</p>
					<div class=\"cleared\"></div>
					<p class=\"profile-update-unit-left\">" . wfMsgForContent( 'user-profile-interests-music' ) . "</p>
					<p class=\"profile-update-unit\">
						<textarea name=\"music\" id=\"music\" rows=\"3\" cols=\"75\">{$music}</textarea>
					</p>
					<div class=\"cleared\"></div>
					<p class=\"profile-update-unit-left\">" . wfMsgForContent( 'user-profile-interests-books' ) . "</p>
					<p class=\"profile-update-unit\">
						<textarea name=\"books\" id=\"books\" rows=\"3\" cols=\"75\">{$books}</textarea>
					</p>
					<div class=\"cleared\"></div>
					<p class=\"profile-update-unit-left\">" . wfMsgForContent( 'user-profile-interests-magazines' ) . "</p>
					<p class=\"profile-update-unit\">
						<textarea name=\"magazines\" id=\"magazines\" rows=\"3\" cols=\"75\">{$magazines}</textarea>
					</p>
					<div class=\"cleared\"></div>
					<p class=\"profile-update-unit-left\">" . wfMsgForContent( 'user-profile-interests-videogames' ) . "</p>
					<p class=\"profile-update-unit\">
						<textarea name=\"videogames\" id=\"videogames\" rows=\"3\" cols=\"75\">{$videogames}</textarea>
					</p>
					<div class=\"cleared\"></div>	
				</div>
				
				<div class=\"profile-info clearfix\">
					<p class=\"profile-update-title\">" . wfMsgForContent( 'user-profile-interests-eats' ) . "</p>
					<p class=\"profile-update-unit-left\">" . wfMsgForContent( 'user-profile-interests-foodsnacks' ) . "</p>
					<p class=\"profile-update-unit\">
						<textarea name=\"snacks\" id=\"snacks\" rows=\"3\" cols=\"75\">{$snacks}</textarea>
					</p>
					<div class=\"cleared\"></div>
					<p class=\"profile-update-unit-left\">" . wfMsgForContent( 'user-profile-interests-drinks' ) . "</p>
					<p class=\"profile-update-unit\">
						<textarea name=\"drinks\" id=\"drinks\" rows=\"3\" cols=\"75\">{$drinks}</textarea>
					</p>
					<div class=\"cleared\"></div>
				</div>
				<input type=\"button\" class=\"site-button\" value=\"Update\" size=\"20\" onclick=document.profile.submit() />
		</div>
		</form>
		"
		 ;
		
		
	
		return $form;
	}
	
	
	function displayPreferencesForm(){
		global $wgRequest, $wgSiteView, $wgUser, $wgOut;
		
		$wgOut->setHTMLTitle( wfMsg('pagetitle', wfMsg('user-profile-section-preferences')));
		$form =  '<h1>'.wfMsg('user-profile-section-preferences').'</h1>';
		
		$form .= UserProfile::getEditProfileNav( wfMsg( 'user-profile-section-preferences' ) );
		
		$form .= '<form action="" method=post enctype="multipart/form-data" name=profile>';
		
		$form .= '<div class="profile-info clearfix">
			<div class="profile-update">
				<p class="profile-update-title">' . wfMsgForContent( 'user-profile-preferences-emails' ) . '</p>
				<p class="profile-update-row">
					' . wfMsgForContent( 'user-profile-preferences-emails-personalmessage' ) . ' <input type="checkbox" size="25" name="notify_message" id="notify_message" value="1"' . (($wgUser->getIntOption( 'notifymessage',1 ) == 1)?'checked':'') . '/>
				</p>
				<p class="profile-update-row">
					' . wfMsgForContent( 'user-profile-preferences-emails-friendfoe' ) . ' <input type="checkbox" size="25" class="createbox" name="notify_friend" id="notify_friend" value="1" ' . (($wgUser->getIntOption( 'notifyfriendrequest',1) == 1)?'checked':'') . '/>
				</p>
				<p class="profile-update-row">
					' . wfMsgForContent( 'user-profile-preferences-emails-gift' ) . ' <input type="checkbox" size="25" name="notify_gift" id="notify_gift" value="1" ' . (($wgUser->getIntOption( 'notifygift',1 ) == 1)?'checked':'') . '/>
				</p>
			
				<p class="profile-update-row">
					' . wfMsgForContent( 'user-profile-preferences-emails-level' ) . ' <input type="checkbox" size="25" name="notify_honorifics" id="notify_honorifics" value="1"' . (($wgUser->getIntOption( 'notifyhonorifics',1 ) == 1)?'checked':'') . '/>
				</p>';
				if($wgSitename == "ArmchairGM"){
					$subscribed = 0;
					$dbr =& wfGetDB( DB_MASTER );
					$s = $dbr->selectRow( '`user_mailing_list`', array( 'um_user_id' ), array( 'um_user_id' => $wgUser->getID()  ), $fname );
					if ( $s !== false )$subscribed = 1;	
					$form .= '<p class="profile-update-row">
						' . wfMsgForContent( 'user-profile-preferences-emails-weekly' ) . ' <input type="checkbox" size="25" name="weeklyemail" id="weeklyemail" value="1"' . (($subscribed == 1)?'checked':'') . '/>
					</p>';	
				}
			$form .= '</div>
			<div class="cleared"></div>';
		
		$form .= '<input type="button" class="site-button" value="' . wfMsgForContent('user-profile-update-button') . '" size="20" onclick=document.profile.submit() />
			</form>';
		
		$form .= "</div>";
	
			return $form;
	}
	
	function displayCustomForm(){
		global $wgRequest, $wgSiteView, $wgUser, $wgOut;
	
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`user_profile`', 
			array( 
				'up_custom_1', 'up_custom_2','up_custom_3', 'up_custom_4','up_custom_5'
			
			),
	
		array( 'up_user_id' => $wgUser->getID() ), "" );

		if ( $s !== false ) {
			 $custom1 = $s->up_custom_1;
			 $custom2 = $s->up_custom_2;
			 $custom3 = $s->up_custom_3;
			 $custom4 = $s->up_custom_4;
			
		}
		$wgOut->setHTMLTitle( wfMsg('pagetitle', wfMsg('user-profile-tidbits-title')));
		$form =  '<h1>'.wfMsg('user-profile-tidbits-title').'</h1>';
		
		$form .= UserProfile::getEditProfileNav( wfMsg( 'user-profile-section-custom' ) );
		
		$form .= "<form action=\"\" method=post enctype=\"multipart/form-data\" name=\"profile\"> 
			<div class=\"profile-info clearfix\">
				<div class=\"profile-update\">
					<p class=\"profile-update-title\">" . wfMsgForContent( 'user-profile-tidbits-title' ) . "</p>
					<p class=\"profile-update-unit-left\">" . wfMsgForContent( 'custom-info-field1' ) . "</p>
					<p class=\"profile-update-unit\">
						<textarea name=\"custom1\" id=\"fav_moment\" rows=\"3\" cols=\"75\">{$custom1}</textarea>
					</p>
					<div class=\"cleared\"></div>
					<p class=\"profile-update-unit-left\">" . wfMsgForContent( 'custom-info-field2' ) . "</p>
					<p class=\"profile-update-unit\">
						<textarea name=\"custom2\" id=\"least_moment\" rows=\"3\" cols=\"75\">{$custom2}</textarea>
					</p>
					<div class=\"cleared\"></div>
					<p class=\"profile-update-unit-left\">" . wfMsgForContent( 'custom-info-field3' ) . "</p>
					<p class=\"profile-update-unit\">
						<textarea name=\"custom3\" id=\"fav_athlete\" rows=\"3\" cols=\"75\">{$custom3}</textarea>
					</p>
					<div class=\"cleared\"></div>
					<p class=\"profile-update-unit-left\">" . wfMsgForContent( 'custom-info-field4' ) . "</p>
					<p class=\"profile-update-unit\">
						<textarea name=\"custom4\" id=\"least_fav_athlete\" rows=\"3\" cols=\"75\">{$custom4}</textarea>
					</p>
					<div class=\"cleared\"></div>
				</div>
			<input type=\"button\" class=\"site-button\" value=\"Update\" size=\"20\" onclick=document.profile.submit() />
		</div>
		</form>
		"
		 ;
		
		
	
		return $form;
	}
}


?>
