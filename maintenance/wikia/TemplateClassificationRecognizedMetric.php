<?php

require_once __DIR__ . '/../Maintenance.php';

/**
 * Maintenance script counts current number of recognized templates in content namespaces
 *
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @ingroup Maintenance
 */
class TemplateClassificationRecognizedMetricMaintenance extends Maintenance {

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();

		$this->mDescription = 'Maintenance script counts current number of recognized templates in content namespaces';
	}

	/**
	 * Script entry point
	 */
	public function execute() {
		global $wgContentNamespaces, $wgDWStatsDB;

		$statsDBRead = wfGetDB( DB_SLAVE, [], $wgDWStatsDB );
		$wamTop500 = $this->getWamTop500( $statsDBRead, ( new \WikiaSQL ) );

		$top500CNRecognizedCount = 0;
		$top500CNAllCount = 0;

		foreach ( $wamTop500 as $wikia ) {
			$recognizedProvider = new RecognizedTemplatesProvider(
				( new TemplateClassificationService() ),
				$wikia->wiki_id,
				$wgContentNamespaces
			);

			$cnRecognizedTemplates = $recognizedProvider->getRecognizedTemplates();

			$top500CNRecognizedCount += count( $cnRecognizedTemplates );
			$top500CNAllCount += count( $recognizedProvider->getNamespacesTemplates() );
		}

		/*
		 * Store value in DB
		 * TODO uncomment and test when storage is ready
		 */
//		$statsDBWrite = wfGetDB( DB_MASTER, [], $wgStatsDB ); // Change DB
//		$timestamp = date( 'Y-m-d' );
//		$this->setStats( $top500CNRecognizedCount, $top500CNAllCount, $timestamp, $statsDBWrite );

		$this->pushGecko( $top500CNRecognizedCount, $top500CNAllCount );
	}

	private function getWamTop500( $db, \WikiaSQL $sql ) {
		return $sql->SELECT( 'wiki_id' )
			->FROM( 'fact_wam_scores' )
			->WHERE( 'time_id' )->EQUAL_TO( date( 'Y-m-d', time() - 60 * 60 * 24 ) )
			->ORDER_BY( 'wam_rank' )
			->LIMIT( 500 )
			->run( $db );
	}

	private function setStats( $recognizedCNCount, $totalCNCount, $timestamp, $dbw ) {
		( new \WikiaSQL() )->INSERT( 'recognized_content_namespace_templates_count' )
			->SET( 'timestamp', $timestamp )
			->SET( 'recognized_cn', $recognizedCNCount )
			->SET( 'total_cn', $totalCNCount )
			->run( $dbw );
	}

	private function pushGecko( $top500CNRecognizedCount, $top500CNAllCount ) {
		global $wgGeckoboardApiKey, $wgGeckoboardPushUrl, $wgTemplateClassificationGeckometerWidgetKey;

		$metric = 0;
		if ( $top500CNAllCount > 0 ) {
			$metric = $top500CNRecognizedCount / $top500CNAllCount * 100;
		}
		$data = [
			'item' => strval( $metric ),
			'min' => [ 'value' => 0 ],
			'max' => [ 'value' => 100 ]
		];

		$params = [
			'api_key' => $wgGeckoboardApiKey,
			'data' => $data
		];

		Http::post(
			$wgGeckoboardPushUrl . $wgTemplateClassificationGeckometerWidgetKey,
			[ 'postData' => json_encode( $params ) ]
		);
	}
}

$maintClass = 'TemplateClassificationRecognizedMetricMaintenance';
require_once RUN_MAINTENANCE_IF_MAIN;
