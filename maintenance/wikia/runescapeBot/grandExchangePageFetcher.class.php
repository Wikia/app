<?php

class GrandExchangePageFetcher {

	const RUNESCAPE_NS_FILTER = 112;
	const OLDSCHOOL_RUNESCAPE_NS_FILTER = 114;
	const GRAND_EXCHANGE_CATEGORY_NAME = "Category: Grand Exchange";

	private $nameSpaceFilter;

	/**
	 * GrandExchangePageFetcher constructor.
	 * @throws Exception
	 */
	public function __construct() {
		$this->nameSpaceFilter = $this->determineNamespaceFilter();
	}

	/**
	 * @return array
	 * @throws MWException
	 * @throws Exception
	 */
	public function fetchAllGrandExchangePages() {
		$pages = [];
		$requestParams = [
			'format' => 'json',
			'maxlag' => 5,
			'action' => 'query',
			'list' => 'categorymembers',
			'cmprop' => 'title',
			'cmlimit' => 'max',
			'cmtitle' => self::GRAND_EXCHANGE_CATEGORY_NAME,
			'cmnamespace' => $this->nameSpaceFilter
		];

		$hasNext = true;
		while ( $hasNext ) {
			$fauxRequest = new FauxRequest( $requestParams );
			$api = new ApiMain( $fauxRequest );
			$api->execute();
			$jsonData = $api->getResultData();

			foreach( $jsonData['query']['categorymembers'] as $page ) {
				$pages[] = $this->stripExchangePrefix( $page['title'] );
			}

			if ( isset( $jsonData['query-continue']['categorymembers']['cmcontinue'] ) ) {
				$requestParams['cmcontinue'] = $jsonData['query-continue']['categorymembers']['cmcontinue'];
			} else {
				$hasNext = false;
			}
		}

		return $pages;
	}

	private function stripExchangePrefix( $pageTitle ) : string {
		return preg_replace("/^Exchange:/", "", $pageTitle );
	}

	/**
	 * Item pages which need updating are found in different namespaces on the runescape
	 * and oldschoolrunescape wikis. Determine which namespace we should filter on based
	 * on which wiki we're running
	 * @return int
	 * @throws Exception
	 */
	private function determineNamespaceFilter() {
		global $wgCityId;

		if ( (int) $wgCityId === UpdateGrandExchangeItemPrices::RUNESCAPE_CITY_ID ) {
			return self::RUNESCAPE_NS_FILTER;
		}

		if ( (int) $wgCityId === UpdateGrandExchangeItemPrices::OLDSCHOOL_RUNESCAPE_CITY_ID ) {
			return self::OLDSCHOOL_RUNESCAPE_NS_FILTER;
		}

		throw new Exception( "this should only be run on a runescape wiki!" );
	}
}
