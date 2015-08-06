<?php

/**
 * Provides "tagsreport" MW API end-point
 *
 * See /api.php for documentation
 */
class WikiaApiTagsReport extends ApiQueryBase {

	const LIMIT = 75;

	public function execute() {
		global $wgCityId;
		wfProfileIn( __METHOD__ );

		// apply API request parameters
		$params = $this->extractRequestParams();

		$pageId = false;
		if ( isset( $params['title'] ) ) {
			$title = Title::newFromText( $params['title'] );
			if ( $title instanceof Title ) {
				$pageId = $title->getArticleID();
			}
		}

		// build a query
		$this->addTables( TagsReportPage::TABLE );
		$this->addFields( 'ct_page_id as page_id' );
		$this->addFields( 'ct_kind as tag' );

		$this->addWhere  ( [ 'ct_wikia_id' => $wgCityId ] );

		// optional API parameters
		$this->addWhereIf( [ 'ct_page_id'  => $pageId ],        $pageId !== false );
		$this->addWhereIf( [ 'ct_kind'     => $params['tag'] ], isset( $params['tag'] ) );

		// apply limits and continue
		$limit = $params['limit'];
		$this->addOption( 'LIMIT', $limit + 1 );
		$this->addWhereRange( 'ct_page_id', 'newer', $params[ 'continue' ], null /* $end */ );

		// run the query and format the results
		$res = $this->select( __METHOD__ );
		$entries = [];
		$count = 0;

		foreach ( $res as $row ) {
			$pageId = intval( $row->page_id );

			if ( ++ $count > $limit ) {
				// We've reached the one extra which shows that there are additional pages to be had. Stop here...
				$this->setContinueEnumParameter( 'continue', $pageId );
				break;
			}

			$title = Title::newFromID( $pageId );

			if ( $title instanceof Title ) {
				$entries[] = [
					'page_id' => $pageId,
					'title'   => $title->getPrefixedText(),
					'name'    => $row->tag,
				];
			}
		}

		$this->getDB()->freeResult( $res );

		// get the report generation time
		$generationTime = $this->getDB()->selectField(
			TagsReportPage::TABLE,
			'max(ct_timestamp) as ts',
			[ 'ct_wikia_id' => $wgCityId ],
			__METHOD__
		);

		$this->getResult()->addValue( 'query', 'generated', $generationTime );

		// add the <tags> entries
		$this->getResult()->setIndexedTagName( $entries, 'tag' );
		$this->getResult()->addValue( 'query', 'tagsreport', $entries );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Get connection to the stats DB slave
	 *
	 * @return DatabaseBase
	 */
	protected function getDB() {
		global $wgStatsDB;
		return wfGetDB( DB_SLAVE, 'api', $wgStatsDB );
	}

	public function getAllowedParams() {
		return [
			'title' => [
				ApiBase :: PARAM_TYPE => 'string'
			],
			'tag' => [
				ApiBase :: PARAM_TYPE => 'string'
			],
			'limit' => array(
				ApiBase::PARAM_DFLT => self::LIMIT,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2
			),
			'continue' => null,
		];
	}

	public function getParamDescription() {
		return [
			'title' => 'Query by article title (string)',
			'tag' => 'Query by tag type (string)',
			'limit' => 'How many tags to return',
			'continue' => 'When more results are available, use this to continue',
		];
	}

	public function getDescription() {
		return [ 'This module provides tags report data for articles' ];
	}

	/**
	 * Examples
	 */
	public function getExamples() {
		$mainPage = Title::newMainPage()->getPrefixedDBkey();

		return [
			'api.php?action=tagsreport',
			'api.php?action=tagsreport&title=' . urlencode( $mainPage ),
			'api.php?action=tagsreport&tag=gallery',
		];
	}

	public function getVersion() {
		return '$Id$';
	}
}
