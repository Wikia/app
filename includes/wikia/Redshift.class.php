<?php

use Wikia\Logger\WikiaLogger;

/**
 * This class provides access to Redshift analytics data storage on Amazon
 *
 * @author macbre
 *
 * @see https://wikia-inc.atlassian.net/browse/DE-4421
 */
class Redshift {

	private static $connection = null;

	/**
	 * Lazily connect to Redshift using PostgreSQL POD client
	 *
	 * @return \PDO
	 * @throws \PDOException
	 */
	private static function getConnection() : \PDO {
		global $wgRedshiftUser, $wgRedshiftPass, $wgRedshiftHost;

		if ( is_null( self::$connection ) ) {
			$dsn = "pgsql:host={$wgRedshiftHost};dbname=wikianalytics;port=5439";

			// https://www.php.net/manual/en/pdo.connections.php
			// https://www.php.net/manual/en/ref.pdo-pgsql.connection.php
			try {
				$then = microtime(true);
				self::$connection = new \PDO( $dsn, $wgRedshiftUser, $wgRedshiftPass );
				$took = microtime(true) - $then;
			}
			catch ( \PDOException $e ) {
				WikiaLogger::instance()->error( __METHOD__, [
					'host' => $wgRedshiftHost,
					'exception' => $e,
				] );
				throw $e;
			}

			WikiaLogger::instance()->info( __METHOD__, [
				'host' => $wgRedshiftHost,
				'took_sec' => $took,
			] );
		}

		return self::$connection;
	}

	/**
	 * Prepare and execute a given query. Yields results.
	 *
	 * @param string $sql
	 * @param array $params
	 * @return \stdClass[]
	 * @throws \PDOException
	 */
	public static function query( string $sql, array $params = [] ) {
		$dbh = self::getConnection();
		$sth = $dbh->prepare($sql );

		// borrowed from Database::query
		if ( !( \Profiler::instance() instanceof \ProfilerStub ) ) {
			$queryProf = 'redshift: ' . substr( \DatabaseBase::generalizeSQL( $sql ), 0, 255 );
			$totalProf = 'Redshift::query';
			$totalProfileIn = \Profiler::instance()->scopedProfileIn( $totalProf );
			$queryProfileIn = \Profiler::instance()->scopedProfileIn( $queryProf );
		}

		// @see https://www.php.net/manual/en/pdostatement.execute.php
		try {
			$then = microtime( true );
			$sth->execute( $params );
			$took = microtime( true ) - $then;
		}
		catch ( \PDOException $e) {
			WikiaLogger::instance()->error( __METHOD__, [
				'sql' => $sql,
				'params' => $params,
				'exception' => $e,
			] );
			throw $e;
		}

		if ( isset( $totalProfileIn ) ) {
			\Profiler::instance()->scopedProfileOut( $queryProfileIn );
			\Profiler::instance()->scopedProfileOut( $totalProfileIn );
		}

		WikiaLogger::instance()->info( __METHOD__, [
			'sql' => $sql,
			'params' => $params,
			'rows' => $sth->rowCount(),
			'took_sec' => $took,
		] );

		while($row = $sth->fetchObject()) {
			yield $row;
		}

		// release the results
		$sth = null;
	}

	/**
	 * Return daily page views.
	 *
	 * @param int $days
	 * @return	array	Daily page views.
	 */
	public static function getDailyTotals(int $days) : array {
		global $wgCityId;

		$sql = 'WITH dates AS (' . # generates a sequence of dates between the current date and :days before
			'SELECT (GETDATE()::date - row_number() OVER (ORDER BY true))::date AS n ' .
			'FROM wikianalytics.pageviews ' .
			'LIMIT :days ' .
			'),' .
			'data AS (' .
			'SELECT dt, SUM(cnt) AS views FROM wikianalytics.pageviews ' .
			'WHERE wiki_id = :wiki_id ' .
			'GROUP BY dt ' .
			') ' .
			'SELECT n AS dt, NVL(views, 0) AS views ' .
			'FROM dates ' .
			'LEFT OUTER JOIN data ' .
			'ON n=dt ' .
			'ORDER BY dt DESC';

		$res = self::query(
			$sql,
			[ ':wiki_id' => $wgCityId, ':days' => $days ]
		);

		$pageviews = [];
		foreach($res as $row) {
			// e.g. 2019-06-28 -> 166107
			$pageviews[ $row->dt ] = $row->views;
		}

		// sort dates ascending
		ksort($pageviews);

		return $pageviews;
	}

}
