<?php

/*
 * WAM Service
 * Service for handling WAM related queries
 */
class WAMService extends Service {

	const WAM_DEFAULT_ITEM_LIMIT_PER_PAGE = 20;
	const WAM_BLACKLIST_EXT_VAR_NAME = 'wgEnableContentWarningExt';
	const WAM_EXCLUDE_FLAG_NAME = 'wgExcludeFromWAM';
	const CACHE_DURATION = 86400; /* 24 hours */
	const MEMCACHE_VER = '2';
	const WAM_LINK = 'http://www.wikia.com/WAM';

	protected $verticalIds = [
		WikiFactoryHub::VERTICAL_ID_OTHER,
		WikiFactoryHub::VERTICAL_ID_TV,
		WikiFactoryHub::VERTICAL_ID_VIDEO_GAMES,
		WikiFactoryHub::VERTICAL_ID_BOOKS,
		WikiFactoryHub::VERTICAL_ID_COMICS,
		WikiFactoryHub::VERTICAL_ID_LIFESTYLE,
		WikiFactoryHub::VERTICAL_ID_MUSIC,
		WikiFactoryHub::VERTICAL_ID_MOVIES,
	];

	protected static $verticalNames = [
		WikiFactoryHub::VERTICAL_ID_OTHER => 'Other',
		WikiFactoryHub::VERTICAL_ID_TV => 'TV',
		WikiFactoryHub::VERTICAL_ID_VIDEO_GAMES => 'Games',
		WikiFactoryHub::VERTICAL_ID_BOOKS => 'Books',
		WikiFactoryHub::VERTICAL_ID_COMICS => 'Comics',
		WikiFactoryHub::VERTICAL_ID_LIFESTYLE => 'Lifestyle',
		WikiFactoryHub::VERTICAL_ID_MUSIC => 'Music',
		WikiFactoryHub::VERTICAL_ID_MOVIES => 'Movies',
	];

	protected $defaultIndexOptions = array(
		'currentTimestamp' => null,
		'previousTimestamp' => null,
		'verticalId' => null,
		'wikiLang' => null,
		'wikiId' => null,
		'wikiWord' => null,
		'sortColumn' => 'wam_rank',
		'sortDirection' => 'ASC',
		'offset' => 0,
		'limit' => self::WAM_DEFAULT_ITEM_LIMIT_PER_PAGE
	);

	/**
	 * Returns the latest WAM score provided a wiki ID
	 * @param int $wikiId
	 * @return number
	 */
	public function getCurrentWamScoreForWiki ($wikiId) {
		wfProfileIn(__METHOD__);

		$memKey = wfSharedMemcKey('datamart', self::MEMCACHE_VER, 'wam', $wikiId);

		$getData = function () use ($wikiId) {
			if ( $this->isDisabled() ) {
				return 0;
			}

			$db = $this->getDB();

			$result = $db->select(
				array('fact_wam_scores'),
				array(
					'wam'
				),
				array(
					'wiki_id' => $wikiId
				),
				__METHOD__,
				array(
					'ORDER BY' => 'time_id DESC',
					'LIMIT' => 1
				)
			);

			return ($row = $db->fetchObject($result)) ? $row->wam : 0;
		};

		$wamScore = WikiaDataAccess::cacheWithLock($memKey, self::CACHE_DURATION, $getData);
		wfProfileOut(__METHOD__);
		return $wamScore;
	}

	/**
	 * @param array $inputOptions - available options:
	 * 	int $currentTimestamp
	 * 	int $previousTimestamp
	 * 	int $verticalId
	 * 	int $wikiId
	 * 	string $wikiWord
	 * 	string $sortColumn
	 * 	string $sortDirection
	 * 	int $offset
	 * 	int $limit
	 *
	 * @return array
	 */
	public function getWamIndex($inputOptions) {
		$inputOptions += $this->defaultIndexOptions;

		$inputOptions['currentTimestamp'] = $inputOptions['currentTimestamp'] ? strtotime('00:00 -1 day', $inputOptions['currentTimestamp']) : strtotime('00:00 -1 day');
		$inputOptions['previousTimestamp'] = $inputOptions['previousTimestamp']
			? strtotime('00:00 -1 day', $inputOptions['previousTimestamp'])
			: $inputOptions['currentTimestamp'] - 60 * 60 * 24;

		wfProfileIn(__METHOD__);

		$wamIndex = array(
			'wam_index' => array(),
			'wam_results_total' => 0
		);

		if ( $this->isDisabled() ) {
			wfProfileOut( __METHOD__ );
			return $wamIndex;
		}

		$db = $this->getDB();

		$tables = $this->getWamIndexTables();
		$fields = $this->getWamIndexFields();
		$countFields = $this->getWamIndexCountFields();
		$conds = $this->getWamIndexConditions($inputOptions, $db);
		$options = $this->getWamIndexOptions($inputOptions);
		$join_conds = $this->getWamIndexJoinConditions($inputOptions);

		$result = $db->select(
			$tables,
			$fields,
			$conds,
			__METHOD__,
			$options,
			$join_conds
		);

		$resultCount = $db->select(
			$tables,
			$countFields,
			$conds,
			__METHOD__,
			array(),
			$join_conds
		);

		while ( $row = $db->fetchObject( $result ) ) {
			$row = ( array )$row;
			$row['vertical_name'] = $this->getVerticalName( $row['vertical_id'] );
			$wamIndex['wam_index'][$row['wiki_id']] = $row;
		}
		$count = $resultCount->fetchObject();
		$wamIndex['wam_results_total'] = $count->wam_results_total;
		$wamIndex['wam_index_date'] = $inputOptions['currentTimestamp'];

		wfProfileOut(__METHOD__);

		return $wamIndex;
	}

