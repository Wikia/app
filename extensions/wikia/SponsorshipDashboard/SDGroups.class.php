<?php

/**
 * SponsorshipDashboard
 * @author Jakub "Szeryf" Kurcek
 *
 * List of groups
 */

class SponsorshipDashboardGroups {

	public function __construct(){

		$this->App = WF::build('App');
	}

	public function getData(){

		return $this->getFromDatabase();
	}

	public function getObjArray( $doNotShowEmptyGroups = false ){
		
		$groups = $this->getData();

		$returnArray = array();
		foreach( $groups as $group ){
			$oGroup = new SponsorshipDashboardGroup( $group['id'] );
			if ( $oGroup->exist() ){
				$oGroup->loadGroupParams();
				if ( !$doNotShowEmptyGroups || count( $oGroup->reports ) > 0 ) {
					$returnArray[ $group['id'] ] = $oGroup;
				}
			}
		}

		return $returnArray;
	}

	/*
	 * Returns all groups that contain specified user
	 *
	 * @param int $id SponsorshipDashboard UserId
	 *
	 * @return array
	 */

	public function getUserData( $id ){

		$id = (int) $id;
		if ( !empty( $id ) ){

			$dbr = wfGetDB( DB_SLAVE, array(), SponsorshipDashboardService::getDatabase() );
			$res = $dbr->select(
				'specials.wmetrics_user_group_map',
				array( 'wmgum_group_id as group_id'  ),
				array( 'wmgum_user_id' => $id ),
				__METHOD__,
				array()
			);
			$returnArray = array();
			while ( $row = $res->fetchObject( $res ) ) {
				$oGroup = new SponsorshipDashboardGroup( $row->group_id );
				if ( $oGroup->exist() ){
					$oGroup->loadGroupParams();
					$returnArray[ $row->group_id ] = $oGroup;
				}
			}

			return $returnArray;
		}

		return array();
	}

	protected function getFromDatabase(){

		$dbr = wfGetDB( DB_SLAVE, array(), SponsorshipDashboardService::getDatabase() );
		$res = $dbr->select(
			'specials.wmetrics_group',
			array( 'wmgr_id as id', 'wmgr_name as name', 'wmgr_description as description'  ),
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