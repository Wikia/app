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

	static private $loadBalancer = null;

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
			/**
			 * Wikia change:
			 *  1. self::getLoadBalancer() - get the fresh connection without a transaction started
			 *  2. clear DBO_TRX flag - do not start transactions automatically after a connection
			 *
			 * @author macbre
			 */
			$this->connection = $this->getLoadBalancer()->getConnection( $this->connectionId, $this->groups, $this->wiki );
			$this->connection->clearFlag( DBO_TRX );
		}

		if ( $this->isConnection( $this->connection ) ) {
			return $this->connection;
		}

		throw new RuntimeException( 'Expected a DatabaseBase instance' );
	}

	/**
	 * Wikia change - get new load balancer instance dedicated for SMW connections
	 * See comments in getConnection() on why we need this
	 *
	 * $this->wiki value is always the same on a given wiki
	 *
	 * @return \LoadBalancer
	 */
	private function getLoadBalancer() {
		if ( self::$loadBalancer === null ) {
			self::$loadBalancer = wfGetLBFactory()->newMainLB( $this->wiki );
		}

		return self::$loadBalancer;
	}

	/**
	 * @see DBConnectionProvider::releaseConnection
	 *
	 * @since 1.9
	 */
	public function releaseConnection() {
		if ( $this->wiki !== false && $this->connection !== null ) {
			$this->getLoadBalancer()->reuseConnection( $this->connection ); # Wikia change
		}
	}

	protected function isConnection( $connection ) {
		return $connection instanceof DatabaseBase;
	}

}
