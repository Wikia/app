<?php
require_once __DIR__ . '/../../Maintenance.php';

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_NOTICE );

/**
 * Script to compare robots response between MW/FC and robots service.
 *
 * This script runs against production wikis (should be run from prod server like cron-s1).
 */
class CompareRobots extends Maintenance {

	private $batchSize = 1000;

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Compares the response of robots service and MW/FC';
	}

	private function httpGet( $url, $headers, $ssl ) {
		$headers['Fastly-FF'] = 1;
		if ( $ssl ) {
			$headers['Fastly-SSL'] = 1;
		}
		$response = \Http::get(
			$url,
			5,	// 5s
			[
				'returnInstance' => true,
				'followRedirects' => false,
				'timeout' => 5,
				'headers' => $headers
			]
		);

		return $response;
	}

	private function fetchRobotsFromMediaWiki( $domain, $ssl=false ) {
		$url = $domain . '/robots.txt';
		return $this->httpGet( $url, [], $ssl );
	}

	private function fetchRobotsFromFC( $domain, $ssl=false ) {
		$headers =[
			'X-Original-Host' => parse_url( $domain, PHP_URL_HOST )
		];
		return $this->httpGet( 'http://graph-cms.fandom.com/robots.txt', $headers, $ssl );
	}

	private function fetchRobotsFromK8s( $domain, $ssl=false ) {
		$url = $domain . '/newrobots.txt';
		return $this->httpGet( $url, [], $ssl );
	}

	private function responsesEqual( $prodResponse, $serviceResponse ) {
		if ( $prodResponse->getStatus() !== $serviceResponse->getStatus() ) {
			$this->error( "\tStatuses don't match, prod: {$prodResponse->getStatus()}, service: {$serviceResponse->getStatus()}" );
			return false;
		}
		if ( $prodResponse->getStatus() >= 300 && $prodResponse->getStatus() < 400 ) {
			$prodRedirect = $prodResponse->getResponseHeader( 'location' );
			$serviceRedirect = $serviceResponse->getResponseHeader( 'location' );
			$serviceRedirect = str_replace( 'newrobots.txt', 'robots.txt', $serviceRedirect);
			if ( $prodRedirect !== $serviceRedirect ) {
				$this->error( "\tRedirects don't match, prod: {$prodRedirect}, service: {$serviceRedirect}" );
				return false;
			}
			return true;
		}
		if ( $prodResponse->getStatus() != 200 ) {
			$this->error( "\tInvalid response status: {$prodResponse->getStatus()}" );
			return false;
		}
		if ( $prodResponse->getContent() !==  $serviceResponse->getContent() ) {
			$this->error( "\tReponse content is different" );
			return false;
		}
		return true;
	}

	public function execute() {
		global $wgHTTPProxy;
		$wgHTTPProxy = 'prod.border.service.sjc.consul:80';

		$db = wfGetDB( DB_SLAVE, [], 'wikicities' );

		$fcCommunities = array_reduce(
			WikiFactory::getVariableForAllWikis(
			FandomCreator\CommunitySetup::WF_VAR_FC_COMMUNITY_ID,
			1000000
			),
			function( $result, $item ) {
				if ($item['value'] != -1) {
					$result[$item['city_id']] = $item['value'];
				}
				return $result;
			},
			[]
		);
		$lastCityId = 0;
		$domainsChecked = 0;
		$failures = 0;
		do {
			$cities = $db->select( 'city_list', ['city_id', 'city_url'],
				"city_id > $lastCityId", __METHOD__,
				[ 'ORDER BY' => 'city_id ASC', 'LIMIT' => $this->batchSize ] );
			while( $wiki = $cities->fetchObject() ) {
				$lastCityId = $wiki->city_id;
				$parsed = parse_url( $wiki->city_url );
				$url = $parsed['scheme'] . '://' . $parsed['host'];
				foreach( [false, true ] as $https ) {
					$this->output( "Checking {$url} domain, https: " . json_encode( $https ) . "\n" );
					if ( !array_key_exists( $wiki->city_id, $fcCommunities ) ) {
						$prodResponse = $this->fetchRobotsFromMediaWiki( $url, $https );
					} else {
						$prodResponse = $this->fetchRobotsFromFC( $url, $https );
					}
					$serviceResponse = $this->fetchRobotsFromK8s( $url, $https );

					$domainsChecked += 1;
					if ( !$this->responsesEqual( $prodResponse, $serviceResponse ) ) {
						$failures += 1;
					} else {
						$this->output( "\tSUCCESS!\n" );
					}
				}
			}
			$rowsCount = $cities->numRows();
			$db->freeResult( $cities );
		} while( $rowsCount == $this->batchSize );

		$this->output( "Total domains checked: {$domainsChecked}, failures: {$failures}" );
	}
}

$maintClass = 'CompareRobots';
require_once RUN_MAINTENANCE_IF_MAIN;