	public function getWamIndexDates() {
		$dates = array(
			'max_date' => null,
			'min_date' => null
		);

		if ( $this->isDisabled() ) {
			return $dates;
		}

		wfProfileIn(__METHOD__);

		$getData = function() {
			$db = $this->getDB();

			$fields = array(
				'MAX(time_id) AS max_date',
				'MIN(time_id) AS min_date'
			);

			$result = $db->select(
				'fact_wam_scores',
				$fields,
				'',
				__METHOD__
			);

			$row = $db->fetchRow($result);

			$dates = array();
			$dates['max_date'] = strtotime('+1 day', strtotime($row['max_date']));
			$dates['min_date'] = strtotime('+1 day', strtotime($row['min_date']));

			return $dates;
		};

		$memKey = wfSharedMemcKey( 'wam-index-dates', self::MEMCACHE_VER );
		$dates = WikiaDataAccess::cache( $memKey, self::CACHE_DURATION, $getData );
		wfProfileOut( __METHOD__ );

		return $dates;
	}

	public function getWAMLanguages( $date ) {
		wfProfileIn( __METHOD__ );

		$date = empty( $date ) ? strtotime( '00:00 -2 day' ) : strtotime( '00:00 -2 day', $date );
		$memKey = wfSharedMemcKey( 'wam-languages', self::MEMCACHE_VER, $date );

		$getData = function () use ( $date ) {
			if ( $this->isDisabled() ) {
				return [];
			}

			$db = $this->getDB();
			$result = $db->select(
				[
					'fw1' => 'fact_wam_scores',
					'dw' => 'dimension_wikis'
				],
				'DISTINCT dw.lang',
				'fw1.time_id = FROM_UNIXTIME(' . $date . ')',
				__METHOD__,
				[ 'ORDER BY' => 'dw.lang ASC' ],
				[ 'fw1' => [ 'INNER JOIN', 'dw.wiki_id = fw1.wiki_id' ] ]
			);

			$languages = [];
			while ( $row = $db->fetchObject( $result ) ) {
				$languages[] = $row->lang;
			}

			return $languages;
		};

		$wamLanguages = WikiaDataAccess::cache( $memKey, self::CACHE_DURATION, $getData );
		wfProfileOut( __METHOD__ );
		return $wamLanguages;
	}

	protected function getWamIndexJoinConditions ($options) {
		$join_conds = array(
			'fw2' => array(
				'left join',
				array(
					'fw1.wiki_id = fw2.wiki_id',
					'fw2.time_id = FROM_UNIXTIME(' . $options['previousTimestamp'] . ')'
				)
			),
			'dw' => array(
				'left join',
				array(
					'fw1.wiki_id = dw.wiki_id'
				)
			)
		);
		return $join_conds;
	}

	protected function getWamIndexOptions ($inputOptions) {
		$options = array();

		$sortDirection = (($inputOptions['sortDirection'] == 'DESC') ? 'DESC' : 'ASC');

		switch ($inputOptions['sortColumn']) {
			case 'wam_rank':
			default:
				$options['ORDER BY'] = 'wam ' . $sortDirection;
				break;
			case 'wam_change':
				$options['ORDER BY'] = 'wam_change ' . $sortDirection;
				break;
		}

		if (!is_null($inputOptions['offset'])) {
			$options['OFFSET'] = $inputOptions['offset'];
		}

		if (!is_null($inputOptions['limit'])) {
			$options['LIMIT'] = $inputOptions['limit'];
		}
		return $options;
	}

