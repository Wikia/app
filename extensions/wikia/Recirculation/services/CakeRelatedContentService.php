<?php

use Swagger\Client\ApiException;
use Swagger\Client\ContentEntity\Api\RelatedContentApi;
use Wikia\DependencyInjection\Injector;
use Wikia\Logger\Loggable;
use Wikia\Service\Swagger\ApiProvider;

class CakeRelatedContentService {

	use Loggable;
	
	const SERVICE_NAME = "content-entity";

	/**
	 * @param $title
	 * @param $ignore
	 * @return RecirculationContent[]
	 */
	public function getContentRelatedTo($title, $limit=3, $ignore=null) {
		$api = $this->relatedContentApi();
		
		try {
			$items = [];

			foreach ($api->getRelatedContentFromEntityName($title) as $i => $relatedContent) {
				$content = $relatedContent->getContent();
				$parsed = parse_url($content->getUrl());
				if ($parsed['path'] == $ignore) {
					continue;
				}
				$items[] = new RecirculationContent(
						$i,
						$content->getUrl(),
						$content->getImage(),
						$content->getTitle(),
						"",
						""
				);

				if (count($items) >= $limit) {
					break;
				}
			}

			return $items;
		} catch (ApiException $e) {
			$this->error("error while getting content", [
				'code' => $e->getCode(),
				'message' => $e->getMessage(),
			]);
			return [];
		}
	}

	/**
	 * @return RelatedContentApi
	 */
	private function relatedContentApi() {
		/** @var ApiProvider $apiProvider */
		$apiProvider = Injector::getInjector()->get(ApiProvider::class);
		return $apiProvider->getApi(self::SERVICE_NAME, RelatedContentApi::class);
	}
}
