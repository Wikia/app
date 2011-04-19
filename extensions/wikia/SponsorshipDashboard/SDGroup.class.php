<?php

/**
 * SponsorshipDashboard
 * @author Jakub "Szeryf" Kurcek
 *
 * Basic group object. Contains report and user objects.
 */

class SponsorshipDashboardGroup {

	const ID = 'id';
	const NAME = 'name';
	const DESCRIPTION = 'description';
	const REPORTS = 'reports';
	const USERS = 'users';

	public $id = 0;
	public $reports = array();
	public $users = array();
	public $name = '';
	public $description = '';
	public $dataLoaded = false;
	public $teaser = false;

	public function __construct( $id = 0 ) {

		$this->App = WF::build('App');
		$this->setId( $id );
	}

	/*
	 * Fills object with data on request basis
	 *
	 * @return void
	 */

	public function fillFromRequest() {

		global $wgRequest;

		$this->id = $wgRequest->getVal( self::ID );
		$this->name = $wgRequest->getVal( self::NAME );
		$this->description = $wgRequest->getVal( self::DESCRIPTION );
		
		$reports = $wgRequest->getVal( self::REPORTS );
		$reports = explode( ',', $reports );
		foreach ( $reports as $report ) {
			$iReport = (int) $report;
			if ( !empty( $iReport ) ) {
				$this->reports[] = (int) $iReport;
			}
		}

		$users = $wgRequest->getVal( self::USERS );
		$users = explode( ',', $users );
		foreach ( $users as $user ) {
			$iUser = (int) $user;
			if ( !empty( $iUser ) ) {
				$this->users[] = (int) $iUser;
			}
		}

		$this->save();
	}

	/*
	 * Saves group, users and reports ( relations not objects itself )
	 *
	 * @return void
	 */

	public function save() {

		$db = wfGetDB( DB_MASTER, array(), SponsorshipDashboardService::getDatabase() );

		if( !empty( $this->id ) ) {

			$db->update(
				'specials.wmetrics_group',
				$this->getTableFromParams(),
				array( 'wmgr_id' => (int) $this->id ),
				__METHOD__
			);
		} else {

			$db->insert(
				'specials.wmetrics_group',
				$this->getTableFromParams(),
				__METHOD__
			);
			$this->setId( $db->insertId() );
		}

		$this->saveReports();
		$this->saveUsers();
	}

	public function setId( $id ) {

		if ( (int)$id >= 0 ) {
			$this->id = (int)$id;
		}
	}

	public function getTableFromParams() {

		$array = array(
		    'wmgr_id'		=> ( int )$this->id,
		    'wmgr_name'		=> htmlspecialchars( $this->name ),
		    'wmgr_description'	=> htmlspecialchars( $this->description )
		);

		return $array;
	}

	public function saveReports() {

		$db = wfGetDB( DB_MASTER, array(), SponsorshipDashboardService::getDatabase() );
		$db->delete(
			'specials.wmetrics_group_reports_map',
			array( 'wmgrm_group_id' => $this->id )
		);

		foreach ( $this->reports as $report ) {
			$db->insert(
				'specials.wmetrics_group_reports_map',
				array( 'wmgrm_group_id' => $this->id, 'wmgrm_report_id' => $report )
			);
		}
	}

	public function saveUsers() {

		$db = wfGetDB( DB_MASTER, array(), F::build('App')->getGlobal('wgExternalDatawareDB') );
		$db->delete(
			'specials.wmetrics_user_group_map',
			array( 'wmgum_group_id' => $this->id )
		);

		foreach ( $this->users as $user ) {
			$db->insert(
				'specials.wmetrics_user_group_map',
				array( 'wmgum_group_id' => $this->id, 'wmgum_user_id' => $user )
			);
		}
	}

	public function loadGroupParams() {

		if( empty( $this->id ) ) {
			return false;
		}

		$dbr = wfGetDB( DB_SLAVE, array(), F::build('App')->getGlobal('wgExternalDatawareDB') );
		$res = $dbr->select(
			'specials.wmetrics_group',
			array(
			    'wmgr_id as id',
			    'wmgr_name as name',
			    'wmgr_description as description'
			),
			array( 'wmgr_id = '. $this->id ),
			__METHOD__,
			array()
		);

		while ( $row = $res->fetchObject( $res ) ) {
			$this->description = ( $row->description );
			$this->name = ( $row->name );
		}
		$this->loadReports();
		$this->loadUsers();
		$this->dataLoaded = true;
	}

	public function exist() {

		if( empty( $this->id ) ) {
			return false;
		}

		$dbr = wfGetDB( DB_SLAVE, array(), F::build('App')->getGlobal('wgExternalDatawareDB') );
		$res = $dbr->select(
			'specials.wmetrics_group',
			array(
			    'wmgr_id as id',
			    'wmgr_name as name',
			    'wmgr_description as description'
			),
			array( 'wmgr_id = '. $this->id ),
			__METHOD__,
			array()
		);

		while ( $row = $res->fetchObject( $res ) ) {
			return true;
		}
		return false;
	}

	public function getGroupParams() {

		$aParams = array();
		$aParams[ self::ID ] = $this->id;
		$aParams[ self::NAME ] = $this->name;
		$aParams[ self::DESCRIPTION ] = $this->description;
		$aParams[ self::REPORTS ] = $this->reports;
		$aParams[ self::USERS ] = $this->users;
		return $aParams;
	}

	public function loadReports() {

		if( empty( $this->id ) ) {
			return false;
		}

		if( $this->dataLoaded ) {
			return true;
		}

		$dbr = wfGetDB( DB_SLAVE, array(), F::build('App')->getGlobal('wgExternalDatawareDB') );
		$res = $dbr->select(
			'specials.wmetrics_group_reports_map',
			array( 'wmgrm_id as id', 'wmgrm_report_id as report_id', 'wmgrm_group_id as group_id' ),
			array( 'wmgrm_group_id = '. $this->id ),
			__METHOD__,
			array()
		);

		$returnArray = array();
		while ( $row = $res->fetchObject( $res ) ) {
			$report = new SponsorshipDashboardReport( $row->report_id);
			$report->loadReportParams();
			$this->reports[ $report->id ] = $report;
		}
	}

	public function loadUsers() {

		if( empty( $this->id ) ) {
			return false;
		}

		if( $this->dataLoaded ) {
			return true;
		}

		$dbr = wfGetDB( DB_SLAVE, array(), F::build('App')->getGlobal('wgExternalDatawareDB') );
		$res = $dbr->select(
			'specials.wmetrics_user_group_map',
			array( 'wmgum_id as id', 'wmgum_user_id as user_id', 'wmgum_user_id as user_id' ),
			array( 'wmgum_group_id = '. $this->id ),
			__METHOD__,
			array()
		);
		$returnArray = array();
		while ( $row = $res->fetchObject( $res ) ) {
			$user = new SponsorshipDashboardUser( $row->user_id);
			$user->loadUserParams();
			$this->users[ $user->id ] = $user;
		}
	}
	
	public function delete() {
		if( !empty( $this->id ) ) {
			$db = wfGetDB( DB_MASTER, array(), F::build('App')->getGlobal('wgExternalDatawareDB') );
			$db->delete(
				'specials.wmetrics_group',
				array( 'wmgr_id' => $this->id )
			);
			$this->setId( 0 );
		}
	}


}