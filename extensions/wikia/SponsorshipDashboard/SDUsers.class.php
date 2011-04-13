<?php

/**
 * @author Jakub Kurcek
 */

class SponsorshipDashboardUsers {

	public function __construct(){

		$this->App = WF::build('App');
	}

	public function getData(){

		return $this->getFromDatabase();
	}

	protected function getFromDatabase(){

		$wgExternalDatawareDB = $this->App->getGlobal( 'wgExternalDatawareDB' );

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );
		$res = $dbr->select(
			'specials.wmetrics_user',
			array( 
				'wmusr_id as id',
				'wmusr_name as name',
				'wmusr_user_id as userId',
				'wmusr_description as description',
				'wmusr_status as status',
				'wmusr_type as type'
			),
			array(),
			__METHOD__,
			array()
		);

		$returnArray = array();
		while ( $row = $res->fetchObject( $res ) ) {
			$returnArray[ $row->id ] = array(
				'id'		=>	$row->id,
				'name'		=>	$row->name,
				'description'	=>	$row->description,
				'userId'	=>	$row->userId,
				'status'	=>	$row->status,
				'type'		=>	$row->type

			);
		}

		return $returnArray;

	}
}