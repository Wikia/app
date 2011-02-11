<?php

/**
 * switch colocation cookie
 */


$wgSpecialPages[ "Datacenter" ] = "SpecialDatacenter";

class SpecialDatacenter extends UnlistedSpecialPage {

	private
		$mTitle,
		$mCookie,
		$mCookieName;

	public function __construct() {
		parent::__construct( 'Datacenter' );
		$this->mCookieName = "-wikia-colocation";
		$this->mCookie = false;
	}

	public function execute( $subpage ) {
		global $wgOut, $wgUser, $wgRequest, $wgMessageCache, $wgCookiePrefix;

		$wgMessageCache->addMessages( array( "datacenter" => "Datacenter" ), "en" );

		wfProfileIn( __METHOD__ );

		$this->setHeaders();
		$this->mTitle = SpecialPage::getTitleFor( "Datacenter" );

		/**
		 * if posted change cookie value
		 */
		if( $wgRequest->wasPosted() ) {
			$val = $wgRequest->getVal( "iowacookie", 0 );
			if( $val == 2 ) {
				$wgOut->addHTML( Wikia::successbox( "cookie set to sjc" ) );
				$wgRequest->response()->setcookie( $this->mCookieName, "sjc" );
				$this->mCookie = "sjc";
			}
			elseif( $val == 1 ) {
				$wgOut->addHTML( Wikia::successbox( "cookie set to iowa" ) );
				$wgRequest->response()->setcookie( $this->mCookieName, "iowa" );
				$this->mCookie = "iowa";
			}
			elseif( $val == 3 ) {
				$wgOut->addHTML( Wikia::successbox( "cookie set to ash" ) );
				$wgRequest->response()->setcookie( $this->mCookieName, "ash" );
				$this->mCookie = "ash";
			}
			else {
				$wgOut->addHTML( Wikia::successbox( "cookie removed" ) );
				$wgRequest->response()->setcookie( $this->mCookieName, "sjc", 1 );
				$this->mCookie = false;
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
			( $this->mCookie ? $this->mCookie : "not set" ) . "</em>"
		);

		/**
		 * show input chooser
		 */
		$wgOut->addHTML( Xml::openElement( "form", array( "action" => $this->mTitle->getFullURL(), "method" => "post" ) ) );
		$select = new XMLSelect( "iowacookie", "iowacookie" );
		$select->addOption( "Switch to San Jose", 2 );
		$select->addOption( "Switch to Iowa",     1 );
		$select->addOption( "Switch to Ashburn",  3 );
		$select->addOption( "Remove preferences", 0 );
		$wgOut->addHTML( $select->getHTML() );
		$wgOut->addHTML( Xml::submitButton( "submit" ) );
		$wgOut->addHTML( Xml::closeElement( "form" ) );

		wfProfileOut( __METHOD__ );
	}
}
