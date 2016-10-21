<?php

/**
 * A query module to generate pageviews .
 *
 */
class WikiaApiQueryLastEditors extends ApiQueryBase {

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
		global $wgStatsDB, $wgStatsDBEnabled;
		return ( !empty( $wgStatsDBEnabled ) ) ? wfGetDB(DB_SLAVE, array(), $wgStatsDB) : null;
	}

	private function getEventsInfo() {
		wfProfileIn( __METHOD__ );

		$where = array();

		$where['wiki_id'] = intval($this->mCityId);
		
		# bot
		if ( empty( $this->params['bot'] ) ) {
			$where['user_is_bot'] = 'N';
		}
		
		# content
		if ( $this->params['content'] == 1 ) {
			$where['is_content'] = 'Y';
		}
		
		# anons
		if ( empty( $this->params['anons'] ) ) {
			$where[] = 'user_id > 0';
		}

		$db = $this->getDB();
		if ( is_null ( $db  ) ) {
			wfProfileOut(__METHOD__);
			return false;
		}
		
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
				'ORDER BY' => 'rev_timestamp DESC',
				'USE INDEX' => 'for_wikia_api_last_editors_idx',
				'LIMIT'	=> $this->params['limit'],
				'OFFSET' => $this->params['offset']
			)
		);
		
		$i = 0;
		$data = array();
		while ( $row = $db->fetchObject($oRes) ) {
			# wiki 
			$oWiki = WikiFactory::getWikiByID( $row->wiki_id );
			if ( empty( $oWiki ) ) continue;
			# server name
			$server = WikiFactory::getVarValueByName( "wgServer", $row->wiki_id );
			# user
			$oUser = null; 
			$username = long2ip( $row->ip );
			if ( $row->user_id > 0 ) {
				$oUser = User::newFromId( $row->user_id );
				$username = $oUser->getName();
			}
			# page
			$url = "";
			if ( $row->event_type == 1 || $row->event_type == 2 ) { // edit or create
				$oGTitle = GlobalTitle::newFromId( $row->page_id, $row->wiki_id );
				if ( is_object( $oGTitle ) ) {
					$url = $oGTitle->getFullURL();
				}
			} 
			if ( empty( $url ) ) {
				if ( is_object( $oUser ) ) {
					$url = $oUser->getUserPage()->getFullURL();
				} else {
					$url = $server;
				}
			}
			# avatar
			$avatar = AvatarService::getAvatarUrl( $username, 75 );
			 
			$data[$i] = array(
				'wiki_id' 		=> $row->wiki_id,
				'wiki_url'		=> $server,
				'page_id'		=> $row->page_id,
				'page_url'		=> $url,
				'namespace'		=> $row->page_ns,
				'action'		=> ( $row->log_id > 0 ) ? 'remove' : 'edit',
				'user_id'		=> $row->user_id,
				'user_name'		=> $username,
				'user_avatar'	=> $avatar,
				'bot'			=> $row->user_is_bot,
				'content'		=> $row->is_content,
				'redirect'		=> $row->is_redirect, 
				'edited'		=> $row->rev_timestamp,
			);
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

		$data = $this->getEventsInfo();
		
		$this->getResult()->setIndexedTagName($data, 'row');
		$this->getResult()->addValue('query', 'wklasteditors', $data);

		wfProfileOut( __METHOD__ );
	}

	public function getExamples() {
		return array_merge(
			array (
				"Get last logged-in editors of content pages Wiki",
				"  api.php?action=query&prop=wklasteditors&limit=25&bot=0&content=1&anon=0",
				"Get last editors ",
				"  api.php?action=query&prop=wklasteditors&limit=25",				
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
			'bot' => array (
				ApiBase :: PARAM_ISMULTI => 0,
				ApiBase :: PARAM_TYPE => 'integer',
				ApiBase :: PARAM_DFLT => 0,
				ApiBase :: PARAM_MIN => 0,
			),
			'content' => array (
				ApiBase :: PARAM_ISMULTI => 0,
				ApiBase :: PARAM_TYPE => 'integer',
				ApiBase :: PARAM_DFLT => 0,
				ApiBase :: PARAM_MIN => 0,
			),			
			'anon' => array (
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
			'offset' 	=> 'Limit offset',
			'bot'		=> 'Return also bots ( if bot = 1 )',
			'content'	=> 'Check only editors of content namespaces',
			'anon'		=> 'Return also anons ( if anon = 1 )'
		);
	}

	public function getDescription() {
		return array (
			'Get the last contributors'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: WikiaApiQueryLastEditors.php 4840 2011-09-01 13:21:38Z moli $';
	}
}
