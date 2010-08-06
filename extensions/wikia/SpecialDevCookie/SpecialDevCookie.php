<?php

/**
 * switch cookie used for development
 */

$wgSpecialPages['DevCookie'] = 'SpecialDevCookie';
$wgDevCookieName = "-wikia-development";
$wgGroupPermissions['*']['devcookie'] = false;
$wgGroupPermissions['staff']['devcookie'] = true;

class SpecialDevCookie extends UnlistedSpecialPage {

	private
		$mTitle,
		$mCookie,
		$mCookieName;

	public function __construct() {
		global $wgDevCookieName;

		parent::__construct( 'DevCookie', 'devcookie' );

		$this->mCookieName = $wgDevCookieName;
		$this->mCookie = null;
	}

	public function execute( $subpage ) {
		global $wgOut, $wgUser, $wgRequest, $wgMessageCache, $wgCookiePrefix;

		$wgMessageCache->addMessages( array( 'devcookie' => 'DevCookie' ), 'en' );

		wfProfileIn( __METHOD__ );

		$this->setHeaders();
		$this->mTitle = SpecialPage::getTitleFor( 'DevCookie' );

		if( $this->isRestricted() && !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}

		/**
		 * if posted change cookie value
		 */
		if( $wgRequest->wasPosted() ) {
			$val = $wgRequest->getVal( 'cookie', 0 );
			if( $val == 1 ) {
				$wgOut->addHTML( Wikia::successbox( 'cookie set' ) );
				$wgRequest->response()->setcookie( $this->mCookieName, '1' );
				$this->mCookie = '1';
			}
			elseif( $val == 0 ) {
				$wgOut->addHTML( Wikia::successbox( 'cookie set' ) );
				$wgRequest->response()->setcookie( $this->mCookieName, '0' );
				$this->mCookie = '0';
			}
			else {
				$wgOut->addHTML( Wikia::successbox( 'cookie removed' ) );
				$wgRequest->response()->setcookie( $this->mCookieName, '-1', 1 );
				$this->mCookie = null;
			}

		}
		else {
			/**
			 * show current value of cookie
			 */
			if ( isset( $_COOKIE[ $wgCookiePrefix . $this->mCookieName ] ) ) {
				$this->mCookie = $_COOKIE[ $wgCookiePrefix . $this->mCookieName ];
			}
		}
		$wgOut->addHTML(
			"Current value of cookie {$wgCookiePrefix}{$this->mCookieName}: <em>" .
			( is_null($this->mCookie) ? 'not set' : ($this->mCookie ? 'true' : 'false') ) . '</em>'
		);

		/**
		 * show input chooser
		 */
		$wgOut->addHTML( Xml::openElement( 'form', array( 'action' => $this->mTitle->getFullURL(), 'method' => 'post' ) ) );
		$select = new XMLSelect( 'cookie', 'cookie' );
		$select->addOption( 'Set cookie to true', 1 );
		//$select->addOption( 'Set cookie to false', 0 );
		$select->addOption( 'Remove cookie', -1 );
		$wgOut->addHTML( $select->getHTML() );
		$wgOut->addHTML( Xml::submitButton( 'submit' ) );
		$wgOut->addHTML( Xml::closeElement( 'form' ) );

		wfProfileOut( __METHOD__ );
	}
}
