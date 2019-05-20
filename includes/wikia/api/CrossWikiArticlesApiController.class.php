<?php
/**
 * Controller to fetch information about articles across multiple
 * wikis. Used by recommendations service to avoid multiple calls
 * to MW.
 *
 * @author Mariusz Strzelecki <mstrzelecki@fandom.com>
 */

class CrossWikiArticlesApiController extends WikiaApiController {

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

		// now query each wiki
		$items = [];

		foreach( $wikiToArticleMap as $wikiId => $articles ) {
			$items = array_merge($items, $this->getDetailsForWiki( $wikiId, $articles ));
		}

		$this->setResponseData(
			[ 'items' => $items ],
			null,
			WikiaResponse::CACHE_STANDARD
		);
	}

	/**
	 * Returns details for articles from a given wiki. Performs cross-wiki database queries.
	 *
	 * @param int $wikiId
	 * @param int[] $articles
	 * @return array
	 * @throws Exception
	 */
	protected function getDetailsForWiki( int $wikiId, array $articles ) {
		$dbr = wfGetDB( DB_SLAVE, [], WikiFactory::IDtoDB( $wikiId ) );

		$res = $dbr->select(
			'page',
			'page.page_id, page_title, page_namespace',
			['page.page_id' => $articles],
			__METHOD__
		);

		$videos = $this->getVideosIds( $wikiId );
		$wikiDetails = (new WikiDetailsService)->getWikiDetails($wikiId);

		$items = [];
		foreach ($res as $row) {
			$title = GlobalTitle::newFromText( $row->page_title, $row->page_namespace, $wikiId );

			$items[ $wikiId . '_' . $row->page_id ] = array(
				'url' => $title->getFullURL(),
				'title' => $title->getPrefixedText(),
				'wikiName' => $wikiDetails['title'],
				#'thumbnail' => $articleApiDetails[$row->page_id]['thumbnail'] ?? null, # TODO
				'hasVideo' => in_array( $row->page_id , $videos )
			);
		}

		return $items;
	}

	protected function getThumbnails( $dbname, $articleIds ) {
		$params = array(
			'controller' => 'ArticlesApiController', 
			'method' => 'getDetails', 
			'abstract' => '0', 
			'ids' => implode(',', $articleIds), 
			'format' => 'json'
		);
		$response = \ApiService::foreignCall( $dbname, $params, \ApiService::WIKIA );
		return is_array($response) ? $response['items'] : array();
	}

	protected function getVideosIds( $wikiId ) {
		return array_map( function( $video ) { return $video->getId(); }, ArticleVideoService::getFeaturedVideosForWiki( $wikiId ) );
	}

}
