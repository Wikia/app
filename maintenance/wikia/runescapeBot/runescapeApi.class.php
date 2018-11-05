<?php

class RunescapeApi {

	const API_URL_TEMPLATE = "http://services.runescape.com/m=itemdb_rs/api/graph/%s.json";
	const TOP_TRADED_ITEMS_URL = "http://services.runescape.com/m=itemdb_rs/top100.ws";

	/**
	 * @param string $itemId
	 * @return string
	 * @throws Exception
	 */
	public function getItemId( string $itemId ) : GrandExchangeItem  {
		$response = Http::get( sprintf( self::API_URL_TEMPLATE, $itemId ), "default", [ 'noProxy' => true ] );

		if ( $response === false ) {
			throw new Exception( "Error fetching data from runescape API" );
		}


		$jsonResponse = json_decode( $response, true );
		if ( json_last_error() !== JSON_ERROR_NONE || !isset( $jsonResponse['daily'] ) ) {
			throw new Exception( "Error decoding json from runesacpe API" );
		}

		$latestTimestamp = max( array_keys( $jsonResponse['daily'] ) );

		return new GrandExchangeItem(
			$this->stripLast3Digits( $latestTimestamp ),
			$jsonResponse['daily'][$latestTimestamp],
			$itemId
		);
	}


	/**
	 * The original Tybot would strip the last 3 digits from the timestamp, we'll do that here as well
	 */
	private function stripLast3Digits( $timestamp ) {
		return substr( $timestamp, 0, -3 );
	}

	public function getTopItems() {
		$idToTradeCountMap = [];
		$response = Http::get( self::TOP_TRADED_ITEMS_URL, "default", [ 'noProxy' => true ] );

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
}
