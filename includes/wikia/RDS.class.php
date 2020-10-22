<?php

use Wikia\Logger\WikiaLogger;

/**
 * This class provides access to RDS analytics data storage on Amazon
 *
 * @author macbre
 *
 * @see https://wikia-inc.atlassian.net/browse/DE-4421
 */
class RDS {

	private static $connection = null;

	/**
	 * Prepare and execute a given query. Yields results.
	 *
	 * @param string $sql
	 * @param array $params
	 * @return stdClass[]
	 * @throws PDOException
	 */
	public static function query( string $sql, array $params = [] ) {
		$dbh = self::getConnection();
		$queryStatement = $dbh->prepare( $sql );
		// borrowed from Database::query
		if ( !( Profiler::instance() instanceof ProfilerStub ) ) {
			$queryProf = 'rds: ' . substr( DatabaseBase::generalizeSQL( $sql ), 0, 255 );
			$totalProf = 'RDS::query';
			$totalProfileIn = Profiler::instance()->scopedProfileIn( $totalProf );
			$queryProfileIn = Profiler::instance()->scopedProfileIn( $queryProf );
		}
		// @see https://www.php.net/manual/en/pdostatement.execute.php
		try {
			$then = microtime( true );
			$queryStatement->execute( $params );
			$took = microtime( true ) - $then;
		} catch ( \PDOException $e ) {
			WikiaLogger::instance()->error( __METHOD__, [
				'sql' => $sql,
				'params' => $params,
				'exception' => $e,
			] );
			throw $e;
		}
		if ( isset( $totalProfileIn ) ) {
			Profiler::instance()->scopedProfileOut( $queryProfileIn );
			Profiler::instance()->scopedProfileOut( $totalProfileIn );
		}
		WikiaLogger::instance()->info( __METHOD__, [
			'sql' => $sql,
			'params' => $params,
			'rows' => $queryStatement->rowCount(),
			'took_sec' => $took,
		] );

		while ( $row = $queryStatement->fetchObject() ) {
			yield $row;
		}
		// release the results
		$queryStatement = null;
	}

	/**
	 * Lazily connect to RDS using PostgreSQL POD client
	 *
	 * @return PDO
	 * @throws PDOException
	 */
	private static function getConnection(): \PDO {
		global $wgWikiAnalyticsDatabaseUser, $wgWikiAnalyticsDatabasePass, $wgWikiAnalyticsDatabaseHost;
		if ( is_null( self::$connection ) ) {
			$dsn = "pgsql:host={$wgWikiAnalyticsDatabaseHost};dbname=wikianalytics;port=5432";
			// https://www.php.net/manual/en/pdo.connections.php
			// https://www.php.net/manual/en/ref.pdo-pgsql.connection.php
			try {
				$then = microtime( true );
				self::$connection = new \PDO(
					$dsn,
					$wgWikiAnalyticsDatabaseUser,
					$wgWikiAnalyticsDatabasePass
				);
				// don't allow queries longer than 20s
				// if the query times out, the result will be empty
				self::$connection->query( "set statement_timeout to 120000" );
				$took = microtime( true ) - $then;
			} catch ( \PDOException $e ) {
				WikiaLogger::instance()->error( __METHOD__, [
					'host' => $wgWikiAnalyticsDatabaseHost,
					'exception' => $e
				] );
				throw $e;
			}
			WikiaLogger::instance()->info( __METHOD__, [
				'host' => $wgWikiAnalyticsDatabaseHost,
				'took_sec' => $took,
			] );
		}
		return self::$connection;
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
			'SELECT generate_series AS n FROM generate_series((NOW()::DATE - INTERVAL \''. $days .' days\'), (NOW()::DATE), \'1 day\')' . # does not work well with passing the :days as a parameter, so it was added to the string
			'),' .
			'pages AS (' .
			'SELECT dt, views FROM wikianalytics.pageviews_by_wiki_and_date ' .
			'WHERE wiki_id = :wiki_id ' .
			') ' .
			'SELECT n AS dt, COALESCE(views, 0) AS views ' .
			'FROM dates ' .
			'LEFT OUTER JOIN pages ' .
			'ON n=dt ' .
			'ORDER BY dt DESC';

		$res = self::query(
			$sql,
			[ ':wiki_id' => $wgCityId]
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
