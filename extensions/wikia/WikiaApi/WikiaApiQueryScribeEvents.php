<?php

/**
 * A query module to generate pageviews .
 *
 */
class WikiaApiQueryScribeEvents extends ApiQueryBase {

	private 
		$params = array(),
		$mRevId = false,
		$mCityId = false,
		$mPageId = false,
		$mLogid = false;

	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName, "");
	}
	
	protected function getDB() {
		global $wgStatsDB;
		return wfGetDB(DB_SLAVE, array(), $wgStatsDB);
	}

	private function getEventsInfo() {
		wfProfileIn( __METHOD__ );

		$where = array();
		if ( $this->params['all'] != 1 ) { 
			$where['wiki_id'] = intval($this->mCityId);
		} else {
			$where[] = "wiki_id > 0";
		}

		$db = $this->getDB();
		$this->profileDBIn();
		$oRes = $db->select( 
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
			$where,
			__METHOD__,
			array(
				'ORDER BY' => 'event_date DESC',
				'LIMIT'	=> $this->params['limit'],
				'OFFSET' => $this->params['offset']
			)
		);
		
		$i = 0;
		$data = array();
		while ($row = $db->fetchObject($oRes)) {
			$record = array();
			foreach ($row as $key => $val ) {
				$record[$key] = $val;
			}
			$data[$i] = $record;
			//ApiResult :: setContent( $data[$i], $i );
			$i++;
		}
		$db->freeResult($oRes);
		$this->profileDBOut();

		wfProfileOut( __METHOD__ );
		return $data;
	}

	public function execute() {
		global $wgCityId, $wgUser;
		wfProfileIn( __METHOD__ );

		# extract request params
		$this->mCityId = $wgCityId;
		$this->params = $this->extractRequestParams(false);

		if (!$wgUser->isAllowed('scribeevents')) {
			$this->dieUsageMsg(array('readrequired'));
		}

		$data = $this->getEventsInfo();
		
		$this->getResult()->setIndexedTagName($data, 'event');
		$this->getResult()->addValue('query', 'events', $data);

		wfProfileOut( __METHOD__ );
	}

	protected function getExamples() {
		return array_merge(
			array (
				"Get last events for Wiki ",
				"  api.php?action=query&prop=wkevents&limit=25",
				"Get last events for all Wikis ",
				"  api.php?action=query&prop=wkevents&limit=25&all=1",				
			)
		);
	}
	
	public function getAllowedParams() {
		return array (
			'limit' => array (
				ApiBase :: PARAM_ISMULTI => 0,
				ApiBase :: PARAM_TYPE => 'integer',
				ApiBase :: PARAM_DFLT => 25,
				ApiBase :: PARAM_MIN => 25,
			),
			'offset' => array (
				ApiBase :: PARAM_ISMULTI => 0,
				ApiBase :: PARAM_TYPE => 'integer',
				ApiBase :: PARAM_DFLT => 0,
				ApiBase :: PARAM_MIN => 0,
			),
			'all' => array (
				ApiBase :: PARAM_ISMULTI => 0,
				ApiBase :: PARAM_TYPE => 'integer',
				ApiBase :: PARAM_DFLT => 0,
				ApiBase :: PARAM_MIN => 0,
			),			
		);
	}

	public function getParamDescription() {
		return array (
			'limit' 	=> 'Limit records',
		);
	}

	public function getDescription() {
		return array (
			'Get scribe events'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: WikiaApiQueryScribeEvents.php 4840 2010-06-09 16:21:38Z moli $';
	}
}
