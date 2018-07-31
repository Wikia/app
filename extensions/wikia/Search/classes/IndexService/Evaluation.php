<?php

namespace Wikia\Search\IndexService;

use BadRequestApiException;
use MWNamespace;

class Evaluation extends AbstractService {
	const DISABLE_BACKLINKS_COUNT_FLAG = 'disable_backlinks_count';
	const BACKLINKS_FROM_ALL_NAMESPACES_FLAG = 'backlinks_from_all_namespaces';
	const LANGUAGES_SUPPORTED = ['en', 'de', 'es', 'fr', 'it', 'ja', 'pl', 'pt-br', 'ru', 'zh', 'zh-tw'];

	/**
	 * @return array
	 * @throws BadRequestApiException
	 */
	public function execute() {

		$service = $this->getService();
		$pageId = $service->getCanonicalPageIdFromPageId( $this->currentPageId );

		$page = \WikiPage::newFromID( $pageId );
		$text = $page->getRawText();

		$titleStr = $service->getTitleStringFromPageId( $pageId );
		$languageCode = $this->getLanguageCode();

		return [
			'wiki_id' => $service->getWikiId(),
			'page_id' => $pageId,
			"title_${languageCode}" => $titleStr,
			'url' => $service->getUrlFromPageId( $pageId ),
			'ns' => $service->getNamespaceFromPageId( $pageId ),
			'lang' => $service->getSimpleLanguageCode(),
			'indexed' => gmdate( "Y-m-d\TH:i:s\Z" ),
			"content_${languageCode}" => $text,
			// 'backlinks_count' is added in processAllDocuments()
		];
	}

	/**
	 * @param array $documents
	 * @return array
	 * @throws \DBUnexpectedError
	 */
	protected function processAllDocuments( $documents ) {
		if ( empty( $documents ) || in_array( self::DISABLE_BACKLINKS_COUNT_FLAG, $this->flags ) ) {
			return $documents;
		}

		$pageIds = array_filter( array_map( function ( $document ) {
			return $document['page_id']['set'];
		}, $documents ) );

		$backlinksCount = $this->getBacklinksCount( $pageIds );

		return array_map( function ( $document ) use ( $backlinksCount ) {
			$id = $document['page_id']['set'];

			if ( isset( $id ) && isset( $backlinksCount[ $id ] ) ) {
				$document['backlinks_count'] = [
					'set' => $backlinksCount[ $id ]
				];
			}

			return $document;
		}, $documents );
	}

	/**
	 * @param $pageIds
	 * @return array
	 * @throws \DBUnexpectedError
	 */
	private function getBacklinksCount( $pageIds ) {
		$contentNamespaces = MWNamespace::getContentNamespaces();

		$service = $this->getService();

		$titles = [];

		foreach ( $pageIds as $id ) {
			$titles[ $id ] = $service->getTitleFromPageId( $id )->getPrefixedDBkey();
		}

		$where = [ 'pl_title' => array_values( $titles ) ];

		// Adding namespace to query causes db to use `pl_namespace` index and is much faster
		if ( !in_array( self::BACKLINKS_FROM_ALL_NAMESPACES_FLAG, $this->flags ) ) {
			$where['pl_namespace'] = $contentNamespaces;
		}

		$dbr = wfGetDB( DB_SLAVE );

		$dbResults = $dbr->select(
			'pagelinks',
			[ 'count(*) as cnt', 'pl_title' ],
			$where,
			__METHOD__,
			[ 'GROUP BY' => 'pl_title' ]
		);

		$backlinks = [];

		while ( ( $row = $dbResults->fetchObject() ) ) {
			$id = array_search( $row->pl_title, $titles );
			$backlinks[ $id ] = $row->cnt;
		}

		return $backlinks;
	}

	/**
	 * @return string
	 * @throws BadRequestApiException
	 */
	private function getLanguageCode() {
		$code = $this->service->getLanguageCode();

		if ( in_array( $code, self::LANGUAGES_SUPPORTED ) ) {
			return $code;
		} else {
			throw new BadRequestApiException( "This wiki's content language isn't supported" );
		}
	}
}
