<?php

class UnconvertedInfoboxesPage extends PageQueryPage {
	const LIMIT = 1000;

	function __construct( $name = 'UnconvertedInfoboxes' ) {
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

	public function doQuery( $offset = false, $limit = self::LIMIT ) {
		return $this->fetchFromCache( $limit, $offset );
	}

	public function recache( $limit = false, $ignoreErrors = true ) {
		$dbw = wfGetDB( DB_MASTER );

		/**
		 * 1. Get the new data first
		 */
		$nonportableTemplates = $this->reallyDoQuery();
		$dbw->begin();

		/**
		 * 2. Delete the existing records
		 */
		( new WikiaSQL() )
			->DELETE( 'querycache' )
			->WHERE( 'qc_type' )->EQUAL_TO( $this->getName() )
			->run( $dbw );

		/**
		 * 3. Insert the new records if the $nonportableTemplates array is not empty
		 */
		$num = 0;
		if ( !empty( $nonportableTemplates ) ) {

			( new WikiaSQL() )
				->INSERT()->INTO( 'querycache', [
					'qc_type',
					'qc_value',
					'qc_namespace',
					'qc_title'
				] )
				->VALUES( $nonportableTemplates )
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

	public function reallyDoQuery( $limit = false, $offset = false ) {
		$dbr = wfGetDB( DB_SLAVE, [ $this->getName(), __METHOD__, 'vslow' ] );

		$nonportableTemplates = ( new WikiaSQL() )
			->SELECT( 'page_title as title' )
			->FROM( 'page' )
			->WHERE( 'page_namespace' )->EQUAL_TO( NS_TEMPLATE )
			->runLoop( $dbr, function( &$nonportableTemplates, $row ) {
				$title = Title::newFromText( $row->title, NS_TEMPLATE );
				$contentText = ( new WikiPage( $title ) )->getText();
				if ( $title !== null && self::isTitleWithNonportableInfobox( $title->getText(), $contentText ) ) {
					$links = $title->getIndirectLinks();
					$nonportableTemplates[] = [
						$this->getName(),
						count( $links ),
						NS_TEMPLATE,
						$row->title,
					];
				}
			} );

		return $nonportableTemplates;
	}

	public static function isTitleWithNonportableInfobox( $titleText, $contentText ) {
		$titleNeedle = 'infobox';
		if ( strripos( $titleText, $titleNeedle ) !== false ) {
			$portableInfoboxNeedle = '<infobox>';

			// If a portable infobox markup was found
			// it means that the template doesn't have a non-portable infobox
			return !( strpos( $contentText, $portableInfoboxNeedle ) !== false );
		} else {
			$nonportableInfoboxRegEx = '/class=\"[^\"]*infobox[^\"]*\"/i';
			$nonportableInfoboxRegExMatch = preg_match( $nonportableInfoboxRegEx, $contentText );

			// If a non-portable infobox markup was found
			// the $nonportableInfoboxRegExMatch is not empty
			return !empty( $nonportableInfoboxRegExMatch );
		}
	}
}
