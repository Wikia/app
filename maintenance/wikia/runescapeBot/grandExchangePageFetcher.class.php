<?php

class GrandExchangePageFetcher {

	const GRAND_EXCHANGE_CATEGORY_NAME = "Category: Grand Exchange";
	const EXCHANGE_NAMESPACE = 112;

	/**
	 * @return array
	 * @throws MWException
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
			'cmnamespace' => self::EXCHANGE_NAMESPACE,
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

}
