<?php

namespace Wikia\Search\IndexService;
/**
 * Allows indexing of Article types
 * @package Search
 * @subpackage IndexService
 */
class ArticleType extends AbstractService
{
	/**
	 * Returns article type filed
	 * @see \Wikia\Search\IndexService\AbstractService::execute()
	 * @throws \WikiaException
	 * @return array
	 */
	public function execute() {
		$articleTypeService = new \ArticleTypeService();

		$wikiId = (int) $this->getService()->getWikiId();
		$pageId = (int) $this->currentPageId;
		if ( $pageId === null ) {
			throw new \WikiaException( 'A pageId-dependent indexer service was executed without a page ID queued' );
		}

		return [ "article_type_s" => $articleTypeService->getArticleType( $wikiId, $pageId ) ];
	}

}
