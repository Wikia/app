<?php
namespace Wikia\Api\Recommendations\DataProviders;

/**
 * Category based recommendations for RecommendationsApi
 * @author Maciej Brench <macbre@wikia-inc.com>
 * @author Damian Jozwiak <damian@wikia-inc.com>
 * @author Łukasz Konieczny <lukaszk@wikia-inc.com>
 *
 */
class Category implements IDataProvider {

	const ARTICLE_TYPE = 'article';
	const ARTICLE_SOURCE = 'RelatedPages';

	/**
	 * Get articles using RelatedPages
	 *
	 * @param int $articleId
	 * @param int $limit
	 * @return array
	 */
	public function get( $articleId, $limit ) {
		$relatedPages = \RelatedPages::getInstance();
		$relatedPages->reset();

		$res = $relatedPages->get( $articleId, $limit );
		$recommendations = $this->prepareData( $res );

		return $recommendations;
	}

	/**
	 * Format the data to be returned
	 *
	 * @param array $items
	 * @return array
	 */
	protected function prepareData( Array $items ) {
		$app = \F::app();

		// used to prefix the local URLs
		$server = $app->wg->server;

		$data = [];

		foreach ( $items as $item ) {
			$data[] = [
				'type' => self::ARTICLE_TYPE,
				'title' => $item[ 'title' ],
				'url' => $server . $item[ 'url' ],
				'description' => $item[ 'text' ],
				'media' => [
					'thumbUrl' => $item[ 'imgUrl' ],
				],
				'source' => self::ARTICLE_SOURCE,
			];
		}

		return $data;
	}
}
