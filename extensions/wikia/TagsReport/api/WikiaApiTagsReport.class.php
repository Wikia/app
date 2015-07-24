<?php

/**
 * Provides "tagsreport" MW API end-point
 *
 * See /api.php for documentation
 */
class WikiaApiTagsReport extends ApiQueryBase {

	public function execute() {
		global $wgCityId;
		wfProfileIn(__METHOD__);

		// apply API request parameters
		$params = $this->extractRequestParams();

		$pageId = false;
		if (isset($params['title'])) {
			$title = Title::newFromText($params['title']);
			if ($title instanceof Title) {
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

		// run the query and format the results
		$res = $this->select( __METHOD__ );
		$entries = [];

		foreach($res as $row) {
			$pageId = intval($row->page_id);
			$title = Title::newFromID($pageId);

			if ($title instanceof Title) {
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

		$this->getResult()->addValue('query', 'generated', $generationTime);

		// add the <tags> entries
		$this->getResult()->setIndexedTagName($entries, 'tag');
		$this->getResult()->addValue('query', 'tags', $entries);

		wfProfileOut(__METHOD__);
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
		];
	}

	public function getParamDescription() {
		return [
			'title' => 'query by article title (string)',
			'tag' => 'query by tag type (string)',
		];
	}

	public function getDescription() {
		return [ 'This module provides tags report data for articles' ];
	}

	/**
	 * Examples
	 */
	public function getExamples() {
		return [
			'api.php?action=tagsreport',
			'api.php?action=tagsreport&title=Main_Page',
			'api.php?action=tagsreport&tag=dpl',
		];
	}

	public function getVersion() {
		return '$Id$';
	}
}
