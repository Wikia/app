<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "CentralNotice extension\n";
	exit( 1 );
}

/**
 * Unlisted Special Page which sets a cookie for hiding banners across all languages of a project.
 * This is typically used on donation thank-you pages so that users who have donated will no longer
 * see fundrasing banners.
 */
class SpecialHideBanners extends UnlistedSpecialPage {
	function __construct() {
		parent::__construct( 'HideBanners' );
	}

	function execute( $par ) {
		global $wgOut;

		$this->setHideCookie();

		$wgOut->disable();
		wfResetOutputBuffers();

		header( 'Content-Type: image/png' );
		header( 'Cache-Control: no-cache' );

		readfile( dirname( __FILE__ ) . '/../1x1.png' );
	}

	/**
	 * Set the cookie for hiding fundraising banners.
	 */
	function setHideCookie() {
		global $wgNoticeCookieDomain, $wgCookieSecure, $wgNoticeHideBannersExpiration;
		if ( is_numeric( $wgNoticeHideBannersExpiration ) ) {
			$exp = $wgNoticeHideBannersExpiration;
		} else {
			$exp = time() + 86400 * 14; // Cookie expires after 2 weeks
		}
		if ( is_callable( array( 'CentralAuthUser', 'getCookieDomain' ) ) ) {
			$cookieDomain = CentralAuthUser::getCookieDomain();
		} else {
			$cookieDomain = $wgNoticeCookieDomain;
		}
		// Hide fundraising banners for this domain
		setcookie( 'centralnotice_fundraising', 'hide', $exp, '/', $cookieDomain, $wgCookieSecure );
	}
}
