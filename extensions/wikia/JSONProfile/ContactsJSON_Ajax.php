<?php

function WikiaSearch_GetContactsAsUsers( $contacts ){
	global $wgUser, $wgMemc;
	
	$dbr =& wfGetDB( DB_SLAVE );
	
	$rel = new UserRelationship($wgUser->getName() );
	$current_friends = $rel->getAllRelationships();
	$awaiting_requests = $rel->getAwaitingRequests();
	
	$users = array();
	$users["users"] = array();
	
	$key = wfMemcKey( 'user', 'emails' );
	$email_table = $wgMemc->get( $key );
	$mem = 1;
	
	if( !is_array( $email_table ) ){
		$res = $dbr->select( '`wikicities`.user INNER JOIN user_profile on up_user_id = user_id', 
			array('user_email','user_id', 'user_name', 'user_real_name'),
			"" , __METHOD__, 
			"");
			
		$email_table = array();
		while ($row = $dbr->fetchObject( $res ) ) {
			if( $row->user_email ){
				$email_table[ $row->user_email ][] = array( 
					"user_id" => $row->user_id,
					"user_name" => $row->user_name,
					"user_real_name" => $row->user_real_name,
				);
			}
		}
		$mem = 0;
		$wgMemc->set( $key, $email_table,  60 * 60 * 6 );
	}
	
	foreach( $contacts as $contact ){
		
		if( !$email_table[ $contact["email"] ] ) continue;
		 
		foreach( $email_table[ $contact["email"] ] as $user ){
			 
			if( in_array( $user["user_id"] , $awaiting_requests ) ) continue; //already sent a request
			if( $user["user_id"] == $wgUser->getID() ) continue; //Its (not) you!!
			if( array_key_exists( $user["user_id"], $current_friends )) continue; //not your current friend
			
			$photo = new ProfilePhoto( $user["user_id"]  );
			$users["users"][] = array( 
					"user_id" => $user["user_id"],
					"user_name" => $user["user_name"],
					"user_real_name" => $user["user_real_name"],
					"user_image" => $photo->getProfileImageURL("m"),
					"user_email" => $contact["email"],
					"user_email_name" => $contact["name"],
			);
			
		}
	}
	
	return $users;
}

$wgAjaxExportList [] = 'wfInitContactsEmail';
function wfInitContactsEmail( $callback="populateEmail"){
	global $wgUser;
	$_SESSION["contact_login"] = "";
	$email = array();
	if( $wgUser->isLoggedIn() ){
		$email_address = $wgUser->getEmail();
		$email_parts = split("@",$email_address);
		$email["user_name"] =  $email_parts[0];  
		$email["domain"] = $email_parts[1];
		$email["address"] = $email_address;
	}
	return "var user_email=" . jsonify($email) . ";\n\nparent.{$callback}(user_email);";
	
}

$wgAjaxExportList [] = 'wfDoGetContactsJSON';
function wfDoGetContactsJSON( $callback="renderContacts" ){
	global $IP;
	
	$contact_login_info = $_SESSION["contact_login_info"];
	if( is_array( $contact_login_info ) ){
		$username = $contact_login_info["username"];
		$password = $contact_login_info["password"];
		$type = $contact_login_info["type"];
		//$_SESSION["contact_login_info"] = "";
	}
	
	//check sesssion
	$contact_login = $_SESSION["contact_login"];
	if( is_array( $contact_login ) ){
		$username = $contact_login["username"];
		$password = $contact_login["password"];
		$type = $contact_login["type"];
		$_SESSION["contact_login"] = "";
	}/*else{
	//get from post
		$username = $_POST['email'];
		$password = $_POST['password'];
		$type = $_POST['type'];
	}*/
		
	if(!isset( $username ) || !isset( $password )  ) {
		return "no";
	}
	
	require_once ( "$IP/extensions/wikia/WikiContacts/WikiContacts.php" );
	
	if( WikiContacts::isLiveService( $type ) ){
		$contacts = class_exists( 'WikiContacts' ) ? WikiContacts::fetchMS( @$_COOKIE["delauthtoken"] ) : array();
	}else{
		$contacts = class_exists( 'WikiContacts' ) ? WikiContacts::fetch( $type, $username, $password ) : array();
	}
	
	if ( $contacts === false ) {
		$contacts_json["error"] = 1;
		$contacts_json["error_message"] = "Your login information in incorrect.  Please try again.";
	}
	
	$contacts_json["type"] = $type;
	$contacts_json["contacts"] = $contacts;
	return "var json_contacts=" . jsonify($contacts_json) . ";\n\n{$callback}(json_contacts);";
	//return "<script type=\"text/javascript\">var json_contacts=" . jsonify($contacts_json) . ";\n\nparent.{$callback}(json_contacts);</script>";
}

