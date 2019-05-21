<?php
/**
 * Controller to fetch information about articles across multiple
 * wikis. Used by recommendations service to avoid multiple calls
 * to MW.
 *
 * @author Mariusz Strzelecki <mstrzelecki@fandom.com>
 */

class CrossWikiArticlesApiController extends WikiaApiController {

	const THUMBNAIL_SIZE = 200;
	const CACHE_3_DAYS = 259200;

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
			$items += $this->getDetailsForWiki( $wikiId, $articles );
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
	 * @return array
	 * @throws Exception
	 */
	protected function getDetailsForWiki( int $wikiId, array $articles ) {
		$dbr = wfGetDB( DB_SLAVE, [], WikiFactory::IDtoDB( $wikiId ) );

		$res = $dbr->select(
			['page', 'page_wikia_props'],
			'page.page_id, page_title, page_namespace, props',
			['page.page_id' => $articles],
			__METHOD__,
			[],
			[
				'page_wikia_props' => [
					'LEFT JOIN', [
						'page.page_id=page_wikia_props.page_id',
						'propname' => WPP_IMAGE_SERVING
					]
				],
			]
		);

		$videos = $this->getVideosIds( $wikiId );
		$wikiName = WikiFactory::getVarValueByName('wgSitename', $wikiId);

		$items = [];
		foreach ($res as $row) {
			// extract suggested image
			$imageServingData = @unserialize($row->props);

			if (is_array($imageServingData)) {
				$image = $imageServingData[0];
				$file = new GlobalFile(GlobalTitle::newFromText($image, NS_FILE, $wikiId));

				$thumbnail = $file->getUrlGenerator()
					->width(self::THUMBNAIL_SIZE)->height(self::THUMBNAIL_SIZE)->zoomCropDown()
					->url();
			}
			else {
				$thumbnail = null;
			}

			$title = GlobalTitle::newFromText( $row->page_title, $row->page_namespace, $wikiId );

			$items[ $wikiId . '_' . $row->page_id ] = array(
				'url' => $title->getFullURL(),
				'title' => $title->getPrefixedText(),
				'wikiName' => $wikiName,
				'thumbnail' => $thumbnail,
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
