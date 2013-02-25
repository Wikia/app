<?php

/*
 * WAM Service
 * Service for handling WAM related queries
 */
class WAMService extends Service {

	const WAM_DEFAULT_ITEM_LIMIT_PER_PAGE = 20;

	/**
	 * Returns the latest WAM score provided a wiki ID
	 * @param int $wikiId
	 * @return number
	 */
	public static function getCurrentWamScoreForWiki ($wikiId) {
		$app = F::app();
		$app->wf->ProfileIn(__METHOD__);

		$memKey = $app->wf->SharedMemcKey('datamart', 'wam', $wikiId);

		$getData = function () use ($app, $wikiId) {
			$db = $app->wf->GetDB(DB_SLAVE, array(), $app->wg->DatamartDB);

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

		$wamScore = WikiaDataAccess::cacheWithLock($memKey, 86400 /* 24 hours */, $getData);
		$app->wf->ProfileOut(__METHOD__);
		return $wamScore;
	}

	/**
	 * @param null $currentTimestamp
	 * @param null $previousTimestamp
	 * @param null $verticalId
	 * @param null $wikiId
	 * @param string $wikiWord
	 * @param string $sortColumn
	 * @param string $sortDirection
	 * @param int $offset
	 * @param int $limit
	 * @return array
	 */
	public function getWamIndex ($currentTimestamp = null, $previousTimestamp = null, $verticalId = null, $wikiLang = null, $wikiId = null, $wikiWord = null, $sortColumn = 'wam_rank', $sortDirection = 'ASC', $offset = 0, $limit = self::WAM_DEFAULT_ITEM_LIMIT_PER_PAGE) {
		$app = F::app();
		$app->wf->profileIn(__METHOD__);

		$wamIndex = array(
			'wam_index' => array(),
			'wam_results_total' => 0
		);
		if (!empty($app->wg->StatsDBEnabled)) {
			$db = $app->wf->GetDB(DB_SLAVE, array(), $app->wg->DatamartDB);

			$tables = $this->getWamIndexTables();
			$fields = $this->getWamIndexFields();
			$countFields = $this->getWamIndexCountFields();
			$conds = $this->getWamIndexConditions($currentTimestamp, $previousTimestamp, $wikiId, $verticalId, $wikiLang, $wikiWord);
			$options = $this->getWamIndexOptions($sortDirection, $sortColumn, $offset, $limit);
			$join_conds = $this->getWamIndexJoinConditions();

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
				$wamIndex['wam_index'][$row['wiki_id']] = $row;
			}
			$count = $resultCount->fetchObject();
			$wamIndex['wam_results_total'] = $count->wam_results_total;
		}

		$app->wf->profileOut(__METHOD__);

		return $wamIndex;
	}

	protected function getWamIndexJoinConditions () {
		$join_conds = array(
			'fw2' => array(
				'left join',
				array(
					'fw1.wiki_id = fw2.wiki_id',
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

	protected function getWamIndexOptions ($sortDirection, $sortColumn, $offset, $limit) {
		$options = array();

		$sortDirection = (($sortDirection == 'DESC') ? 'DESC' : 'ASC');

		switch ($sortColumn) {
			case 'wam_rank':
			default:
				$options['ORDER BY'] = 'wam ' . $sortDirection;
				break;
			case 'wam_change':
				$options['ORDER BY'] = 'wam_change ' . $sortDirection;
				break;
		}

		if (!is_null($offset)) {
			$options['OFFSET'] = $offset;
		}

		if (!is_null($offset)) {
			$options['LIMIT'] = $limit;
			return $options;
		}
		return $options;
	}

	protected function getWamIndexConditions ($currentTimestamp, $previousTimestamp, $wikiId, $verticalId, $wikiLang, $wikiWord) {
		$conds = array(
			'fw1.time_id = FROM_UNIXTIME(' . ($currentTimestamp ? $currentTimestamp : strtotime('00:00 -2 day')) . ')',
			'fw2.time_id = FROM_UNIXTIME(' . ($previousTimestamp ? $previousTimestamp : strtotime('00:00 -3 day')) . ')'
		);

		if (!is_null($wikiId)) {
			$conds ['fw1.wiki_id'] = $wikiId;
		}

		if (!is_null($wikiWord)) {
			$conds [] = "dw.url like '%" . mysql_real_escape_string($wikiWord) . "%' ";
						"OR dw.title like '%" . mysql_real_escape_string($wikiWord) . "%'";
		}

		if (!is_null($verticalId)) {
			$conds ['dw.hub_id'] = $verticalId;
		} else {
			$conds ['dw.hub_id'] = array(2, 3, 9);
		}

		if (!is_null($wikiLang)) {
			$conds ['dw.lang'] = mysql_real_escape_string($wikiLang);
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
			'dw.title',
			'dw.url',
			'dw.hub_id',
			'fw1.wam - fw2.wam as wam_change'
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
}