$wgAjaxExportList [] = 'wfDoSendContactsEmailJSON';
function wfDoSendContactsEmailJSON( $emails, $callback="send_finish"){
	global $wgUser;
	
	//$emails = $_POST["emails"];
	if( !$emails )return "no";
	
	$dbw = wfGetDB( DB_MASTER );
	
	$emails_sent = 0;
	$email_array = explode(",", $emails);
	foreach( $email_array as $email ){
		if( $email ){
			$email = trim( $email );
			
			$your_name = (($wgUser->getRealName())? $wgUser->getRealName():$wgUser->getName());
			$subject = wfMsg( 'invite_subject', $your_name );
			$body = wfMsg( 'invite_body', $your_name );
			
			$dbw->begin();
			$dbw->insert(
				wfSharedTable("send_queue"),
				array(
					'que_ip'      => wfGetIP(),
					'que_to'      => $email,
					'que_from'    => "search@wikia.com",
					'que_name'    => $email,
					'que_user'    => $wgUser->getName(),
					'que_subject' => $subject,
					'que_body'    => $body,
				),
				__METHOD__
			);
			$dbw->commit();	
			$emails_sent++;
		}
		
	}
	return "{$callback}({$emails_sent})";
	//return "<script type=\"text/javascript\">parent.{$callback}({$emails_sent});</script>";
}

$wgAjaxExportList [] = 'wfDoContactsLogin';
function wfDoContactsLogin( ){
	$username = $_POST['email'];
	$password = $_POST['password'];
	$type = $_POST['type'];
	$from = $_POST['wpSourceForm'];
	
	//store in session for later import
	$_SESSION["contact_login_info"] = array(
		"username" => $username,
		"password" => $password,
		"type" => $type
	);
	return "<script type=\"text/javascript\">\n\nlocation.href='{$from}?loggedin=1';</script>";
}

$wgAjaxExportList [] = 'wfDoGetContactsAsUsersJSON';
function wfDoGetContactsAsUsersJSON( $callback="renderContacts"){
	global $IP, $wgUser, $wgMemc;
	
	$contact_login_info = $_SESSION["contact_login_info"];
	if( is_array( $contact_login_info ) ){
		$username = $contact_login_info["username"];
		$password = $contact_login_info["password"];
		$type = $contact_login_info["type"];
		$_SESSION["contact_login_info"] = "";
	}
	
	/*
	$username = $_POST['email'];
	$password = $_POST['password'];
	$type = $_POST['type'];
	*/
	
	if(!isset($username ) || !isset($password)  ) {
		return "no";
	}
	
	require_once ( "$IP/extensions/wikia/WikiContacts/WikiContacts.php" );
	

	
	//store in session for later import
	$_SESSION["contact_login"] = array(
		"username" => $username,
		"password" => $password,
		"type" => $type
	);
	
	if( WikiContacts::isLiveService( $type ) ){
		$contacts = class_exists( 'WikiContacts' ) ? WikiContacts::fetchMS( @$_COOKIE["delauthtoken"] ) : array();
	}else{
		$contacts = class_exists( 'WikiContacts' ) ? WikiContacts::fetch( $type, $username, $password ) : array();
	}
	if ( $contacts === false ) {
		$users["error"] = 1;
		$users["error_message"] = "Your login information in incorrect.  Please try again.";
		return "json_contacts=" . jsonify($users) . ";\n\n{$callback}(json_contacts);";
		//return "<script type=\"text/javascript\">json_contacts=" . jsonify($users) . ";\n\nparent.{$callback}(json_contacts);</script>";
	}
	
	$users = WikiaSearch_GetContactsAsUsers( $contacts );

	$users["type"] = $type;
	
	return "json_contacts=" . jsonify($users) . ";\n\nparent.{$callback}(json_contacts)";
	//return "<script type=\"text/javascript\">json_contacts=" . jsonify($users) . ";\n\nparent.{$callback}(json_contacts);</script>";
}

