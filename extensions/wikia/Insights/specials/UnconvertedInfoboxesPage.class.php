<?php

class UnconvertedInfoboxesPage extends PageQueryPage {
	const LIMIT = 1000;

	function __construct( $name = 'Nonportableinfoboxes' ) {
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

	/**
	 * Queries all templates and for the ones with non-portable infoboxes checks how many pages
	 * uses the them.
	 *
	 * @param bool $limit Only for consistency
	 * @param bool $offset Only for consistency
	 * @return bool|mixed
	 */
	public function reallyDoQuery( $limit = false, $offset = false ) {
		$dbr = wfGetDB( DB_SLAVE, [ $this->getName(), __METHOD__, 'vslow' ] );

		$nonportableTemplates = ( new WikiaSQL() )
			->SELECT( 'page_title' )->AS_( 'title' )
			->FROM( 'page' )
			->WHERE( 'page_namespace' )->EQUAL_TO( NS_TEMPLATE )
				->AND_( 'page_is_redirect' )->EQUAL_TO( 0 )
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

	/**
	 * Checks if a page contains non-portable infoboxes based on its title and content.
	 * The first check is if the title includes a word "infobox":
	 * - if yes, check for a new markup (<infobox>) in the content. If it is missing - it indicates that
	 *   the template contains a non-portable infobox
	 * - if no, check for an occurrence of a word "infobox" inside all class HTML attributes
	 *
	 * Returns true if a page may consist a non-portable infobox
	 *
	 * @param string $titleText
	 * @param string $contentText
	 * @return bool
	 */
	public static function isTitleWithNonportableInfobox( $titleText, $contentText ) {
		// ignore docs pages
		if ( stripos( $titleText, '/doc' ) ) {
			return false;
		}

		$titleNeedle = 'infobox';
		if ( strripos( $titleText, $titleNeedle ) !== false ) {
			$portableInfoboxNeedle = '<infobox';

			// If a portable infobox markup was found
			// it means that the template doesn't have a non-portable infobox
			return strpos( $contentText, $portableInfoboxNeedle ) === false;
		} else {
			$nonportableInfoboxRegEx = '/class=\"[^\"]*infobox[^\"]*\"/i';
			$nonportableInfoboxRegExMatch = preg_match( $nonportableInfoboxRegEx, $contentText );

			// If a non-portable infobox markup was found
			// the $nonportableInfoboxRegExMatch is not empty
			return !empty( $nonportableInfoboxRegExMatch );
		}
	}
}
