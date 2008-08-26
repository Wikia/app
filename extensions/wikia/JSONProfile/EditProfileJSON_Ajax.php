<?php

$wgAjaxExportList [] = 'wfGetProfileSectionJSON';
function wfGetProfileSectionJSON($section=false, $callback="showProfileSection"){
	global $wgUser, $wgOut, $IP, $wgMessageCache, $wgRequest, $wgSiteView;
	
	require_once("$IP/extensions/wikia/UserProfile_NY/UserProfileClass.php");
	
	require_once( "$IP/extensions/wikia/JSONProfile/JSON.php" );
	$json = new Services_JSON();
	$rel_JSON_array = array();
	
	$rel_JSON_array["page_title"] = wfMsg('edit-profile-title');
	
	if( !$wgUser->isLoggedIn() ) {
		$rel_JSON_array["error"] = 1;
		$rel_JSON_array["page_title"] = wfMsgForContent( 'user-profile-update-notloggedin-title' );
		$rel_JSON_array["status_message"] = wfMsgForContent(  'user-profile-update-notloggedin-text',  "login.html", "register.html" );
		return "var json_rel=" . $json->encode($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
	}
	
	/*
	if( $wgUser->isBlocked() ){
		$wgOut->blockedPage( false );
		return false;
	}
	*/
	
	$rel_JSON_array["page_title"] = wfMsg('edit-profile-title');
	if(!$section)$section="basic";
	$section = strtolower($section);
	switch($section){
		case "basic":
			$rel_JSON_array["sections"] = getBasicFormInfoJSON();
			$rel_JSON_array["page_title"] = wfMsg('edit-profile-title');
			$rel_JSON_array["tabs"] = getEditProfileNav( wfMsg('edit-profile-title') );
			
			//$form .= UserProfile::getEditProfileNav( wfMsg( 'user-profile-section-personal' ) );
			
		break;
		case "personal":
			$rel_JSON_array["sections"] = getPersonalFormInfoJSON();
			$rel_JSON_array["page_title"] = wfMsg('user-profile-section-interests');
			$rel_JSON_array["tabs"] = getEditProfileNav( wfMsg('user-profile-section-interests') );
		break;
		case "custom":
			$rel_JSON_array["sections"] = getCustomFormInfoJSON();
			$rel_JSON_array["page_title"] = wfMsg('user-profile-tidbits-title');
			$rel_JSON_array["tabs"] = getEditProfileNav( wfMsg('user-profile-tidbits-title') );
		break;
		case "preferences":
			$rel_JSON_array["sections"] = getPreferencesFormInfoJSON();
			$rel_JSON_array["page_title"] = wfMsg('user-profile-section-preferences');
			$rel_JSON_array["tabs"] = getEditProfileNav( wfMsg('user-profile-section-preferences') );
		break;
		case "work":
			$rel_JSON_array["sections"] = getWorkFormInfoJSON();
			$rel_JSON_array["page_title"] = wfMsg('user-profile-section-work');
			$rel_JSON_array["tabs"] = getEditProfileNav( wfMsg('user-profile-section-work') );
		break;
		case "privacy":
			$rel_JSON_array["sections"] = getPrivacyFormInfoJSON();
			$rel_JSON_array["page_title"] = wfMsg('user-profile-section-privacy');
			$rel_JSON_array["tabs"] = getEditProfileNav( wfMsg('user-profile-section-privacy') );
		break;
		case "education":
			$rel_JSON_array["sections"] = getEducationFormInfoJSON();
			$rel_JSON_array["page_title"] = wfMsg('user-profile-education');
			$rel_JSON_array["tabs"] = getEditProfileNav( wfMsg('user-profile-education') );
		break;
	}
	
	//$rel_JSON_array["submit_button"] = array("class"=>"site-button","value"=>wfMsgForContent('user-profile-update-button'),"size"=>"20","onclick"=>"doSubmit(json_rel);");
	$rel_JSON_array["submit_button"] = array("cssclass"=>"site-button","value"=>wfMsgForContent('user-profile-update-button'),"size"=>"20","onclick"=>"doSubmit(json_rel);");
	
	return "var json_rel=" . $json->encode($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
	
	
}

function getPrivacyFormInfoJSON($extra=0){
	
	global $wgUser;
	
	$checks = ProfilePrivacy::$privacy_checks;
	$types = ProfilePrivacy::$privacy_types;
	
	$current_privacy = ProfilePrivacy::getPrivacyList( $wgUser->getName() );
	
	foreach( $checks as $check_id => $check_name ){
		$this_section=array();
		$this_section["header"] = "";
		$this_section["scripts"] = array();
		$select = "<select name=\"check-{$check_id}\" id=\"check-{$check_id}\">";
		if($current_privacy[$check_name]=="") $current_privacy[$check_name]="Everyone";
		foreach($types as $type_id => $type_name ){
			$select .= "<option value=\"{$type_id}\" " . (( $current_privacy[$check_name]==$type_name)?"selected":"") . ">{$type_name}</option>";
		}
		$select .= "</select> " . wfMsg("privacy_" . strtolower($check_name) );
		
		$this_section["items"][] = array(
			"type"=>"text",
			"field"=> "check-{$check_id}",
			"content"=>$select
		);
		$sections[] = $this_section;
	}
	
	return $sections;
}

function getWorkFormInfoJSON($extra=0){
	global $wgUser, $wgRequest;
	
	$u = new UserProfile( $wgUser->getName() );
	$profile_data = $u->getProfile();
	
	$sections=array();
	$x = 0;
	
	
	$profile_data["work"][] = array();

	foreach( $profile_data["work"] as $job ){
		
		$this_section=array();
		$sub_section=array();
		
		$countries = array("Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Bouvet Island","Brazil","British Indian Ocean Territory","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China","Christmas Island","Cocos Islands","Colombia","Comoros","Congo","Congo, Democratic Republic of the","Cook Islands","Costa Rica","Cote d'Ivoire","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Guiana","French Polynesia","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Heard Island and McDonald Islands","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macao","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Norfolk Island","North Korea","Norway","Oman","Pakistan","Palau","Palestinian Territory","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland","Portugal","Puerto Rico","Qatar","Romania","Russian Federation","Rwanda","Saint Helena","Saint Kitts and Nevis","Saint Lucia","Saint Pierre and Miquelon","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia and Montenegro","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia","South Korea","Spain","Sri Lanka","Sudan","Suriname","Svalbard and Jan Mayen","Swaziland","Sweden","Switzerland","Syrian Arab Republic","Taiwan","Tajikistan","Tanzania","Thailand","Timor-Leste","Togo","Tokelau","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","United States Minor Outlying Islands","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands, British","Virgin Islands, U.S.","Wallis and Futuna","Western Sahara","Yemen","Zambia","Zimbabwe");
		if( !$job["country"] ){
			$job["country"] = wfMsgForContent( 'user-profile-default-country' );
		}
		
		
		$header_text = (($x==0)?wfMsg('latest-employer'):wfMsg('previous-employer')) . ($job["id"] ? " <a href=\"javascript:delete_job({$job["id"]});\" class=\"education-delete\">Delete</a>" :  "");
				
		$this_section["header"] = $header_text;
		$this_section["id"] = "work-section-{$job["id"]}";	
		$this_section["items"] = array();
		$this_section["scripts"] = array();

		if( $x == 0 ){
			$this_section["items"][] = array(
			"type"=>"text",
			"field"=> "numberofjobs",
			"content"=>"<input type=hidden id=numberofjobs value=\"" . count($profile_data["work"]) . "\">",
			"params"=>array("type"=>"hidden","size"=>"25","name"=>"wnumberofjobs","id"=>"numberofjobs","value"=>count($profile_data["work"])),
			);
		}
		
		$this_section["items"][] = array(
			"type"=>"field",
			"name"=> "Employer",
			"tag"=>"input",
			"params"=>array("type"=>"text","size"=>"25","name"=>"work-{$x}-employer","id"=>"work-{$x}-employer","value"=>$job["employer"]),
		);
		$this_section["items"][] = array(
			"type"=>"field",
			"name"=> "Position",
			"tag"=>"input",
			"params"=>array("type"=>"text","size"=>"25","name"=>"work-{$x}-position","id"=>"work-{$x}-position","value"=>$job["position"]),
		);
		$this_section["items"][] = array(
			"type"=>"field",
			"name"=> "Description",
			"tag"=>"textarea",
			"value"=>$job["description"],
			"params"=>array("type"=>"text","size"=>"25","name"=>"work-{$x}-desc","id"=>"work-{$x}-desc"),
		);

	
		$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'user-profile-personal-city' ),
				"tag"=>"input",
				"params"=>array("type"=>"text","size"=>"25","name"=>"work-{$x}-city","id"=>"work-{$x}-city","value"=>$job["city"]),
		);
		$sub_section[] = array(
				"type"=>"text",
				"content"=>'<div class="edit-profile-label" id="work-' . $x . '-state_label">' . wfMsgForContent( 'user-profile-personal-country' ) . '</div>',
			);
		$sub_section[] = array(
				"type"=>"text",
				"content"=>'<span id="work-' . $x . '-state_form"></span><script>displaySection("work-' . $x . '-state","' . $job["country"]. '","' . $job["state"] . '");</script>',
				"field"=>"work-{$x}-state",
			);
		$sub_section[] = array(
			"type"=>"field",
			"tag"=>"select",
			"params"=>array("name"=>"work-{$x}-country","id"=>"work-{$x}-country","onChange"=>"displaySection('work-{$x}-state',this.value,'');"),
			"options"=>$countries,
			"selected"=>$job["country"],
		);
		$this_section["items"][] = array(
				"type"=>"group",
				"items"=>$sub_section,
				);
			
				$this_section["scripts"][] = 'displaySection("work-' . $x . '-state","' . $job["country"] . '","' . $job["state"] . '")';
			
			
		$this_section["items"][] = array(
			"type"=>"text",
			"field"=> "work-{$x}-id",
			"content"=>"<input type=hidden id=work-{$x}-id value=\"{$job["id"]}\">",
			"params"=>array("type"=>"hidden","size"=>"25","name"=>"work-{$x}-id","id"=>"work-{$x}-id","value"=>$job["id"]),
		);
		
		$this_section["items"][] = array(
			"type"=>"text",
			"field"=> "work-{$x}-iscurrent",
			"content"=>"<div class=\"current-job\"><input type=checkbox onclick=\"work_end_toggle({$x})\" id=\"work-{$x}-iscurrent\" name=\"work-{$x}-iscurrent\" value=\"1\" " . (($job["is_current"] == 1)?"checked":"") . "> This is my current job</div>",
			"tag"=>"checkbox"
		);

		
		// DATES EMPLOYED
		
		$month_names = array("January","February","March","April","May","June","July","August","September","October","November","December");
   
		
		// START DATE
		
		$month_from_select = "Start Date <div class=\"work-dates\"><select name=\"work-{$x}-from-month\" id=\"work-{$x}-from-month\">";
		$month_from_select .= "<option value=\"\" selected>Month</option>";
		foreach($month_names as $month){
			$month_from_select .= "<option value=\"{$month}\">{$month}</option>";
		}
		$month_from_select .= "</select>";
		
		$year_from_select = "<select name=\"work-{$x}-from-year\" id=\"work-{$x}-from-year\">";
		$year_from_select .= "<option value=\"\" selected>Year</option>";
		for($xy = date("Y",time()); $xy > 1900; $xy--){
		
			$year_from_select .= "<option value=\"{$xy}\">{$xy}</option>";
		}
		$year_from_select .= "</select>";
		
		$this_section["items"][] = array(
			"type"=>"text",
			"field"=> "work-{$x}-from-month",
			"content"=>$month_from_select
		);
		$this_section["items"][] = array(
			"type"=>"text",
			"field"=> "work-{$x}-from-year",
			"content"=>" {$year_from_select}</div>"
		);
		
		//END DATE 
		
		$month_to_select = "<span id=\"work-{$x}-end-container\" " . (($job["is_current"])?"style=\"display:none;\"":"") . ">End Date <div class=\"work-dates\"><select name=\"work-{$x}-to-month\" id=\"work-{$x}-to-month\">";
		$month_to_select .= "<option value=\"\" selected>Month</option>";
		foreach($month_names as $month){
			$month_to_select .= "<option value=\"{$month}\">{$month}</option>";
		}
		$month_to_select .= "</select>";
		
		$year_to_select = "<select name=\"work-{$x}-to-year\" id=\"work-{$x}-to-year\">";
		$year_to_select .= "<option value=\"\" selected>Year</option>";
		for($xy = date("Y",time()); $xy > 1900; $xy--){
		
			$year_to_select .= "<option value=\"{$xy}\">{$xy}</option>";
		}
		$year_to_select .= "</select>";
		
		$this_section["items"][] = array(
			"type"=>"text",
			"field"=> "work-{$x}-to-month",
			"content"=>$month_to_select
		);
		$this_section["items"][] = array(
			"type"=>"text",
			"field"=> "work-{$x}-to-year",
			"content"=>"{$year_to_select}</div>"
		);
		
		$sections[] = $this_section;
		$x++;
	}		
	
	return $sections;
}


