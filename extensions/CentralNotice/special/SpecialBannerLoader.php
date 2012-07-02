<?php

/**
 * Generates banner HTML files
 */
class SpecialBannerLoader extends UnlistedSpecialPage {
	public $siteName = 'Wikipedia'; // Site name
	public $language = 'en'; // User language

	function __construct() {
		// Register special page
		parent::__construct( "BannerLoader" );
	}

	function execute( $par ) {
		global $wgOut, $wgRequest;

		$wgOut->disable();
		$this->sendHeaders();

		// Get values from the query string
		$this->language = $wgRequest->getText( 'userlang', 'en' );
		$this->siteName = $wgRequest->getText( 'sitename', 'Wikipedia' );
		$this->campaign = $wgRequest->getText( 'campaign', 'undefined' );

		if ( $wgRequest->getText( 'banner' ) ) {
			$bannerName = $wgRequest->getText( 'banner' );
			try {
				$content = $this->getJsNotice( $bannerName );
				if ( preg_match( "/&lt;centralnotice-template-\w+&gt;\z/", $content ) ) {
					echo "/* Failed cache lookup */";
				} elseif ( strlen( $content ) == 0 ) {
					// Hack for IE/Mac 0-length keepalive problem, see RawPage.php
					echo "/* Empty */";
				} else {
					echo $content;
				}
			} catch (SpecialBannerLoaderException $e) {
				echo "/* Banner could not be generated */";
			}
		} else {
			echo "/* No banner specified */";
		}
	}

	/**
	 * Generate the HTTP response headers for the banner file
	 */
	function sendHeaders() {
		global $wgJsMimeType, $wgNoticeBannerMaxAge;
		header( "Content-type: $wgJsMimeType; charset=utf-8" );
		// No client-side banner caching so we get all impressions
		header( "Cache-Control: public, s-maxage=$wgNoticeBannerMaxAge, max-age=0" );
	}

	/**
	 * Generate the JS for the requested banner
	 * @return a string of Javascript containing a call to insertBanner()
	 *   with JSON containing the banner content as the parameter
	 * @throws SpecialBannerLoaderException
	 */
	function getJsNotice( $bannerName ) {
		// Make sure the banner exists
		if ( CentralNoticeDB::bannerExists( $bannerName ) ) {
			$this->bannerName = $bannerName;
			$bannerHtml = '';
			$bannerHtml .= preg_replace_callback(
				'/{{{(.*?)}}}/',
				array( $this, 'getNoticeField' ),
				$this->getNoticeTemplate()
			);
			$bannerArray = array(
				'bannerName' => $bannerName,
				'bannerHtml' => $bannerHtml,
				'campaign' => $this->campaign,
				'fundraising' => $this->getFundraising( $bannerName ),
				'autolink' => $this->getAutolink( $bannerName ),
				'landingPages' => $this->getLandingPages( $bannerName )
			);
			$bannerJs = 'insertBanner('.FormatJson::encode( $bannerArray ).');';
			return $bannerJs;
		}
		return '';
	}

	/**
	 * Generate the HTML for the requested banner
	 * @throws SpecialBannerLoaderException
	 */
	function getHtmlNotice( $bannerName ) {
		// Make sure the banner exists
		if ( CentralNoticeDB::bannerExists( $bannerName ) ) {
			$this->bannerName = $bannerName;
			$bannerHtml = '';
			$bannerHtml .= preg_replace_callback(
				'/{{{(.*?)}}}/',
				array( $this, 'getNoticeField' ),
				$this->getNoticeTemplate()
			);
			return $bannerHtml;
		}
		return '';
	}

	/**
	 * Get the body of the banner with only {{int:...}} messages translated
	 */
	function getNoticeTemplate() {
		$out = $this->getMessage( "centralnotice-template-{$this->bannerName}" );
		return $out;
	}

	/**
	 * Extract a message name and send to getMessage() for translation
	 * If the field is 'amount', get the current fundraiser donation amount and pass it as a
	 * parameter to the message.
	 * @param $match A message array with 2 members: raw match, short name of message
	 * @return translated messsage string
	 * @throws SpecialBannerLoaderException
	 */
	function getNoticeField( $match ) {
		$field = $match[1];
		$params = array();
		
		// Handle "magic messages"
		switch ( $field ) {
			case 'amount': // total fundraising amount
				$params = array( $this->toMillions( $this->getDonationAmount() ) );
				break;
			case 'daily-amount': // daily fundraising amount
				$params = array( $this->toThousands( $this->getDailyDonationAmount() ) );
				break;
		}
		
		$message = "centralnotice-{$this->bannerName}-$field";
		$source = $this->getMessage( $message, $params );
		return $source;
	}

	/**
	 * Convert number of dollars to millions of dollars
	 */
	private function toMillions( $num ) {
		$num = sprintf( "%.1f", $num / 1e6 );
		if ( substr( $num, - 2 ) == '.0' ) {
			$num = substr( $num, 0, - 2 );
		}
		$lang = Language::factory( $this->language );
		return $lang->formatNum( $num );
	}
	
