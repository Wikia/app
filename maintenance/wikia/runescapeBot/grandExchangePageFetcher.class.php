<?php

class GrandExchangePageFetcher {

	const GRAND_EXCHANGE_CATEGORY_NAME = "Category: Grand Exchange";

	const RUNESCAPE_CITY_ID = 304;
	const OLDSCHOOL_RUNESCAPE_CITY_ID = 691244;

	const RUNESCAPE_NS_FILTER = 112;
	const OLDSCHOOL_RUNESCAPE_NS_FILTER = 114;

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
			'cmnamespace' => $this->getNameSpaceFilter()
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
	private function getNameSpaceFilter() {
		global $wgCityId;

		if ( (int) $wgCityId === self::RUNESCAPE_CITY_ID ) {
			return self::RUNESCAPE_NS_FILTER;
		}

		if ( (int) $wgCityId === self::OLDSCHOOL_RUNESCAPE_CITY_ID ) {
			return self::OLDSCHOOL_RUNESCAPE_NS_FILTER;
		}

		throw new Exception( "this should only be run on a runescape wiki!" );
	}
}
