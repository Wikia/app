<?php

/**
 * A query module to generate pageviews .
 *
 */
class WikiaApiQueryEventInfo extends ApiQueryBase {

	private 
		$params = array(),
		$mRevId = false,
		$mCityId = false,
		$mPageId = false,
		$mLogid = false;

	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName, "");
		$this->mLogId = $this->mRevId = $tihs->mPageId = 0;
	}

	private function getRevisionCount() {
		wfProfileIn( __METHOD__ );
		$this->mRevId = 0;
		if ( isset($this->params['revid']) ) {
			$this->mRevId = intval($this->params['revid']);
		}
		$count = intval($this->mRevId > 0);
		wfProfileOut( __METHOD__ );
		return $count;
	}

	private function getPageCount() {
		wfProfileIn( __METHOD__ );
		$this->mPageId = 0;
		if ( isset($this->params['pageid']) ) {
			$this->mPageId = intval($this->params['pageid']);
		}
		$count = intval($this->mPageId > 0);
		wfProfileOut( __METHOD__ );
		return $count;
	}

	private function getLoggingCount() {
		wfProfileIn( __METHOD__ );
		$this->mLogid = 0;
		if ( isset($this->params['logid']) ) {
			$this->mLogid = intval($this->params['logid']);
		}
		$count = intval($this->mLogid > 0);
		wfProfileOut( __METHOD__ );
		return $count;
	}
	
	protected function getDB() {
		global $wgStatsDB;
		return wfGetDB(DB_SLAVE, array(), $wgStatsDB);
	}

	private function getEventInfo() {
		wfProfileIn( __METHOD__ );

		$db = $this->getDB();
		$this->profileDBIn();
		$oRow = $db->selectRow( 
			'events', 
			array(
				'wiki_id', 
				'page_id', 
				'rev_id', 
				'log_id', 
				'user_id', 
				'user_is_bot', 
				'page_ns', 
				'is_content', 
				'is_redirect', 
				'ip',
				'rev_timestamp',
				'image_links',
				'video_links',
				'total_words',
				'rev_size',
				'wiki_lang_id',
				'wiki_cat_id',
				'event_type',
				'event_date',
				'media_type'
			),	 
			array( 
				'wiki_id' 	=> intval($this->mCityId),
				'page_id' 	=> intval($this->mPageId),
				'rev_id' 	=> intval($this->mRevId),
				'log_id' 	=> intval($this->mLogId),
			),
			__METHOD__
		);
		$this->profileDBOut();

		wfProfileOut( __METHOD__ );
		return $oRow;
	}

	public function execute() {
		global $wgCityId;
		wfProfileIn( __METHOD__ );

		# extract request params
		$this->mCityId = $wgCityId;
		$this->params = $this->extractRequestParams(false);

		# check "pageid" param
		$pageCount = $this->getPageCount();

		# check "revid" param
		$revCount = $this->getRevisionCount();

		# check "logid" param
		$logCount = $this->getLoggingCount();
	
		if ( $revCount === 0 && $pageCount === 0 && $logCount == 0 ) {
			wfProfileOut( __METHOD__ );
			return;
		}

		if ( $pageCount == 0 ) {
			wfProfileOut( __METHOD__ );
			$this->dieUsage('The pageid parameter can not be empty', 'pageid');
		}
		
		if ( $logCount > 0 && $revCount > 0 ) {
			wfProfileOut( __METHOD__ );
			$this->dieUsage('The logid parameter may not be used with the revid parameter', 'logid');
		}

		if ( $pageCount > 0 && ( $revCount == 0 && $logCount == 0 ) ) {
			wfProfileOut( __METHOD__ );
			$this->dieUsage('The pageid parameter may not be used without the revid= or logid= parameter', 'logid');
		}

		$oRow = $this->getEventInfo();
		$vals = array();
		if ( is_object($oRow) ) {
			foreach ( $oRow as $key => $value ) {
				$vals[$key] = $value;				
			}
		}
		
		$this->getResult()->setIndexedTagName($vals, 'event');
		$this->getResult()->addValue('query', 'event', $vals);

		wfProfileOut( __METHOD__ );
	}

	protected function getExamples() {
		return array_merge(
			array (
				"Get event record for page and revision ",
				"  api.php?action=query&prop=wkevent&pageid=1&revid=506",
				"Get event record for page and log id (for removed pages) ",
				"  api.php?action=query&prop=wkevent&pageid=1&logid=100"
				
			)
		);
	}
	
	public function getAllowedParams() {
		return array (
			'pageid' => array (
				ApiBase :: PARAM_TYPE => 'integer',
				ApiBase :: PARAM_ISMULTI => false
			),
			'revid' => array (
				ApiBase :: PARAM_TYPE => 'integer',
				ApiBase :: PARAM_ISMULTI => false
			),
			'logid' => array (
				ApiBase :: PARAM_TYPE => 'integer',
				ApiBase :: PARAM_ISMULTI => false
			)
		);
	}

	public function getParamDescription() {
		return array (
			'pageid' 	=> 'Identifier of page',
			'revid' 	=> 'Identifier of revision',
			'logid' 	=> 'Identifier of log (for removed pages)'
		);
	}

	public function getDescription() {
		return array (
			'Get informations needed to fill events table.'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: WikiaApiQueryEventInfo.php 4840 2010-06-09 16:21:38Z moli $';
	}
}
