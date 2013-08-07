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

echo date( "Y-m-d H:i:s" );
echo "\n";
echo date( "Y-m-d H:i:s" );
echo "\nScript finished running!\n";

$homePageTest = new CorporateHomePageTest();
$homePageTest->run_tests();


class CorporateHomePageTest {

	public function run_tests() {
		$cityVisualization = new CityVisualization();
		$corporateWikis = $cityVisualization->getVisualizationWikisIds();

		foreach ( $corporateWikis as $wikiId ) {
			$statistics = $this->getStatisticsModulesContents( $wikiId );

		}
	}

	private function getStatisticsModulesContents( $wikiId ) {
		$html = $this->getHomePageContents( $wikiId );
		$statistics = $this->extractNumbersFromHtml( $html );
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

	}

	/**
	 * gets value for given key
	 *
	 * @param $key
	 */
	public function getValue( $key ) {

	}

}