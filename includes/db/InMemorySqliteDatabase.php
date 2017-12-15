<?php

class InMemorySqliteDatabase extends DatabaseSqlite {

	function __construct( PDO $pdo ) {
		$this->mConn = $pdo;

		$this->setFlag( DBO_TRX );
		$this->open();
	}

	function open( $server = false, $user = false, $pass = false, $dbName = false ) {
		if ( $this->mConn ) {
			$this->mOpened = true;
			return $this->mConn;
		}

		return false;
	}

	function tableName( $name, $format = 'quoted' ) {
		return $name;
	}
}
