<?php

require_once( 'Auth/OpenID/DatabaseConnection.php' );

class MediaWikiOpenIDDatabaseConnection extends Auth_OpenID_DatabaseConnection {

	function __construct( $db ) {
		$this->db = $db;
	}

	function autoCommit( $mode ) {
		$old = $this->db->getFlag( DBO_TRX );
		if ( $mode ) {
			$this->db->setFlag( DBO_TRX );
		} else {
			$this->db->clearFlag( DBO_TRX );
		}
		return $old;
	}

	function query( $sql, $params = array() ) {
		return $this->db->safeQuery( $sql, $params );
	}

	function begin() {
		$this->db->begin();
	}

	function commit() {
		$this->db->commit();
	}

	function rollback() {
		$this->db->rollback();
	}

	function getOne( $sql, $params = array() ) {
		$res = $this->query( $sql, $params );

		if ( !$res instanceof ResultWrapper )
			return $res;
		if ( !$res->numRows() )
			return false;

		$row = $res->fetchRow();
		if ( $row !== false ) {
			$res->free();
			return reset( $row );
		} else {
			return false;
		}
	}

	function getRow( $sql, $params = array() ) {
		$res = $this->query( $sql, $params );

		if ( !$res instanceof ResultWrapper )
			return $res;
		if ( !$res->numRows() )
			return false;

		$row = $res->fetchRow();
		$res->free();
		return $row;
	}

	function getAll( $sql, $params = array() ) {
		$res = $this->query( $sql, $params );

		if ( !$res instanceof ResultWrapper )
			return $res;
		if ( !$res->numRows() )
			return false;

		$ret = array();
		foreach ( $res as $row ) {
			$ret[] = (array)$row;
		}
		return $ret;
	}
}
