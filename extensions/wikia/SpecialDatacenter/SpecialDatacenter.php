<?php

/**
 * switch colocation cookie
 */


$wgSpecialPages[ "Datacenter" ] = "SpecialDatacenter";

class SpecialDatacenter extends UnlistedSpecialPage {

	private
		$mTitle,
		$mCookie,
		$mCookieName,
		$mOut,
		$mRequest;

	public function __construct() {
		parent::__construct( 'Datacenter' );
		$this->mCookieName = "-wikia-colocation";
		$this->mCookie = false;
	}

	public function execute( $subpage ) {
		global $wgOut, $wgRequest, $wgCookiePrefix;

		wfProfileIn( __METHOD__ );

		$this->mRequest = RequestContext::getMain()->getRequest();
		$this->mOut = RequestContext::getMain()->getOutput();

		$this->setHeaders();
		$this->mTitle = SpecialPage::getTitleFor( "Datacenter" );

		/**
		 * if posted change cookie value
		 */
		if( $this->mRequest->wasPosted() ) {
			$val = $this->mRequest->getVal( "iowacookie", 0 );
			if( $val == 2 ) {
				$this->mOut->addHTML( Wikia::successbox( "cookie set to sjc" ) );
				$this->mRequest->response()->setcookie( $this->mCookieName, "sjc" );
				$this->mCookie = "sjc";
			}
			elseif( $val == 1 ) {
				$this->mOut->addHTML( Wikia::successbox( "cookie set to iowa" ) );
				$this->mRequest->response()->setcookie( $this->mCookieName, "iowa" );
				$this->mCookie = "iowa";
			}
			elseif( $val == 3 ) {
				$this->mOut->addHTML( Wikia::successbox( "cookie set to ash" ) );
				$this->mRequest->response()->setcookie( $this->mCookieName, "ash" );
				$this->mCookie = "ash";
			}
			elseif( $val == 4 ) {
				$this->mOut->addHTML( Wikia::successbox( "cookie set to closest" ) );
				$this->mRequest->response()->setcookie( $this->mCookieName, "closest" );
				$this->mCookie = "closest";
			}
			else {
				$this->mOut->addHTML( Wikia::successbox( "cookie removed" ) );
				$this->mRequest->response()->setcookie( $this->mCookieName, "sjc", 1 );
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
		$this->mOut->addHTML(
			"Current value of cookie {$wgCookiePrefix}{$this->mCookieName}: <em>" .
			( $this->mCookie ? $this->mCookie : "not set" ) . "</em>"
		);

		/**
		 * show input chooser
		 */
		$this->mOut->addHTML( Xml::openElement( "form", array( "action" => $this->mTitle->getFullURL(), "method" => "post" ) ) );
		$select = new XMLSelect( "iowacookie", "iowacookie" );
		$select->addOption( "Switch to the closest", 4 );
		$select->addOption( "Switch to San Jose", 2 );
		$select->addOption( "Switch to Iowa",     1 );
		$select->addOption( "Switch to Ashburn",  3 );
		$select->addOption( "Remove preferences", 0 );
		$this->mOut->addHTML( $select->getHTML() );
		$this->mOut->addHTML( Xml::submitButton( "submit" ) );
		$this->mOut->addHTML( Xml::closeElement( "form" ) );

		wfProfileOut( __METHOD__ );
	}
}
