<?php

/**
 * Switch cookie used for development and/or staging servers.
 *
 * TODO: if this becomes anything other than a hacky internal tool, do the following:
 *	- i18n
 *	- Move CSS into external file
 *	- Move HTML into template files
 */

$wgSpecialPages['DevCookie'] = 'SpecialDevCookie';
$wgDevCookieName = "-wikia-development";
$wgStagingCookieName = "wikia-preview";
$wgGroupPermissions['*']['devcookie'] = false;
$wgGroupPermissions['staff']['devcookie'] = true;

class SpecialDevCookie extends UnlistedSpecialPage {

	private	$mTitle;
	private $mCookieValues;

	public function __construct() {
		global $wgDevCookieName, $wgStagingCookieName;

		parent::__construct( 'DevCookie', 'devcookie' );
		
		$this->mCookieValues = array(
			$wgDevCookieName => null,
			$wgStagingCookieName => null
		);
	}

	public function execute( $subpage ) {
		global $wgOut, $wgUser, $wgMessageCache;
		global $wgDevCookieName;

		$wgMessageCache->addMessages( array( 'devcookie' => 'DevCookie' ), 'en' );

		wfProfileIn( __METHOD__ );

		$this->setHeaders();
		$this->mTitle = SpecialPage::getTitleFor( 'DevCookie' );

		if( $this->isRestricted() && !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}
		
		// Output some style since these classes aren't styled in css: {successbox, errorbox}
		$wgOut->addHTML("<style type='text/css'>
		.successbox{
			padding:5px;
			border: 1px #080 solid;
			background-color: #afa;
			color: #000;
		}
		.errorbox{
			padding:5px;
			border: 1px #800 solid;
			background-color: #faa;
			color: #000;
		}
		</style>");

		// Dev cookie
//		$wgOut->addHTML('<h1>Dev cookie</h1>');
//		$this->handlePostForCookie($wgDevCookieName);
//		$this->showSelectBox($wgDevCookieName);
		
		// Staging cookie
		$wgOut->addHTML('<h1>Preview cookie</h1>');
		$wgOut->addHTML('<p>To use the preview server (code that will be released to production soon), set this cookie to <em>true</em></p>');
		$this->handlePostForCookie($wgStagingCookieName);
		$this->showSelectBox($wgStagingCookieName);

		wfProfileOut( __METHOD__ );
	}
	
	/**
	 * Given a cookie name, handles any posts to change its value, and displays
	 * the current value of the cookie.
	 */
	private function handlePostForCookie($cookieName){
		/**
		 * if posted change cookie value
		 */
		 global $wgRequest, $wgOut, $wgCookiePrefix;
		if( $wgRequest->wasPosted() && ($cookieName == $wgRequest->getVal( 'cookieName' )) ) {
			$val = $wgRequest->getVal( 'cookie', 0 );
			if( $val == 1 ) {
				$wgOut->addHTML( Wikia::successbox( 'cookie set' ) );
				$wgRequest->response()->setcookie( $cookieName, '1' );
				$this->mCookieValues[$cookieName] = '1';
			}
			elseif( $val == 0 ) {
				$wgOut->addHTML( Wikia::successbox( 'cookie set' ) );
				$wgRequest->response()->setcookie( $cookieName, '0' );
				$this->mCookieValues[$cookieName] = '0';
			}
			else {
				$wgOut->addHTML( Wikia::successbox( 'cookie removed' ) );
				$wgRequest->response()->setcookie( $cookieName, '-1', 1 );
				$this->mCookieValues[$cookieName] = null;
			}
		} else {
			// get current value of cookie
			if ( isset( $_COOKIE[ $wgCookiePrefix . $cookieName ] ) ) {
				$this->mCookieValues[$cookieName] = $_COOKIE[ $wgCookiePrefix . $cookieName ];
			}
		}
		$wgOut->addHTML(
			"Current value of the dev cookie: <em>" .
			( is_null($this->mCookieValues[$cookieName]) ? 'not set' : ($this->mCookieValues[$cookieName] ? 'true' : 'false') ) . '</em>'
		);
	} // end handlePostForCookie()

	/**
	 * Given a cookie-name, show a select box for changing the value of that cookie (currently
	 * only supports 1/0 cookies w/the option of being removed completely).
	 */
	private function showSelectBox($cookieName){
		global $wgOut;
		$wgOut->addHTML( Xml::openElement( 'form', array( 'action' => $this->mTitle->getFullURL(), 'method' => 'post' ) ) );
		$wgOut->addHTML( Xml::hidden( 'cookieName' , $cookieName ) );
		$select = new XMLSelect( 'cookie', 'cookie' );
		$select->addOption( 'Set cookie to true', 1 );
		//$select->addOption( 'Set cookie to false', 0 );
		$select->addOption( 'Remove cookie', -1 );
		$wgOut->addHTML( $select->getHTML() );
		$wgOut->addHTML( Xml::submitButton( 'submit' ) );
		$wgOut->addHTML( Xml::closeElement( 'form' ) );
	}
}