function getBasicFormInfoJSON(){
			global $wgRequest, $wgSiteView, $wgUser;
			
			$dbr =& wfGetDB( DB_MASTER );
			$s = $dbr->selectRow( '`user_profile`', 
				array( 
					'up_location_city', 'up_location_state', 'up_location_country',
					'up_hometown_city', 'up_hometown_state', 'up_hometown_country',
					'up_birthday','up_occupation','up_about','up_schools','up_places_lived',
					'up_websites', 'up_gender'
				
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
				//$birthday = UpdateProfile::formatBirthday($s->up_birthday);
				$birthday = formatBirthdayForDropdowns($s->up_birthday);
				$schools = $s->up_schools;
				$places = $s->up_places_lived;
				$websites = $s->up_websites;
				$gender = $s->up_gender;
			
			}
			else {
				$location_city = "";
				$location_state = "";
				$about = "";
				$occupation = "";
				$hometown_city = "";
				$hometown_state = "";
				$birthday = "";
				$schools = "";
				$places = "";
				$websites = "";
				$gender = "";
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
   
			$sections = array();
			
			
			//----------
			$this_section=array();
			$this_section["header"] = wfMsgForContent( 'user-profile-personal-info' );
			
			$this_section["items"] = array();
			$this_section["scripts"] = array();
			
			//parse real name to approximate first/last name
			$name_parts = split(" ", $real_name);
			$first_name = $name_parts[0];
			$last_name = $name_parts[1];
			if( count( $name_parts > 2 ) ){
				for( $x = 2; $x< count( $name_parts ); $x++){
					$last_name .= " " . $name_parts[ $x ];
				}
			}
			
			$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'user-profile-personal-firstname' ),
				"tag"=>"input",
				"params"=>array("type"=>"text","size"=>"25","name"=>"first_name","id"=>"first_name","value"=>$first_name),
			);
			$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'user-profile-personal-lastname' ),
				"tag"=>"input",
				"params"=>array("type"=>"text","size"=>"25","name"=>"last_name","id"=>"last_name","value"=>$last_name),
			);
			$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'user-profile-personal-email' ),
				"tag"=>"input",
				"params"=>array("type"=>"text","size"=>"25","name"=>"email","id"=>"email","value"=>$email),
			);
			if(!$wgUser->mEmailAuthenticated){
				$confirm = Title::makeTitle(NS_SPECIAL, "ConfirmEmail");
				$this_section["items"][] = array(
					"type"=>"text",
					"content"=>"<a href=\"{$confirm->escapeFullURL()}\">" . wfMsgForContent( 'user-profile-personal-confirmemail' ) . "</a>",
				);
				$this_section["items"][] = array(
					"type"=>"text",
					"content"=>'<p class="profile-update-unit-left"></p><p class="profile-update-unit-small">(your e-mail needs to be authenticated to receive site notifications)</p>',
				);
			}
			$this_section["items"][] = array(
					"type"=>"field",
					"name"=>"Gender:",
					"tag"=>"select",
					"params"=>array("name"=>"gender","id"=>"gender"),
					"name_value"=>true,
					"options"=>array("_"=>"Select One","_0"=>"Male","_1"=>"Female"),
					"selected"=>$gender,
				);
			$sections[] = $this_section;
			//----------
			
			
			//----------
			$this_section=array();
			$sub_section = array();
			
			$this_section["header"] = wfMsgForContent( 'user-profile-personal-location' );
			
			$this_section["items"] = array();
			$this_section["scripts"] = array();
			
			$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'user-profile-personal-city' ),
				"tag"=>"input",
				"params"=>array("type"=>"text","size"=>"25","name"=>"location_city","id"=>"location_city","value"=>$location_city),
			);
			$sub_section[] = array(
					"type"=>"text",
					"content"=>'<div class="edit-profile-label" id="location_state_label">' . wfMsgForContent( 'user-profile-personal-country' ) . '</div>',
				);
			$sub_section[] = array(
					"type"=>"text",
					"content"=>'<span id="location_state_form"></span><script>displaySection("location_state","' . $location_country . '","' . $location_state . '");</script>',
					"field"=>"location_state",
				);
			$sub_section[] = array(
				"type"=>"field",
				"tag"=>"select",
				"params"=>array("name"=>"location_country","id"=>"location_country","onChange"=>"displaySection('location_state',this.value,'');"),
				"options"=>$countries,
				"selected"=>$location_country,
			);
			
			$this_section["items"][] = array(
				"type"=>"group",
				"items"=>$sub_section,
				);
			
			$this_section["scripts"][] = 'displaySection("location_state","' . $location_country . '","' . $location_state . '")';
			
			$sections[] = $this_section;
			//----------
			
			
			//----------
			$this_section=array();
			$sub_section = array();
			
			$this_section["header"] = wfMsgForContent( 'user-profile-personal-hometown' );
			
			$this_section["items"] = array();
			$this_section["scripts"] = array();
			
			$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'user-profile-personal-city' ),
				"tag"=>"input",
				"params"=>array("type"=>"text","size"=>"25","name"=>"hometown_city","id"=>"hometown_city","value"=>$hometown_city),
			);
			
			$sub_section[] = array(
					"type"=>"text",
					"content"=>'<div class="edit-profile-label" id="hometown_state_label">' . wfMsgForContent( 'user-profile-personal-country' ) . '</div>',
				);
			
			$sub_section[] = array(
					"type"=>"text",
					"content"=>'<span id="hometown_state_form"></span><script>displaySection("hometown_state","' . $hometown_country . '","' . $hometown_state . '");</script>',
					"field"=>"hometown_state",
				);
				
			$sub_section[] = array(
					"type"=>"extra",
					"id"=>"hometown_state",
				);
				
			$sub_section[] = array(
				"type"=>"field",
				"tag"=>"select",
				"params"=>array("name"=>"hometown_country","id"=>"hometown_country","onChange"=>"displaySection('hometown_state',this.value,'');"),
				"options"=>$countries,
				"selected"=>$hometown_country,
			);
			
			$this_section["items"][] = array(
				"type"=>"group",
				"items"=>$sub_section,
				);
			
			$this_section["scripts"][] = 'displaySection("hometown_state","' . $hometown_country . '","' . $hometown_state . '")';
			
			$sections[] = $this_section;
			//----------
			
			/*
			//----------
			$this_section=array();
			$sub_section = array();
			
			$this_section["header"] = wfMsgForContent( 'user-profile-personal-birthday' );
			
			$this_section["items"] = array();
			$this_section["scripts"] = array();
			
			$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'user-profile-personal-birthdate' ),
				"tag"=>"input",
				"params"=>array("type"=>"text","size"=>"25","name"=>"birthday","id"=>"birthday","value"=>$birthday),
			);
			
			$sections[] = $this_section;
			//----------
			*/
			
			//----------
			$this_section=array();
			$sub_section = array();
			
			$this_section["header"] = wfMsgForContent( 'user-profile-personal-birthday' );
			
			$this_section["items"] = array();
			$this_section["scripts"] = array();
			
			$sub_section[] = array(
					"type"=>"text",
					"content"=>"",
					"field"=>'birthmonth',
				);
			
			$sub_section[] = array(
					"type"=>"text",
					"content"=>"",
					"field"=>"birthyear",
				);
				
			$sub_section[] = array(
					"type"=>"text",
					"content"=>"",
					"field"=>"birthdate",
				);
				
			$sub_section[] = array(
				"type"=>"text",
				"content"=>"<div class=\"edit-profile-label\">" . wfMsgForContent( 'user-profile-personal-birthdate' ) . "</div><span id=\"profile-birthdate\"></span>",
			);
			
			$this_section["items"][] = array(
				"type"=>"group",
				"items"=>$sub_section,
				);
				
				$this_section["scripts"][] = "document.getElementById(\"profile-birthdate\").innerHTML = formDate('birth', 'birth', 5, 1, 1, 1" . ($birthday != "" ? ", {$birthday}" : "") . ");";
			
			$sections[] = $this_section;
			//----------
			
			
			//----------
			$this_section=array();
			$sub_section = array();
			
			$this_section["header"] = wfMsgForContent( 'user-profile-personal-aboutme' );
			
			$this_section["items"] = array();
			$this_section["scripts"] = array();
			
			$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'user-profile-personal-aboutme' ),
				"tag"=>"textarea",
				"params"=>array("name"=>"about","id"=>"about"),
				"value"=>$about,
			);
			
			$sections[] = $this_section;
			//----------
			
			/*
			//----------
			$this_section=array();
			$sub_section = array();
			
			$this_section["header"] = wfMsgForContent( 'user-profile-personal-work' );
			
			$this_section["items"] = array();
			$this_section["scripts"] = array();
			
			$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'user-profile-personal-occupation' ),
				"tag"=>"textarea",
				"params"=>array("name"=>"occupation","id"=>"occupation"),
				"value"=>$occupation,
			);
			
			$sections[] = $this_section;
			//----------
			*/
			
			
			//----------
			//$this_section=array();
			//$sub_section = array();
			
			//$this_section["header"] = wfMsgForContent( 'user-profile-personal-education' );
			
			//$this_section["items"] = array();
			//$this_section["scripts"] = array();
			
			//$this_section["items"][] = array(
				//"type"=>"field",
				//"name"=>wfMsgForContent( 'user-profile-personal-schools' ),
				//"tag"=>"textarea",
				//"params"=>array("name"=>"schools","id"=>"schools"),
				//"value"=>$schools,
			//);
			
			//$sections[] = $this_section;
			//----------
			
			
			//----------
			//$this_section=array();
			//$sub_section = array();
			
			//$this_section["header"] = wfMsgForContent( 'user-profile-personal-places' );
			
			//$this_section["items"] = array();
			//$this_section["scripts"] = array();
			
			//$this_section["items"][] = array(
				//"type"=>"field",
				//"name"=>wfMsgForContent( 'user-profile-personal-placeslived' ),
				//"tag"=>"textarea",
				//"params"=>array("name"=>"places","id"=>"places"),
				//"value"=>$places,
			//);
			
			//$sections[] = $this_section;
			//----------
			
			
			//----------
			//$this_section=array();
			//$sub_section = array();
			
			//$this_section["header"] = wfMsgForContent( 'user-profile-personal-web' );
			
			//$this_section["items"] = array();
			//$this_section["scripts"] = array();
			
			//$this_section["items"][] = array(
				//"type"=>"field",
				//"name"=>wfMsgForContent( 'user-profile-personal-websites' ),
				//"tag"=>"textarea",
				//"params"=>array("name"=>"websites","id"=>"websites"),
				//"value"=>$websites,
			//);
			
			//$sections[] = $this_section;
			//----------
			
			
			return $sections;
			
			/*
			
								
			$form .= '
				<input type="button" class="site-button" value="' . wfMsgForContent('user-profile-update-button') . '" size="20" onclick=document.profile.submit() />
				</form>';
			
			$form .= "</div>";
		
				return $form;
				*/
		}
		
		function getPersonalFormInfoJSON(){
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
			else {
				
				 $places = "";
				 $websites = "";
				 $relationship = "";

				 $companies = "";
				 $schools = "";
				 $movies = "";
				 $tv = "";
				 $music = "";
				 $books = "";
				 $videogames = "";
				 $magazines = "";
				 $snacks = "";
				 $drinks = "";
			}
			
			
			$sections = array();
			
			
			//----------
			$this_section=array();
			$this_section["header"] = wfMsgForContent( 'user-profile-interests-entertainment' );
			
			$this_section["items"] = array();
			$this_section["scripts"] = array();
			
			$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'user-profile-interests-movies' ),
				"tag"=>"textarea",
				"params"=>array("name"=>"movies","id"=>"movies"),
				"value"=>$movies,
			);
			
			$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'user-profile-interests-tv' ),
				"tag"=>"textarea",
				"params"=>array("name"=>"tv","id"=>"tv"),
				"value"=>$tv,
			);
			
			$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'user-profile-interests-music' ),
				"tag"=>"textarea",
				"params"=>array("name"=>"music","id"=>"music"),
				"value"=>$music,
			);
			
			$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'user-profile-interests-books' ),
				"tag"=>"textarea",
				"params"=>array("name"=>"books","id"=>"books"),
				"value"=>$books,
			);
			
			$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'user-profile-interests-magazines' ),
				"tag"=>"textarea",
				"params"=>array("name"=>"magazines","id"=>"magazines"),
				"value"=>$magazines,
			);
			
			$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'user-profile-interests-videogames' ),
				"tag"=>"textarea",
				"params"=>array("name"=>"videogames","id"=>"videogames"),
				"value"=>$videogames,
			);
			
			$sections[] = $this_section;
			//----------
			
			//----------
			$this_section=array();
			$this_section["header"] = wfMsgForContent( 'user-profile-interests-eats' );
			
			$this_section["items"] = array();
			$this_section["scripts"] = array();
			
			$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'user-profile-interests-foodsnacks' ),
				"tag"=>"textarea",
				"params"=>array("name"=>"snacks","id"=>"snacks"),
				"value"=>$snacks,
			);
			
			$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'user-profile-interests-drinks' ),
				"tag"=>"textarea",
				"params"=>array("name"=>"drinks","id"=>"drinks"),
				"value"=>$drinks,
			);
			
			$sections[] = $this_section;
			//----------
			
			return $sections;
		}
		
		function getPreferencesFormInfoJSON(){
			global $wgRequest, $wgSiteView, $wgUser, $wgOut;
			
			$sections = array();
			
			
			//----------
			$this_section=array();
			$this_section["header"] = wfMsgForContent( 'user-profile-preferences-emails' );
			
			$this_section["items"] = array();
			$this_section["scripts"] = array();
			
			$sub_section = array();
			$sub_section[] = array(
				"type"=>"field",
				"tag"=>"input",
				"sameline"=>true,
				"params"=>array("type"=>"checkbox", "size"=>"25", "name"=>"notify_message", "id"=>"notify_message", "value"=>"1"),
				"checked"=>(($wgUser->getIntOption( 'notifymessage',1 ) == 1)?true:false),
			);
			
			$sub_section[] = array(
				"type"=>"text",
				"sameline"=>true,
				"content"=> "<label for=\"notify_message\"> ".wfMsgForContent( 'user-profile-preferences-emails-personalmessage' )."</label>",
			);
			
			$this_section["items"][] = array(
				"type"=>"group",
				"items"=>$sub_section,
			);
				
			$sub_section = array();
			$sub_section[] = array(
				"type"=>"field",
				"tag"=>"input",
				"params"=>array("type"=>"checkbox", "size"=>"25", "name"=>"notify_friend", "id"=>"notify_friend", "value"=>"1"),
				"sameline"=>true,
				"checked"=>(($wgUser->getIntOption( 'notifyfriendrequest',1 ) == 1)?true:false),
			);
			
			$sub_section[] = array(
				"type"=>"text",
				"sameline"=>true,
				"content"=> "<label for=\"notify_friend\"> ".wfMsgForContent( 'user-profile-preferences-emails-friendfoe' )."</label>",
			);
			
			$this_section["items"][] = array(
				"type"=>"group",
				"items"=>$sub_section,
			);
			
			//$this_section["items"][] = array(
				//"type"=>"field",
				//"name"=>wfMsgForContent( 'user-profile-preferences-emails-gift' ),
				//"tag"=>"input",
				//"params"=>array("type"=>"checkbox", "size"=>"25", "name"=>"notify_gift", "id"=>"notify_gift", "value"=>"1"), 
				//"checked"=>(($wgUser->getIntOption( 'notifygift',1 ) == 1)?true:false),
			//);
			
			
			//$this_section["items"][] = array(
				//"type"=>"field",
				//"name"=>wfMsgForContent( 'user-profile-preferences-emails-level' ),
				//"tag"=>"input",
				//"params"=>array("type"=>"checkbox", "size"=>"25", "name"=>"notify_honorifics", "id"=>"notify_honorifics", "value"=>"1"), 
				//"checked"=>(($wgUser->getIntOption( 'notifyhonorifics',1 ) == 1)?true:false),
			//);
			
			$sections[] = $this_section;
			//----------
			
			return $sections;
		}
		
		
		
		function getCustomFormInfoJSON(){
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
			else {
				 $custom1 = "";
				 $custom2 = "";
				 $custom3 = "";
				 $custom4 = "";
				
			}
			
			$sections = array();
			
			
			//----------
			$this_section=array();
			$this_section["header"] = wfMsgForContent( 'user-profile-tidbits-title' );
			
			$this_section["items"] = array();
			$this_section["scripts"] = array();
			
			$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'custom-info-field1' ),
				"tag"=>"textarea",
				"params"=>array("name"=>"custom1","id"=>"custom1"),
				"value"=>$custom1,
			);
			
			$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'custom-info-field2' ),
				"tag"=>"textarea",
				"params"=>array("name"=>"custom2","id"=>"custom2"),
				"value"=>$custom2,
			);
			
			$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'custom-info-field3' ),
				"tag"=>"textarea",
				"params"=>array("name"=>"custom3","id"=>"custom3"),
				"value"=>$custom3,
			);
			
			$this_section["items"][] = array(
				"type"=>"field",
				"name"=>wfMsgForContent( 'custom-info-field4' ),
				"tag"=>"textarea",
				"params"=>array("name"=>"custom4","id"=>"custom4"),
				"value"=>$custom4,
			);
			
			$sections[] = $this_section;
			//----------
			
			return $sections;
		}
		
		function getSchoolsInfo($user_id) {
			global $wgMemc;
			
			$key = wfMemcKey( 'user', 'profile', 'education', $user_id );

			$schools = array();
			$data = $wgMemc->get( $key );
			if( $data ){
				wfDebug( "Cache Hit - Got education list ({$key}) from cache (size: " .sizeof($data). ")\n" );
				$schools = $data;
			}else{
		
				wfDebug( "Cache Miss - Got education list ({$key}) from db\n" );
				$dbr =& wfGetDB( DB_SLAVE );
				$sql = "SELECT q1.*, education_concentration.concentration FROM (SELECT education.education_id, user_id, user_name, education.school_type as school_type_id, education.school_id, school_name, education.attended_for as attended_for_id, classyear, 
					education_schooltype.school_type, education_attendedfor.attended_for, education.degree
				FROM education, education_schooltype, education_attendedfor, education_schools
				WHERE education.user_id={$user_id}  AND 
					education.school_type=education_schooltype.school_type_id AND (education.attended_for=education_attendedfor.attended_for_id OR education.attended_for=0) AND
					education.school_id=education_schools.school_id) AS q1 LEFT OUTER JOIN education_concentration on q1.education_id=education_concentration.education_id
				ORDER BY classyear ASC";
			
			
				$res = $dbr->query($sql);
				
				while($row = $dbr->fetchObject( $res )) {
					$schools[] = array(
						"education_id"=>$row->education_id,
						"user_id"=>$row->user_id,
						"user_name"=>$row->user_name,
						"school_type_id"=>$row->school_type_id,
						"school_type"=>$row->school_type,
						"school_id"=>$row->school_id,
						"school_name"=>$row->school_name,
						"attended_for_id"=>$row->attended_for_id,
						"classyear"=>$row->classyear,
						"concentration_id"=>$row->concentration_id,
						"concentration"=>$row->concentration,
						"attended_for"=>$row->attended_for,
						"degree"=>$row->degree,
						);
				}
				
				$wgMemc->set( $key, $schools );
				
			}
			return $schools;
		}
		
		function getEducationFormInfoJSON(){
			global $wgRequest, $wgSiteView, $wgUser;
			
			$user_id = $wgUser->getId();
			
			$schools = getSchoolsInfo($user_id);
				
			$schools[] = array(
				"education_id"=>0,
				"user_id"=>"",
				"user_name"=>"",
				"school_type_id"=>"",
				"school_type"=>"",
				"school_id"=>"",
				"school_name"=>"",
				"attended_for_id"=>"",
				"classyear"=>"",
				"concentration_id"=>"",
				"concentration"=>"",
				"attended_for"=>"",
				"degree"=>"",
				);
				
			
			$sections = array();

			foreach ($schools as $which_ed=>$ed_info) {
				
				//$count = $which_ed+1;
				
				//----------
				$this_section=array();
				//$this_section["header"] = "School {$count}";
				
				$header_text = ($ed_info["education_id"] ? "{$ed_info["school_name"]} Class of {$ed_info["classyear"]}" . "<a href=\"javascript:delete_education({$ed_info["education_id"]});\" class=\"education-delete\">Delete</a>" :  "Add New School");
				
				$this_section["header"] = $header_text;
				$this_section["id"] = "education-section-{$ed_info["education_id"]}";
				$this_section["items"] = array();
				$this_section["scripts"] = array();
				
				/*
				if ($ed_info["education_id"]) {
					$this_section["items"][] = array(
					"type"=>"text",
					"content"=>"(<a href=\"javascript:delete_education({$ed_info["education_id"]});\">delete this entry</a>)",
				);
				*/
				
				if (!$ed_info["education_id"]) {
					$this_section["items"][] = array(
						"type"=>"field",
						"tag"=>"input",
						"params"=>array("type"=>"hidden","name"=>"ed_changed","id"=>"ed_changed","value"=>""),
					);
					/*
					$this_section["items"][] = array(
						"type"=>"text",
						"content"=>"<script type=\"text/javascript\" src=\"JSON/schoollist.js\"></script>",
					);
					*/
					
				}
				
				
				
				$this_section["items"][] = array(
					"type"=>"field",
					"name"=>"Type of School",
					"tag"=>"select",
					"params"=>array("name"=>"school_type-" . $ed_info["education_id"],"id"=>"school_type-" . $ed_info["education_id"],"onchange"=>"setChanged(" . $ed_info["education_id"] . ");"),
					"name_value"=>true,
					"options"=>array("_1"=>"College/University"),
					"selected"=>$ed_info["school_type"],
				);
				
				
				$sub_section = array();
				
				$sub_section[] = array(
					"type"=>"field",
					"sameline"=>true,
					"tag"=>"input",
					"params"=>array("type"=>"hidden","name"=>"school_id-" . $ed_info["education_id"],"id"=>"school_id-" . $ed_info["education_id"],"value"=>$ed_info["school_id"]),
				);
				
				$sub_section[] = array(
					"type"=>"field",
					"name"=>"School / Class Year<br/>",
					"sameline"=>true,
					"tag"=>"input",
					"params"=>array("type"=>"text","name"=>"school_name-" . $ed_info["education_id"],"id"=>"school_name-" . $ed_info["education_id"],"value"=>$ed_info["school_name"], "onkeyup"=>"lookup_school(this.value, " . $ed_info["education_id"] . ");"),
				);
				
				$sub_section[] = array(
					"type"=>"field",
					"name"=>"&nbsp;",
					"tag"=>"select",
					"sameline"=>true,
					"params"=>array("name"=>"classyear-" . $ed_info["education_id"],"id"=>"classyear-" . $ed_info["education_id"],"onchange"=>"setChanged(" . $ed_info["education_id"] . ");"),
					"options"=>getYearList("Year"),
					"selected"=>$ed_info["classyear"],
				);
				
				
				$this_section["items"][] = array(
						"type"=>"group",
						"items"=>$sub_section,
				);
				
				//$this_section["scripts"][] = "document.getElementById(\"profile-classyear\").innerHTML = formDate('class', 'class', 1, 0, 0, 1" . ($ed_info["classyear"] != "" ? ", " . $ed_info["classyear"] : "") . ");";

				/*
				$this_section["items"][] = array(
					"type"=>"field",
					"name"=>"School:",
					"tag"=>"select",
					"params"=>array("name"=>"school_id-" . $ed_info["education_id"],"id"=>"school_id-" . $ed_info["education_id"],"onchange"=>"setChanged(" . $ed_info["education_id"] . ");"),
					"name_value"=>true,
					"options"=>array("_0"=>"Select One","_1"=>"Rutgers","_2"=>"Wake Forest","_3"=>"Providence","_4"=>"Tufts"),
					"selected"=>$ed_info["school_id"],
				);
				*/
				
				
				
				$this_section["items"][] = array(
					"type"=>"text",
					"content"=>"<div id=\"school_suggest-" . $ed_info["education_id"] . "\" class=\"suggest-container\" style=\"display:none;\"></div>",
				);
				
				$this_section["items"][] = array(
					"type"=>"field",
					"name"=>"Attended For",
					"tag"=>"select",
					"params"=>array("name"=>"attended_for-" . $ed_info["education_id"],"id"=>"attended_for-" . $ed_info["education_id"],"onchange"=>"setChanged(" . $ed_info["education_id"] . ");"),
					"name_value"=>true,
					"options"=>array("_1"=>"Undergraduate","_2"=>"Graduate School"),
					"selected"=>$ed_info["attended_for_id"],
				);
				/*
				$this_section["items"][] = array(
					"type"=>"field",
					"name"=>"Concentration:",
					"tag"=>"select",
					"params"=>array("name"=>"concentration-" . $ed_info["education_id"],"id"=>"concentration-" . $ed_info["education_id"],"onchange"=>"setChanged(" . $ed_info["education_id"] . ");"),
					"options"=>array("Select One","Business","Computer Science","Law"),
					"selected"=>$ed_info["concentration"],
				);
				*/
				
				$this_section["items"][] = array(
					"type"=>"field",
					"name"=>"Concentration",
					"tag"=>"input",
					"params"=>array("type"=>"text","name"=>"concentration-" . $ed_info["education_id"],"id"=>"concentration-" . $ed_info["education_id"],"value"=>$ed_info["concentration"],"onchange"=>"setChanged(" . $ed_info["education_id"] . ");"),
				);
				
				$this_section["items"][] = array(
					"type"=>"field",
					"name"=>"Degree",
					"tag"=>"input",
					"params"=>array("type"=>"text","name"=>"degree-" . $ed_info["education_id"],"id"=>"degree-" . $ed_info["education_id"],"value"=>$ed_info["degree"],"onchange"=>"setChanged(" . $ed_info["education_id"] . ");"),
				);
				
				
				
				$sections[] = $this_section;
				//----------
			}
			
			return $sections;
			
		}

		
