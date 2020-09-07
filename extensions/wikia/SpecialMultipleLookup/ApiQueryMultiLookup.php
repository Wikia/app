<?php

/**
 * Provides API module to look up activity from a given IP address across all of FANDOM
 */
class ApiQueryMultiLookup extends ApiQueryBase {
	/** @var DatabaseBase $db */
	private $db;

	public function __construct( ApiBase $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'ml' );
	}

	/**
	 * @inheritdoc
	 */
	public function execute() {
		if ( !$this->getUser()->isAllowed( 'multilookup' ) ) {
			$this->dieUsageMsg( 'badaccess-groups' );
		}

		$params = $this->extractRequestParams();

		if ( !IP::isIPAddress( $params['target'] ) ) {
			$this->dieUsage( 'Invalid IP', 'brokenip', 400 );
		}

		$ipAddress = inet_pton( $params['target'] );

		$this->addTables( 'multilookup' );
		$this->addFields( '*' );
		$this->addWhereFld( 'ml_ip_bin', $ipAddress );

		if ( !empty( $params['offset'] ) ) {
			$ts = $this->getDB()->timestamp( $params['offset'] );
			$this->addWhere( 'ml_ts < ' . $this->getDB()->addQuotes( $ts ) );
		}

		$this->addOption( 'ORDER BY', 'ml_ts DESC' );

		$result = $this->getResult();

		foreach ( $this->select( __METHOD__ ) as $row ) {
			$wiki = WikiFactory::getWikiByID( $row->ml_city_id );

			if ( !$wiki ) {
				continue;
			}

			foreach ( $this->getActivityOnWiki( $wiki, $ipAddress ) as $user ) {
				$activity = [
					'wiki' => $wiki->city_url,
					'user' => $user,
					'date' => $row->ml_ts
				];

				if ( !$result->addValue( null, null, $activity ) ) {
					$this->setContinueEnumParameter( 'offset', $row->ml_ts );
				}
			}
		}

		$result->setIndexedTagName_internal( null, 'mlactivity' );
	}

	/**
	 * @inheritdoc
	 */
	protected function getDB() {
		if ( empty( $this->db ) ) {
			global $wgSpecialsDB;
			$this->db = wfGetDB( DB_SLAVE , [ 'api' ], $wgSpecialsDB );
		}

		return $this->db;
	}

	private function getActivityOnWiki( $wiki, $ipAddress ) {
		$dbName = $wiki->city_dbname;
		$userIp = inet_ntop( $ipAddress );
		$cacheKey = wfSharedMemcKey( 'multilookup', $userIp, $dbName );
		$isUcpWiki = $wiki->city_path == 'slot2';
		$conds = $isUcpWiki ? [ 'rc_ip' => $userIp ] : [ 'rc_ip_bin' => $ipAddress ];

		return WikiaDataAccess::cache( $cacheKey,60 * 15 /* 15 mins */, function () use ( $dbName, $conds, $userIp ) {
			$dbr = wfGetDB( DB_SLAVE, [], $dbName );

			$res = $dbr->select(
				[ 'recentchanges' ],
				[ 'rc_user as user_id' ],
				$conds,
				__METHOD__,
				[ 'DISTINCT' ]
			);

			$users = [];
			foreach ( $res as $user ) {
				// SUS-812: use username lookup - user ID for registered users, IP address for anons
				$userName = User::getUsername( $user->user_id, $userIp );

				$users[] = $userName;
			}

			return $users;
		} );
	}

	/**
	 * @inheritdoc
	 */
	protected function getAllowedParams() {
		return [
			'target' => [
				ApiBase::PARAM_REQUIRED => true,
			],
			'offset' => null,
		];
	}

	/**
	 * @inheritdoc
	 */
	protected function getParamDescription() {
		return [
			'target' => 'IP address to look up',
			'offset' => 'Optional timestamp for query continue',
		];
	}

	/**
	 * @inheritdoc
	 */
	protected function getDescription() {
		return 'Provides API module to look up activity from a given IP address across all of FANDOM';
	}

	/**
	 * @inheritdoc
	 */
	public function getExamples() {
		return [
			'api.php?action=query&list=multilookup&mltarget=8.8.8.8',
			'api.php?action=query&list=multilookup&mltarget=8.8.8.8&ml',
		];
	}

	/**
	 * @inheritdoc
	 */
	public function getVersion() {
		return __CLASS__ . '-V1';
	}
}
