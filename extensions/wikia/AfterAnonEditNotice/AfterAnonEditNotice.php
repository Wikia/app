<?php

function wfGetAfterAnonEditNotice( &$notice ) {
	wfDebug( "wfGetAfterAnonEditNotice: enter. Current notice = $notice\n" );
	if( !empty( $_SESSION['afterAnonEditNotice'] ) ) {
		wfInitAfterAnonEditNoticeMessage();
		$notice = wfGetCachedNotice( 'anoneditnotice' );
		$_SESSION['afterAnonEditNotice'] = false;
		wfDebug( "wfGetAfterAnonEditNotice: inside. New notice = $notice\n" );
		return false;
	}
	return true;
}

function wfActivateAfterAnonEditNotice( &$article, &$user, &$text, &$summary, $minoredit, $watchthis, $sectionanchor, &$flags ) {
	wfDebug( "wfActivateAfterAnonEditNotice: enter\n" );
	if( is_object( $user ) && $user->isAnon() ) {
		$_SESSION['afterAnonEditNotice'] = true;
		wfDebug( "wfActivateAfterAnonEditNotice: inside ($_SESSION[afterAnonEditNotice]) \n" );
	}
	return true;
}

function wfInitAfterAnonEditNoticeMessage() {
	global $wgMessageCache;
	$wgMessageCache->addMessage( 'anoneditnotice', '-' );
	
	return true;
}


$wgHooks['SiteNoticeBefore'][] = 'wfGetAfterAnonEditNotice';
$wgHooks['ArticleSaveComplete'][] = 'wfActivateAfterAnonEditNotice';
$wgHooks['LoadAllMessages'][] = 'wfInitAfterAnonEditNoticeMessage';

?>