$wgAjaxExportList [] = 'wfGenerateSchoolList';
function wfGenerateSchoolList(){
	
	$dbr =& wfGetDB( DB_SLAVE );
	
	$sql = "SELECT * FROM education_schools order by school_id ASC";
	$dbr->query($sql);
	$res = $dbr->query($sql);

	$schools = array();
	//$school_temp_1 = array();
	//$school_temp_2 = array();
	$output = "var schools = new Array();\n";
	while($row = $dbr->fetchObject( $res )) {
		$the_school = $row->school_name;
		$the_school_id = $row->school_id;
		$school_len = (strlen($the_school)<=4 ? strlen($the_school) : 4);
		$check_str = "";
		$temp_array = &$schools;
		for ($i=0; $i<$school_len; $i++) {
			$the_char = strtolower(substr($the_school, $i, 1));
			$check_str .= "[\"{$the_char}\"]";
			if (!is_array($temp_array[$the_char])) {
				$temp_array[$the_char] = array();
				$output .= "schools{$check_str} = new Array();\n";
			}
		
			if($i==($school_len-1)) {
				$temp_array[$the_char][] = $the_school;
				$output .= "schools{$check_str}.push({school_name:\"{$the_school}\",school_id:{$the_school_id}});\n";
			}
			else {
				$temp_array = &$temp_array[$the_char];
			}
		}
		
	}

	return $output;
	
}

