<?php
$wgExtensionFunctions[] = 'wfUserBoardReadLang';

//read in localisation messages
function wfUserBoardReadLang(){
	require_once( "UserBoard.i18n.php" );
	# Add messages
	global $wgMessageCache;
	foreach( $wgUserBoardMessages as $key => $value ) {
		$wgMessageCache->addMessages( $wgUserBoardMessages[$key], $key );
	}
}

$wgUserBoard = true;

$wgAutoloadClasses['BoardBlast'] = "{$wgUserBoardDirectory}/SpecialSendBoardBlast.php";
$wgSpecialPages['SendBoardBlast'] = 'BoardBlast';

$wgAutoloadClasses['ViewUserBoard'] = "{$wgUserBoardDirectory}/SpecialUserBoard.php";
$wgSpecialPages['UserBoard'] = 'ViewUserBoard';
$wgSpecialPageGroups['UserBoard'] = 'users';

require_once( "{$wgUserBoardDirectory}/UserBoard_AjaxFunctions.php" );
	
$wgAutoloadClasses["UserBoard"] = "{$wgUserBoardDirectory}/UserBoardClass.php";
$wgUserProfileDisplay['board'] = true;

$wgHooks['UserRename::Local'][] = "UserBoardUserRenameLocal";

function UserBoardUserRenameLocal( $dbw, $uid, $oldusername, $newusername, $process, $cityId, &$tasks ) {
	$tasks[] = array(
		'table' => 'user_board',
		'userid_column' => 'ub_user_id',
		'username_column' => 'ub_user_name',
	);
	$tasks[] = array(
		'table' => 'user_board',
		'userid_column' => 'ub_user_id_from',
		'username_column' => 'ub_user_name_from',
	);
	return true;
}
?>
