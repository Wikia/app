<?php
/**
 * Class definition for \Wikia\Search\IndexService\ArticleQuality
 */
namespace Wikia\Search\IndexService;
/**
 * Allows us to access article quality service
 * @package Search
 * @subpackage IndexService
 */
class ArticleQuality extends AbstractService {
	/**
	 * Queries the API for article quality
	 * @see \Wikia\Search\IndexService\AbstractService::execute()
	 * @return array
	 */
	public function execute() {
		$result = array();

		$aqService = new \ArticleQualityService();
		$pageId = $this->currentPageId;
		if ( $pageId === null ) {
			throw new \WikiaException( 'A pageId-dependent indexer service was executed without a page ID queued' );
		}

		$aqService->setArticleById( $pageId );
		$result[ 'article_quality_i' ] = $aqService->getArticleQuality();

		return $result;
	}

}
