<?php

class RunescapeApi {

	const API_URL_TEMPLATE = "http://services.runescape.com/m=itemdb_%s/api/graph/%s.json";
	const TOP_TRADED_ITEMS_URL = "http://services.runescape.com/m=itemdb_%s/top100.ws";
	const ONE_SECOND = 1;

	// The APIs for runescape and oldschoolrunescape differ based on the suffix of the itemdb_ parameter
	// (see the URLs above). We'll look at wgCityId to determine which community we're on and therefore which
	// suffix (and therefore which API) we should use.
	const RUNESCAPE_ITEMDB_SUFFIX = "rs";
	const OLDSCHOOL_RUNESCAPE_ITEMDB_SUFFIX = "oldschool";

	private $itemDbSuffix;

	/**
	 * RunescapeApi constructor.
	 * @throws Exception
	 */
	public function __construct() {
		$this->itemDbSuffix = $this->determineItemDbSuffix();
	}

	/**
	 * @param string $itemId
	 * @return GrandExchangeItem
	 * @throws Exception
	 */
	public function getItemById(string $itemId ) : GrandExchangeItem  {
		$url =  sprintf( self::API_URL_TEMPLATE, $this->itemDbSuffix, $itemId );
		$response = $this->makeRequestAndRetryOnFailure( $url );
		if ( $response === false ) {
			throw new Exception( "Error fetching data from runescape API" );
		}

		$jsonResponse = json_decode( $response, true );
		if ( json_last_error() !== JSON_ERROR_NONE || !isset( $jsonResponse['daily'] ) ) {
			throw new Exception( "Error decoding json from runesacpe API. Last error: " . json_last_error() );
		}

		$latestTimestamp = max( array_keys( $jsonResponse['daily'] ) );

		return new GrandExchangeItem(
			$this->convertToSeconds( $latestTimestamp ),
			$jsonResponse['daily'][$latestTimestamp],
			$itemId
		);
	}


	/**
	 * The runscape API returns epoch time in ms, we want it in seconds. Strip off the last 3 digits to do
	 * the conversion
	 * @param $timestamp
	 * @return bool|string
	 */
	private function convertToSeconds( $timestamp ) {
		return substr( $timestamp, 0, -3 );
	}

	public function getTopItems() {
		$idToTradeCountMap = [];
		$url =  sprintf( self::TOP_TRADED_ITEMS_URL, $this->itemDbSuffix );
		$response = $this->makeRequestAndRetryOnFailure( $url );

		if ( $response === false ) {
			return $idToTradeCountMap;
		}

		$domDocument = HtmlHelper::createDOMDocumentFromText( $response );
		$tableBody = $domDocument->getElementsByTagName( 'tbody' );
		$tableRows = $tableBody->item(0)->getElementsByTagName('tr');
		/** @var DOMElement $row */
		foreach( $tableRows as $row ) {
			$totalsColumn = $row->getElementsByTagName( 'td' )->item( 5 );
			$totalsLink = $totalsColumn->getElementsByTagName( 'a' )->item( 0 );

			$itemid = $this->extractIdFromTotalsLink( $totalsLink );
			$tradeCount = $this->extractTradeCountFromTotalsLink( $totalsLink );
			$idToTradeCountMap[$itemid] = $tradeCount;
		}

		return $idToTradeCountMap;
	}

	private function makeRequestAndRetryOnFailure( string $url, int $retriesLeft = 2  ) {
		$response = Http::get( $url, "default", [ 'noProxy' => true ] );
		if ( $response === false && $retriesLeft !== 0 ) {
			sleep( self::ONE_SECOND );
			return $this->makeRequestAndRetryOnFailure( $url, $retriesLeft - 1 );
		}

		return $response;
	}

	private function extractIdFromTotalsLink( DOMElement $totalsLink ) {
		$match = [];
		$urlAttr = $totalsLink->getAttribute( "href" );
		preg_match( "/obj=(\d+)/", $urlAttr, $match );
		return $match[1];
	}

	private function extractTradeCountFromTotalsLink(DOMElement $totalsLink  ) {
		$match = [];
		preg_match( "/([\d\.]+)/", $totalsLink->textContent, $match );
		return $match[1];
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	private function determineItemDbSuffix() {
		global $wgCityId;

		if ( (int) $wgCityId === UpdateGrandExchangeItemPrices::RUNESCAPE_CITY_ID ) {
			return self::RUNESCAPE_ITEMDB_SUFFIX;
		}

		if ( (int) $wgCityId === UpdateGrandExchangeItemPrices::OLDSCHOOL_RUNESCAPE_CITY_ID ) {
			return self::OLDSCHOOL_RUNESCAPE_ITEMDB_SUFFIX;
		}

		throw new Exception( "this should only be run on a runescape wiki!" );
	}
}
