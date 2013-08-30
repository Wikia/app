<?php

/**
 *
 ********************************** <important> ****************************************
 * This is a proof-of-concept and not a final implementation.
 * It MUST NOT be reused or copied at this point
 * Thank you. :)
 ********************************** </important> ****************************************
 *
 *
 *
 * this script runs periodically, pulls the Corporate Pages
 * (with statistics modules),
 * parses the data in statistics modules and stores it.
 * If there is no stats module, number of modules is wrong
 * or the data does not change for specified number of days,
 * an email is sent to designated person(s)
 *
 * Example:
 * run_maintenance --script='wikia/checks/homePagesChecks.php \
 *   --noChangeThreshold=4 --watcherEmails=email1@wikia-inc.com,email2@wikia-inc.com'
 *
 */

ini_set( "include_path", dirname( __FILE__ ) . "/../.." );
require_once( 'commandLine.inc' );

echo 'Execution starts ' . date( "Y-m-d H:i:s" );
echo "\n";

$homePageTest = new CorporateHomePageChecker( $options );
$homePageTest->runTests();

echo 'Execution ends' . date( "Y-m-d H:i:s" );
echo "\nScript finished running!\n";

class CorporateHomePageChecker {

	const REPORT_EMAIL_TOPIC = 'Abnormal condition on Corporate Page detected';
	const NO_STATS_MODULE_FOUND = 'No stats module found on CityID %d';
	const INVALID_STATS_MODULE_NUMBER = 'Found %d stats modules instead of %d on CityID %d';
	const STATISTIC_DID_NOT_CHANGE = 'Statistic %d did not change on CityID %d';
	const DEFAULT_NO_CHANGE_THRESHOLD = 7;
	const EXPECTED_NUMBER_OF_STAT_MODULES = 6;
	const DATE_FORMAT = "Y-m-d";

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
	private $noChangeThreshold;

	/**
	 * @var array
	 */
	private $watcherEmails;

	/**
	 * @var array
	 */
	private $collectedErrors;

	/**
	 * Modules excluded from change checks
	 *
	 * @var array
	 */
	private $excludedModules = [ 0, 1 ];


	/**
	 * @param $params array of options
	 *
	 * Valid options are:
	 * noChangeThreshold (int) -> how many days of non-changed stat cause an error
	 */
	public function __construct( $params ) {
		$this->baseDate = date( self::DATE_FORMAT );
		if ( !empty( $params['noChangeThreshold'] ) ) {
			$this->noChangeThreshold = intval( $params['noChangeThreshold'] );
		} else {
			$this->noChangeThreshold = self::DEFAULT_NO_CHANGE_THRESHOLD;
		}
		if ( !empty( $params['watcherEmails'] ) ) {
			$this->watcherEmails = explode( ',', $params['watcherEmails'] );
		} else {
			// if no emails are passed, we don't send anything
			$this->watcherEmails = [];
		}

		$this->dataStorage = new CorporateHomePageStatisticsStorage();
		$cityVisualization = new CityVisualization();
		$this->corporateWikis = $cityVisualization->getVisualizationWikisIds();
		$this->collectedErrors = [];
	}

	public function runTests() {

		foreach ( $this->corporateWikis as $wikiId ) {
			$corpWikiStatistics = $this->processCorporateWikiStats( $wikiId );

			if ( !$corpWikiStatistics ) {
				$this->collectError( self::NO_STATS_MODULE_FOUND, [ $wikiId ] );
			} elseif ( count( $corpWikiStatistics ) != self::EXPECTED_NUMBER_OF_STAT_MODULES ) {
				$this->collectError( self::INVALID_STATS_MODULE_NUMBER, [ count( $corpWikiStatistics ), self::EXPECTED_NUMBER_OF_STAT_MODULES, $wikiId ] );
			} else {
				$this->verifyStatsChanged( $wikiId, $corpWikiStatistics );
			}
		}

		if ( $this->sendErrors() ) {
			echo "Error(s) detected\n";
		} else {
			echo "No errors detected\n";
		}
	}

