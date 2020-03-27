<?php
/**
 * This is the MySQLi database abstraction layer.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup Database
 */

use Wikia\Util\Assert;

/**
 * Database abstraction object for PHP extension mysqli.
 *
 * @ingroup Database
 * @since 1.22
 * @see Database
 */
class DatabaseMysqli extends DatabaseMysqlBase {

	/* @var mysqli $mConn */
	protected $mConn;

	/**
	 * @param string $sql
	 * @return mysqli_result|bool
	 */
	protected function doQuery( $sql ) {
		if ( $this->bufferResults() ) {
			$ret = $this->mConn->query( $sql );
		} else {
			$ret = $this->mConn->query( $sql, MYSQLI_USE_RESULT );
		}
		return $ret;
	}

	/**
	 * @param string $realServer
	 * @return bool|mysqli
	 * @throws DBConnectionError
	 */
	protected function mysqlConnect( $realServer ) {
		global $wgDBmysql5, $wgMysqlConnectionCharacterSet;

		# Fail now
		# Otherwise we get a suppressed fatal error, which is very hard to track down
		if ( !function_exists( 'mysqli_init' ) ) {
			throw new DBConnectionError( $this, "MySQLi functions missing,"
				. " have you compiled PHP with the --with-mysqli option?\n" );
		}

		// Other than mysql_connect, mysqli_real_connect expects an explicit port
		// and socket parameters. So we need to parse the port and socket out of
		// $realServer
		$port = null;
		$socket = null;
		$hostAndPort = IP::splitHostAndPort( $realServer );
		if ( $hostAndPort ) {
			$realServer = $hostAndPort[0];
			if ( $hostAndPort[1] ) {
				$port = $hostAndPort[1];
			}
		} elseif ( substr_count( $realServer, ':' ) == 1 ) {
			// If we have a colon and something that's not a port number
			// inside the hostname, assume it's the socket location
			$hostAndSocket = explode( ':', $realServer );
			$realServer = $hostAndSocket[0];
			$socket = $hostAndSocket[1];
		}

		$connFlags = 0;
		if ( $this->mFlags & DBO_SSL ) {
			$connFlags |= MYSQLI_CLIENT_SSL;
		}
		if ( $this->mFlags & DBO_COMPRESS ) {
			$connFlags |= MYSQLI_CLIENT_COMPRESS;
		}
		if ( $this->mFlags & DBO_PERSISTENT ) {
			$realServer = 'p:' . $realServer;
		}

		$mysqli = mysqli_init();
		if ( $wgMysqlConnectionCharacterSet ) {
			// Wikia change - allow to specify an explicit connection character set
			$mysqli->options( MYSQLI_SET_CHARSET_NAME, $wgMysqlConnectionCharacterSet );
		} elseif ( $wgDBmysql5 ) {
			// Tell the server we're communicating with it in UTF-8.
			// This may engage various charset conversions.
			$mysqli->options( MYSQLI_SET_CHARSET_NAME, 'utf8' );
		}

		$mysqli->options( MYSQLI_OPT_CONNECT_TIMEOUT, 3 );

		if ( $mysqli->real_connect( $realServer, $this->mUser,
			$this->mPassword, $this->mDBname, $port, $socket, $connFlags )
		) {
			return $mysqli;
		}

		return false;
	}

	/**
	 * @return bool
	 */
	public function closeConnection() {
		return $this->mConn->close();
	}

	/**
	 * @return int
	 */
	function insertId() {
		return $this->mConn->insert_id;
	}

	/**
	 * @return int
	 */
	function lastErrno() {
		if ( $this->mConn ) {
			return $this->mConn->errno;
		} else {
			return mysqli_connect_errno();
		}
	}

	/**
	 * @return int
	 */
	function affectedRows() {
		return $this->mConn->affected_rows;
	}

	/**
	 * @param $db
	 * @return bool
	 */
	function selectDB( $db ) {
		// SRE-105: Only change the DB explicitly if it was actually changed
		if ( $this->mDBname !== $db ) {
			$this->mDBname = $db;
			return $this->mConn->select_db( $db );
		}

		return true;
	}

	/**
	 * @return string
	 */
	function getServerVersion() {
		return $this->mConn->server_info;
	}

	/**
	 * @param mysqli_result $res
	 * @return bool
	 */
	protected function mysqlFreeResult( $res ) {
		Assert::true( $res instanceof mysqli_result, __METHOD__ );
		$res->free_result();
		return true;
	}

	/**
	 * @param mysqli_result $res
	 * @return bool|stdClass
	 */
	protected function mysqlFetchObject( $res ) {
		Assert::true( $res instanceof mysqli_result, __METHOD__ );
		$object = $res->fetch_object();
		if ( $object === null ) {
			return false;
		}
		return $object;
	}

