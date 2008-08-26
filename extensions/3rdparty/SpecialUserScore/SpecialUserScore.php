<?php
$wgExtensionFunctions[] = "wfExtensionSpecialUserScore";
function wfExtensionSpecialUserScore() {
	global $wgMessageCache;

	# Internationalisation file
	require_once( dirname(__FILE__) . '/SpecialUserScore.i18n.php' );

	# Add messages
	foreach( $wgUserScoreMessages as $key => $value ) {
		$wgMessageCache->addMessages( $wgUserScoreMessages[$key], $key );
	}

//	$wgMessageCache->addMessages(array('userscore' => 'UserScore'));	//moved to SpecialUserScore.i18n.php
	SpecialPage::addPage( new SpecialPage( 'UserScore' , 'userrights') );
}
?>