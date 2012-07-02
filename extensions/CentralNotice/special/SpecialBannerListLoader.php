<?php

/**
 * Generates JSON files listing all the banners for a particular site
 */
class SpecialBannerListLoader extends UnlistedSpecialPage {
	public $project; // Project name
	public $language; // Project language
	public $location; // User country
	protected $sharedMaxAge = 300; // Cache for 5 minutes on the server side
	protected $maxAge = 300; // Cache for 5 minutes on the client side

	function __construct() {
		// Register special page
		parent::__construct( "BannerListLoader" );
	}

	function execute( $par ) {
		global $wgOut, $wgRequest;

		$wgOut->disable();
		$this->sendHeaders();

		// Get project language from the query string
		$this->language = $wgRequest->getText( 'language', 'en' );

		// Get project name from the query string
		$this->project = $wgRequest->getText( 'project', 'wikipedia' );

		// Get location from the query string
		$this->location = $wgRequest->getText( 'country' );

		if ( $this->project && $this->language ) {
			$content = $this->getJsonList();
			if ( strlen( $content ) == 0 ) {
				// Hack for IE/Mac 0-length keepalive problem, see RawPage.php
				echo "/* Empty */";
			} else {
				echo $content;
			}
		} else {
			echo "/* No site specified */";
		}
	}

	/**
	 * Generate the HTTP response headers for the banner file
	 */
	function sendHeaders() {
		global $wgJsMimeType;
		header( "Content-type: $wgJsMimeType; charset=utf-8" );
		header( "Cache-Control: public, s-maxage=$this->sharedMaxAge, max-age=$this->maxAge" );
	}

	/**
	 * Generate JSON for the specified site
	 */
	function getJsonList() {
		$banners = array();

		// See if we have any preferred campaigns for this language and project
		$campaigns = CentralNoticeDB::getCampaigns( $this->project, $this->language, null, 1, 1, $this->location );

		// Quick short circuit to show preferred campaigns
		if ( $campaigns ) {
			// Pull banners
			$banners = CentralNoticeDB::getCampaignBanners( $campaigns );
		}

		// Didn't find any preferred banners so do an old style lookup
		if ( !$banners )  {
			$banners = CentralNoticeDB::getBannersByTarget(
				$this->project, $this->language, $this->location );
		}

		return FormatJson::encode( $banners );
	}

}