	/**
	 * @param Array $options
	 * @param DatabaseBase $db
	 * @return array
	 */
	protected function getWamIndexConditions ($options, $db) {
		$conds = array(
			'fw1.time_id = FROM_UNIXTIME(' . $options['currentTimestamp'] . ')'
		);

		if ($options['wikiId']) {
			$conds ['fw1.wiki_id'] = $options['wikiId'];
		}

		if (!is_null($options['wikiWord'])) {
			$conds [] = "dw.url like '%" . $db->strencode($options['wikiWord']) . "%' " .
						"OR dw.title like '%" . $db->strencode($options['wikiWord']) . "%'";
		}

		if ( $options['verticalId'] ) {
			$verticals = $options['verticalId'];
		} else {
			$verticals = $this->verticalIds;
		}
		$conds['fw1.vertical_id'] = $verticals;

		if (!is_null($options['wikiLang'])) {
			$conds ['dw.lang'] = $db->strencode($options['wikiLang']);
		}

		if (!empty($options['excludeBlacklist']) || !empty($options['excludeNonCommercial'])) {
			$bannedIds = !empty($options['excludeBlacklist']) ? $this->getIdsBlacklistedWikis() : [];
			$nonCommercialIds = !empty($options['excludeNonCommercial']) ? $this->getNonCommercialWikis() : [];
			$blacklistIds = array_merge( $bannedIds, $nonCommercialIds );
			if (!empty($blacklistIds)) {
				$conds[] = 'fw1.wiki_id NOT IN (' . $db->makeList( $blacklistIds ) . ')';
			}
		}

		$conds[] = '(dw.url IS NOT NULL AND dw.title IS NOT NULL)';

		return $conds;
	}

	protected function getWamIndexFields () {
		$fields = array(
			'fw1.wiki_id',
			'fw1.wam',
			'fw1.wam_rank',
			'fw1.hub_wam_rank',
			'fw1.vertical_wam_rank',
			'fw1.peak_wam_rank',
			'fw1.peak_hub_wam_rank',
			'fw1.peak_vertical_wam_rank',
			'fw1.top_1k_days',
			'fw1.top_1k_weeks',
			'fw1.first_peak',
			'fw1.last_peak',
			'fw1.hub_name',
			'fw1.vertical_id',
			'dw.title',
			'dw.url',
			'fw1.wam - IFNULL(fw2.wam, 0) as wam_change',
			'ISNULL(fw2.wam) as wam_is_new'
		);
		return $fields;
	}

	protected function getWamIndexCountFields () {
		$fields = array(
			'count(fw1.wiki_id) as wam_results_total'
		);
		return $fields;
	}

	protected function getWamIndexTables () {
		$tables = array(
			'fw1' => 'fact_wam_scores',
			'fw2' => 'fact_wam_scores',
			'dw' => 'dimension_wikis'
		);
		return $tables;
	}

	protected function getNonCommercialWikis() {
		$licensed = new LicensedWikisService();
		$licensedIds = array_keys( $licensed->getCommercialUseNotAllowedWikis() );
		return $licensedIds;
	}

	protected function getIdsBlacklistedWikis() {
		$blacklistIds = WikiaDataAccess::cache(
			wfSharedMemcKey(
				'wam_blacklist',
				self::MEMCACHE_VER
			),
			self::CACHE_DURATION,
			function () {
				$contentWarningWikis = $excludedWikis = [];

				// Exlude wikias with ContentWarning extension enabled
				$blacklistExtVarId = WikiFactory::getVarIdByName( self::WAM_BLACKLIST_EXT_VAR_NAME );
				if ( $blacklistExtVarId ) {
					$contentWarningWikis = array_keys(
						WikiFactory::getListOfWikisWithVar( $blacklistExtVarId, 'bool', '=', true )
					);
				}
				// Exclude wikias with an exclusion flag set to true
				$blacklistFlagVarId = WikiFactory::getVarIdByName( self::WAM_EXCLUDE_FLAG_NAME );
				if ( $blacklistFlagVarId ) {
					$excludedWikis = array_keys(
						WikiFactory::getListOfWikisWithVar( $blacklistFlagVarId, 'bool', '=', true )
					);
				}

				return array_merge( $contentWarningWikis, $excludedWikis );
			}
		);

		return $blacklistIds;
	}

	protected function translateVerticalsNames($verticals) {
		if (is_array($verticals)) {
			foreach($verticals as &$verticalId) {
				$verticalId = $this->getVerticalName($verticalId);
			}
		} else {
			$verticals = $this->getVerticalName($verticals);
		}
		return $verticals;
	}

	protected function getVerticalName( $verticalId ) {
		if ( isset( self::$verticalNames[ $verticalId ] ) ) {
			return self::$verticalNames[ $verticalId ];
		}
	}

	protected function getDB() {
		$app = F::app();
		wfGetLB( $app->wg->DWStatsDB )->allowLagged(true);
		$db = wfGetDB( DB_SLAVE, array(), $app->wg->DWStatsDB );
		$db->clearFlag( DBO_TRX );
		return $db;
	}

	/**
	 * wgStatsDBEnabled can be used to disable queries to statsdb_mart database
	 *
	 * @return bool
	 */
	protected function isDisabled() {
		return empty( F::app()->wg->StatsDBEnabled );
	}
}
