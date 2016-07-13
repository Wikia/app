<?php

namespace SMW\MediaWiki;

use DatabaseBase;
use RuntimeException;
use SMW\DBConnectionProvider;

/**
 * @license GNU GPL v2+
 * @since 1.9
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LazyDBConnectionProvider implements DBConnectionProvider {

	const SMW_GROUP = 'smw'; # Wikia change

	/**
	 * @var DatabaseBase|null
	 */
	protected $connection = null;

	/**
	 * @var int|null
	 */
	protected $connectionId = null;

	/**
	 * @var string|array
	 */
	protected $groups;

	/**
	 * @var string|boolean $wiki
	 */
	protected $wiki;

	/**
	 * @since 1.9
	 *
	 * @param int $connectionId
	 * @param string|array $groups defaults to LazyDBConnectionProvider::SMW_GROUP - connect to SMW cluster (if needed) // Wikia change
	 * @param string|boolean $wiki
	 */
	public function __construct( $connectionId, $groups = self::SMW_GROUP, $wiki = false ) {
		$this->connectionId = $connectionId;
		$this->groups = $groups;
		$this->wiki = $wiki;

		// Wikia change - begin
		// moved here from wfGetDB()
		global $smwgUseExternalDB, $wgDBname;

		if ( $groups === self::SMW_GROUP && $smwgUseExternalDB === true ) {
			if ( $wiki === false ) {
				$wiki = $wgDBname;
			}
			$this->wiki = "smw+" . $wiki;
			$this->groups = 'smw';
			wfDebug( __METHOD__ . ": smw+ cluster is active, requesting $wiki\n" );
		}

		// Wikia change - end
	}

	/**
	 * @see DBConnectionProvider::getConnection
	 *
	 * @since 1.9
	 *
	 * @return DatabaseBase
	 * @throws RuntimeException
	 */
	public function getConnection() {

		if ( $this->connection === null ) {
			$this->connection = wfGetLB( $this->wiki )->getConnection( $this->connectionId, $this->groups, $this->wiki );
			$this->connection->clearFlag( DBO_TRX ); # Wikia change - do not start transactions automatically
		}

		if ( $this->isConnection( $this->connection ) ) {
			return $this->connection;
		}

		throw new RuntimeException( 'Expected a DatabaseBase instance' );
	}

	/**
	 * @see DBConnectionProvider::releaseConnection
	 *
	 * @since 1.9
	 */
	public function releaseConnection() {
		if ( $this->wiki !== false && $this->connection !== null ) {
			wfGetLB( $this->wiki )->reuseConnection( $this->connection );
		}
	}

	protected function isConnection( $connection ) {
		return $connection instanceof DatabaseBase;
	}

}