$wgAjaxExportList [] = 'wfDeleteWorkSectionJSON';
function wfDeleteWorkSectionJSON($which){
	global $wgUser;
	
	$user_id = $wgUser->getID();
	$dbr =& wfGetDB( DB_MASTER );
	$sql = "DELETE FROM user_profile_work WHERE w_id={$which} and w_user_id={$user_id}";
	$dbr->query($sql);
	$dbr->commit();
	
	UserProfile::clearCache( $wgUser->getID() );
	
	return "\$('work-section-{$which}').toggle();";
	
	
}

$wgAjaxExportList [] = 'wfDeleteEducationSectionJSON';
function wfDeleteEducationSectionJSON($which){
	global $wgUser, $wgMemc;
	
	$user_id = $wgUser->getId();
	$dbr =& wfGetDB( DB_MASTER );
	$sql = "DELETE FROM education WHERE education_id={$which} and user_id={$user_id}";
	$dbr->query($sql);
	$dbr->commit();
	
	$key = wfMemcKey( 'user', 'profile', 'education', $wgUser->getId() );
	$wgMemc->delete($key);
	//return "document.getElementById('education-section-{$which}').innerHTML = 'This Section Has Been Deleted';";
	return "\$('education-section-{$which}').toggle();";
	
	
}
		
