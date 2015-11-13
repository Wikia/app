<?php

class TemplatesWithoutTypePage extends PageQueryPage {
	const LIMIT = 1000;
	const TEMPLATES_WITHOUT_TYPE_TYPE = 'Templateswithouttype';

	function __construct( $name = self::TEMPLATES_WITHOUT_TYPE_TYPE ) {
		parent::__construct( $name );
	}

	public function isListed() {
		return false;
	}

	public function sortDescending() {
		return true;
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
	 * @return bool|int
	 */
	public function recache( $limit = false, $ignoreErrors = true ) {
		$dbw = wfGetDB( DB_MASTER );

		/**
		 * 1. Get the new data first
		 */
		$templatesWithoutType = $this->reallyDoQuery();
		$dbw->begin();

		/**
		 * 2. Delete the existing records
		 */
		( new WikiaSQL() )
			->DELETE( 'querycache' )
			->WHERE( 'qc_type' )->EQUAL_TO( $this->getName() )
			->run( $dbw );

		/**
		 * 3. Insert the new records if the $templatesWithoutType array is not empty
		 */
		$num = 0;
		if ( !empty( $templatesWithoutType ) ) {

			( new WikiaSQL() )
				->INSERT()->INTO( 'querycache', [
					'qc_type',
					'qc_value',
					'qc_namespace',
					'qc_title'
				] )
				->VALUES( $templatesWithoutType )
				->run( $dbw );

			$num = $dbw->affectedRows();
			if ( $num === 0 ) {
				$dbw->rollback();
				$num = false;
			} else {
				$dbw->commit();
			}
		}

		return $num;
	}

	/**
	 * Prepares a list of not recognized templates that are used on content namespace pages on a wikia.
	 *
	 * return array structure
	 * [
	 *   [ {qc_type}, {qc_value}, {qc_ns}, {qc_title} ],
	 *   ...
	 * ]
	 * @param bool $limit Only for consistency
	 * @param bool $offset Only for consistency
	 * @return array
	 */
	public function reallyDoQuery( $limit = false, $offset = false ) {
		global $wgCityId, $wgContentNamespaces;
		$dbr = wfGetDB( DB_SLAVE, [ $this->getName(), __METHOD__, 'vslow' ] );
		$templatesWithoutType = [];

		$cnTemplatesOnWikia = $this->getContentNamespacesTemplates( $dbr, $wgContentNamespaces );
		$notRecognizedTemplates  = $this->getNotRecognizedTemplatesOnWikia(
			( new TemplateClassificationService() ),
			$wgCityId
		);

		$cnNotRecognizedTemplates = $this->intersectSets( $cnTemplatesOnWikia, $notRecognizedTemplates );

		foreach( $cnNotRecognizedTemplates as $notRecognizedTemplate ) {
			$title = Title::newFromID( $notRecognizedTemplate );
			if ( $title instanceof Title ) {
				$links = $title->getIndirectLinks();
				$templatesWithoutType[] =
					[
						$this->getName(),
						count( $links ),
						NS_TEMPLATE,
						$title->getDBkey()
					];
			}
		}

		return $templatesWithoutType;
	}

	private function getContentNamespacesTemplates($db, $contentNamespaces) {
		$sql = ( new \WikiaSQL() )
			->SELECT()->DISTINCT( 'p2.page_id as temp_id' )
			->FROM( 'page' )->AS_( 'p' )
			->INNER_JOIN( 'templatelinks' )->AS_( 't' )
			->ON( 't.tl_from', 'p.page_id' )
			->INNER_JOIN( 'page' )->AS_( 'p2' )
			->ON( 'p2.page_title', 't.tl_title' )
			->WHERE( 'p.page_namespace' )->IN( $contentNamespaces )
			->AND_( 'p2.page_namespace' )->EQUAL_TO( NS_TEMPLATE )
			->AND_( 'p.page_id' )->NOT_EQUAL_TO( Title::newMainPage()->getArticleID() );

		$pages = $sql->runLoop( $db, function ( &$pages, $row ) {
			$pages[] = $row->temp_id;
		});

		return $pages;
	}

	private function getNotRecognizedTemplatesOnWikia( TemplateClassificationService $tcService, $wikiaId ) {
		$templates = $tcService->getTemplatesOnWiki( $wikiaId );
		foreach ( $templates as $pageId => $type ) {
			if ( $this->isRecognized( $type ) ) {
				unset( $templates[$pageId] );
			}
		}
		return $templates;
	}


	/**
	 * Remove non content templates from list of not recognized templates
	 */
	public function intersectSets( $cnTemplatesOnWikia, $notRecognizedTemplates ) {
		$cnNotRecognizedTemplates = [];
		foreach ( $notRecognizedTemplates as $pageId => $type ) {
			if ( in_array( $pageId, $cnTemplatesOnWikia ) ) {
				$cnNotRecognizedTemplates[] = $pageId;
			}
		}
		return $cnNotRecognizedTemplates;
	}

	private function isRecognized( $type ) {
		return $type !== TemplateClassificationService::TEMPLATE_UNKNOWN
			&& $type !== AutomaticTemplateTypes::TEMPLATE_UNCLASSIFIED
			&& $type !== AutomaticTemplateTypes::TEMPLATE_OTHER;
	}
}
