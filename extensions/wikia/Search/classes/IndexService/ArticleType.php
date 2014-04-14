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
		if ( $this->getService()->getLanguageCode() !== "en" ) {
			return [];
		}

		$articleTypeService = new \ArticleTypeService();

		if ( $this->currentPageId === null ) {
			throw new \WikiaException( 'A pageId-dependent indexer service was executed without a page ID queued' );
		}
		$pageId = (int) $this->currentPageId;

		try {
			$type = $articleTypeService->getArticleType($pageId);
			return [ "article_type_s" => $type];
		} catch( \ServiceUnavailableException $ex ) {
			\Wikia\Logger\WikiaLogger::instance()->error("article_type_s update ignored.", ["wikiId" => $this->getService()->getWikiId(), "pageId" => $pageId]);
			// Don't specify article type in case of service being unavailable.
			// If indexer is using partial update it should not override existing article type.
			return [];
		}
	}
}
