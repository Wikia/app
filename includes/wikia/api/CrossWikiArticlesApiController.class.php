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

		// looking for unique wikis and preparing cross-wiki sql
		$wikisCollection = array();
		$sqlFilters = array();
		foreach ( $articles as $article ) {
			list( $wikiId, $articleId ) = explode('_', $article);
			$wikisCollection[] = $wikiId;
			$sqlFilters[] = sprintf('(page_wikia_id=%s and page_id=%s)', $wikiId, $articleId);
		}
		$multiArticleSqlFilter = implode(' or ', $sqlFilters);
		
		// getting wikis details 
		$wds = new WikiDetailsService();
		$wikisData = array();
		foreach (array_unique($wikisCollection) as $wikiId) {
			$wikiDetails = $wds->getWikiDetails($wikiId);
			$wikisData[$wikiId] = array(
				'title' => $wikiDetails['title'],
				'baseUrl' => $wikiDetails['url'],
				'dbname' => WikiFactory::IDtoDB($wikiId)
			);
		}

		// getting articles data
		global $wgExternalDatawareDB;
		$db = wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );
		$dbResult = $db->query( 'select * from pages where '. $multiArticleSqlFilter, __METHOD__ );
		$items = [];
		while ( $row = $db->fetchObject( $dbResult ) ) { 
			$title = Title::newFromRow($row);
			$items[ $row->page_wikia_id . '_' . $row->page_id ] = array(
				'url' => $wikisData[$row->page_wikia_id]['baseUrl'] . $title->getLocalUrl(),
				'title' => $title->getPrefixedText(),
				'wikiName' => $wikisData[$row->page_wikia_id]['title'],
				'thumbnail' => $this->getThumbnail($wikisData[$row->page_wikia_id]['baseUrl'], $row->page_id)
			);
		}
		$db->freeResult( $dbResult );

		$this->setResponseData(
			[ 'items' => $items ],
			WikiaResponse::CACHE_STANDARD
		);
	}

	protected function getThumbnail( $baseUrl, $articleId ) {
		$response = json_decode(
			file_get_contents(
				sprintf("%s/api.php?action=imageserving&wisId=%s&format=json", $baseUrl, $articleId), 
				false, 
				stream_context_create(array("ssl"=>array( "verify_peer"=>false,"verify_peer_name"=>false)))
			)
		);
		return is_object($response) ? $response->image->imageserving : null;
	}
}
