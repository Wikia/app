<?php

/**
 * WikiaApiQueryWhosOnline
 *
 * API for WhosOnline extension
 *
 * @author Maciej Brencz <macbre@wikia.com>
 * @author Maciej Błaszkowski <marooned@wikia.com> - optimization
 *
 */

class WikiaApiQueryWhosOnline extends WikiaApiQuery {

	/**
	 * constructor
	 */
	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName);
	}

	/**
	 * main function
	 */
	public function execute() {
		$this->executeQuery();
	}

	private function executeQuery() {
		global $wgMemc, $wgMaxAgeUserOnline, $wgCityId;

		$key = 'wikia:whosonline:data';
		$memcData = $wgMemc->get($key);
		if (!is_array($memcData)) {
			// database instance
			$dbr =& $this->getDB(DB_SLAVE);

			// build query
			$this->addTables( array( 'online') );
			$this->addFields( array('userid', 'username', 'timestamp', 'wikiid') );

			$this->addOption( 'ORDER BY', 'timestamp DESC' );

			$maxAge = wfTimestamp(TS_UNIX) - $wgMaxAgeUserOnline;
			$this->addWhere("timestamp >= '$maxAge'");

			// build results
			$data = array();
			$res = $this->select(__METHOD__);

			$i = $countUsers = $countAnons = 0;

			while ($row = $dbr->fetchObject($res)) {
				// count both anons and logged-in
				if ($row->userid != 0) {
					// add only logged-in
					$data[$i] = array (
						'userid' => $row->userid,
						'user' => $row->username,
						'time' => $row->timestamp,
						'wikiid' => $row->wikiid
					);
					$countUsers++;
				}
				else {
					$countAnons++;
				}
				$i++;
			}

			$dbr->freeResult($res);

			$memcData = array (
				'data' => $data,
				'countUsers' => $countUsers,
				'countAnons' => $countAnons
			);
			$wgMemc->set($key, $memcData, $wgMaxAgeUserOnline);
		} else {
			extract($memcData, EXTR_OVERWRITE);
		}

		$params = $this->getInitialParams();
		$limit  = is_numeric($params['limit']) ? $params['limit'] : 50;
		$offset = is_numeric($params['offset']) ? $params['offset'] : 0;

		if (empty($wgWhosOnlinePerWiki)) {
			//look on every wiki and display only one record for one user (the newest)
			$tmpUsers = array();
			for($i = count($data)-1; $i >= 0; $i--) {
				if (empty($tmpUsers[$data[$i]['user']])) {
					$tmpUsers[$data[$i]['user']] = 1;
				} else {
					$data[$i]['userid'] == 0 ? $countAnons-- : $countUsers--;
					unset($data[$i]);
				}
			}
		} else {
			//look only on current wiki
			for($i = count($data)-1; $i >= 0; $i--) {
				if ($data[$i]['wikiid'] != $wgCityId) {
					$data[$i]['userid'] == 0 ? $countAnons-- : $countUsers--;
					unset($data[$i]);
				}
			}
		}

		// limit results
		$data = array_slice($data, $offset, $limit);

		$this->getResult()->setIndexedTagName($data, 'online');
		$this->getResult()->addValue('query', $this->getModuleName(), $data);
		$this->getResult()->addValue('query', 'users', intval($countUsers) );
		$this->getResult()->addValue('query', 'anons', intval($countAnons) );
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: WhosOnlineApi.php Macbre, Marooned $';
	}

	public function getQueryDescription() {
		return 'Get list of users currently online';
	}

	public function getAllowedQueryParams() {
		return array (
			'limit' => array (
				ApiBase :: PARAM_TYPE => 'integer'
			),
			'offset' => array (
				ApiBase :: PARAM_TYPE => 'integer'
			)
		);
	}

	public function getParamQueryDescription() {
		return array (
			'limit'    => 'Limit number of returned users',
			'offset'   => 'Offset of returned list of users',
		);
	}

	public function getQueryExamples() {
		return array (
			'api.php?action=query&list=whosonline',
			'api.php?action=query&list=whosonline&wklimit=5',
			'api.php?action=query&list=whosonline&wklimit=5&wkoffset=15'
		);
	}
}