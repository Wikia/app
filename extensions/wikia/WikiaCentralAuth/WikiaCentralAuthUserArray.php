<?php

class WikiaCentralAuthUserArray {
	static function newFromResult( $res ) {
		return new WikiaCentralAuthUserArrayFromResult( $res );
	}
}

class WikiaCentralAuthUserArrayFromResult extends UserArrayFromResult {
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

		$dbr = WikiaCentralAuthUser::getCentralSlaveDB();
		$caRes = $dbr->select( 
			'user', 
			'*',
			array( 
				'user_name' => $names
			), 
			__METHOD__ 
		);
		$this->globalData = array();
		foreach ( $caRes as $row ) {
			$this->globalData[$row->user_name] = $row;
		}
		wfDebug( __METHOD__.': got user data for ' . implode( ', ', array_keys( $this->globalData ) ) . "\n" );
	}

	function setCurrent( $row ) {
		parent::setCurrent( $row );

		if ( $row !== false ) {
			$caRow = isset( $this->globalData[$row->user_name] ) ? $this->globalData[$row->user_name] : false;
			$this->current->centralAuth = WikiaCentralAuthUser::newFromRow( $caRow );
		}
	}
}

