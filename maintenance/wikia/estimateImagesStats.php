<?php

/**
 * Script that estimates the amount of images on given wikis
 *
 * @author Macbre
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class EstimateImagesStats extends Maintenance {

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'offset', 'Wikis batch offset' );
		$this->addOption( 'batch', 'Wikis batch size' );
		$this->addOption( 'wam', 'Include WAM 200 wikis only (they\'re excluded by default)' );
		$this->mDescription = 'Estimates the amount of images on given wikis';
	}

	/**
	 * @return array list of IDs of wikis from WAM top 200
	 */
	private function getWAM200Wikis() {
		global $wgDatamartDB;
		$db = $this->getDB( DB_SLAVE, [], $wgDatamartDB );

		$wikis = [];

		$res = $db->select(
			'dimension_top_wikis',
			'wiki_id',
			'',
			__METHOD__,
			[
				'ORDER BY' => 'rank',
				'LIMIT' => 200
			]
		);

		while ( $row = $res->fetchRow() ) {
			$wikis[] = intval( $row['wiki_id'] );
		}

		return $wikis;
	}

	/**
	 * Get wiki stats
	 *
	 * @param $domain string wiki main URL
	 * @return array|bool stats or false in case of an error
	 */
	private function getWikiStats( $domain ) {
		// http://muppet.wikia.com/api.php?action=query&meta=siteinfo&siprop=statistics
		$query = [
			'action' => 'query',
			'meta' => 'siteinfo',
			'siprop' => 'statistics',
			'format' => 'json'
		];

		$url = sprintf( '%sapi.php?%s', $domain, http_build_query( $query ) );

		// send request and parse response
		$options = [
			'noProxy' => true
		];

		$resp = Http::get( $url, 'default', $options );
		$parsed = json_decode( $resp, true );

		return !empty( $parsed['query']['statistics'] ) ? $parsed['query']['statistics'] : false;
	}

	public function execute() {
		$offset = $this->getOption( 'offset', 0 );
		$batch = $this->getOption( 'batch', 500 );
		$wam = $this->hasOption( 'wam' );

		$this->output( "Getting stats for {$batch} wikis (offset {$offset})..." );

		$dbr = WikiFactory::db( DB_SLAVE );

		$conds = [
			'city_public = 1',
		];

		// support --wam option
		$wamWikis = $this->getWAM200Wikis();
		if ( $wam === false ) {
			// exclude WAM wikis
			$conds[] = sprintf( 'city_id NOT IN (%s)', join( ',', $wamWikis ) );
		}
		else {
			// WAM wikis only
			$this->output( ' WAM wikis only!' );
			$conds[] = sprintf( 'city_id IN (%s)', join( ',', $wamWikis ) );
		}

		// get wikis
		$res = $dbr->select(
			'city_list',
			[
				'city_id',
				'city_dbname',
				'city_url'
			],
			$conds,
			__METHOD__,
			[
				'LIMIT' => $batch,
				'OFFSET' => $offset
			]
		);

		// get stats
		$images = 0;
		$wikis = 0;

		while ( $row = $res->fetchRow() ) {
			$this->output( sprintf( "\n#%d: %s <%s>...",
				$row['city_id'],
				$row['city_dbname'],
				$row['city_url']
			) );

			$stats = $this->getWikiStats( $row['city_url'] );

			if ( is_array( $stats ) ) {
				$wikis++;
				$images += $stats['images'];
				$this->output( " {$stats['images']} image(s)" );
			}
			else {
				$this->output( ' error!' );
			}
		}

		$this->output( sprintf( "\nGot %d image(s) for %d wikis\n", $images, $wikis ) );
	}
}

$maintClass = "EstimateImagesStats";
require_once( RUN_MAINTENANCE_IF_MAIN );
