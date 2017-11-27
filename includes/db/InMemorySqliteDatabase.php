<?php

class InMemorySqliteDatabase extends DatabaseSqlite {

	function __construct() {
		$this->setFlag( DBO_TRX );
		$this->open();
	}

	function open( $server = false, $user = false, $pass = false, $dbName = false ) {
		$this->mConn = new PDO('sqlite::memory:' );
		if ( $this->mConn ) {
			$this->mOpened = true;
			return $this->mConn;
		}

		return false;
	}

	function tableName( $name, $format = 'quoted' ) {
		return $name;
	}

	public function getConnection(): PDO {
		if ( !$this->mConn ) {
			$this->open();
		}

		return $this->mConn;
	}
}