$wgAjaxExportList [] = 'wfDoSendContactsFriendRequestJSON';
function wfDoSendContactsFriendRequestJSON( $userids, $callback="send_finish"){
	global $wgUser, $wgMemc;
	
	//$userids = $_POST["userids"];
	if( !$userids )return "no";
	
	$rel = new UserRelationship($wgUser->getName() );
	
	$req_sent = 0;
	$userids_array = explode(",", $userids);
	
	foreach( $userids_array as $user_id ){
		
		$user_id = trim( $user_id );
		
		if( $user_id > 0 ){
			
			$user = User::newFromId( $user_id );
			$user->loadFromId();
			
			$rel->addRelationshipRequest($user->getName(),1,"",true,3);
			 
			$key = wfMemcKey( 'user', 'profile', 'notifupdated', $user_id );
			$wgMemc->set($key,false);
			
			$req_sent++;
		}
		
	}
	return "{$callback}({$req_sent})";
	//return "<script type=\"text/javascript\">parent.{$callback}({$req_sent});</script>";
}

$wgAjaxExportList [] = 'wfDoContactsUploadCSV';
function wfDoContactsUploadCSV( ){
	global $wgRequest, $wgUser, $wgUploadDirectory;
	if( $wgRequest->wasPosted() ){
		$file = $wgRequest->getFileTempname( 'ufile' );
		move_uploaded_file( $file, $wgUploadDirectory . "/" . $wgUser->getID() . "-tmp-csv" );
		
		$file = $wgUploadDirectory . "/" . $wgUser->getID() . "-tmp-csv";
		$_SESSION["contact_login_info"] = array(
			"file" => $file,
			"type" => "csv"
		);
		$from = $_POST['csvSourceForm'];
		if( $_POST['upload_csv'] == 2 ){
			$_SESSION["contacts_upload_csv"] = $file;
		}
		return "<script type=\"text/javascript\">\n\nlocation.href='{$from}?csvupload=1';</script>";
	}
}

$wgAjaxExportList [] = 'wfDoGetContactsCSVJSON';
function wfDoGetContactsCSVJSON( $callback="renderContacts"){
	global $wgRequest;
	$contacts_json["type"] = "csv";
	
	//first check uploaded file
	$contact_login_info = $_SESSION["contact_login_info"];
	if( is_array( $contact_login_info ) ){
		$file = $contact_login_info["file"];
		$_SESSION["contact_login_info"] = "";
	}
	
	//check if uploaded from finder on reg
	if( $_SESSION["contacts_upload_csv"] ){
		$file = $_SESSION["contacts_upload_csv"];
		$_SESSION["contacts_upload_csv"] = "";
	}

	if( $file ){
		$contacts_json["contacts"] = WikiaSearch_getContactsCSV( $file );
		unlink( $file );
		return "var json_contacts=" . jsonify($contacts_json) . ";\n\nparent.{$callback}(json_contacts)";
	}else{
		$contacts_json["error"] = 1;
		$contacts_json["error_message"] = "Upload failed.  Please try again.";
	}
	return "void(0)";
}

$wgAjaxExportList [] = 'wfDoGetContactsAsUsersCSVJSON';
function wfDoGetContactsAsUsersCSVJSON( $callback="renderContacts" ){
	global $wgRequest;

	//first check uploaded file
	$contact_login_info = $_SESSION["contact_login_info"];
	if( is_array( $contact_login_info ) ){
		$file = $contact_login_info["file"];
		$_SESSION["contact_login_info"] = "";
	}
	
	if( !$file ){
		$contacts_json["error"] = 1;
		$contacts_json["error_message"] = "Upload failed.  Please try again.";
	}else{
		$contacts = WikiaSearch_getContactsCSV( $file );
		$users = WikiaSearch_GetContactsAsUsers( $contacts );
		$users["type"] = "csv";
		return "json_contacts=" . jsonify($users) . ";\n\nparent.{$callback}(json_contacts);";
	
	}
	
	return "void(0)";
}

