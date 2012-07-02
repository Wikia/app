<?php

class ContributionTotal extends UnlistedSpecialPage {

	protected $sharedMaxAge = 300; // Cache for 5 minutes on the server side
	protected $maxAge = 300; // Cache for 5 minutes on the client side
	
	function __construct() {
		parent::__construct( 'ContributionTotal' );
	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $egFundraiserStatisticsFundraisers;

		$this->setHeaders();

		// Get request data
		$fundraiserId = $wgRequest->getText( 'fundraiser' );
		$action = $wgRequest->getText( 'action' );
		$fudgeFactor = $wgRequest->getInt( 'adjustment' );
		
		// If no fundraiser was specified, use the most recent
		if ( !$fundraiserId ) {
			$mostRecentFundraiser = end( $egFundraiserStatisticsFundraisers );
			$fundraiserId = $mostRecentFundraiser['id'];
		}

		$output = efContributionReportingTotal( $fundraiserId, $fudgeFactor );

		header( "Cache-Control: max-age=$this->maxAge,s-maxage=$this->sharedMaxAge" );
		if ( $action == 'raw' ) {
			$wgOut->disable();
			echo $output;
		} else {
			$wgOut->setRobotpolicy( 'noindex,nofollow' );
			$wgOut->addHTML( $output );
		}
	}
}
