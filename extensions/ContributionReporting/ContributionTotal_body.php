<?php

class ContributionTotal extends SpecialPage {
	function ContributionTotal() {
		SpecialPage::SpecialPage( 'ContributionTotal' );
	}

	function execute( $par ) {
		global $wgRequest, $wgOut;

		wfLoadExtensionMessages( 'ContributionReporting' );

		$this->setHeaders();

		# Get request data from, e.g.
		$start = intval( wfTimestampOrNull( TS_UNIX, $wgRequest->getVal( 'start' ) ) );
		$action = $wgRequest->getText( 'action' );
		$fudgeFactor = $wgRequest->getInt( 'fudgefactor' );

		$output = efContributionReportingTotal( $start, $fudgeFactor );

		header( 'Cache-Control: max-age=300,s-maxage=300' );
		if ( $action == 'raw' ) {
			$wgOut->disable();
			echo $output;
		} else {
			$wgOut->setRobotpolicy( 'noindex,nofollow' );
			$wgOut->addHTML( $output );
		}
	}
}