function WikiaSearch_getContactsCSV( $file ){
	$addresses = array();
	if( !$file ) return $addresses;
	if( !is_file($file) ) return false;
	
	$fp = fopen ($file,"r");
	
	$delim = ",";
	
	while (!feof($fp)){
	    $line = trim( fgets( $fp ), "\r\n" );
	    $fields = array();
	    $fldCount = 0;
	    $inQuotes = false;
		    
	    for ($i = 0; $i < mb_strlen($line); $i++) {
		if (!isset($fields[$fldCount])) $fields[$fldCount] = "";
		$tmp = mb_substr($line, $i, mb_strlen($delim));
		if ($tmp === $delim && !$inQuotes) {
		    $fldCount++;
		    $i+= mb_strlen($delim) - 1;
		}
		else if ($fields[$fldCount] == "" && mb_substr($line, $i, 1) == '"' && !$inQuotes) {
		    if (!$removeQuotes) $fields[$fldCount] .= mb_substr($line, $i, 1);
		    $inQuotes = true;
		} 
		else if (mb_substr($line, $i, 1) == '"') {
		    if (mb_substr($line, $i+1, 1) == '"') {
			$i++;
			$fields[$fldCount] .= mb_substr($line, $i, 1);
		    } else {
			if (!$removeQuotes) $fields[$fldCount] .= mb_substr($line, $i, 1);
			$inQuotes = false;
		    }
		}
		else {
		    $fields[$fldCount] .= mb_substr($line, $i, 1);
		}
	    }
	    $data = $fields;
		//try outlook
		if( strpos( $data[57], "@" ) !== false ){
			$email = $data[57];
			if (!empty($dataname) && $data[3] ) {
				$dataname = $data[1] . " " . $data[3];
			}
			if (empty($dataname)) {
				$dataname = $data[3];
			}
		}
		//outlook express
		if( strpos( $data[1], "@" ) !== false ){
			$email = $data[1];
			$dataname = $data[0];
		}
		//thunderbird
		if( strpos( $data[4], "@" ) !== false ){
			$email = $data[4];
			$dataname = $data[2];
			if (empty($dataname) && ($data[0] || $data[1])) {
				$dataname = $data[0] . " " . $data[1];
			}				
		}
			
		if (empty($dataname)) {
			$dataname = $email;
		}
		if (!empty($email) ) {  //Skip table if email is blank
			$addresses[] = array("name"=>$dataname,"email"=>$email);
		}
	}
	// jeff added
	fclose($fp);
	return $addresses;
}

function WikiaSearch_fgetcsv( &$fp, $delim = ',', $removeQuotes = true )
{
    if( !$fp ) return false;
    if( !is_file($fp) ) return false;
    echo "get";
    exit();
    $line = trim( fgets( $fp ), "\r\n" );
    $fields = array();
    $fldCount = 0;
    $inQuotes = false;
	    
    for ($i = 0; $i < mb_strlen($line); $i++) {
	if (!isset($fields[$fldCount])) $fields[$fldCount] = "";
	$tmp = mb_substr($line, $i, mb_strlen($delim));
	if ($tmp === $delim && !$inQuotes) {
	    $fldCount++;
	    $i+= mb_strlen($delim) - 1;
	}
	else if ($fields[$fldCount] == "" && mb_substr($line, $i, 1) == '"' && !$inQuotes) {
	    if (!$removeQuotes) $fields[$fldCount] .= mb_substr($line, $i, 1);
	    $inQuotes = true;
	} 
	else if (mb_substr($line, $i, 1) == '"') {
	    if (mb_substr($line, $i+1, 1) == '"') {
		$i++;
		$fields[$fldCount] .= mb_substr($line, $i, 1);
	    } else {
		if (!$removeQuotes) $fields[$fldCount] .= mb_substr($line, $i, 1);
		$inQuotes = false;
	    }
	}
	else {
	    $fields[$fldCount] .= mb_substr($line, $i, 1);
	}
    }
    return $fields;
}

$wgAjaxExportList [] = 'wfGetYahooSignInUrl';
function wfGetYahooSignInUrl( $url  ){
	
	global $wgYahooAPISecret, $wgYahooAPIAppid;
	//$url = $url . "?appid=" . $wgYahooAPIAppid; 
	$parts = parse_url( $url );
	
	$ts = time();
	$relative_uri = "";
	if ( isset( $parts["path"] ) ){
		$relative_uri .= $parts["path"];
	}
	if ( isset ( $parts["query" ] ) ) {
		$relative_uri .= "?" . $parts["query"] . "&ts=$ts";
	}
	
	$sig = md5( $relative_uri . $wgYahooAPISecret );
	
	$signed_url = $parts["scheme"] . "://" .  $parts["host"] . $relative_uri . "&sig=$sig";
	
	return "window.open('{$signed_url}', \"\", \"width=760px,height=560,left=100,top=100,scrollbars=yes, location=yes\")";
	
}
?>
