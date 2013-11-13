<?php

/*
 * WAM Service
 * Service for handling WAM related queries
 */
class WAMService extends Service {

	const WAM_DEFAULT_ITEM_LIMIT_PER_PAGE = 20;
	const WAM_BLACKLIST_EXT_VAR_NAME = 'wgEnableContentWarningExt';

	protected static $verticalNames = [
		WikiFactoryHub::CATEGORY_ID_GAMING => 'Gaming',
		WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT => 'Entertainment',
		WikiFactoryHub::CATEGORY_ID_LIFESTYLE => 'Lifestyle'
	];
	protected static $verticalIds = [
		'Gaming' => WikiFactoryHub::CATEGORY_ID_GAMING,
		'Entertainment' => WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT,
		'Lifestyle' => WikiFactoryHub::CATEGORY_ID_LIFESTYLE
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
	public static function getCurrentWamScoreForWiki ($wikiId) {
		$app = F::app();
		wfProfileIn(__METHOD__);

		$memKey = wfSharedMemcKey('datamart', 'wam', $wikiId);

		$getData = function () use ($app, $wikiId) {
			$db = wfGetDB(DB_SLAVE, array(), $app->wg->DWStatsDB);

			$result = $db->select(
				array('statsdb_mart.fact_wam_scores'),
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

		$wamScore = WikiaDataAccess::cacheWithLock($memKey, 86400 /* 24 hours */, $getData);
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
	public function getWamIndex ($inputOptions) {
		$inputOptions += $this->defaultIndexOptions;

		$inputOptions['currentTimestamp'] = $inputOptions['currentTimestamp'] ? strtotime('00:00 -1 day', $inputOptions['currentTimestamp']) : strtotime('00:00 -1 day');
		$inputOptions['previousTimestamp'] = $inputOptions['previousTimestamp']
			? strtotime('00:00 -1 day', $inputOptions['previousTimestamp'])
			: $inputOptions['currentTimestamp'] - 60 * 60 * 24;

		$app = F::app();
		wfProfileIn(__METHOD__);

		$wamIndex = array(
			'wam_index' => array(),
			'wam_results_total' => 0
		);
		if (!empty($app->wg->StatsDBEnabled)) {
			$db = wfGetDB(DB_SLAVE, array(), $app->wg->DWStatsDB);

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

			/* @var $db DatabaseMysql */
			while ($row = $db->fetchObject($result)) {
				$row = (array)$row;
				$row['hub_id'] = $this->getVerticalId($row['hub_name']);
				$wamIndex['wam_index'][$row['wiki_id']] = $row;
			}
			$count = $resultCount->fetchObject();
			$wamIndex['wam_results_total'] = $count->wam_results_total;
			$wamIndex['wam_index_date'] = $inputOptions['currentTimestamp'];
		}

		wfProfileOut(__METHOD__);

		return $wamIndex;
	}

	public function getWamIndexDates() {
		$dates = array(
			'max_date' => null,
			'min_date' => null
		);

		$app = F::app();
		wfProfileIn(__METHOD__);

		if (!empty($app->wg->StatsDBEnabled)) {
			$db = wfGetDB(DB_SLAVE, array(), $app->wg->DWStatsDB);

			$fields = array(
				'MAX(time_id) AS max_date',
				'MIN(time_id) AS min_date'
			);

			$result = $db->select(
				'statsdb_mart.fact_wam_scores',
				$fields
			);

			$row = $db->fetchRow($result);

			$dates['max_date'] = strtotime('+1 day', strtotime($row['max_date']));
			$dates['min_date'] = strtotime('+1 day', strtotime($row['min_date']));
		}

		wfProfileOut(__METHOD__);

		return $dates;
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

		if ($options['verticalId']) {
			$vericals = $options['verticalId'];
		} else {
			$vericals = array(
				WikiFactoryHub::CATEGORY_ID_GAMING,
				WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT,
				WikiFactoryHub::CATEGORY_ID_LIFESTYLE
			);
		}
		$conds['fw1.hub_name'] = $this->translateVerticalsNames($vericals);

		if (!is_null($options['wikiLang'])) {
			$conds ['dw.lang'] = $db->strencode($options['wikiLang']);
		}

		if (!empty($options['excludeBlacklist'])) {
			$blacklistIds = $this->getIdsBlacklistedWikis();
			if (!empty($blacklistIds)) {
				$conds[] = 'fw1.wiki_id NOT IN (' . $db->makeList( $blacklistIds ) . ')';
			}
		}

		return $conds;
	}

	protected function getWamIndexFields () {
		$fields = array(
			'fw1.wiki_id',
			'fw1.wam',
			'fw1.wam_rank',
			'fw1.hub_wam_rank',
			'fw1.peak_wam_rank',
			'fw1.peak_hub_wam_rank',
			'fw1.top_1k_days',
			'fw1.top_1k_weeks',
			'fw1.first_peak',
			'fw1.last_peak',
			'fw1.hub_name',
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
			'fw1' => 'statsdb_mart.fact_wam_scores',
			'fw2' => 'statsdb_mart.fact_wam_scores',
			'dw' => 'statsdb_mart.dimension_wikis'
		);
		return $tables;
	}

	protected function getIdsBlacklistedWikis() {
		$blacklistIds = array();
		$blacklistExt = WikiFactory::getVarByName(self::WAM_BLACKLIST_EXT_VAR_NAME, null);

		if( $blacklistExt->cv_id ) {
			$blacklistIds = WikiaDataAccess::cache(
				wfSharedMemcKey(
					'wam_blacklist',
					$blacklistExt->cv_id
				),
				24 * 60 * 60,
				function () use ( $blacklistExt ) {
					$blacklistWikis = WikiFactory::getListOfWikisWithVar( $blacklistExt->cv_id, 'bool', '=', true, true );
					return array_keys( $blacklistWikis );
				}
			);
		}

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

	protected function getVerticalName($verticalId) {
		if (isset(self::$verticalNames[$verticalId])) {
			return self::$verticalNames[$verticalId];
		}
	}

	protected function getVerticalId($verticalName) {
		if (isset(self::$verticalIds[$verticalName])) {
			return self::$verticalIds[$verticalName];
		}
	}
}
