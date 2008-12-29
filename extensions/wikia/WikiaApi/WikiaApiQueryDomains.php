<?php

/**
 * WikiaApiQueryDomains - ask for id <> domains array for wikia
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia.com>
 *
 * @todo use access for giving variables values only with proper access rights
 *
 * $Id: WikiaApiQueryDomains.php 12417 2008-05-07 09:33:11Z eloy $
 */
class WikiaApiQueryDomains extends ApiQueryBase {

	/**
	 * constructor
	 */
	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName, "wk");
	}

	/**
	 * main function
	 */
	public function execute() {
		$wikia = null;

		extract( $this->extractRequestParams() );

		/**
		 * database instance
		 */
		$db = $this->getDB();
		$activeonly = false;
		if( isset($active) ) {
			$activeonly = true;
		}

		/**
		 * query builder
		 */
		$this->addTables(array(wfSharedTable('city_list')));
		$this->addFields(array('city_id', 'city_url'));

		if ($activeonly) $this->addWhereFld('city_public', 1);
		if ($wikia) $this->addWhereFld('city_id', $wikia);

		$this->addOption( "ORDER BY ", "city_id" );

		#--- result builder
		$data = array();
		$res = $this->select(__METHOD__);
		while ($row = $db->fetchObject($res)) {
			$domain = $row->city_url;
			$domain =  preg_replace('/^http:\/\//', '', $domain);
			$domain =  preg_replace('/\/$/',        '', $domain);
			if ($domain) {
				$data[$row->city_id] = array(
					"id"		=> $row->city_id,
					"domain"	=> $domain,
				);
				ApiResult :: setContent( $data[$row->city_id], $domain );
			}
		}
		$db->freeResult($res);

		$this->getResult()->setIndexedTagName($data, 'variable');
		$this->getResult()->addValue('query', $this->getModuleName(), $data);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: WikiaApiQueryDomains.php 12417 2008-05-07 09:33:11Z eloy $';
	}

	public function getDescription() {
		return "Get domains handled by Wikia";
	}

	public function getAllowedParams() {
		return array (
			"wikia" => array(
				ApiBase :: PARAM_TYPE => 'integer'
			),
			"active" => array(
				ApiBase :: PARAM_TYPE => "integer",
				ApiBase :: PARAM_MAX => 1,
				ApiBase :: PARAM_MIN => 0,
			)
		);
	}

	public function getParamDescription() {
		return array (
			"wikia" => "Identifier in Wiki Factory",
			"active" => "Get only active domains [optional]"
		);
	}

	public function getExamples() {
		return array (
			"api.php?action=query&list=wkdomains",
			"api.php?action=query&list=wkdomains&wkactive=1",
			"api.php?action=query&list=wkdomains&wkwikia=177",
		);
	}
};
