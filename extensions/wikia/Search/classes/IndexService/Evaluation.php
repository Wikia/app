<?php

namespace Wikia\Search\IndexService;

use BadRequestApiException;
use DatabaseMysqli;
use User;

class Evaluation extends AbstractService {
	const DISABLE_BACKLINKS_COUNT_FLAG = 'disable_backlinks_count';
	const DISABLE_CONTENT_FLAG = 'without_content';
	const PARSE_PAGE = 'parse_page';
	const LANGUAGES_SUPPORTED = [ 'en', 'de', 'es', 'fr', 'it', 'ja', 'pl', 'pt-br', 'ru', 'zh', 'zh-tw' ];

	/**
	 * @return array
	 * @throws BadRequestApiException
	 */
	public function execute() {

		$service = $this->getService();

		$pageId = $service->getCanonicalPageIdFromPageId( $this->currentPageId );

		$titleStr = $service->getTitleStringFromPageId( $pageId );
		$languageCode = $this->getLanguageCode();

		$ret = [
			'wiki_id' => $service->getWikiId(),
			'page_id' => $pageId,
			"title_${languageCode}" => $titleStr,
			'url' => $service->getUrlFromPageId( $pageId ),
			'ns' => $service->getNamespaceFromPageId( $pageId ),
			'lang' => $service->getSimpleLanguageCode(),
			'indexed' => gmdate( "Y-m-d\TH:i:s\Z" ),
			// "content is added in processAllDocuments()
			// 'backlinks_count' is added in processAllDocuments()
			// 'redirects' is added in processAllDocuments()
		];

		if ( in_array( self::PARSE_PAGE, $this->flags ) ) {
			$page = \WikiPage::newFromID( $pageId );
			$ret["html_${languageCode}"] =
				$page->getParserOutput( $page->makeParserOptions( new User() ) )->mText;
		}

		return $ret;
	}

