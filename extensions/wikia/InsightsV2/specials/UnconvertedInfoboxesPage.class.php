<?php

class UnconvertedInfoboxesPage extends PageQueryPage {
	const LIMIT = 1000;
	const UNCONVERTED_INFOBOXES_TYPE = 'Nonportableinfoboxes';

	function __construct( $name = self::UNCONVERTED_INFOBOXES_TYPE ) {
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
		}

		wfRunHooks( 'UnconvertedInfoboxesQueryRecached', [ 'count' => $num ] );

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
		global $wgCityId;

		$tcs = new UserTemplateClassificationService();
		$recognizedTemplates = $tcs->getTemplatesOnWiki( $wgCityId );

		$nonportableInfoboxes = [];

		foreach ( $recognizedTemplates as $templateId => $type ) {
			if ( $tcs->isInfoboxType( $type ) ) {
				$title = Title::newFromID( $templateId );
				if ( $title instanceof Title
					&& $title->inNamespace( NS_TEMPLATE )
					&& !$title->isRedirect()
					&& empty( PortableInfoboxDataService::newFromTitle( $title )->getData() )
				) {
					$links = $title->getIndirectLinks();
					$nonportableInfoboxes[] = [
						$this->getName(),
						count( $links ),
						NS_TEMPLATE,
						$title->getDBkey(),
					];
				}
			}
		}

		return $nonportableInfoboxes;
	}
}
