<?php

/**
 * SponsorshipDashboard
 * @author Jakub "Szeryf" Kurcek
 *
 * Motherclass for all output providers.
 * Output providers are ment to provide formatted output.
 * Like charts, tables, CSV ect.
 */

abstract class SponsorshipDashboardOutputFormatter {

	public $report = null;
	public $App = null;

	public function  __construct() {
		$this->App = F::build( 'App' );
	}

	public function set( $report ){
		$this->report = $report;
	}

	abstract public function getHTML();

}
