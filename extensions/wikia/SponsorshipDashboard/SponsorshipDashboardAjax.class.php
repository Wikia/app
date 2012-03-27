<?php

/**
 * WikiMetrics
 *
 * A WikiMetrics extension for MediaWiki
 * Adding comment functionality on article pages
 *
 * @author Jakub Kurcek  <jakub@wikia.inc>
 * @copyright Copyright (C) 2010 Jakub Kurcek, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 */

class SponsorshipDashboardAjax {

	static public function axDownloadCSV() {
		Wikia::log( __METHOD__, 'Depreciated?' );
		$SponsorshipDashboard = new SponsorshipDashboard();

		if ( isset( $_GET['elementId'] ) && !empty( $_GET['elementId'] ) && $SponsorshipDashboard->isAllowed() ){

			$report = new SponsorshipDashboardReport( $_GET['elementId'] );
			$report->loadReportParams();
			$dataFormatter = SponsorshipDashboardOutputCSV::newFromReport( $report );
			echo $dataFormatter->getHTML();
			exit;

		} else {

			echo wfMsg('sponsorship-dashboard-not-allowed');
		}
	}
}