<?php

class WikiSet {
	const OPTIN = 'optin';
	const OPTOUT = 'optout';
	const VERSION = 1;

	private $mId;	// ID of the group
	private $mName;	// Display name of the group
	private $mType;	// Opt-in based or opt-out based
	private $mWikis;	// List of wikis
	// This property is used, don't remove it
	// (That means you Reedy)
	private $mVersion = self::VERSION;      // Caching purposes

	static $mCacheVars = array(
		'mId',
		'mName',
		'mType',
		'mWikis',
		'mVersion',
	);

	/**
	 * @param $name string
	 * @param $type string
	 * @param $wikis array
	 * @param $id int
	 */
	public function __construct( $name = '', $type = self::OPTIN, $wikis = array(), $id = 0 ) {
		$this->mId = $id;
		$this->mName = $name;
		$this->mType = $type;
		$this->mWikis = $wikis;
	}

	/**
	 * @param $k string
	 * @return string
	 */
	protected static function memcKey( $k ) { return "wikiset:{$k}"; }

	/**
	 * @return int
	 */
	public function getId() { return $this->mId; }

	/**
	 * @return bool
	 */
	public function exists() { return (bool)$this->getID(); }

	/**
	 * @return string
	 */
	public function getName() { return $this->mName; }

	/**
	 * @param $n
	 * @param $commit bool
	 */
	public function setName( $n, $commit = false ) { return $this->setDbField( 'ws_name', $n, $commit ); }

	/**
	 * @return array
	 */
	public function getWikisRaw() { return $this->mWikis; }

	/**
	 * @param $w
	 * @param $commit bool
	 */
	public function setWikisRaw( $w, $commit = false ) { return $this->setDbField( 'ws_wikis', $w, $commit ); }

	/**
	 * @return string
	 */
	public function getType() { return $this->mType; }

	/**
	 * @param $t
	 * @param bool $commit bool
	 * @return bool
	 */
	public function setType( $t, $commit = false ) {
		if ( !in_array( $t, array( self::OPTIN, self::OPTOUT ) ) ) {
			return false;
		}
		return $this->setDbField( 'ws_type', $t, $commit );
	}

	/**
	 * @param $field
	 * @param $value
	 * @param $commit
	 */
	protected function setDbField( $field, $value, $commit ) {
		$map = array( 'ws_name' => 'mName', 'ws_type' => 'mType', 'ws_wikis' => 'mWikis' );
		$mname = $map[$field];
		$this->$mname = $value;
		if ( $commit ) {
			$this->commit();
		}
	}

	/**
	 * @param $row
	 * @return null|WikiSet
	 */
	public static function newFromRow( $row ) {
		if ( !$row ) {
			return null;
		}
		return new WikiSet(
			$row->ws_name,
			$row->ws_type,
			explode( ',', $row->ws_wikis ),
			$row->ws_id
		);
	}

	/**
	 * @param $name
	 * @param $useCache bool
	 * @return null|WikiSet
	 */
	public static function newFromName( $name, $useCache = true ) {
		if ( $useCache ) {
			global $wgMemc;
			$data = $wgMemc->get( self::memcKey( "name:" . md5( $name ) ) );
			if ( $data ) {
				if ( $data['mVersion'] == self::VERSION ) {
					$ws = new WikiSet( null, null );
					foreach ( $data as $key => $val ) {
						$ws->$key = $val;
					}
					return $ws;
				}
			}
		}
		$dbr = CentralAuthUser::getCentralSlaveDB();
		$row = $dbr->selectRow(
			'wikiset', '*', array( 'ws_name' => $name ), __METHOD__
		);
		if ( !$row ) {
			return null;
		}
		$ws = self::newFromRow( $row );
		$ws->saveToCache();
		return $ws;
	}

	/**
	 * @param $id
	 * @param $useCache bool
	 * @return null|WikiSet
	 */
	public static function newFromID( $id, $useCache = true ) {
		if ( $useCache ) {
			global $wgMemc;
			$data = $wgMemc->get( self::memcKey( $id ) );
			if ( $data ) {
				if ( $data['mVersion'] == self::VERSION ) {
					$ws = new WikiSet( null, null );
					foreach ( $data as $name => $val ) {
						$ws->$name = $val;
					}
					return $ws;
				}
			}
		}
		$dbr = CentralAuthUser::getCentralSlaveDB();
		$row = $dbr->selectRow(
			'wikiset', '*', array( 'ws_id' => $id ), __METHOD__
		);
		if ( !$row ) {
			return null;
		}
		$ws = self::newFromRow( $row );
		$ws->saveToCache();
		return $ws;
	}

	/**
	 * @return bool
	 */
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
		if ( !$this->mId ) {
			$this->mId = $dbw->insertId();
		}
		$this->purge();
		return (bool)$dbw->affectedRows();
	}

	/**
	 * @return bool
	 */
	public function delete() {
		$dbw = CentralAuthUser::getCentralDB();
		$dbw->delete( 'wikiset', array( 'ws_id' => $this->mId ), __METHOD__ );
		$dbw->commit();
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
		foreach ( self::$mCacheVars as $var ) {
			if ( isset( $this->$var ) ) {
				$data[$var] = $this->$var;
			}
		}
		$wgMemc->set( self::memcKey( $this->mId ), $data );
	}

	/**
	 * @return array
	 */
	public function getWikis() {
		if ( $this->mType == self::OPTIN ) {
			return $this->mWikis;
		} else {
			return array_diff( CentralAuthUser::getWikiList(), $this->mWikis );
		}
	}

	/**
	 * @param $wiki string
	 * @return bool
	 */
	public function inSet( $wiki = '' ) {
		if ( !$wiki ) {
			$wiki = wfWikiID();
		}
		return in_array( $wiki, $this->getWikis() );
	}

	/**
	 * @return array
	 */
	public function getRestrictedGroups() {
		$dbr = CentralAuthUser::getCentralSlaveDB();
		$r = $dbr->select(
			'global_group_restrictions', '*', array( 'ggr_set' => $this->mId ), __METHOD__
		);
		$result = array();
		foreach ( $r as $row ) {
			$result[] = $row->ggr_group;
		}
		return $result;
	}

	/**
	 * @return array
	 */
	public static function getAllWikiSets() {
		$dbr = CentralAuthUser::getCentralSlaveDB();
		$res = $dbr->select( 'wikiset', '*', false, __METHOD__ );
		$result = array();
		foreach ( $res as $row ) {
			$result[] = self::newFromRow( $row );
		}
		return $result;
	}

	/**
	 * @param $group
	 * @return int
	 */
	public static function getWikiSetForGroup( $group ) {
		$dbr = CentralAuthUser::getCentralSlaveDB();
		$res = $dbr->selectRow( 'global_group_restrictions', '*', array( 'ggr_group' => $group ), __METHOD__ );
		return $res ? $res->ggr_set : 0;
	}

	/**
	 * @static
	 * @param $type
	 * @return string
	 */
	public static function formatType( $type ) {
		return wfMsgHtml( "centralauth-rightslog-set-{$type}" );
	}
}