	private function verifyStatsChanged( $wikiId, $corpWikiStatistics ) {
		$datesToCheck = [];

		/*
		 * checking noChangeThreshold days total, which means we're counting baseDate too
		 */
		for ( $i = 1; $i < $this->noChangeThreshold; $i ++ ) {
			$datesToCheck[] = date( self::DATE_FORMAT, strtotime( $this->baseDate . " -$i days" ) );
		}

		foreach ( $corpWikiStatistics as $statKey => $statValue ) {
			// only check modules that we care for
			if ( in_array( $statKey, $this->excludedModules ) ) {
				continue;
			}

			$changed = false;

			foreach ( $datesToCheck as $date ) {
				$previousStatValue = $this->dataStorage->getValue( $this->getStatsKey( $date, $wikiId, $statKey ) );

				if ( $statValue != $previousStatValue ) {
					$changed = true;
					break;
				}
			}
			if ( !$changed ) {
				$this->collectError( self::STATISTIC_DID_NOT_CHANGE, [ $statKey, $wikiId ] );
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

		if ( !empty( $corpWikiStatistics ) ) {
			foreach ( $corpWikiStatistics as $statKey => $statValue ) {
				// only store modules that we care for
				if ( !in_array( $statKey, $this->excludedModules ) ) {
					$this->dataStorage->setValue( $this->getStatsKey( $this->baseDate, $wikiId, $statKey ), $statValue );
				}
			}
			$result = $corpWikiStatistics;
		} else {
			$result = false;
		}

		return $result;
	}

	private function collectError( $errMessage, $data ) {
		$errMessage = vsprintf( $errMessage, $data );
		$this->collectedErrors[] = $errMessage;
	}

	/**
	 * Sends out emails; Returns true if any error notifications were sent,
	 * false otherwise
	 *
	 * @return bool
	 */
	private function sendErrors() {
		$result = false;
		if ( !empty( $this->collectedErrors ) ) {
			$errorList = implode( "\n", $this->collectedErrors );
			foreach ( $this->watcherEmails as $email ) {
				UserMailer::send( new MailAddress( $email ), new MailAddress( $email ), self::REPORT_EMAIL_TOPIC, $errorList );
			}
			$result = true;
		}

		return $result;
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

		if ( !empty( $htmlContents ) ) {
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
		$matches = [];

		preg_match_all( $regex, $html, $matches );
		if ( !empty( $matches[1] ) && count( $matches[1] ) == self::EXPECTED_NUMBER_OF_STAT_MODULES ) {
			$output = $matches[1];
			$output = $this->normalizeNumbersArray( $output );
		} else {
			$output = [];
		}

		return $output;
	}

	/**
	 * @param $array
	 * @return $array
	 */
	private function normalizeNumbersArray( $array ) {
		$newArray = [];
		foreach ( $array as $key => $value ) {
			$newArray[$key] = intval( preg_replace( '#\D#imsU', '', $value ) );
		}

		return $newArray;
	}

}

/**
 * Class CorporateHomePageStatisticsStorage
 * basically, any key-value storage implementation
 * can be used here
 */
class CorporateHomePageStatisticsStorage {

	/**
	 * slave db connection
	 *
	 * @var
	 */
	private $sdbConn;

	/**
	 * master db connection
	 *
	 * @var
	 */
	private $mdbConn;

	/**
	 * Stores value for given key
	 *
	 * @param $key
	 * @param $value
	 */
	public function setValue( $key, $value ) {
		echo "setting $value at $key\n";
		$db = $this->getMaster();

		// insert or update
		$db->replace( '`common_key_value`', [ '`key`' ], [ '`key`' => $key, '`value`' => $value ], __METHOD__ );
	}

	/**
	 * gets value for given key
	 *
	 * @param $key
	 * @return mixed|null
	 */
	public function getValue( $key ) {
		$value = null;

		echo "getting value from $key\n";
		$db = $this->getSlave();
		$result = $db->select( 'common_key_value', [ '`value`' ], [ '`key`' => $key ], __METHOD__ );
		$row = $result->fetchRow();
		if ( $row ) {
			$value = $row[ 'value' ];
		}

		return $value;


	}

	/**
	 * @return DatabaseBase
	 */
	private function getMaster() {
		if ( $this->mdbConn == null ) {
			$this->mdbConn = wfGetDB( DB_MASTER, [], 'specials' );
		}

		return $this->mdbConn;
	}

	/**
	 * @return DatabaseBase
	 */
	private function getSlave() {
		if ( $this->sdbConn == null ) {
			$this->sdbConn = wfGetDB( DB_SLAVE, [], 'specials' );
		}

		return $this->sdbConn;
	}

}
