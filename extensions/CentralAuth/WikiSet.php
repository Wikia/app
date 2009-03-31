<?php

class WikiSet {
	const OPTIN = 'optin';
	const OPTOUT = 'optout';
	const VERSION = 1;

	private $mId;	//ID of the group
	private $mName;	//Display name of the group
	private $mType;	//Opt-in based or opt-out based
	private $mWikis;	//List of wikis
	private $mVersion = self::VERSION;	//Caching purposes

	static $mCacheVars = array(
		'mId',
		'mName',
		'mType',
		'mWikis',
		'mVersion',
	);

	public function __construct( $name = '', $type = self::OPTIN, $wikis = array(), $id = 0 ) {
		$this->mId = $id;
		$this->mName = $name;
		$this->mType = $type;
		$this->mWikis = $wikis;
	}

	protected static function memcKey( $k ) { return "wikiset:{$k}"; }

	public function getId() { return $this->mId; }
	public function exists() { return (bool)$this->getID(); }
	public function getName() { return $this->mName; }
	public function setName( $n, $commit = false ) { return $this->setDbField( 'ws_name', $n, $commit ); }
	public function getWikisRaw() { return $this->mWikis; }
	public function setWikisRaw( $w, $commit = false ) { return $this->setDbField( 'ws_wikis', $w, $commit ); }
	public function getType() { return $this->mType; }
	public function setType( $t, $commit = false ) {
		if( !in_array( $t, array( self::OPTIN, self::OPTOUT ) ) )
			return false;
		return $this->setDbField( 'ws_type', $t, $commit );
	}
	protected function setDbField( $field, $value, $commit ) {
		$map = array( 'ws_name' => 'mName', 'ws_type' => 'mType', 'ws_wikis' => 'mWikis' );
		$mname = $map[$field];
		$this->$mname = $value;
		if( $commit )
			$this->commit();
	}

	public static function newFromRow( $row ) {
		if( !$row ) return null;
		return new WikiSet(
			$row->ws_name,
			$row->ws_type,
			explode( ',', $row->ws_wikis ),
			$row->ws_id
		);
	}

	public static function newFromName( $name, $useCache = true ) {
		if( $useCache ) {
			global $wgMemc;
			$data = $wgMemc->get( self::memcKey( "name:" . md5( $name ) ) );
			if( $data ) {
				if( $data['mVersion'] == self::VERSION ) {
					$ws = new WikiSet( null, null, null );
					foreach( $data as $key => $val ) 
						$ws->$key = $val;
					return $ws;
				}
			}
		}
		$dbr = CentralAuthUser::getCentralSlaveDB();
		$row = $dbr->selectRow(
			'wikiset', '*', array( 'ws_name' => $name ), __METHOD__
		);
		if( !$row )
			return null;
		$ws = self::newFromRow( $row );
		$ws->saveToCache();
		return $ws;
	}

	public static function newFromID( $id, $useCache = true ) {
		if( $useCache ) {
			global $wgMemc;
			$data = $wgMemc->get( self::memcKey( $id ) );
			if( $data ) {
				if( $data['mVersion'] == self::VERSION ) {
					$ws = new WikiSet( null, null, null );
					foreach( $data as $name => $val ) 
						$ws->$name = $val;
					return $ws;
				}
			}
		}
		$dbr = CentralAuthUser::getCentralSlaveDB();
		$row = $dbr->selectRow(
			'wikiset', '*', array( 'ws_id' => $id ), __METHOD__
		);
		if( !$row )
			return null;
		$ws = self::newFromRow( $row );
		$ws->saveToCache();
		return $ws;
	}

	public function commit() {
		$dbw = CentralAuthUser::getCentralDB();
		$dbw->replace( 'wikiset', array( 'ws_id' ),
			array(
				'ws_id' => $this->mId,
				'ws_name' => $this->mName,
				'ws_type' => $this->mType,
				'ws_wikis' => implode( ',', $this->mWikis ),
			), __METHOD__
		);
		$dbw->commit();
		if( !$this->mId )
			$this->mId = $dbw->insertId();
		$this->purge();
		return (bool)$dbw->affectedRows();
	}

	public function purge() {
		global $wgMemc;
		$wgMemc->delete( self::memcKey( $this->mId ) );
		$wgMemc->delete( self::memcKey( "name:" . md5( $this->mName ) ) );
	}

	public function saveToCache() {
		global $wgMemc;
		$data = array();
		foreach( self::$mCacheVars as $var ) {
			$data[$var] = $this->$var;
		}
		$wgMemc->set( self::memcKey( $this->mId ), $data );
	}

	public function getWikis() {
		if( $this->mType == self::OPTIN ) 
			return $this->mWikis;
		else
			return array_diff( CentralAuthUser::getWikiList(), $this->mWikis );
	}

	public function inSet( $wiki = '' ) {
		if( !$wiki )
			$wiki = wfWikiID();
		return in_array( $wiki, $this->getWikis() );
	}

	public function getRestrictedGroups() {
		$dbr = CentralAuthUser::getCentralSlaveDB();
		$r = $dbr->select(
			'global_group_restrictions', '*', array( 'ggr_set' => $this->mId ), __METHOD__
		);
		$result = array();
		foreach( $r as $row )
			$result[] = $row->ggr_group;
		return $result;
	}

	public static function getAllWikiSets() {
		$dbr = CentralAuthUser::getCentralSlaveDB();
		$res = $dbr->select( 'wikiset', '*', false, __METHOD__ );
		$result = array();
		while( $row = $dbr->fetchObject( $res ) )
			$result[] = self::newFromRow( $row );
		return $result;
	}

	public static function getWikiSetForGroup( $group ) {
		$dbr = CentralAuthUser::getCentralSlaveDB();
		$res = $dbr->selectRow( 'global_group_restrictions', '*', array( 'ggr_group' => $group ), __METHOD__ );
		return $res ? $res->ggr_set : 0;
	}

	public static function formatType( $type ) {
		return wfMsgHtml( "centralauth-rightslog-set-{$type}" );
	}
}
