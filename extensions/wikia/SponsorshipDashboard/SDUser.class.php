<?php

/**
 * SponsorshipDashboard
 * @author Jakub "Szeryf" Kurcek
 *
 * User object - keeps user information
 */

class SponsorshipDashboardUser {

	const ID = 'id';
	const USER_ID = 'userId';
	const NAME = 'name';
	const STATUS = 'status';
	const DESCRIPTION = 'description';
	const TYPE = 'type';
	const TYPE_MEDIA_WIKI = 0;
	const TYPE_SPONSORED_LINKS = 1;

	public $allowedTypes = array( self::TYPE_MEDIA_WIKI, self::TYPE_SPONSORED_LINKS );

	public $id = 0;
	public $userId = 0;
	public $name = '';
	public $type = 0;
	public $status = 0;
	public $description = '';

	public function setId( $id ) {

		if ( (int)$id >= 0 ) {
			$this->id = (int)$id;
		}
	}

	public function setType( $iType) {
		$this->type = ( in_array( $iType, $this->allowedTypes ) ) ? $iType : 0;
	}

	public function setUserId( $iUserId ) {

		$oUser = User::newFromId( (int)$iUserId );
		$this->userId = ( $oUser->loadFromDatabase() ) ? $oUser->getId() : 0;
	}

	public function fillFromRequest() {

		global $wgRequest;

		$this->id = ( int )$wgRequest->getVal( self::ID );
		$stats = $wgRequest->getVal( self::STATUS );
		$this->status = ( empty( $stats ) ) ? 0 : 1;
		$this->type = ( $wgRequest->getVal( self::TYPE ) );
		$this->name = $wgRequest->getVal( self::NAME );
		$this->description = $wgRequest->getVal( self::DESCRIPTION );
	}

	public function save() {

		if ( $this->exist() ) {

			$wgExternalDatawareDB = $this->App->getGlobal( 'wgExternalDatawareDB' );
			$db = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

			$aParams = $this->getTableFromParams();

			if ( empty( $aParams ) ) {
				return false;
			}

			if( !empty( $this->id ) ) {

				$db->update(
					'specials.wmetrics_user',
					$aParams,
					array( 'wmusr_id' => (int) $this->id ),
					__METHOD__
				);
			} else {

				$db->insert(
					'specials.wmetrics_user',
					$aParams,
					__METHOD__
				);
				$this->setId( $db->insertId() );
			}

			return true;
		}
		return false;
	}

	public function getTableFromParams() {

		if( empty( $this->name ) ) {
			return array();
		}

		$oUser = User::newFromName( $this->name );
		$oUser->load();
		if ( !$oUser->loadFromDatabase() ) {
			return array();
		}

		$this->userId = $oUser->getId();

		$array = array(
		    'wmusr_id'		=> ( int )$this->id,
		    'wmusr_name'	=> htmlspecialchars( $this->name ),
		    'wmusr_user_id'	=> $this->userId,
		    'wmusr_type'	=> $this->type,
		    'wmusr_status'	=> (int) $this->status,
		    'wmusr_description'	=> $this->description
		);

		return $array;
	}

	public function exist() {

		if( empty( $this->id ) && empty( $this->name ) ) {
			return false;
		}

		if ( !empty( $this->id ) ) {
			$oUser = User::newFromId( $this->id );
		} else {
			$oUser = User::newFromName( $this->name );
		}

		$oUser->load();

		return $oUser->loadFromDatabase();
	}

	public function getUserParams() {

		$aParams = array();
		$aParams[ self::ID ] = $this->id;
		$aParams[ self::NAME ] = $this->name;
		$aParams[ self::DESCRIPTION ] = $this->description;
		$aParams[ self::STATUS ] = $this->status;
		$aParams[ self::TYPE ] = $this->type;
		$aParams[ self::USER_ID ] = $this->userId;

		return $aParams;
	}

	public function loadUserParams() {

		if( empty( $this->id ) ) {
			return false;
		}

		$dbr = wfGetDB( DB_SLAVE, array(), F::build('App')->getGlobal('wgExternalDatawareDB') );
		$res = $dbr->select(
			'specials.wmetrics_user',
			array(
			    'wmusr_id as id',
			    'wmusr_user_id as user_id',
			    'wmusr_description as description',
			    'wmusr_name as name',
			    'wmusr_type as type',
			    'wmusr_status as status'
			),
			array( 'wmusr_id = '. $this->id ),
			__METHOD__,
			array()
		);

		while ( $row = $res->fetchObject( $res ) ) {
			$this->description = ( $row->description );
			$this->name = ( $row->name );
			$this->userId = ( $row->user_id );
			$this->status = ( $row->status );
			$this->type = ( $row->type );
		}
	}

	public function __construct( $id = 0 ) {

		$this->App = WF::build('App');
		$this->setId( $id );
	}

	public function delete() {
		if( !empty( $this->id ) ) {
			$db = wfGetDB( DB_MASTER, array(), F::build('App')->getGlobal('wgExternalDatawareDB') );
			$db->delete(
				'specials.wmetrics_user',
				array( 'wmusr_id' => $this->id )
			);
			$this->setId( 0 );
		}
	}

	static public function newFromUserId( $iId ) {

		$iId = ( int )$iId;

		$dbr = wfGetDB( DB_SLAVE, array(), F::build('App')->getGlobal('wgExternalDatawareDB') );

		$res = $dbr->select(
			'specials.wmetrics_user',
			array(
			    'wmusr_id as id'
			),
			array( 'wmusr_user_id = '. $iId ),
			__METHOD__,
			array()
		);

		if ( $row = $res->fetchObject( $res ) ) {
			return new self( $row->id );
		}
	}
}