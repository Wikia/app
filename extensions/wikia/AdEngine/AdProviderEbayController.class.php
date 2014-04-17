<?php

class AdProviderEbayController extends WikiaController
{
	const SERVICE_URI = 'http://rest.ebay.com/epn/v1/find/item.rss?';
	
	protected static $ebayLangSiteId = [
		'AT' => 3,
		'AU' => 4,
		'BE' => 5,
		'CA' => 7,
		'CH' => 14,
		'DE' => 11,
		'ES' => 13,
		'FR' => 10,
		'IE' => 2,
		'IT' => 12,
		'NL' => 16,
		'UK' => 15, 'GB' => 15, // Geo for UK users can return both UK OR GB
		'US' => 1,
	];
	

	public function centerWell()
	{
		$query = [ preg_replace('/ Wiki$/', '', $this->request->getVal('title')) ];

		$siteId = $this->getSiteId($this->request->getVal('geo'));

		$rssUrl = $this->buildUrl($query, $siteId);
		$allProducts = $this->generateData($rssUrl);

		if (empty($allProducts)) {
			$allProducts = [];
		}

		if (count($allProducts) > 3) {
			$rand_keys = array_rand($allProducts, 4);
		} else {
			$rand_keys = array_keys($allProducts);
		}

		$products = [];
		foreach($rand_keys as $key) {
			$products[] = $allProducts[$key];
		}

		$this->products = $products;
		$this->query = $query;
		$this->rssUrl = $rssUrl;
	}

	/**
	 * @param string $url URL of the RSS to fetch and parse
	 * @return array of all products
	 */
	private function generateData($url)
	{

		$result = Http::get($url);

		if ($result === false) {
			return false;
		}

		$result = simplexml_load_string($result);

		$allProducts = [];

		$items = $result->xpath('/rss/channel/item');

		foreach ($items as $item) {

			if ($item->asXML() === '<item/>') {
				continue;
			}

			$product = [
				'title' => (string) $item->title,
				'link' => (string) $item->link,
				// TODO: we might remove description after we get design
				'description' => (string) $item->description,
				'image' => false
			];

			$ebayInfo = $item->children('e', true);

			foreach ($ebayInfo as $info) {
				$product[$info->getName()] = (string) $info;
			}

			if (preg_match('/img[^s]+src=["\']([^"\']+)/', $product['description'], $imageUrlMatch)) {
				$product['image'] = $imageUrlMatch[1];
			}

			$allProducts[] = $product;
		}

		return $allProducts;

	}

	/**
	 * @param array  	$queryWords Keywords to search on eBay
	 * @param int 		$siteId 	One of values below
	 *
	 * @return string
	 */
	private function buildUrl(array $queryWords,  $siteId = 1) {

		$urlParams = [
			'keyword' => count($queryWords) > 1 ? '(' . implode(',', $queryWords) . ')' : implode(',', $queryWords),
			'sortOrder' => 'BestMatch',
			'programid' => $siteId,
			'campaignid' => 5337465385,
			'toolid' => '10039',
			'listingType1' => 'AuctionWithBIN',
			'listingType2' => 'FixedPrice',
			'lgeo' => 1,
			'feedType' => 'rss',
		];

		return self::SERVICE_URI . http_build_query($urlParams);
	}

	private function getSiteId($lng) {

		if (isset(self::$ebayLangSiteId[mb_strtoupper($lng)])) {
			return self::$ebayLangSiteId[mb_strtoupper($lng)];
		}

		return self::$ebayLangSiteId['US'];
	}


}
