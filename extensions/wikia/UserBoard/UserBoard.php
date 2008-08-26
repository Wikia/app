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
$wgSpecialPages['BoardBlast'] = 'BoardBlast';

$wgAutoloadClasses['ViewUserBoard'] = "{$wgUserBoardDirectory}/SpecialUserBoard.php";
$wgSpecialPages['UserBoard'] = 'ViewUserBoard';

require_once( "{$wgUserBoardDirectory}/UserBoard_AjaxFunctions.php" );
	
$wgAutoloadClasses["UserBoard"] = "{$wgUserBoardDirectory}/UserBoardClass.php";
$wgUserProfileDisplay['board'] = true;
?>
