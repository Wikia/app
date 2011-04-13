<?php

/**
 * SponsorshipDashboard
 * @author Jakub "Szeryf" Kurcek
 *
 * List of reports
 */

class SponsorshipDashboardReports {
	
	var $App;

	public function __construct(){

		$this->App = WF::build('App');
	}
	
	public function getData(){
		
		$wgExternalDatawareDB = $this->App->getGlobal( 'wgExternalDatawareDB' );

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );
		$res = $dbr->select(
			'specials.wmetrics_report',
			array( 'wmre_id as id', 'wmre_name as name', 'wmre_description as description'  ),
			array(),
			__METHOD__,
			array()
		);

		$returnArray = array();
		while ( $row = $res->fetchObject( $res ) ) {
			$returnArray[ $row->id ] = array(
				'id'		=>	$row->id,
				'name'		=>	$row->name,
				'description'	=>	$row->description
			    
			);
		}
		
		return $returnArray;
	}
}