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

	static public function axGetGapiForm() {

		$obj = new SponsorshipDashboardSourceGapi();
		return $obj->getFormHTML();
	}

	static public function axGetGapiCuForm() {

		$obj = new SponsorshipDashboardSourceGapiCu();
		return $obj->getFormHTML();
	}
	
	static public function axGetStatsForm() {

		$obj = new SponsorshipDashboardSourceStats();
		return $obj->getFormHTML();
	}

	static public function axGetOneDotForm() {

		$obj = new SponsorshipDashboardSourceOneDot();
		return $obj->getFormHTML();
	}

	static public function axGetMobileForm() {

		$obj = new SponsorshipDashboardSourceMobile();
		return $obj->getFormHTML();
	}

	static public function axSaveReport() {
		
		$SponsorshipDashboard = new SponsorshipDashboard();
		
		if ( $SponsorshipDashboard->isAllowed() ){
			$report = new SponsorshipDashboardReport();
			$report->fillFromSerializedData( serialize( $_POST['formData'] ) );		
			if ( isset ( $_POST['asNew'] ) && $_POST['asNew'] == 'true' ){
				$report->setId( 0 );
			}
			$report->save();
		}
		echo $SponsorshipDashboard->reportSaved();
	}


	static public function axDelete() {

		$SponsorshipDashboard = new SponsorshipDashboard();
		
		if ( $SponsorshipDashboard->isAllowed() && isset( $_GET['elementId'] ) && isset( $_GET['elementType'] ) ) {
			if ( !empty( $_GET['elementId'] ) ){

				$element = false;
				switch ( $_GET['elementType'] ) {
					case 'report' : $element = new SponsorshipDashboardReport( $_GET['elementId'] ); break;
					case 'group' : $element = new SponsorshipDashboardGroup( $_GET['elementId'] ); break;
					case 'user' : $element = new SponsorshipDashboardUser( $_GET['elementId'] ); break;
				}
				
				if ( !empty( $element ) ) {
					$element->delete();

				}
			}
		}
	}

	static public function axPreviewReport() {

		$SponsorshipDashboard = new SponsorshipDashboard();

		if ( $SponsorshipDashboard->isAllowed() ){

			$report = new SponsorshipDashboardReport();
			var_dump( $_POST['formData'] );
			$report->fillFromSerializedData( serialize( $_POST['formData'] ) );
			$report->lockSources();
			$dataFormatter = SponsorshipDashboardOutputChart::newFromReport( $report );
			echo $dataFormatter->getHTML();

		} else {

			echo wfMsg('sponsorship-dashboard-not-allowed');
		}
	}

	static public function axDownloadCSV() {

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