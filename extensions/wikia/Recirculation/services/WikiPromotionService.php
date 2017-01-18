<?php

use Swagger\Client\ApiException;
use Swagger\Client\SiteAttribute\Api\SiteAttributeApi;
use Wikia\Logger\Loggable;
use Wikia\Service\Swagger\ApiProvider;

class WikiPromotionService {

	use Loggable;

	const SERVICE_NAME = "site-attribute";

	const ATTRIBUTE_NAME = "promoDetails";

	/** @var ApiProvider */
	private $apiProvider;

	public function __construct(ApiProvider $apiProvider) {
		$this->apiProvider = $apiProvider;
	}

	public function getWikiPromoDetails(int $wikiId) {
		/** @var SiteAttributeApi $api */
		$api = $this->apiProvider->getApi(self::SERVICE_NAME, SiteAttributeApi::class);

		try {
			$response = $api->getAttribute($wikiId, self::ATTRIBUTE_NAME);
		} catch (ApiException $e) {
			$this->error(
					"error getting site attribute",
					[
							'wiki' => $wikiId,
							'code' => $e->getCode(),
							'message' => $e->getMessage()
					]);

			return null;
		}

		return $response->getValue();
	}
}
