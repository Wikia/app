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
		if( $activeonly ) {
			$tbl_cd = array(
				wfSharedTable( "city_domains" ),
				wfSharedTable( "city_list" )
			);
			$this->addWhere(
				wfSharedTable( "city_domains" ).".city_id = " .
				wfSharedTable( "city_list" ).".city_id"
			);
			$this->addWhereFld(
				wfSharedTable( "city_list" ).".city_public", $active
			);
			$this->addFields( array(
				wfSharedTable( "city_domains" ).".city_id",
				wfSharedTable( "city_domains" ).".city_domain"
			));
		}
		else {
			list( $tbl_cd ) = $db->tableNamesN( wfSharedTable( "city_domains" ) );
			if (!is_null( $wikia )) {
				$this->addWhereFld( "city_id", $wikia );
			}
			$this->addFields( array( "city_id", "city_domain" ));
		}
		$this->addTables( $tbl_cd );

		$this->addOption( "ORDER BY ", "city_id" );

		#--- result builder
		$data = array();
		$res = $this->select(__METHOD__);
		while ($row = $db->fetchObject($res)) {
			$data[$row->city_id] = array(
				"id"		=> $row->city_id,
				"domain"	=> $row->city_domain,
			);
			ApiResult :: setContent( $data[$row->city_id], $row->city_domain );
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
