<?php
/**
 * Class definition for Wikia\SwiftSync\Queue
 */
namespace Wikia\SwiftSync;

use \Wikia\Logger\WikiaLogger;

/**
 * SwiftSync class needed to sync files between DC
 * 
 * @author moli
 * @package SwiftSync
 */
class Queue {
	/* @Int Record ID */
	public $id;
	/* @Int WikiId - Wiki ID */
	public $city_id;
	/* @String action - action name */
	public $action = '';
	/* @String dst - destination file */
	public $dst = '';
	/* @String src - source file */
	public $src = ''; 
	/* @Int error - error code */
	private $error =  0;
	
	/* sync files table */
	const SYNC_TABLE = 'image_sync';
	/* archive sync files table */
	const SYNC_ARCH_TABLE = 'image_sync_done';

	/*
	 * constructor
	 */
	public function __construct( $city_id, $action, $dst, $src = '' ) {
		$this->city_id = $city_id;
		$this->action  = $action;
		$this->dst     = $dst;
		$this->src     = $src;
	}

	/**
	 * Log erros from newFromParams method
	 *
	 * @param string $message
	 * @param object $row row that caused an issue
	 */
	private static function log($message, $row) {
		WikiaLogger::instance()->error( 'SwiftStorage: queue item error', [
			'exception' => new \Exception( $message ),
			'row'       => (array) $row
		]);
	}

	/*
	 * set id
	 */
	public function setID( $id ) {
		$this->id = $id;
	}
	
	/*
	 * set error code 
	 */
	public function setError( $error ) {
		$this->error = $error;
	}
	
	/*
	 * @param Array $params (op, city_id, dst)
	 * @return \Queue object
	 */
	static public function newFromParams( $params ) {
		global $wgCityId;
		wfProfileIn( __METHOD__ );
		
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
		
		if ( is_null( $params[ 'city_id' ] ) ) {
			$city_id = $wgCityId;
		} else {
			/* for Avatars */
			$city_id = 0;
		}
		
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
			self::log( 'Image destination is empty', $row );
			wfProfileOut( __METHOD__ );
			return false;
		}
		
		if ( is_null( $row->city_id ) ) {
			self::log( 'Wikia identify is empty', $row );
			wfProfileOut( __METHOD__ );
			return false;
		}
		
		if ( empty( $row->img_action ) ) {
			self::log( 'Sync action is empty', $row );
			wfProfileOut( __METHOD__ );
			return false;
		}

		$obj = new Queue( $row->city_id, $row->img_action, $row->img_dest, $row->img_src );
		
		if ( $obj ) {
			$obj->setID( $row->id );
		}
		
		wfProfileOut( __METHOD__ );
		return $obj; 
	}
	
	static public function getTable() {
		return self::SYNC_TABLE;
	}
	
	static public function getArchTable() {
		return self::SYNC_ARCH_TABLE;
	}
	
	static public function getDB( $master = false ) {
		global $wgSwiftSyncDB;
		return wfGetDB( ( empty( $master ) ) ? DB_SLAVE : DB_MASTER, array(), $wgSwiftSyncDB );
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
	
	/* 
	 * Move parsed image to archive table 
	 * @return Boolean True/False
	 */ 
	public function moveToArchive() {
		wfProfileIn( __METHOD__ );
		
		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return false;
		}
		
		if ( empty( $this->id ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}
		
		$dbw = self::getDB( true );
		$dbw->begin( __METHOD__ );
		$query = "INSERT INTO %s (city_id, img_action, img_src, img_dest, img_added, img_sync, img_error) ";
		$query .= "SELECT city_id, img_action, img_src, img_dest, img_added, img_sync, %s FROM %s WHERE id = %d ";
		$dbw->query(
			sprintf( $query, self::getArchTable(), $this->error, self::getTable(), $this->id ),
			__METHOD__ 
		);
		$dbw->delete( self::getTable(), [ 'id' => $this->id ], __METHOD__ );
		$dbw->commit( __METHOD__ );
		
		wfProfileOut( __METHOD__ );
		return true;
	}
}