$wgAjaxExportList [] = 'wfUpdateProfileJSON';
function wfUpdateProfileJSON(){

	global $wgUser, $wgRequest, $IP, $wgSiteView;
	
	if ($wgUser->isLoggedIn()) {
		require_once("$IP/extensions/wikia/UserProfile_NY/UserProfileClass.php");
		
		if($wgRequest->wasPosted()){
			//$section = $wgRequest->getVal("section");
			$section = $wgRequest->getVal("section");
			if(!$section)$section="basic";
			switch($section){
				case "basic":
					saveProfileBasicJSON();
					saveWikiaSettings_basicJSON();
					$b = new UserBulletin();
					$b->addBulletin($wgUser->getName(),"basic profile","");
					break;
				case "personal":
					saveProfilePersonalJSON();
					$b = new UserBulletin();
					$b->addBulletin($wgUser->getName(),"personal profile","");
					break;
				case "custom":
					saveProfileCustomJSON();
					break;
				case "preferences":
					saveWikiaSettings_prefJSON();
					break;
				case "work":
					saveProfileWorkJSON();
					$b = new UserBulletin();
					$b->addBulletin($wgUser->getName(),"work profile","");
					break;
				case "privacy":
					saveProfilePrivacyJSON();
					break;
				case "education":
					saveProfileEducationJSON();
					break;
			}
			
			UserProfile::clearCache( $wgUser->getID() );
			
			$wpSourceForm = $wgRequest->getVal("wpSourceForm");
			$log = new LogPage( wfMsgForContent( 'user-profile-update-profile' ) );
			$log->addEntry( wfMsgForContent( 'user-profile-update-profile' ), $wgUser->getUserPage(), wfMsgForContent( 'user-profile-update-log-section' ) . " '{$section}'" );
			//$wgOut->addHTML("<span class='profile-on'>" . wfMsgForContent( 'user-profile-update-saved' ) . "</span><br><br>");
			$output = "<script type=\"text/javascript\">location.href='{$wpSourceForm}?profileupdated=1';</script>";
		}

	}
	else {
		$output = "<script type=\"text/javascript\">alert('You are not logged in');\n\nlocation.href='{$wpSourceForm}';</script>";
	}
	
	return $output;
}

