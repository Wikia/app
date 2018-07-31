<?php

namespace Wikia\Search\IndexService;

use Wikia\Search\Utilities;

class Evaluation extends AbstractService {
	const DISABLE_BACKLINKS_COUNT_FLAG = 'disable_backlinks_count';

	/**
	 * @return array
	 */
	public function execute() {

		$service = $this->getService();
		$pageId = $service->getCanonicalPageIdFromPageId( $this->currentPageId );

		$page = \WikiPage::newFromID( $pageId );
		$text = $page->getRawText();

		$titleStr = $service->getTitleStringFromPageId( $pageId );

		return [
			'wiki_id' => $service->getWikiId(),
			'page_id' => $pageId,
			( new Utilities )->field( 'title' ) => $titleStr,
			'url' => $service->getUrlFromPageId( $pageId ),
			'ns' => $service->getNamespaceFromPageId( $pageId ),
			'lang' => $service->getSimpleLanguageCode(),
			'indexed' => gmdate( "Y-m-d\TH:i:s\Z" ),
			( new Utilities )->field( 'content' ) => $text,
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
		$service = $this->getService();

		$titles = [];

		foreach ( $pageIds as $id ) {
			$titles[ $id ] = $service->getTitleFromPageId( $id )->getPrefixedDBkey();
		}

		$dbr = wfGetDB( DB_SLAVE );

		$dbResults = $dbr->select(
			'pagelinks',
			[ 'count(*) as cnt', 'pl_title' ],
			[ 'pl_title' => array_values( $titles ) ],
			__METHOD__,
			[ 'GROUP BY' => 'pl_title' ]
		);

		$backlinks = [];

		while ( ( $row = $dbResults->fetchObject() ) ) {
			$id = array_search( $row->pl_title, $titles );
			$backlinks[$id] = $row->cnt;
		}

		return $backlinks;
	}
}
