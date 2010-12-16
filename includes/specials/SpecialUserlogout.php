<?php
/**
 * @file
 * @ingroup SpecialPage
 */

/**
 * constructor
 */
function wfSpecialUserlogout() {
	global $wgUser, $wgOut, $wgRequest;

	/**
	 * Some satellite ISPs use broken precaching schemes that log people out straight after
	 * they're logged in (bug 17790). Luckily, there's a way to detect such requests.
	 */
	if ( isset( $_SERVER['REQUEST_URI'] ) && strpos( $_SERVER['REQUEST_URI'], '&amp;' ) !== false ) {
		wfDebug( "Special:Userlogout request {$_SERVER['REQUEST_URI']} looks suspicious, denying.\n" );
		wfHttpError( 400, wfMsg( 'loginerror' ), wfMsg( 'suspicious-userlogout' ) );
		return;
	}
	
	$oldName = $wgUser->getName();
	$wgUser->logout();
	$wgOut->setRobotPolicy( 'noindex,nofollow' );

	// Hook.
	$injected_html = '';
	wfRunHooks( 'UserLogoutComplete', array(&$wgUser, &$injected_html, $oldName) );

	$wgOut->addHTML( wfMsgExt( 'logouttext', array( 'parse' ) ) . $injected_html );
	
	$mReturnTo = $wgRequest->getVal( 'returnto' );		
	$mReturnToQuery = $wgRequest->getVal( 'returntoquery' );
		
	$title = Title::newFromText($mReturnTo);
	if (!empty($title))
	{
		$mResolvedReturnTo = strtolower(SpecialPage::resolveAlias($title->getDBKey()));
		if(in_array($mResolvedReturnTo,array('userlogout','signup','connect')))
		{
			$titleObj = Title::newMainPage();
			$mReturnTo = $titleObj->getText( );
			$mReturnToQuery = '';
		}			
	}
		
		
	$wgOut->returnToMain(false, $mReturnTo, $mReturnToQuery);
}
