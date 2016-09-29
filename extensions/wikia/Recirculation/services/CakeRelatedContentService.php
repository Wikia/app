<?php

use Swagger\Client\ApiException;
use Swagger\Client\ContentEntity\Api\RelatedContentApi;
use Swagger\Client\ContentEntity\Models\Content;
use Swagger\Client\ContentEntity\Models\RelatedContent;
use Wikia\DependencyInjection\Injector;
use Wikia\Logger\Loggable;
use Wikia\Service\Swagger\ApiProvider;

class CakeRelatedContentService {

	const FAILED_TO_RETRIEVE_RECOMMENDATIONS = "getRelatedContentFromEntityName failed to retrieve recommendations";
	const ARTICLES_ARE_NOT_ARRAY = "getRelatedContentFromEntityName expected fandom_articles to be an array";
	const THREADS_ARE_NOT_ARRAY = "getRelatedContentFromEntityName expected discussion_threads to be an array";
	const WIKI_ARTICLES_ARE_NOT_ARRAY = "getRelatedContentFromEntityName expected wiki_articles to be an array";
	use Loggable;

	const SERVICE_NAME = "content-entity-service";
	const DISCUSSION_THREAD_TITLE_MAX_LENGTH = 105;
	const TIMEOUT = 5;

	/**
	 * @param $title
	 * @param $ignore
	 * @return RecirculationContent[]
	 */
	public function getContentRelatedTo( $title, $universeName = null, $limit = 5, $ignore = null ) {

		if ( !$this->onValidWiki() || !$this->onValidPage( $title ) ) {
			return [];
		}

		$api = $this->relatedContentApi();

		try {
			$filteredRelatedContent = $api->getRelatedContentFromEntityName( $title, $universeName, $limit + 1, "true" );
		} catch ( ApiException $e ) {
			$this->error( "error while getting content", [
				'code' => $e->getCode(),
				'message' => $e->getMessage(),
			] );
		}
		$context = [ "title" => $title, "limit" => $limit ];

		if ( empty( $filteredRelatedContent ) ) {
			$this->warning( static::FAILED_TO_RETRIEVE_RECOMMENDATIONS, $context );
			return [];
		}

		// The server may have given us a malformed response, so log and adjust accordingly
		if ( !is_array( $filteredRelatedContent->getFandomArticles() ) ) {
			$this->warning( static::ARTICLES_ARE_NOT_ARRAY,
				array_merge( [ "fandom_articles" => $filteredRelatedContent->getFandomArticles() ], $context ) );
			$filteredRelatedContent->setFandomArticles( [] );
		}

		if ( !is_array( $filteredRelatedContent->getDiscussionThreads() ) ) {
			$this->warning( static::THREADS_ARE_NOT_ARRAY,
				array_merge( [ "discussion_threads" => $filteredRelatedContent->getDiscussionThreads() ], $context ) );
			$filteredRelatedContent->setDiscussionThreads( [] );
		}

		if ( !is_array( $filteredRelatedContent->getWikiArticles() ) ) {
			$this->warning( static::WIKI_ARTICLES_ARE_NOT_ARRAY,
				array_merge( [ "wiki_articles" => $filteredRelatedContent->getWikiArticles() ], $context ) );
			$filteredRelatedContent->setWikiArticles( [] );
		}

		$wikiArticles = [];
		foreach ( $filteredRelatedContent->getWikiArticles() as $article ) {
			$parsed = parse_url( $article->getContent()->getUrl() );
			if ( urldecode( $parsed[ 'path' ] ) != $ignore ) {
				$wikiArticles[] = $article;
			}
		}

		$items = [];
		$fandomArticles = array_slice( $filteredRelatedContent->getFandomArticles(), 0, $limit - count( $items ), true );
		$this->addRecirculationContent( $fandomArticles, $items );

		$discussionThreads = array_slice( $filteredRelatedContent->getDiscussionThreads(), 0, $limit - count( $items ), true );
		$this->addRecirculationContent( $discussionThreads, $items );

		$wikiArticles = array_slice( $wikiArticles, 0, $limit - count( $items ), true );
		$this->addRecirculationContent( $wikiArticles, $items );

		return $items;
	}

	private function addRecirculationContent( $list, &$items ) {
		/** @var RelatedContent $item */
		foreach ( $list as $item ) {
			$content = $item->getContent();

			$items[] = new RecirculationContent( [
				'index' => count( $items ),
				'url' => $content->getUrl(),
				'thumbnail' => $content->getImage(),
				'title' => $this->formatTitle( $content ),
			] );
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
