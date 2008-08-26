<?php

class CentralAuthUserArray {
	static function newFromResult( $res ) {
		return new CentralAuthUserArrayFromResult( $res );
	}
}

class CentralAuthUserArrayFromResult extends UserArrayFromResult {
	var $globalData;

	function __construct( $res ) {
		parent::__construct( $res );

		if ( $res->numRows() == 0 ) {
			return;
		}

		/**
		 * Load global user data 
		 */
		$names = array();
		foreach ( $res as $row ) {
			$names[] = $row->user_name;
		}
		$res->rewind();

		$dbr = CentralAuthUser::getCentralSlaveDB();
		$caRes = $dbr->select( array( 'localuser', 'globaluser' ), '*',
			array( 
				'gu_name' => $names,
				'lu_name=gu_name',
				'lu_wiki' => wfWikiID()
			), __METHOD__ );
		$this->globalData = array();
		foreach ( $caRes as $row ) {
			$this->globalData[$row->gu_name] = $row;
		}
		wfDebug( __METHOD__.': got user data for ' . implode( ', ', 
			array_keys( $this->globalData ) ) . "\n" );
	}

	function setCurrent( $row ) {
		parent::setCurrent( $row );

		if ( $row !== false ) {
			$caRow = isset( $this->globalData[$row->user_name] ) ? $this->globalData[$row->user_name] : false;
			$this->current->centralAuthObj = CentralAuthUser::newFromRow( $caRow );
		}
	}
}

