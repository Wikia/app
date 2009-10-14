<?php

/**
 * switch colocation cookie
 */


$wgSpecialPages[ "Iowa" ] = "SpecialIowa";

class SpecialIowa extends UnlistedSpecialPage {

	private
		$mTitle,
		$mCookie,
		$mCookieName;

	public function __construct() {
		parent::__construct( 'Iowa', 'wikifactory' );
		$this->mCookieName = "-wikia-colocation";
		$this->mCookie = false;
	}

	public function execute( $subpage ) {
		global $wgOut, $wgUser, $wgRequest, $wgMessageCache, $wgCookiePrefix;

		$wgMessageCache->addMessages( array( "iowa" => "Iowa" ), "en" );

		if( !$wgUser->isAllowed( 'wikifactory' ) ) {
			$this->displayRestrictionError();
			return;
		}
		wfProfileIn( __METHOD__ );

		$this->setHeaders();
		$this->mTitle = SpecialPage::getTitleFor( "Iowa" );

		/**
		 * show current value of cookie
		 */
		if ( isset( $_COOKIE[ $wgCookiePrefix . $this->mCookieName ] ) ) {
			$this->mCookie = $_COOKIE[ $wgCookiePrefix . $this->mCookieName ];
		}
		$wgOut->addHTML(
			"Current value of cookie {$wgCookiePrefix}{$this->mCookieName}: <em>" .
			( $this->mCookie ? $this->mCookie : "not set" ) . "</em>"
		);

		/**
		 * show input chooser
		 */
		$wgOut->addHTML( Xml::openElement( "form", array( "action" => $this->mTitle->getFullURL(), "method" => "post" ) ) );
		$select = new XMLSelect( "iowacookie", "iowacookie" );
		$select->addOption( "set cookie to Iowa", 1 );
		$select->addOption( "remove cookie at all", 0 );
		$wgOut->addHTML( $select->getHTML() );
		$wgOut->addHTML( Xml::submitButton( "submit" ) );
		$wgOut->addHTML( Xml::closeElement( "form" ) );

		/**
		 * if posted change cookie value
		 */
		if( $wgRequest->wasPosted() ) {
			$val = $wgRequest->getVal( "iowacookie", 0 );
			if( $val == 1 ) {
				$wgOut->addHTML( Wikia::successmsg( "cookie set" ) );
				$wgRequest->response()->setcookie( $this->mCookieName, "iowa" );
			}
			else {
				$wgOut->addHTML( Wikia::successmsg( "cookie removed" ) );
				$wgRequest->response()->setcookie( $this->mCookieName, "sjc", 1 );
			}
		}
		wfProfileOut( __METHOD__ );
	}
}
