<?php

namespace Wikia\Search\IndexService;
/**
 * Allows indexing of Article types
 * @package Search
 * @subpackage IndexService
 */
class ArticleType extends AbstractService {
	/**
	 * Returns article type filed
	 * @see \Wikia\Search\IndexService\AbstractService::execute()
	 * @throws \WikiaException
	 * @return array
	 */
	public function execute() {
		$articleTypeService = new \ArticleTypeService();

		if ( $this->currentPageId === null ) {
			throw new \WikiaException( 'A pageId-dependent indexer service was executed without a page ID queued' );
		}
		$pageId = (int) $this->currentPageId;

		return [ "article_type_s" => $articleTypeService->getArticleType( $pageId ) ];
	}
}
