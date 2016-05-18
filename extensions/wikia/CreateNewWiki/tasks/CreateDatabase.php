<?php

namespace Wikia\CreateNewWiki\Tasks;

class CreateDatabase implements Task {

	use \Wikia\Logger\Loggable;

	//TODO would be awesome to read it from some config
	const ACTIVE_CLUSTER = "c7";

	/** @var  TaskContext */
	private $taskContext;

	/** @var  string */
	private $clusterDB;

	public function __construct( $taskContext ) {
		$this->taskContext = $taskContext;
	}

	protected function getLoggerContext() {
		return TaskHelper::getLoggerContext( $this->taskContext );
	}

	public function prepare() {
		$this->taskContext->setSharedDBW( \WikiFactory::db( DB_MASTER ) );
		$this->clusterDB = "wikicities_" . self::ACTIVE_CLUSTER;
		$this->taskContext->setDbName( $this->prepareDatabaseName(
			$this->clusterDB, $this->taskContext->getWikiName(), $this->taskContext->getLanguage() ) );

		return TaskResult::createForSuccess();
	}

	public function check() {
		if ( wfReadOnly() || $this->isClusterReadOnly( $this->taskContext->getWikiDBW() ) ) {
			return TaskResult::createForError( 'DB is read only' );
		} else {
			return TaskResult::createForSuccess();
		}
	}

	private function isClusterReadOnly( $dbw ) {
		// SUS-108: check read-only state of ACTIVE_CLUSTER before performing any DB-related actions
		return $dbw->getLBInfo( 'readOnlyReason' ) !== false;
	}

	public function run() {
		$dbw = wfGetDB( DB_MASTER, array(), $this->clusterDB );
		$dbw->query( sprintf( "CREATE DATABASE `%s`", $this->taskContext->getDBname() ) );

		$dbw = wfGetDB( DB_MASTER, array(), $this->taskContext->getDBname() );
		$this->taskContext->setWikiDBW( $dbw );

		return TaskResult::createForSuccess();
	}

	/**
	 * prepareDatabaseName
	 *
	 * check if database name is used, if it's used prepare another one
	 *
	 * @author Piotr Molski <moli@wikia-inc.com>
	 * @access private
	 *
	 * @param string $clusterDB
	 * @param string	$dbname -- name of DB to check
	 * @param string	$lang   -- language for wiki
	 *
	 * @return string: fixed name of DB
	 */
	private function prepareDatabaseName( $clusterDB, $dbName, $lang ) {
		wfProfileIn( __METHOD__ );

		$dbwf = \WikiFactory::db( DB_SLAVE );
		$dbr  = wfGetDB( DB_SLAVE, array(), $clusterDB );

		if( $lang !== "en" ) {
			$dbName = $lang . $dbName;
		}

		$dbName = substr( str_replace( "-", "", $dbName ), 0 , 50 );

		while( $this->doesDbExistInCityList( $dbwf, $dbName ) || $this->doesDbExistInCluster( $dbr, $dbName ) ) {
			$suffix = rand( 1, 999 );
			$dbName = sprintf("%s%s", $dbName, $suffix);
		}
		wfProfileOut( __METHOD__ );

		return $dbName;
	}

	private function doesDbExistInCityList( $dbwf, $dbName ) {
		$this->debug( __METHOD__ . ": Checking if database " . $dbName . " already exists in city_list" );
		$row = $dbwf->selectRow(
			array( "city_list" ),
			array( "count(*) as count" ),
			array( "city_dbname" => $dbName ),
			__METHOD__
		);
		if( $row->count > 0 ) {
			$this->debug( __METHOD__ . ": Database " . $dbName . " exists in city_list!" );
			return true;
		} else {
			return false;
		}
	}

	private function doesDbExistInCluster( $dbr, $dbName ) {
		$this->debug( __METHOD__ . ": Checking if database " . $dbName . " already exists in cluster" );
		$sth = $dbr->query( sprintf( "show databases like '%s'", $dbName) );
		if ( $dbr->numRows( $sth ) > 0 ) {
			$this->debug( __METHOD__ . ": Database " . $dbName . " exists on cluster!" );
			return true;
		} else {
			return false;
		}
	}
}