	/**
	 * @param array $documents
	 * @return array
	 * @throws \DBUnexpectedError
	 * @throws BadRequestApiException
	 */
	protected function processAllDocuments( $documents ) {
		if ( empty( $documents ) ) {
			return $documents;
		}

		$languageCode = $this->getLanguageCode();

		$filteredDocuments = array_filter( $documents, function ( $document ) {
			return isset( $document['page_id']['set'] );
		} );

		$pageIds = array_map( function ( $document ) {
			return $document['page_id']['set'];
		}, $filteredDocuments );

		if ( empty( $pageIds ) ) {
			return $documents;
		}

		list( $backlinksCount, $redirects, $contents ) = $this->getAdditionalInfo( $pageIds );

		return array_map( function ( $document ) use (
			$backlinksCount, $languageCode, $redirects, $contents
		) {
			if ( !isset( $document['page_id']['set'] ) ) {
				return $document;
			}

			$id = $document['page_id']['set'];

			if ( isset( $backlinksCount[ $id ] ) ) {
				$document['backlinks_count'] = [
					'set' => $backlinksCount[ $id ]
				];
			}

			if ( isset( $redirects[ $id ] ) ) {
				$document["redirects_${languageCode}"] = [
					'set' => $redirects[ $id ]
				];
			}

			if ( isset ( $contents[$id] ) ) {
				$document["content_${languageCode}"] = [
					'set' => $contents[$id],
				];
			}

			return $document;
		}, $documents );
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

	/**
	 * @param $pageIds
	 * @return array
	 * @throws \DBUnexpectedError
	 */
	private function getAdditionalInfo( $pageIds ) {
		$service = $this->getService();

		$titlesById = [];
		$titlesByNamespace = [];
		$backlinks = [];
		$redirects = [];


		foreach ( $pageIds as $id ) {
			$title = $service->getTitleFromPageId( $id );
			$dbKey = $title->getDBkey();

			$titlesById[ $id ] = $dbKey;

			// Group by namespace so better indexes can be used
			$titlesByNamespace[ $title->getNamespace() ][] = $dbKey;
		}

		$dbr = wfGetDB( DB_SLAVE );

		$contents = $this->loadContent( $dbr, $pageIds );

		foreach ( $titlesByNamespace as $namespace => $titles ) {
			$this->setBacklinksCount( $dbr, $namespace, $titles, $titlesById, $backlinks );
			$this->setRedirects( $dbr, $namespace, $titles, $titlesById, $redirects );
		}

		return [ $backlinks, $redirects, $contents ];
	}

	/**
	 * @param DatabaseMysqli $dbr
	 * @param $namespace
	 * @param $titles
	 * @param $titlesById
	 * @param $backlinks
	 * @throws \DBUnexpectedError
	 */
	private function setBacklinksCount( DatabaseMysqli $dbr, $namespace, $titles, $titlesById, &$backlinks ) {
		if ( in_array( self::DISABLE_BACKLINKS_COUNT_FLAG, $this->flags ) ) {
			return;
		}
		$dbResults = $dbr->select(
			'pagelinks',
			[ 'count(*) as cnt', 'pl_title' ],
			[
				'pl_namespace' => $namespace,
				'pl_title' => $titles
			],
			__METHOD__,
			[ 'GROUP BY' => 'pl_title' ]
		);

		while ( ( $row = $dbResults->fetchObject() ) ) {
			$id = array_search( $row->pl_title, $titlesById );
			$backlinks[ $id ] = $row->cnt;
		}

		$dbResults->free();
	}

	/**
	 * @param DatabaseMysqli $dbr
	 * @param $namespace
	 * @param $titles
	 * @param $titlesById
	 * @param $redirects
	 * @throws \DBUnexpectedError
	 */
	private function setRedirects( DatabaseMysqli $dbr, $namespace, $titles, $titlesById, &$redirects ) {
		$dbResults = $dbr->select(
			[ 'redirect', 'page' ],
			[ 'rd_title', 'page_title' ],
			[
				'rd_title' => $titles,
				'rd_namespace' => $namespace
			],
			__METHOD__,
			[],
			[
				'page' => [
					'INNER JOIN',
					[ 'page_id = rd_from' ]
				]
			]
		);

		while ( ( $row = $dbResults->fetchObject() ) ) {
			$id = array_search( $row->rd_title, $titlesById );

			if ( !isset( $redirects[ $id ] ) ) {
				$redirects[ $id ] = [];
			}

			$redirects[ $id ][] = $row->page_title;
		}

		$dbResults->free();
	}

	/**
	 * @param DatabaseMysqli $dbr
	 * @param $ids
	 * @throws \DBUnexpectedError
	 */
	private function loadContent( DatabaseMysqli $dbr, $ids ) {
		if ( in_array( self::DISABLE_CONTENT_FLAG, $this->flags ) ) {
			return [];
		}
		$contents = [];
		$text_id_to_page_id = [];
		$text_ids = [];
		$cond = [];

		foreach ( $ids as $id ) {
			$revId = $this->getService()->getPageFromPageId( $id )->mTitle->getLatestRevID();
			$cond[] = "(rev_page=${id} AND rev_id = ${revId})";
		}

		$dbResults =
			$dbr->select( [ 'revision' ], [ 'rev_page', 'rev_text_id' ], implode( " OR ", $cond ),
				__METHOD__ );

		while ( ( $row = $dbResults->fetchObject() ) ) {
			$text_id_to_page_id[$row->rev_text_id] = $row->rev_page;
			$text_ids[] = $row->rev_text_id;
		}

		$dbResults->free();
		$dbResults =
			$dbr->select( 'text', [ 'old_id', 'old_text', 'old_flags' ], [ 'old_id' => $text_ids ],
				__METHOD__ );

		while ( ( $row = $dbResults->fetchObject() ) ) {
			$contents[$text_id_to_page_id[$row->old_id]] = \Revision::getRevisionText( $row );
		}

		$dbResults->free();

		return $contents;
	}
}
