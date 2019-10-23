<?php
/**
 * Controller to fetch information about articles across multiple
 * wikis. Used by recommendations service to avoid multiple calls
 * to MW.
 *
 * @author Mariusz Strzelecki <mstrzelecki@fandom.com>
 */

class CrossWikiArticlesApiController extends WikiaApiController {

	const THUMBNAIL_SIZE = 400;
	const CACHE_3_DAYS = 259200;

	private $articleVideoService;
	private $apiService;
	private $globalTitle;
	private $wikiFactory;
	private $articleRetriever;

	/**
	 * Get details about one or more articles
	 *
	 * @requestParam string $ids A string with a comma-separated list of pairs wikiID_articleId
	 *
	 * @responseParam array $items A list of results with the article ID as the index, each item has a title, url and thumbnail url
	 *
	 * @example $ids=177996_68580,2233_1678
	 */
	public function getDetails() {
		$this->setOutputFieldType( "items", self::OUTPUT_FIELD_TYPE_OBJECT );
		$articles = explode( ',', $this->request->getVal( 'ids', null ) );

		// mapping parameters to wikiId => listOfArticles
		$wikiToArticleMap = [];
		foreach ( $articles as $article ) {
			list( $wikiId, $articleId ) = explode('_', $article);
			if ( ! isset($wikiToArticleMap[$wikiId]) ) {
				$wikiToArticleMap[$wikiId] = [];
			}
			$wikiToArticleMap[$wikiId][] = (int) $articleId;
		}

		// order by wiki id to be consistent with the previous version of this API end-point
		ksort($wikiToArticleMap);

		// now query each wiki
		$items = [];

		foreach( $wikiToArticleMap as $wikiId => $articles ) {
			$items += $this->getDetailsForWiki( $wikiId, $articles, $wikiToArticleMap );
		}

		$this->setResponseData(
			[ 'items' => $items ],
			null,
			# cache for 3 days to avoid daily cache hit ratio drops - https://wikia-inc.atlassian.net/browse/DE-4346
			static::CACHE_3_DAYS
		);
	}

	/**
	 * Returns details for articles from a given wiki. Performs cross-wiki database queries.
	 *
	 * @param int $wikiId
	 * @param int[] $articles
	 * @param $wikiToArticleMap
	 * @return array
	 * @throws Exception
	 */
	protected function getDetailsForWiki( int $wikiId, array $articles, array $wikiToArticleMap ) {
		$dbname = $this->getWikiFactory()->IDtoDB($wikiId);
		$articles = $this->getArticleRetriever()->retrieveArticles($dbname, $articles);

		$videos = $this->getVideosIds( $wikiId );
		$wikiName = $this->getWikiFactory()->getVarValueByName('wgSitename', $wikiId);
		$wikiDetails = $this->getThumbnails( $dbname, $wikiToArticleMap[$wikiId] );

		$items = [];
		foreach ($articles as $row) {
			$title = $this->getGlobalTitle()->newFromText( $row->page_title, $row->page_namespace, $wikiId );
			$url = $title->getFullURL();

			$items[$wikiId . '_' . $row->page_id] = [
				// IW-2588: Force these URLs to always use HTTPS
				// The recommendations service calls this API over HTTP, but forwards these URLs to clients
				'url' => wfHttpsAllowedForURL( $url ) ? wfHttpToHttps( $url ) : $url,
				'title' => $title->getPrefixedText(),
				'wikiName' => $wikiName,
				'thumbnail' => $wikiDetails[$row->page_id]['thumbnail'] ?? null,
				'hasVideo' => in_array( $row->page_id, $videos ),
			];
		}

		return $items;
	}

	protected function getThumbnails( $dbname, $articleIds ) {
		$params = array(
			'controller' => 'ArticlesApiController',
			'method' => 'getDetails',
			'abstract' => '0',
			'ids' => implode(',', $articleIds),
			'format' => 'json',
			'width' => CrossWikiArticlesApiController::THUMBNAIL_SIZE,
			'height' => CrossWikiArticlesApiController::THUMBNAIL_SIZE
		);
		$response = $this->getApiService()->foreignCall( $dbname, $params, \ApiService::WIKIA );
		return is_array($response) ? $response['items'] : array();
	}

	protected function getVideosIds( $wikiId ) {
		$featuredVideos = $this->getArticleVideoService()->getFeaturedVideosForWiki( $wikiId );
		return array_map( function( $video ) { return $video->getId(); }, $featuredVideos );
	}

	private function getArticleRetriever() {
		if ( !isset( $this->articleRetriever ) ) {
			$this->articleRetriever = new ArticleRetriever();
		}
		return $this->articleRetriever;
	}

	private function getWikiFactory() {
		if ( !isset( $this->wikiFactory ) ) {
			$this->wikiFactory = new WikiFactory();
		}
		return $this->wikiFactory;
	}

	private function getGlobalTitle() {
		if ( !isset( $this->globalTitle ) ) {
			$this->globalTitle = new GlobalTitle();
		}
		return $this->globalTitle;
	}

	private function getApiService() {
		if ( !isset( $this->apiService ) ) {
			$this->apiService = new \ApiService();
		}
		return $this->apiService;
	}

	private function getArticleVideoService() {
		if ( !isset( $this->articleVideoService ) ) {
			$this->articleVideoService = new ArticleVideoService();
		}
		return $this->articleVideoService;
	}

}

class ArticleRetriever {
	function retrieveArticles($dbname, $articles) {
		$dbr = wfGetDB( DB_SLAVE, [], $dbname );

		$res = $dbr->select(
			['page'],
			'page.page_id, page_title, page_namespace',
			['page.page_id' => $articles],
			__METHOD__,
			[],
			[]
		);

		return $res;
	}
}
