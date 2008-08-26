<?php

/**
 *
DROP TABLE IF EXISTS `user_welcome_track`;
CREATE TABLE `user_welcome_track` (
  `uw_id` int(10) unsigned NOT NULL auto_increment,
  `uw_from_id` int(10) unsigned NOT NULL default '0',
  `uw_to_id` int(10) unsigned NOT NULL default '0',
  `uw_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`uw_id`,`uw_from_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
 */

$wgAvailableRights[] = 'massmessage';
$wgGroupPermissions['staff']['massmessage'] = true;
$wgGroupPermissions['sysop']['massmessage'] = true;
$wgGroupPermissions['janitor']['massmessage'] = true;
$wgGroupPermissions['user']['massmessage'] = false;

$wgAjaxExportList [] = 'wfGetNewUsersJSON';
$wgAjaxExportList [] = 'wfMessageUsersJSON';

function wfMessageUsersJSON(){
	global $IP, $wgMemc, $wgUser, $wgRequest;
	
	$dbr =& wfGetDB( DB_MASTER );
	
	if( !$wgUser->isAllowed("massmessage") ){
		return "<script language=\"javascript\">alert(\"You do not have permission to send messages!\");</script>";
	}
	
	$message = $wgRequest->getVal("message");
	$ids = explode(",", $wgRequest->getVal("ids"));
	$url = $wgRequest->getVal("return_to");
	
	$query = "INSERT INTO user_welcome_track (uw_from_id, uw_to_id, uw_date) VALUES ";
	$now = date("Y-m-d H:i:s");
        
	foreach($ids as $i){
		try{
			$query .= "( '" . $wgUser->getId() . "', '" . $i . "', '" . $now . "' ),";
			$b = new UserBoard();
			$m = $b->sendBoardMessage($wgUser->getID(), $wgUser->getName(), $i, User::whoIs($i), urldecode($message), 0);
		}catch(Exception  $e){
			return "<script language=\"javascript\">location.href='" . $url . "?error=1'</script>";
		}
			
	}
	
	$query = trim($query, ",");
	
	$insert = $dbr->query($query);
	$dbr->commit();

	return "<script language=\"javascript\">location.href='" . $url . "?error=0'</script>";
}

