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
	public function __construct( $query, $moduleName ) {
		$this->defLimit = 1000;
		parent :: __construct( $query, $moduleName, 'wk' );
	}

	protected function getDB() {
		global $wgExternalSharedDB;
		return wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
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
		if( isset( $active ) ) {
			$activeonly = true;
		}

		/**
		 * query builder
		 */
		$this->addTables( [ 'city_list' ] );

		if ( $activeonly ) {
			$this->addWhereFld( 'city_public', 1 );
		}

		if ( $wikia ) {
			$this->addWhereFld( 'city_id', $wikia );
		}

		if ( empty( $wikia ) ) {
			if ( !empty( $to ) ) {
				if ( $to && is_int( $to ) ) {
					$to = intval( $to );
					$this->addWhere( 'city_id <= ' . $to );	
				}
			}

			if ( !empty( $from ) ) {
				if ( $from && is_int( $from ) ) {
					$from = intval( $from );
					$this->addWhere( 'city_id >= ' . $from );
				}
			}
		}

		if ( !empty( $lang ) ) {
			if ( !Language::isValidBuiltInCode( $lang ) ) {
				// FIXME add proper error msg
				$this->dieUsageMsg( [ 'invalidtitle', $lang ] );
			}

			$this->addWhereFld( 'city_lang', $lang );
		}

		if ( isset( $countonly ) ) {
			/**
			 * query builder
			 */
			$this->addFields( [ 'count(*) as cnt' ] );
			$data = [];
			$res = $this->select( __METHOD__ );
			if ( $row = $db->fetchObject( $res ) ) {
				$data['count'] = $row->cnt;
				ApiResult :: setContent( $data, $row->cnt );
			}
			$db->freeResult( $res );
		} else {
			$this->addFields( [ 'city_id', 'city_url', 'city_lang' ] );
			$this->addOption( 'ORDER BY ', 'city_id' );
			$this->addOption( 'LIMIT', $this->defLimit );

			#--- result builder
			$data = [];
			$res = $this->select( __METHOD__ );
			while ( $row = $db->fetchObject( $res ) ) {
				$domain = $row->city_url;
				$domain =  preg_replace( '/^http:\/\//', '', $domain );
				$domain =  preg_replace( '/\/$/',        '', $domain );
				if ( $domain ) {
					$data[ $row->city_id ] = [
						'id'		=> $row->city_id,
						'domain'	=> $domain,
						'lang'		=> $row->city_lang,
					];
					ApiResult :: setContent( $data[ $row->city_id ], $domain );
				}
			}
			$db->freeResult( $res );
		}

		$this->getResult()->setIndexedTagName( $data, 'variable' );
		$this->getResult()->addValue( 'query', $this->getModuleName(), $data );
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: WikiaApiQueryDomains.php 12417 2008-05-07 09:33:11Z eloy $';
	}

	public function getDescription() {
		return [
			'Get domains handled by Fandom',
			"This API returns a maximum of {$this->defLimit} results"
		];
	}

	public function getAllowedParams() {
		return [
			'wikia' => [
				ApiBase :: PARAM_TYPE => 'integer'
			],
			'active' => [
				ApiBase :: PARAM_TYPE => 'integer',
				ApiBase :: PARAM_MAX => 1,
				ApiBase :: PARAM_MIN => 0,
			],
			'from' => [
				ApiBase :: PARAM_TYPE => 'integer',
				ApiBase :: PARAM_MIN => 1,
				ApiBase :: PARAM_DFLT => 1,
			],
			'to' => [
				ApiBase :: PARAM_TYPE => 'integer',
				ApiBase :: PARAM_MIN => 1,
				ApiBase :: PARAM_DFLT => $this->defLimit,
			],
			'countonly' => [
				ApiBase :: PARAM_TYPE => 'integer',
				ApiBase :: PARAM_MIN => 1,
			],
			'lang' => null,
		];
	}

	public function getParamDescription() {
		return [
			'wikia' => 'Identifier in Wiki Factory',
			'active' => 'Get only active domains [optional]',
			'from' => 'Begin of range - identifier in Wiki Factory',
			'to' => 'end of range - identifier in Wiki Factory',
			'lang' => 'Wiki language',
			'countonly' => 'return only number of Wikis'
		];
	}

	public function getExamples() {
		return [
			'api.php?action=query&list=wkdomains',
			'api.php?action=query&list=wkdomains&wkactive=1',
			'api.php?action=query&list=wkdomains&wkwikia=177',
			'api.php?action=query&list=wkdomains&wkfrom=100&wkto=150',
			'api.php?action=query&list=wkdomains&wkfrom=10000&wkto=15000&wklang=de',
			'api.php?action=query&list=wkdomains&wkcountonly=1',
			'api.php?action=query&list=wkdomains&wkactive=1&wkcountonly=1',
		];
	}
};