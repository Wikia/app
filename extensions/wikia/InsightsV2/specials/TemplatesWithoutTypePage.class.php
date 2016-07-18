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
		}
		$num = count( $templatesWithoutType );

		wfRunHooks( 'TemplatesWithoutTypeQueryRecached', [ 'count' => $num ] );

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
		$templatesWithoutType = [];

		$recognizedProvider = new RecognizedTemplatesProvider(
			( new UserTemplateClassificationService() ),
			$wgCityId,
			$wgContentNamespaces
		);

		$cnNotRecognizedTemplates = $recognizedProvider->getNotRecognizedTemplates();

		$templatesCounter = 0;
		foreach( $cnNotRecognizedTemplates as $pageId => $notRecognizedTemplate ) {
			if ( $templatesCounter === self::LIMIT ) {
				break;
			}

			$title = Title::newFromID( $pageId );
			if ( $title instanceof Title && !$title->isRedirect() ) {
				$links = $title->getIndirectLinks();
				$templatesWithoutType[] =
					[
						$this->getName(),
						count( $links ),
						NS_TEMPLATE,
						$title->getDBkey()
					];
				$templatesCounter++;
			}
		}

		return $templatesWithoutType;
	}
}
