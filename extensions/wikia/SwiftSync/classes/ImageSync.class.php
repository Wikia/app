<?php
/**
 * Class definition for Wikia\SwiftSync\ImageSync
 */
namespace Wikia\SwiftSync;

class ImageSync implements \Iterator {

	/* @private ResultWrapper */
	private $res;
	/* @private Int - result index */
	private $inx;
	/* @protected Queue - current record */ 
	protected $current;
	
	/* 
	 * @param $res ResultWrapper
	 */
	function __construct( $res ) {
		$this->res = $res;
		$this->inx = 0;
		$this->setCurrent( $this->res->current() );
	}

	/* load top X image to sync */
	public static function newFromQueue( $limit = 50 ) {
		wfProfileIn( __METHOD__ );
		
		$dbr = Queue::getDB();
		$res = $dbr->select( 
			Queue::getTable(),
			[ 'id, city_id, img_action, img_src, img_dest' ], 
			[ 'img_sync is null' ], 
			__METHOD__,
			[ 'ORDER BY' => 'id', 'LIMIT' => $limit ]
		);

		wfProfileOut( __METHOD__ );
		
		return self::parseResult( $res );
	}

	protected static function parseResult( $result ) {
		wfProfileIn( __METHOD__ );

		$syncResult = null;
		if ( !is_null( $result ) ) {
			$syncResult = new ImageSync( $result );
		} else {
			\Wikia\SwiftStorage::log( __METHOD__, 'No image to sync to other DC' );
		}
		
		wfProfileOut( __METHOD__ );
		
		return $syncResult;
	}
	

	/*
	 * @param $row
	 * @return void
	 */
	protected function setCurrent( $row ) {
		if ( $row === false ) {
			$this->current = false;
		} else {
			$this->current = Queue::newFromRow( $row );
		}
	}

	/* @return int */
	public function count() {
		return $this->res->numRows();
	}

	/* @return Queue */
	function current() {
		return $this->current;
	}

	/* @return void */
	function key() {
		return $this->inx;
	}

	/* @return void */
	function next() {
		$row = $this->res->next();
		$this->setCurrent( $row );
		$this->inx++;
	}

	/* @return void */
	function rewind() {
		$this->res->rewind();
		$this->inx = 0;
		$this->setCurrent( $this->res->current() );
	}

	/* @return bool */
	function valid() {
		return $this->current !== false;
	}
}
