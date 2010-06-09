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
