<?php

namespace Wikia\Search\IndexService;
/**
 * Allows indexing of Article types
 * @package Search
 * @subpackage IndexService
 */
class ArticleType extends AbstractService {

	//check holmes (article classifier) for supported langs before changing
	protected static $SUPPORTED_LANGS = ['de', 'en', 'es'];
	/**
	 * Returns article type filed
	 * @see \Wikia\Search\IndexService\AbstractService::execute()
	 * @throws \WikiaException
	 * @return array
	 */
	public function execute() {
		$lang = $this->getService()->getLanguageCode();
		if ( !in_array( $lang, self::$SUPPORTED_LANGS ) ) {
			return [];
		}
		$articleTypeService = new \ArticleTypeService();
		if ( $this->currentPageId === null ) {
			throw new \WikiaException( 'A pageId-dependent indexer service was executed without a page ID queued' );
		}
		$pageId = (int) $this->currentPageId;
		try {
			$type = $articleTypeService->getArticleType( $pageId, $lang );
			return [ "article_type_s" => $type];
		} catch( \ServiceUnavailableException $ex ) {
			\Wikia\Logger\WikiaLogger::instance()->error("article_type_s update ignored.", ["wikiId" => $this->getService()->getWikiId(), "pageId" => $pageId]);
			// Don't specify article type in case of service being unavailable.
			// If indexer is using partial update it should not override existing article type.
			return [];
		}
	}
}
