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

$homePageTest = new CorporateHomePageTest( [ ] );
$homePageTest->run_tests();

echo 'Execution ends' . date( "Y-m-d H:i:s" );
echo "\nScript finished running!\n";

class CorporateHomePageTest {

	const NO_STATS_MODULE_FOUND = 'No stats module found on $1';
	const STATISTIC_DID_NOT_CHANGE = 'Statistic $1 did not change on $2';
	const DEAULT_NO_CHANGE_TRESHOLD = 7;

	/**
	 * @var CorporateHomePageStatisticsStorage
	 */
	private $dataStorage;

	/**
	 * @var string
	 */
	private $baseDate;

	/**
	 * @var array
	 */
	private $corporateWikis;

	/**
	 * @var integer
	 */
	private $noChangeTreshold;

	/**
	 * @param $params array of options
	 *
	 * Valid options are:
	 * noChangeTreshold (int) -> how many days of non-changed stat cause an error
	 */
	public function __construct( $params ) {
		$this->baseDate = date( "Y-m-d" );
		if ( ! empty( $params['noChangeTreshold'] ) ) {
			$this->noChangeTreshold = $params['noChangeTreshold'];
		} else {
			$this->noChangeTreshold = self::DEAULT_NO_CHANGE_TRESHOLD;
		}
		$this->dataStorage = new CorporateHomePageStatisticsStorage();
		$cityVisualization = new CityVisualization();
		$this->corporateWikis = $cityVisualization->getVisualizationWikisIds();
	}

	public function run_tests() {

		foreach ( $this->corporateWikis as $wikiId ) {
			$corpWikiStatistics = $this->processCorporateWikiStats( $wikiId );

			if ( $corpWikiStatistics ) {
				$this->verifyStatsChanged( $wikiId, $corpWikiStatistics );
			} else {
				$this->signalError( self::NO_STATS_MODULE_FOUND, [ $wikiId ] );
			}
		}
	}

	private function verifyStatsChanged( $wikiId, $corpWikiStatistics ) {
		$datesToCheck = [ ];

		/*
		 * checking noChangeTreshold days total, which means we're counting baseDate too
		 */
		for ( $i = 1; $i < $this->noChangeTreshold; $i ++ ) {
			$datesToCheck [] = date( "Y-m-d", strtotime( $this->baseDate . " -$i days" ) );
		}

		foreach ( $corpWikiStatistics as $statKey => $statValue ) {
			$changed = false;
			$currentStatValue = $statValue;

			foreach ( $datesToCheck as $date ) {
				$previousStatValue = $this->dataStorage->getValue(
					$this->getStatsKey( $date, $wikiId, $statKey )
				);
				if($currentStatValue != $previousStatValue) {
					$changed = true;
					break;
				}
				$currentStatValue = $previousStatValue;
			}
			if(!$changed) {
				$this->signalError( self::STATISTIC_DID_NOT_CHANGE, [ $statKey, $wikiId ] );
			}
		}
	}


	/**
	 * Returns false if new stats were NOT obtained
	 *
	 * @param $wikiId
	 * @return bool|array
	 */
	private function processCorporateWikiStats( $wikiId ) {
		$corpWikiStatistics = $this->getStatisticsModulesContents( $wikiId );

		if ( ! empty( $corpWikiStatistics ) ) {
			foreach ( $corpWikiStatistics as $statKey => $statValue ) {
				$this->dataStorage->setValue( $this->getStatsKey( $this->baseDate, $wikiId, $statKey ), $statValue );
			}
			$result = $corpWikiStatistics;
		} else {
			$result = false;
		}

		return $result;
	}

	private function signalError( $errMessage, $data ) {
		$message = wfMessage( $errMessage, $data )->text();
	}

	private function getStatisticsModulesContents( $wikiId ) {
		$homePageHtml = $this->getHomePageContents( $wikiId );
		$homePageStatistics = $this->extractNumbersFromHtml( $homePageHtml );

		return $homePageStatistics;
	}

	private function getStatsKey( $date, $wikiId, $statKey ) {
		return implode( '-', [ $date, $wikiId, $statKey ] );
	}

	private function getHomePageContents( $wikiId ) {
		$url = unserialize( WikiFactory::getVarById( 5, $wikiId )->cv_value );

		echo "Loading $wikiId - ${url}";

		$htmlContents = file_get_contents( $url );

		if ( ! empty( $htmlContents ) ) {
			echo " - success\n";
		} else {
			echo " - failed\n";
			$htmlContents = '';
		}

		return $htmlContents;
	}

	/**
	 * Processes HTML and returns array of stat values
	 *
	 * @param $html
	 * @return array
	 */
	private function extractNumbersFromHtml( $html ) {
		$regex = '#datasection.*<strong>(.*)<\/strong>.*#imsU';
		$matches = [ ];

		preg_match_all( $regex, $html, $matches );
		if ( ! empty( $matches[1] ) && count( $matches[1] ) == 6 ) {
			$output = $matches[1];
			$this->normalizeNumbersArray( $output );
		} else {
			$output = [ ];
		}

		return $output;
	}

	private function normalizeNumbersArray( &$array ) {
		foreach ( $array as &$value ) {
			$value = intval( preg_replace( '#\D#imsU', '', $value ) );
		}
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
		echo "getting value from $key\n";
	}

}