	/**
	 * Convert number of dollars to thousands of dollars
	 */
	private function toThousands( $num ) {
		$num = sprintf( "%d", $num / 1000 );
		$lang = Language::factory( $this->language );
		return $lang->formatNum( $num );
	}

	/**
	 * Retrieve a translated message
	 * @param $msg The full name of the message
	 * @return translated messsage string
	 */
	private function getMessage( $msg, $params = array() ) {
		global $wgLang, $wgSitename;

		// A god-damned dirty hack! :D
		$oldLang = $wgLang;
		$oldSitename = $wgSitename;

		$wgSitename = $this->siteName; // hack for {{SITENAME}}
		$wgLang = Language::factory( $this->language ); // hack for {{int:...}}

		$options = array( 'language' => $this->language, 'parsemag' );
		array_unshift( $params, $options );
		array_unshift( $params, $msg );
		$out = call_user_func_array( 'wfMsgExt', $params );

		// Restore global variables
		$wgLang = $oldLang;
		$wgSitename = $oldSitename;

		return $out;
	}

	/**
	 * Pull the current amount raised during a fundraiser
	 * @throws SpecialBannerLoaderException
	 */
	private function getDonationAmount() {
		global $wgNoticeCounterSource, $wgMemc;
		// Pull short-cached amount
		$count = intval( $wgMemc->get( wfMemcKey( 'centralnotice', 'counter' ) ) );
		if ( !$count ) {
			// Pull from dynamic counter
			$counter_value = Http::get( $wgNoticeCounterSource );
			if( !$counter_value ) {
				throw new RemoteServerProblemException();
			}
			$count = intval( $counter_value );
			if ( !$count ) {
				// Pull long-cached amount
				$count = intval( $wgMemc->get(
					wfMemcKey( 'centralnotice', 'counter', 'fallback' ) ) );
				if ( !$count ) {
					throw new DonationAmountUnknownException();
				}
			}
			// Expire in 60 seconds
			$wgMemc->set( wfMemcKey( 'centralnotice', 'counter' ), $count, 60 );
			// No expiration
			$wgMemc->set( wfMemcKey( 'centralnotice', 'counter', 'fallback' ), $count );
		}
		return $count;
	}
	
	/**
	 * Pull the amount raised so far today during a fundraiser
	 * @throws SpecialBannerLoaderException
	 */
	private function getDailyDonationAmount() {
		global $wgNoticeDailyCounterSource, $wgMemc;
		// Pull short-cached amount
		$count = intval( $wgMemc->get( wfMemcKey( 'centralnotice', 'dailycounter' ) ) );
		if ( !$count ) {
			// Pull from dynamic counter
			$counter_value = Http::get( $wgNoticeDailyCounterSource );
			if( !$counter_value ) {
				throw new RemoteServerProblemException();
			}
			$count = intval( $counter_value );
			if ( !$count ) {
				// Pull long-cached amount
				$count = intval( $wgMemc->get(
					wfMemcKey( 'centralnotice', 'dailycounter', 'fallback' ) ) );
				if ( !$count ) {
					throw new DonationAmountUnknownException();
				}
			}
			// Expire in 60 seconds
			$wgMemc->set( wfMemcKey( 'centralnotice', 'dailycounter' ), $count, 60 );
			// No expiration
			$wgMemc->set( wfMemcKey( 'centralnotice', 'dailycounter', 'fallback' ), $count );
		}
		return $count;
	}

	function getFundraising( $bannerName ) {
		global $wgCentralDBname;
		$dbr = wfGetDB( DB_SLAVE, array(), $wgCentralDBname );
		$eBannerName = htmlspecialchars( $bannerName );
		$row = $dbr->selectRow( 'cn_templates', 'tmp_fundraising', array( 'tmp_name' => $eBannerName ) );
		return $row->tmp_fundraising;
	}

	function getAutolink( $bannerName ) {
		global $wgCentralDBname;
		$dbr = wfGetDB( DB_SLAVE, array(), $wgCentralDBname );
		$eBannerName = htmlspecialchars( $bannerName );
		$row = $dbr->selectRow( 'cn_templates', 'tmp_autolink', array( 'tmp_name' => $eBannerName ) );
		return $row->tmp_autolink;
	}

	function getLandingPages( $bannerName ) {
		global $wgCentralDBname;
		$dbr = wfGetDB( DB_SLAVE, array(), $wgCentralDBname );
		$eBannerName = htmlspecialchars( $bannerName );
		$row = $dbr->selectRow( 'cn_templates', 'tmp_landing_pages', array( 'tmp_name' => $eBannerName ) );
		return $row->tmp_landing_pages;
	}
}
/**
 * @defgroup Exception Exception
 */

/**
 * SpecialBannerLoaderException exception
 *
 * This exception is being thrown whenever
 * some fatal error occurs that may affect
 * how the banner is presented.
 *
 * @ingroup Exception
 */

class SpecialBannerLoaderException extends Exception {
}

class RemoteServerProblemException extends SpecialBannerLoaderException {
}

class DonationAmountUnknownException extends SpecialBannerLoaderException {
}
