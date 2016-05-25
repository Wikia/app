<?php

use Swagger\Client\ApiException;
use Swagger\Client\ContentEntity\Api\RelatedContentApi;
use Swagger\Client\ContentEntity\Models\Content;
use Swagger\Client\ContentEntity\Models\RelatedContent;
use Wikia\DependencyInjection\Injector;
use Wikia\Logger\Loggable;
use Wikia\Service\Swagger\ApiProvider;

class CakeRelatedContentService {

	use Loggable;
	
	const SERVICE_NAME = "content-entity";
	const DISCUSSION_THREAD_TITLE_MAX_LENGTH = 105;
	const TIMEOUT = 5;

	/**
	 * @param $title
	 * @param $ignore
	 * @return RecirculationContent[]
	 */
	public function getContentRelatedTo($title, $limit=5, $ignore=null) {
		$items = [];

		if (!$this->onValidWiki() || !$this->onValidPage($title)) {
			return $items;
		}

		$api = $this->relatedContentApi();
		
		try {
			$filteredRelatedContent = $api->getRelatedContentFromEntityName($title, 20, "true");
			$wikiArticles = [];
			foreach ($filteredRelatedContent->getWikiArticles() as $article) {
				$parsed = parse_url($article->getContent()->getUrl());
				if ($parsed['path'] != $ignore) {
					$wikiArticles[] = $article;
				}
			}

			/**
			 * this seems funky, but http://php.net/manual/en/function.array-map.php#refsect1-function.array-map-examples
			 * so this actually will create an array of arrays where the elements are ordered:
			 * [
			 *   // fandom
			 *   // discussion
			 *   // article
			 * ]
			 * because that's the order they're passed in
			 */
			$ordered = array_map(
					null,
					$filteredRelatedContent->getFandomArticles(),
					$filteredRelatedContent->getDiscussionThreads(),
					$wikiArticles);

			foreach ($ordered as $sublist) {
				foreach ($sublist as $item) {
					if (!empty($item)) {
						/** @var RelatedContent $item */
						$content = $item->getContent();

						$items[] = new RecirculationContent(
								count($items),
								$content->getUrl(),
								$content->getImage(),
								$this->formatTitle($content),
								"",
								"");
					}

					if (count($items) >= $limit) {
						break 2;
					}
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
		/** @var RelatedContentApi $api */
		$api = $apiProvider->getApi(self::SERVICE_NAME, RelatedContentApi::class);
		$api->getApiClient()->getConfig()->setCurlTimeout(self::TIMEOUT);

		return $api;
	}

	private function formatTitle(Content $content) {
		global $wgContLang;

		if ($content->getContentType() == "Discussion Thread") {
			return $wgContLang->truncate(
					"[Discussions] {$content->getTitle()}",
					self::DISCUSSION_THREAD_TITLE_MAX_LENGTH);
		}

		return $content->getTitle();
	}

	private function onValidWiki() {
		global $wgCityId;

		return in_array(
				$wgCityId,
				[
						147,    // starwars
						130814, // gameofthrones
						3035,   // fallout
						2237,   // dc
						2233,   // marvel
						208733, // darksouls
				]
		);
	}

	private function onValidPage($title) {
		return $title != "Main Page";
	}
}
