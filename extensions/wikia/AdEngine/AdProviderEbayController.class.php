<?php

class AdProviderEbayController extends WikiaController
{

	const SERVICE_URI = 'http://rest.ebay.com/epn/v1/find/item.rss?';

	public function centerWell()
	{

		$allProducts = $this->getAllProducts('Harry Potter');

		shuffle($allProducts);
		$rand_keys = array_rand($allProducts, 4);

		$this->products = [];

		foreach($rand_keys as $key) {
			$this->products[] = $allProducts[$key];
		}

	}

	/**
	 * @param string $queryWords Keywords to search on eBay
	 * @param $siteId
	 * @return array of all products
	 */
	private function getAllProducts($queryWords,  $siteId = 1)
	{

		$opts = array(
			'http' => array(
				'method' => "GET",
			)
		);

		$context = stream_context_create($opts);

		$result = file_get_contents($this->buildUrl($queryWords,  $siteId), false, $context);

		$result = simplexml_load_string($result);

		$allProducts = [];

		foreach ($result->channel->item as $item) {
			$product = [
				'title' => (string)$item->title,
				'link' => (string)$item->link,
				// TODO: we might remove description after we get design
				'description' => (string)$item->description,
				'image' => false
			];

			if (preg_match('/img[^s]+src=["\']([^"\']+)/', $product['description'], $imageUrlMatch)) {
				$product['image'] = $imageUrlMatch[1];
			}

			$allProducts[] = $product;
		}

		// TODO: caching of $all_products result
		return $allProducts;

	}

	/**
	 * @param string 	$queryWords Keywords to search on eBay
	 * @param int 		$siteId 	One of values below
	 *
	 * AT => 3,
	 * AU => 4,
	 * BE => 5,
	 * CA => 7,
	 * CH => 14,
	 * DE => 11,
	 * ES => 13,
	 * FR => 10,
	 * IE => 2,
	 * IT => 12,
	 * NL => 16,
	 * UK => 15,
	 * US => 1
	 *
	 * @return string
	 */
	private function buildUrl($queryWords,  $siteId = 1) {

		$urlParams = [
			'keyword' => $queryWords,
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


}
