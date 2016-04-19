<?php

class PagesWithoutInfobox extends PageQueryPage {
	const LIMIT = 1000;
	const PAGES_WITHOUT_INFOBOX_TYPE = 'Pageswithoutinfobox';

	function __construct( $name = self::PAGES_WITHOUT_INFOBOX_TYPE ) {
		parent::__construct( $name );
	}

	public function isListed() {
		return false;
	}

	public function isExpensive() {
		return true;
	}

	/**
	 * A wrapper for calling the querycache table
	 *
	 * @param bool $offset
	 * @param int $limit
	 * @return ResultWrapper
	 */
	public function doQuery( $offset = false, $limit = self::LIMIT ) {
		return $this->fetchFromCache( $limit, $offset );
	}

	/**
	 * Update the querycache table
	 *
	 * @param bool $limit Only for consistency
	 * @param bool $ignoreErrors Only for consistency
	 * @return int
	 */
	public function recache( $limit = false, $ignoreErrors = true ) {
		$dbw = wfGetDB( DB_MASTER );

		/**
		 * 1. Get the new data first
		 */
		$pagesWithoutInfobox = $this->reallyDoQuery();

		/**
		 * 2. Delete the existing records
		 */
		( new WikiaSQL() )
			->DELETE( 'querycache' )
			->WHERE( 'qc_type' )->EQUAL_TO( $this->getName() )
			->run( $dbw );

		/**
		 * 3. Insert the new records if the $pagesWithoutInfobox array is not empty
		 */
		( new WikiaSQL() )
			->INSERT()->INTO( 'querycache', [
				'qc_type',
				'qc_value',
				'qc_namespace',
				'qc_title'
			] )
			->VALUES( $pagesWithoutInfobox )
			->run( $dbw );

		wfRunHooks( 'PagesWithoutInfoboxQueryRecached' );

		return count( $pagesWithoutInfobox );
	}

	/**
	 * Returns an array with data on pages that do not have an infobox.
	 *
	 * @param bool $limit Only for consistency
	 * @param bool $offset Only for consistency
	 * @return array
	 */
	public function reallyDoQuery( $limit = false, $offset = false ) {
		global $wgCityId, $wgContentNamespaces;

		$tc = new UserTemplateClassificationService();

		$infoboxTemplates = [];
		foreach( $tc->getTemplatesOnWiki( $wgCityId ) as $pageId => $templateType ) {
			if ( $tc->isInfoboxType( $templateType ) ) {
				$templateTitle = Title::newFromID( $pageId );
				if ( $templateTitle instanceof Title ) {
					$infoboxTemplates[] = $templateTitle->getDBkey();
				}
			}
		}

		$dbr = wfGetDB( DB_SLAVE, [ $this->getName(), __METHOD__, 'vslow' ] );

		$pagesWithInfobox = [];
		if ( !empty( $infoboxTemplates ) ) {
			$pagesWithInfobox = ( new WikiaSQL() )
				->SELECT( 'tl_from' )
				->FROM( 'templatelinks' )
				->WHERE( 'tl_title' )->IN( $infoboxTemplates )
					->AND_( 'tl_namespace' )->EQUAL_TO( NS_TEMPLATE )
				->runLoop( $dbr, function ( &$pagesWithInfobox, $row ) {
					$pagesWithInfobox[$row->tl_from] = true;
				} );
		}

		$contentPages = ( new WikiaSQL() )
			->SELECT( 'page_id', 'page_title', 'page_namespace' )
			->FROM( 'page' )
			->WHERE( 'page_namespace' )->IN( $wgContentNamespaces )
			->ORDER_BY( 'page_id' )->DESC()
			->runLoop( $dbr, function ( &$contentPages, $row ) {
				$contentPages[$row->page_id] = [
					$this->getName(),
					$row->page_id,
					$row->page_namespace,
					$row->page_title,
				];
			} );

		if ( empty( $contentPages ) ) {
			$pagesWithoutInfobox = [];
		} elseif ( empty( $pagesWithInfobox ) ) {
			$pagesWithoutInfobox = $contentPages;
		} else {
			$pagesWithoutInfobox = array_slice( array_diff_key( $contentPages, $pagesWithInfobox ), 0, self::LIMIT );
		}

		return $pagesWithoutInfobox;
	}
}
