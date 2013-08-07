<?php

/**
 * this script runs periodically, pulls the Corporate Pages
 * (with statistics modules),
 * parses the data in statistics modules and stores it.
 * If the data does not change for N days,
 * an email is sent to designated person
 */

ini_set( "include_path", dirname( __FILE__ ) . "/../.." );
require_once( 'commandLine.inc' );

echo 'Execution starts ' . date( "Y-m-d H:i:s" );
echo "\n";

$homePageTest = new CorporateHomePageTest();
$homePageTest->run_tests();

echo 'Execution ends' . date( "Y-m-d H:i:s" );
echo "\nScript finished running!\n";

class CorporateHomePageTest {

	/**
	 * @var CorporateHomePageStatisticsStorage
	 */
	private $dataStorage;

	/**
	 * @var string
	 */
	private $currentDate;


	public function __construct() {
		$this->currentDate = date( "Y-m-d" );
		$this->dataStorage = new CorporateHomePageStatisticsStorage();
	}

	public function run_tests() {
		$cityVisualization = new CityVisualization();
		$corporateWikis = $cityVisualization->getVisualizationWikisIds();

		foreach ( $corporateWikis as $wikiId ) {
			$this->processCorporateWikiStats( $wikiId );
		}
	}

	private function processCorporateWikiStats( $wikiId ) {
		$corpWikiStatistics = $this->getStatisticsModulesContents( $wikiId );
		foreach ( $corpWikiStatistics as $statName => $statValue ) {
			$this->dataStorage->setValue( $this->getStatsKey( $this->currentDate, $wikiId, $statName ), $statValue );
		}
	}

	private function getStatisticsModulesContents( $wikiId ) {
		$homePageHtml = $this->getHomePageContents( $wikiId );
		$homePageStatistics = $this->extractNumbersFromHtml( $homePageHtml );

		return $homePageStatistics;
	}

	private function getStatsKey( $date, $wikiId, $statName ) {
		return implode( '-', [ $date, $wikiId, $statName ] );
	}

	private function getHomePageContents( $wikiId ) {
		$url = unserialize( WikiFactory::getVarById( 5, $wikiId )->cv_value );

		echo "Loading $wikiId - ${url}";

		$htmlContents =file_get_contents($url);

		if ( !empty( $htmlContents ) ) {
			echo " - success\n";
		} else {
			echo " - failed\n";
			$htmlContents = '';
		}

		return $htmlContents;
	}

	/**
	 * Processes HTML and returns associative array
	 * of stat => value, i.e.
	 *
	 * [
	 *
	 *
	 * ]
	 *
	 * @param $html
	 * @return array
	 */
	private function extractNumbersFromHtml( $html ) {
		return [ ];
	}

}

/**
 * Class CorporateHomePageStatisticsStorage
 * basically, any key-value storage implementation
 * can be used here
 */
class CorporateHomePageStatisticsStorage {

	/**
	 * Stores value for given key
	 *
	 * @param $key
	 * @param $value
	 */
	public function setValue( $key, $value ) {
		echo "setting $value at $key\n";
	}

	/**
	 * gets value for given key
	 *
	 * @param $key
	 */
	public function getValue( $key ) {

	}

}