	/**
	 * @param mysqli_result $res
	 * @return array|bool
	 */
	protected function mysqlFetchArray( $res ) {
		Assert::true( $res instanceof mysqli_result, __METHOD__, [ 'sql' => $this->lastQuery() ] );
		$array = $res->fetch_array();
		if ( $array === null ) {
			return false;
		}
		return $array;
	}

	/**
	 * @param mysqli_result $res
	 * @return int
	 */
	protected function mysqlNumRows( $res ) {
		Assert::true( $res instanceof mysqli_result, __METHOD__, [ 'sql' => $this->lastQuery() ] );
		return $res->num_rows;
	}

	/**
	 * @param mysqli_result $res
	 * @return int
	 */
	protected function mysqlNumFields( $res ) {
		Assert::true( $res instanceof mysqli_result, __METHOD__, [ 'sql' => $this->lastQuery() ] );
		return $res->field_count;
	}

	/**
	 * @param mysqli_result $res
	 * @param int $n
	 * @return stdClass
	 */
	protected function mysqlFetchField( $res, $n ) {
		Assert::true( $res instanceof mysqli_result, __METHOD__, [ 'sql' => $this->lastQuery() ] );
		$field = $res->fetch_field_direct( $n );
		$field->not_null = $field->flags & MYSQLI_NOT_NULL_FLAG;
		$field->primary_key = $field->flags & MYSQLI_PRI_KEY_FLAG;
		$field->unique_key = $field->flags & MYSQLI_UNIQUE_KEY_FLAG;
		$field->multiple_key = $field->flags & MYSQLI_MULTIPLE_KEY_FLAG;
		$field->binary = $field->flags & MYSQLI_BINARY_FLAG;
		return $field;
	}

	/**
	 * @param mysqli_result $res
	 * @param int $n
	 * @return string
	 */
	protected function mysqlFieldName( $res, $n ) {
		Assert::true( $res instanceof mysqli_result, __METHOD__, [ 'sql' => $this->lastQuery() ] );
		$field = $res->fetch_field_direct( $n );
		return $field->name;
	}

	/**
	 * @param mysqli_result $res
	 * @param int $n
	 * @return mixed
	 */
	protected function mysqlFieldType( $res, $n ) {
		$field = $res->fetch_field_direct( $n );
		return $field->type;
	}

	/**
	 * @param mysqli_result|ResultWrapper $res
	 * @param int $row
	 * @return bool
	 */
	protected function mysqlDataSeek( $res, $row ) {
		return $res->data_seek( $row );
	}

	/**
	 * @param mysqli|null $conn
	 * @return string
	 */
	protected function mysqlError( $conn = null ) {
		if ( $conn === null ) {
			return mysqli_connect_error();
		} else {
			return $conn->error;
		}
	}

	/**
	 * Escapes special characters in a string for use in an SQL statement
	 * @param string $s
	 * @return string
	 */
	protected function mysqlRealEscapeString( $s ) {
		$ret = $this->mConn->real_escape_string( $s );

		// Wikia change - begin
		// @see PLATFORM-1196
		if ( is_null( $ret ) ) {
			\Wikia\Logger\WikiaLogger::instance()->warning( 'DatabaseMysqli::mysqlRealEscapeString', [
				'arg_type' => is_object( $s ) ? get_class( $s ) : gettype( $s ),
				'exception' => new Exception()
			] );
		}
		// Wikia change - end

		return $ret;
	}

	protected function mysqlPing() {
		return $this->mConn->ping();
	}

	/**
	 * Execute multiple SQL queries concatenated with a semicolon delimiter in a single operation
	 *
	 * @param string $sqlQuery queries to execute
	 * @param string $method name of caller function
	 * @return bool true if operation was successful
	 * @throws DBQueryError
	 */
	public function multiQuery( string $sqlQuery, string $method ): bool {
		$result = $this->mConn->multi_query( $sqlQuery );
		$dbQueryError = null;

		if ( $result ) {
			// process potential errors for all subsequent components of the query
			do {
				$err = $this->lastError();

				if ( $err ) {
					// report error via DBError constructor
					$dbQueryError = new DBQueryError( $this, $err, $this->lastErrno(), $sqlQuery, $method );
				}

			} while ( $this->mConn->next_result() );
		} else {
			// the very first query has failed
			$dbQueryError = new DBQueryError( $this, $this->lastError(), $this->lastErrno(), $sqlQuery, $method );
		}

		if ( $dbQueryError ) {
			throw $dbQueryError;
		}

		return $result;
	}

	/**
	 * Give an id for the connection
	 *
	 * mysql driver used resource id, but mysqli objects cannot be cast to string.
	 * @return string
	 */
	public function __toString() {
		if ( $this->mConn instanceof Mysqli ) {
			return (string)$this->mConn->thread_id;
		} else {
			// mConn might be false or something.
			return (string)$this->mConn;
		}
	}
}
