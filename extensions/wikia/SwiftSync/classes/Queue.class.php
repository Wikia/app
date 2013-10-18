<?php
/**
 * Class definition for Wikia\SwiftSync\Queue
 */
namespace Wikia\SwiftSync;

/**
 * SwiftSync class needed to sync files between DC
 * 
 * @author moli
 * @package SwiftSync
 */
class Queue {
	/* @Int WikiId - Wiki ID */
	public $city_id;
	/* @String action - action name */
	public $action = '';
	/* @String dst - destination file */
	public $dst = '';
	/* @String src - source file */
	public $src = ''; 
	
	/* sync files table */
	const SYNC_TABLE = 'image_sync';
	/* sync files db */
	const SYNC_DB = 'swift_sync';
	
	/*
	 * constructor
	 */
	public function __construct( $city_id, $action, $dst, $src = '' ) {
		$this->city_id = $city_id;
		$this->action  = $action;
		$this->dst     = $dst;
		$this->src     = $src;
	}
	
	/*
	 * @param Array $params (op, city_id, dst)
	 * @return \Queue object
	 */
	static public function newFromParams( $params ) {
		global $wgCityId;
		wfProfileIn( __METHOD__ );
error_log( __METHOD__ . ": params = " . print_r( $params, true ), 3, "/tmp/moli.log" );
		
		if ( !isset( $params[ 'dst' ] ) ) {
			if ( !empty( $params[ 'op' ] ) && ( $params[ 'op' ] == 'delete' ) ) {
				$params[ 'dst' ] = $params[ 'src' ];
			} else {
				$params[ 'dst' ] = '';
			}
		}
		
		if ( !isset( $params[ 'src' ] ) ) {
			$params[ 'src' ] = '';
		}
		
		$city_id = ( !empty( $params[ 'city_id' ] ) ) ? $params[  'city_id' ] : $wgCityId;
		
		$obj = new Queue( $city_id, $params[ 'op' ], $params[ 'dst' ], $params[ 'src' ] );
		
		wfProfileOut( __METHOD__ );
		return $obj; 
	}
	
	/*
	 * @param $row (op, city_id, dst)
	 * @return \Queue object
	 */	
	static public function newFromRow( $row ) {
		wfProfileIn( __METHOD__ );
		
		if ( !isset( $row->img_dest ) ) {
			\Wikia\SwiftStorage::log( __METHOD__, 'Image destination is empty' );
			return false;
		}
		
		if ( empty( $row->city_id ) ) {
			\Wikia\SwiftStorage::log( __METHOD__, 'Wikia identify is empty' );
			return false;
		}
		
		if ( empty( $row->img_action ) ) {
			\Wikia\SwiftStorage::log( __METHOD__, 'Sync action is empty' );
			return false;
		}
		
		$obj = new Queue( $row->city_id, $row->img_action, $row->img_dest, $row->img_src );
		
		wfProfileOut( __METHOD__ );
		return $obj; 
	}
	
	static public function getTable() {
		return sprintf( "`%s`.`%s`", self::SYNC_DB, self::SYNC_TABLE );
	}
	
	static public function getDB( $master = false ) {
		global $wgSpecialsDB;
		
		return wfGetDB( ( empty( $master ) ) ? DB_SLAVE : DB_MASTER, array(), $wgSpecialsDB );
	}
	
	/* 
	 * Save information about uploaded image in database 
	 * @return Boolean True/False
	 */ 
	public function add() {
		wfProfileIn( __METHOD__ );
		
		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return false;
		}
		
		if ( empty( $this->action ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}
				
		$dbw = self::getDB( true );
		$dbw->begin();
		$dbw->insert(
			self::getTable(),
			[
				'city_id'    => $this->city_id,
				'img_action' => $this->action,
				'img_dest'   => $this->dst,
				'img_src'    => $this->src,
				'img_added'  => wfTimestamp( TS_DB ),
			], 
			__METHOD__ 
		);
		$dbw->commit();
		
		wfProfileOut( __METHOD__ );
		return true;
	}
}

