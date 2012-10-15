<?php

require( "MetricsMaintenance.php" );

class FetchOfflineGoogleSpreadsheet extends MetricsMaintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Grabs and does stuff with a Google Documents Spreadsheet";
	}

	public function execute() {
		$url = 'https://spreadsheets.google.com/feeds/worksheets/0Au8PHt8_RuNedDJZU0V0NDNJT3JIWlVyVzd3WmFZb1E/private/full';

		// Headers
		$http = MWHttpRequest::factory( 'https://www.google.com/accounts/ClientLogin',
			array(
				'method' => 'POST',
				'postData' => array(
					'accountType' => 'HOSTED_OR_GOOGLE',
					'service' => 'wise', // Spreadsheet service is "wise"
					'Email' => '',
					'Passwd' => '',
					'source' => self::getUserAgent(),
				)
			)
		);
		$http->setHeader( 'User-Agent', self::getUserAgent() );

		$http->execute();
		if ( $http->getStatus() == 403 ) {
			$this->error( '403', true );
		}

		$content = $http->getContent();

		$authToken = null;
		$pos = strpos( $content, 'Auth' );
		if ( $pos !== false ) {
			$authToken = rtrim( substr( $content, $pos + strlen( "Auth=" ) ) );
		}

		if ( $authToken === null ) {
			$this->error( 'No auth token returned. Check your Google Credentials', true );
		}
		$this->output( "Authorised. Got an authorisation token from Google\n" );

		$cookies = $http->getCookieJar();
		$http = $this->buildAuthedRequest( $url, $authToken, $cookies );

		$http->execute();
		$content = $http->getContent();

		$reader = new XMLReader();
		$reader->XML( $content );

		while ( $reader->read() && $reader->name !== 'entry' );

		$worksheets = array();
		while ( $reader->name === 'entry' ) {
			$node = new SimpleXMLElement( $reader->readOuterXML() );

			// Worksheet based feed
			// $src = (string)$node->link[2]['href'];
			//$src = $node->link[2]->attributes()->href;

			// List based feed
			$src = (string)$node->content["src"];
			// $src = $node->content->attributes()->src;

			// Cell based feed
			// $src = (string)$node->link["href"];
			// $src = $node->link->attributes()->href;

			//$this->output( 'Worksheet found: ' . $src . "\n" );
			$worksheets[] = $src;

			// go to next <entry />
			$reader->next( 'entry' );
		}

		$reader->close();
		$this->output( "\n" );

		foreach( $worksheets as $sheet ) {
			$http = $this->buildAuthedRequest( $sheet, $authToken, $cookies );
			$http->execute();
			$content = $http->getContent();

			$this->output( 'Worksheet: ' . $sheet . "\n" );
			$xml = new SimpleXMLElement( $content );

			$this->output( 'Spreadsheet tab title: ' . $xml->title . "\n" );
			$this->output( "\n" );

			if ( $xml->title != 'For Report Card' ) {
				continue;
			}

			$sheetData = array();
			// foreach "tab"/worksheet
			foreach( $xml->entry as $entry ) {
				$namespaces = $entry->getNameSpaces( true );
				$gsx = $entry->children( $namespaces['gsx'] );
				foreach( get_object_vars( $gsx ) as $key => $value ) {
					if ( !isset( $sheetData[$key] ) ) {
						$sheetData[$key] = array();
					}
					$sheetData[$key][] = $value;
					//$this->output( "{$key}: {$value}\n" );
				}
			}
			$this->output( "\n" );
			$this->getDeploymentFigures( $sheetData );
			// var_dump( $sheetData );
			$this->output( "\n" );
		}

		$this->output( "Finished!\n" );
	}

	/**
	 * @param $data array
	 */
	function getDeploymentFigures( $data ) {
		$db = $this->getDb();

		$db->insert( 'offline', $data, __METHOD__, array( 'IGNORE' ) );
	}

	/**
	 * Pretty print xml string
	 *
	 * @param $xml string
	 * @return string
	 */
	function formatXmlString( $xml ) {
		$dom = new DOMDocument;
		$dom->preserveWhiteSpace = false;
		$dom->loadXML( $xml );
		$dom->formatOutput = true;
		return $dom->saveXml();
	}

	/**
	 * @param $url string
	 * @param $token string
	 * @param $cookies CookieJar
	 * @return MWHttpRequest
	 */
	function buildAuthedRequest( $url, $token = null, $cookies = null ) {
		$http = MWHttpRequest::factory( $url, array(
				'method' => 'GET',
			)
		);
		$http->setHeader( 'User-Agent', self::getUserAgent() );
		if ( $cookies !== null ) {
			$http->setCookieJar( $cookies );
		}
		$http->setHeader( 'GData-Version', '3.0' );
		if ( $token  !== null ) {
			$http->setHeader( 'Authorization', "GoogleLogin auth=\"{$token}\"" );
		}
		return $http;
	}

	/**
	 * @return string
	 */
	private static function getUserAgent() {
		return Http::userAgent() . ' MetricsReporting/' . METRICS_REPORTING_VERSION;
	}
}

$maintClass = "FetchOfflineGoogleSpreadsheet";
require_once( DO_MAINTENANCE );
