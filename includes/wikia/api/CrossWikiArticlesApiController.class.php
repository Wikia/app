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

		// mapping parameters to wikiId => listOfArticles, and preparing cross-wiki sql
		$wikiToArticleMap = array();
		$sqlFilters = array();
		foreach ( $articles as $article ) {
			list( $wikiId, $articleId ) = explode('_', $article);
			if ( ! isset($wikiToArticleMap[$wikiId]) ) {
				$wikiToArticleMap[$wikiId] = array();
			}
			$wikiToArticleMap[$wikiId][] = $articleId;
			$sqlFilters[] = sprintf('(page_wikia_id=%s and page_id=%s)', intval($wikiId), intval($articleId));
		}
		$multiArticleSqlFilter = implode(' or ', $sqlFilters);
		
		// getting wikis details 
		$wds = new WikiDetailsService();
		$wikisData = array();
		foreach (array_keys($wikiToArticleMap) as $wikiId) {
			$wikiDetails = $wds->getWikiDetails($wikiId);
			$dbname = WikiFactory::IDtoDB($wikiId);
			$wikisData[$wikiId] = array(
				'title' => $wikiDetails['title'],
				'baseUrl' => $wikiDetails['url'],
				'images' => $this->getThumbnails( $dbname, $wikiToArticleMap[$wikiId] )
			);
		}

		// getting articles data
		global $wgExternalDatawareDB;
		$db = wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );
		$dbResult = $db->query( 'select page_wikia_id, page_id, page_title from pages where '. $multiArticleSqlFilter, __METHOD__ );
		$items = [];
		while ( $row = $db->fetchObject( $dbResult ) ) { 
			$title = Title::newFromRow($row);
			$articleApiDetails = $wikisData[$row->page_wikia_id]['images'];
			$items[ $row->page_wikia_id . '_' . $row->page_id ] = array(
				'url' => $wikisData[$row->page_wikia_id]['baseUrl'] . $title->getLocalUrl(),
				'title' => $title->getPrefixedText(),
				'wikiName' => $wikisData[$row->page_wikia_id]['title'],
				'thumbnail' => $articleApiDetails[$row->page_id]['thumbnail'] ?? null
			);
		}
		$db->freeResult( $dbResult );

		$this->setResponseData(
			[ 'items' => $items ],
			null,
			WikiaResponse::CACHE_STANDARD
		);
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

}