function saveWikiaSettings_basicJSON(){
			global $wgUser, $wgOut, $wgRequest, $wgSiteView;
		
			$real_name = trim( $wgRequest->getVal("first_name") ) . " " . trim( $wgRequest->getVal("last_name") );
			$real_name = urldecode($real_name);
			$wgUser->setRealName( $real_name);
			$wgUser->setEmail( urldecode($wgRequest->getVal("email")) );
		
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
		
function saveProfileBasicJSON(){
	global $wgUser, $wgMemc, $wgRequest, $wgSitename;

	UpdateProfile::initProfile();
	$dbw =& wfGetDB( DB_MASTER );
		$dbw->update( '`user_profile`',
		array( /* SET */
			'up_location_city' => urldecode($wgRequest->getVal("location_city")),
			'up_location_state' => urldecode($wgRequest->getVal("location_state")),
			'up_location_country' => urldecode($wgRequest->getVal("location_country")),
			
			'up_hometown_city' => urldecode($wgRequest->getVal("hometown_city")),
			'up_hometown_state' => urldecode($wgRequest->getVal("hometown_state")),
			'up_hometown_country' => urldecode($wgRequest->getVal("hometown_country")),
			
			//'up_birthday' => UpdateProfile::formatBirthdayDB($wgRequest->getVal("birthday")),
			'up_birthday' => formatBirthdayFromDropdowns($wgRequest->getVal("birthyear"), $wgRequest->getVal("birthmonth"), $wgRequest->getVal("birthdate")),
			'up_about' => urldecode($wgRequest->getVal("about")),
			'up_occupation' => urldecode($wgRequest->getVal("occupation")),
			'up_schools' => urldecode($wgRequest->getVal("schools")),
			'up_places_lived' => urldecode($wgRequest->getVal("places")),
			'up_websites' => urldecode($wgRequest->getVal("websites")),
			'up_gender' => urldecode($wgRequest->getVal("gender")),
			//'up_relationship' => $wgRequest->getVal("relationship")
			'up_relationship' => ''
		), array( /* WHERE */
			'up_user_id' => $wgUser->getID()
		), ""
		);
		$dbw->commit();
	
}

function saveProfileEducationJSON(){
	global $wgUser, $wgMemc, $wgRequest, $wgSitename;

	UpdateProfile::initProfile();
	$changed = $wgRequest->getVal("ed_changed");
	$changed = trim($changed);
	$changed = trim($changed,";");
	
	$changed_array = explode(";;", $changed);
	
	foreach($changed_array as $the_change) {
		//if ($wgRequest->getVal("school_id-0")) {
			
		$school_id = $wgRequest->getVal("school_id-{$the_change}");
		$school_type = urldecode($wgRequest->getVal("school_type-{$the_change}"));
		$attended_for = urldecode($wgRequest->getVal("attended_for-{$the_change}"));
		$concentration = urldecode($wgRequest->getVal("concentration-{$the_change}"));
		$classyear = $wgRequest->getVal("classyear-{$the_change}");
		$degree = urldecode($wgRequest->getVal("degree-{$the_change}"));
			
		if ($the_change==="0") {
			if ($school_id) {
				$dbw =& wfGetDB( DB_MASTER );
					$dbw->insert( '`education`',
					array( /* SET */
						'school_id' => $school_id,
						'school_type' => $school_type,
						'attended_for' => $attended_for,
						//'concentration_id' => $concentration_id,
						'classyear' => $classyear,
						'user_name' => $wgUser->getName(),
						'user_id' => $wgUser->getId(),
						'degree' => $degree,
					), __METHOD__
					);
					$insert_id = mysql_insert_id();
					$dbw->commit();
					if ($concentration != "Select One") {
						$dbw->insert( '`education_concentration`',
						array( /* SET */
							'education_id' => $insert_id,
							'concentration' => $concentration,
						), __METHOD__
						);
						$dbw->commit();
					}
			}
		}
		else {
			$dbw =& wfGetDB( DB_MASTER );
			$dbw->update( '`education`',
				array( /* SET */
					'school_id' => $school_id,
					'school_type' => $school_type,
					'attended_for' => $attended_for,
					//'concentration_id' => $concentration_id,
					'classyear' => $classyear,
					'user_name' => $wgUser->getName(),
					'user_id' => $wgUser->getId(),
					'degree' => $degree,
				), array( /* WHERE */
					'education_id' => $the_change,
				), __METHOD__
			);
			$dbw->commit();
			if ($concentration != "Select One") {
				$dbw->update( '`education_concentration`',
				array( /* SET */
					'concentration' => $concentration,
				), array( /* WHERE */
					'education_id' => $the_change,
				), __METHOD__
			);
			$dbw->commit();
			}
		}
	}
	
	
	$key = wfMemcKey( 'user', 'profile', 'education', $wgUser->getID() );
	$wgMemc->delete($key);
}


function saveProfilePrivacyJSON(){
	global $wgUser, $wgMemc, $wgRequest, $wgSitename;
	
	$checks = ProfilePrivacy::$privacy_checks;
	
	foreach( $checks as $check_id => $check_name ){
		$p = new ProfilePrivacy();
		$p->setPrivacy( $check_id, $wgRequest->getVal("check-{$check_id}") );
	}
}

function saveProfileWorkJSON(){
	global $wgUser, $wgMemc, $wgRequest, $wgSitename;

	$dbw =& wfGetDB( DB_MASTER );
	
	$month_names = array(   "January" => 1,"February" => 2,"March" => 3,"April" => 4,"May" => 5 ,"June" => 6,
				"July" => 7,"August" => 8,"September" => 9,"October" => 10,"November" => 11,"December" => 12);
			
	
	$number_of_jobs = $wgRequest->getVal("numberofjobs");
	if( !$number_of_jobs)$number_of_jobs = 0;
	
	for($x = 0;$x<=$number_of_jobs;$x++){
		
		if( $wgRequest->getVal("work-{$x}-employer") ){
			
			if( $wgRequest->getVal("work-{$x}-from-year") ){
				$from_year = $wgRequest->getVal("work-{$x}-from-year");
			}else{
				$from_year = "0000";
			}
			if( $wgRequest->getVal("work-{$x}-to-year") ){
				$to_year = $wgRequest->getVal("work-{$x}-to-year");
			}else{
				$to_year = "0000";
			}
			
			$start = $from_year . "-" . $month_names [ $wgRequest->getVal("work-{$x}-from-month") ] . "-1";
			$end = $to_year . "-" . $month_names [ $wgRequest->getVal("work-{$x}-to-month") ] . "-1";
			
			if( $wgRequest->getVal("work-{$x}-id") > 0 ){
				$dbw->update( '`user_profile_work`',
					array( /* SET */
						'w_employer' => urldecode($wgRequest->getVal("work-{$x}-employer")),
						'w_position' => urldecode($wgRequest->getVal("work-{$x}-position")),
						'w_description' => urldecode($wgRequest->getVal("work-{$x}-desc")),
						'w_location_city' => urldecode($wgRequest->getVal("work-{$x}-city")),
						'w_location_state' => urldecode($wgRequest->getVal("work-{$x}-state")),
						'w_location_country' => urldecode($wgRequest->getVal("work-{$x}-country")),
						'w_is_current' => $wgRequest->getVal("work-{$x}-iscurrent"),
						'w_emp_from' => $start,
						'w_emp_to' => $end,
					), array( /* WHERE */
						'w_user_id' => $wgUser->getID(),
						'w_id' => $wgRequest->getVal("work-{$x}-id")
					), __METHOD__
				);
				$dbw->commit();
			}else{
				
				$dbw->insert( '`user_profile_work`',
					array(
						'w_user_name' => $wgUser->getName(),
						'w_user_id' => $wgUser->getID(),
						'w_employer' => urldecode($wgRequest->getVal("work-{$x}-employer")),
						'w_position' => urldecode($wgRequest->getVal("work-{$x}-position")),
						'w_description' => urldecode($wgRequest->getVal("work-{$x}-desc")),
						'w_location_city' => urldecode($wgRequest->getVal("work-{$x}-city")),
						'w_location_state' => urldecode($wgRequest->getVal("work-{$x}-state")),
						'w_location_country' => urldecode($wgRequest->getVal("work-{$x}-country")),
						'w_is_current' => $wgRequest->getVal("work-{$x}-iscurrent"),
						'w_emp_from' => $start,
						'w_emp_to' => $end,
					), __METHOD__
				);
				$dbw->commit();
			}
		}
		
	
		
	}

}

function saveWikiaSettings_prefJSON(){
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
		
		function saveProfilePersonalJSON(){
			global $wgUser, $wgMemc, $wgRequest;

			UpdateProfile::initProfile();
			$dbw =& wfGetDB( DB_MASTER );
				$dbw->update( '`user_profile`',
				array( /* SET */
					
					'up_companies' => urldecode($wgRequest->getVal("companies")),
				
					
					'up_movies' => urldecode($wgRequest->getVal("movies")),
					'up_music' => urldecode($wgRequest->getVal("music")),
					'up_tv' => urldecode($wgRequest->getVal("tv")),
					'up_books' => urldecode($wgRequest->getVal("books")),
					'up_magazines' => urldecode($wgRequest->getVal("magazines")),
					'up_video_games' => urldecode($wgRequest->getVal("videogames")),
					'up_snacks' => urldecode($wgRequest->getVal("snacks")),
					'up_drinks' => urldecode($wgRequest->getVal("drinks"))
				), array( /* WHERE */
					'up_user_id' => $wgUser->getID()
				), ""
				);
				$dbw->commit();
		}
		
		function saveProfileCustomJSON(){
			global $wgUser, $wgMemc, $wgRequest;

			UpdateProfile::initProfile();
			$dbw =& wfGetDB( DB_MASTER );
				$dbw->update( '`user_profile`',
				array( /* SET */
					'up_custom_1' => urldecode($wgRequest->getVal("custom1")),
					'up_custom_2' => urldecode($wgRequest->getVal("custom2")),
					'up_custom_3' => urldecode($wgRequest->getVal("custom3")),
					'up_custom_4' => urldecode($wgRequest->getVal("custom4"))
					
				), array( /* WHERE */
					'up_user_id' => $wgUser->getID()
				), ""
				);
				$dbw->commit();

		}
		
	function getEditProfileNav( $current_nav ){
		$lines = explode( "\n", wfMsg( 'update_profile_nav_json' ) );
		//$output = "<div class=\"profile-tab-bar\">";
		
		$tabs = array();
		
		
		
		foreach ($lines as $line) {
			
			if (strpos($line,'*') !== 0) {
				continue;
			} else {
				$line = explode( '|' , trim($line, '* '), 2 );
				$page = $line[0];
				$link_text = $line[1];
				
				$tabs[] = array("text"=>$link_text,"url"=>$page,"cssclass"=>"profile-tab" . (($current_nav==$link_text)?"-on":""));
			}
		}
		
		return $tabs;
	}

	function formatBirthdayFromDropdowns($year, $month, $day){ 
		if($year == "") $year = "1900";
		if($month == "") $month = "01";
		if($day == "") $day = "01";
		$birthday_date = $year . "-" . $month . "-" . $day;
		return ($birthday_date);
	}
	
	function formatBirthdayForDropdowns($birthday){
		$bday = explode(" ", $birthday);
		if (sizeof($bday)) {
			$dob = explode('-', $bday[0]);
			if(count($dob) == 3){
				$year = $dob[0];
				$month = $dob[1];
				$day = $dob[2];
				//$birthday_date = $month . "/" . $day; // . "/" . $year;
				$birthday_date = "{month:{$month}, day:{$day}, year:{$year}}";
			}
		}
		else {
			$birthday_date = "";
		}
		return $birthday_date;
	}
	function getYearList($title = false) {
		$years = array();
		if ($title) $years[] = $title;
		$current_year = intval(date("Y"));
		for ($i=$current_year; $i>=1900; $i--) $years[] = $i;
		
		return $years;
	}
?>