function wfGetNewUsersJSON($page){
	global $IP, $wgMemc, $wgUser, $wgRequest;
	
	$PER_PAGE = 300;
	
	if( !$wgUser->isLoggedIn() ){
		return "\$('new-users-table').innerHTML ='<h1>Permissions Error!</h1><h3>You need to <a href=\"login.html?return=' + location.href + '\">login</a> to use this page.</h3>'";
	}
	
	if( !$wgUser->isAllowed("massmessage") ){
		return "\$('new-users-table').innerHTML ='<h1>Permissions Error!</h1> <h3>Using this page requiers special privledges.</h3>'";
	}
	
	$offset = is_numeric($page) ? ($page * $PER_PAGE) : 0;

	$dbr =& wfGetDB( DB_SLAVE );
	
	$script = "var tableData='<table id=\"new-users-data\">" . 
		  		  "<tr id=\"new-users-row\">" . 
				  "<th>Select</th>" .
				  "<th>User ID</th>" . 
				  "<th>User Name</th>" . 
				  "<th>Join Date</th>" .
				  "<th>Links</th>" .
				  "</tr>";

	//' boo jedit
	
	$query = "SELECT * FROM user_register_track 
			WHERE ur_user_id 
			IN (SELECT uw_to_id 
				FROM user_welcome_track 
				WHERE uw_from_id={$wgUser->getId()} 
				ORDER BY uw_to_id DESC) 
			ORDER BY ur_user_id DESC
			LIMIT {$offset}, {$PER_PAGE}";
		 
	$hasMsgIds = array();
	$hasMsg = "";
	$i = 0;
	
	$hasMessage = $dbr->query($query);
	while ($row = $dbr->fetchObject( $hasMessage ) ) {
		$hasMsg .= "<tr style=\"background-color: #cccccc\" id=\"new-users-row\">" . 
		"<td><input type = \"checkbox\" id= \"selectedUser[{$i}]\" name= \"selectedUser[{$i}]\" value = \"{$row->ur_user_id}\"></td>" .
			    	"<td>" . $row->ur_user_id . "</td>" . 
				"<td>" . $row->ur_user_name . "</td>" . 
				"<td>" . $row->ur_date . "</td>" .
				"<td><a href=\"profile.html?user={$row->ur_user_name}\">Profile</a> | <a href=\"board.html?user={$row->ur_user_name}\">Wall</a> | <a href=\"activity.html?user={$row->ur_user_name}\">Activity</a></td>" .
			    "</tr>";
		
		$hasMsgIds[] = $row->ur_user_id;
		$i++;
	}

	$query = "SELECT * FROM user_register_track 
			WHERE ur_user_id NOT IN
				(SELECT uw_to_id 
					FROM user_welcome_track 
					WHERE uw_from_id={$wgUser->getId()} 
					ORDER BY uw_to_id DESC) 
			ORDER BY ur_user_id DESC
			LIMIT {$offset}, {$PER_PAGE}";
	
	
	$noMsgIdStart = $i;
	$res = $dbr->query($query);
	while ($row = $dbr->fetchObject( $res ) ) {
		
		$script .= "<tr id=\"new-users-row\">" . 
		"<td><input type = \"checkbox\" id= \"selectedUser[{$i}]\" name= \"selectedUser[{$i}]\" value = \"{$row->ur_user_id}\"></td>" .
			    	"<td>" . $row->ur_user_id . "</td>" . 
				"<td>" . $row->ur_user_name . "</td>" . 
				"<td>" . $row->ur_date . "</td>" .
				"<td><a href=\"profile.html?user={$row->ur_user_name}\">Profile</a> | <a href=\"board.html?user={$row->ur_user_name}\">Wall</a> | <a href=\"activity.html?user={$row->ur_user_name}\">Activity</a></td>" .
			    "</tr>";
		$i++;
	}
	$noMsgIdEnd = $i;
	
	// build the pager
	$hasq = "SELECT COUNT(*) as mycount FROM user_register_track 
			WHERE ur_user_id IN (SELECT ub_user_id 
			FROM user_board WHERE ub_user_id_from={$wgUser->getId()} 
			ORDER BY ub_id DESC) 
			ORDER BY ur_user_id DESC";
	$res = $dbr->query($hasq);
	$row = $dbr->fetchObject( $res );
	$hasCount = $row->mycount;
	
	$hasq = "SELECT COUNT(*) as mycount FROM user_register_track 
			WHERE ur_user_id NOT IN (SELECT ub_user_id 
			FROM user_board WHERE ub_user_id_from={$wgUser->getId()} 
			ORDER BY ub_id DESC) 
			ORDER BY ur_user_id DESC";
	$res = $dbr->query($hasq);
	$row = $dbr->fetchObject( $res );
	$notCount = $row->mycount;
	
	$totalUsers = ($hasCount > $notCount) ? $hasCount : $notCount;
	$max = ceil( $totalUsers / $PER_PAGE);
	$pager = "<div id=\"new-users-pager\" name=\"new-users-pager\"> ";
	
	if($max > 1){
		for($i=0; $i < $max; $i++){
			if($i == $page){
				$pager .= "{$i}";
			}else{
				$pager .= "<a href=\"?page={$i}\">{$i}</a>";
			}
		
			if($i < $max-1){
				$pager .= " - ";
			}
	}
	
	}
	$pager .= "</div>";
	
	$script .= $hasMsg . "</table>';";
	
	// build the javascript out
	$script .= "function selectNoMsgUsers(){";	
	
	for($i=$noMsgIdStart; $i<$noMsgIdEnd; $i++){
		$script .= "\$('selectedUser[{$i}]').checked = true;";
	}
	
	$script .= "}
		var pager='" . $pager . "';";
	$script .= "loadTableData(tableData, pager);";
	
	return $script;
}

?>
