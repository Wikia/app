<?php

class AdminUploadReviewHelper extends ImageReviewHelperBase {

	const LIMIT_IMAGES = 20;
	const LIMIT_IMAGES_FROM_DB = 20;

	static $sortOptions = array(
		'latest first' => 0,
		'by priority and recency' => 1,
		'oldest first' => 2,
	);

	const MEMC_VERSION = '00001';

	public function updateImageState($images, $action = '') {
		$this->wf->ProfileIn(__METHOD__);

		$approvalList = array();
		$rejectionList = array();
		$deletionList = array();
		$statsInsert = array();

		$sqlWhere = array(
			self::STATE_APPROVED => array(),
			self::STATE_REJECTED => array(),
			self::STATE_QUESTIONABLE => array(),
		);

		foreach ($images as $image) {
			if ($image['state'] == self::STATE_APPROVED) {
				$sqlWhere[self::STATE_APPROVED][] = "( city_id = $image[wikiId] AND page_id = $image[pageId]) ";
				$approvalList [] = $image;
			} elseif ($image['state'] == self::STATE_REJECTED) {
				$sqlWhere[self::STATE_REJECTED][] = "( city_id = $image[wikiId] AND page_id = $image[pageId]) ";
				$rejectionList [] = $image;
			} elseif ($image['state'] == self::STATE_DELETED) {
				$sqlWhere[self::STATE_DELETED][] = "( city_id = $image[wikiId] AND page_id = $image[pageId]) ";
				$deletionList [] = $image;
			} elseif ($image['state'] == self::STATE_QUESTIONABLE) {
				$sqlWhere[self::STATE_QUESTIONABLE][] = "( city_id = $image[wikiId] AND page_id = $image[pageId]) ";
			}
		}

		$statsInsert[] = array(
			'city_id' => $image['wikiId'],
			'page_id' => $image['pageId'],
			'review_state' => $image['state'],
			'reviewer_id' => $this->wg->user->getId()
		);

		foreach ($sqlWhere as $state => $where) {
			if (!empty($where)) {
				$db = $this->wf->GetDB(DB_MASTER, array(), $this->wg->SharedDB);

				$db->update(
					'city_visualization_images',
					array(
						'reviewer_id' => $this->wg->user->getId(),
						'image_review_status' => $state,
						'review_end = now()',
					),
					array(implode(' OR ', $where)),
					__METHOD__
				);

				$db->commit();
			}
		}
		$this->saveStats($statsInsert, $sqlWhere, $action);
		$this->wf->ProfileOut(__METHOD__);
	}


	protected function saveStats($statsInsert, $sqlWhere, $action) {
		$db = $this->wf->GetDB(DB_MASTER, array(), $this->wg->SharedDB);

		$db->insert(
			'city_visualization_image_review_stats',
			$statsInsert,
			__METHOD__
		);

		// update stats directly in memcache so they look nice without impacting the database
		$key = wfMemcKey(__CLASS__, __CLASS__ . '::getImageCount', $this->wg->user->getId());
		$stats = $this->wg->memc->get($key, null);
		if ($stats) {
			switch ($action) {
				case '':
					//	$stats['reviewer'] += count($images);
					//	$stats['unreviewed'] -= count($images);
					$stats['questionable'] += count($sqlWhere[self::STATE_QUESTIONABLE]);
					break;
				case ImageReviewSpecialController::ACTION_QUESTIONABLE:
					$changedState = count($sqlWhere[self::STATE_APPROVED]) + count($sqlWhere[self::STATE_REJECTED]);
					//	$stats['reviewer'] += $changedState;
					$stats['questionable'] -= $changedState;
					break;
				case ImageReviewSpecialController::ACTION_REJECTED:
					$changedState = count($sqlWhere[self::STATE_APPROVED]) + count($sqlWhere[self::STATE_DELETED]);
					$stats['rejected'] -= $changedState;
					break;
			}
			$this->wg->memc->set($key, $stats, 3600 /* 1h */);
			// Quick hack/fix for stats going negative -- FIXME
			if ($stats['unreviewed'] < 0) {
				$this->wg->memc->delete($key);
			}
		}
	}


	/**
	 * reset state in abandoned work
	 */
	public function resetAbandonedWork() {
		$this->wf->ProfileIn(__METHOD__);
		$db = $this->wf->GetDB(DB_MASTER, array(), $this->wg->SharedDB);

		$timeLimit = ($this->wg->DevelEnvironment) ? 1 : 3600; // 1 sec

		$db->update(
			'city_visualization_images',
			array(
				'reviewer_id = null',
				'image_review_status' => self::STATE_UNREVIEWED,
			),
			array(
				"review_start < now() - " . $timeLimit,
				"review_end = '0000-00-00 00:00:00'",
				'reviewer_id' => $this->wg->User->getId(),
				'image_review_status' => self::STATE_IN_REVIEW,
			),
			__METHOD__
		);

		$db->update(
			'city_visualization_images',
			array('image_review_status' => self::STATE_QUESTIONABLE),
			array(
				"review_start < now() - " . $timeLimit,
				"review_end = '0000-00-00 00:00:00'",
				'reviewer_id' => $this->wg->User->getId(),
				'image_review_status' => self::STATE_QUESTIONABLE_IN_REVIEW,
			),
			__METHOD__
		);

		$db->commit();

		$this->wf->ProfileOut(__METHOD__);
	}

	/**
	 * get image list from reviewer id based on the timestamp
	 * Note: NOT update image state
	 * @param integer review_end
	 * @return array images
	 */
	public function refetchImageListByTimestamp($timestamp) {
		$this->wf->ProfileIn(__METHOD__);

		$imageList = array();

		$this->wf->ProfileOut(__METHOD__);

		return $imageList;
	}

	/**
	 * get image list
	 * @return array imageList
	 */
	public function getImageList($timestamp, $state = self::STATE_UNREVIEWED, $order = self::ORDER_LATEST) {
		$this->wf->ProfileIn(__METHOD__);

		$db = $this->wf->GetDB(DB_MASTER, array(), $this->wg->SharedDB);

		// for testing
		$this->resetAbandonedWork();

		// get images
		$imageList = array();
		$reviewList = array();

		$where = array();
		$list = $this->getWhitelistedWikis();
		if (!empty($list)) {
			$where[] = 'wiki_id not in(' . implode(',', $list) . ')';
		}

		$whereState = ' image_review_status = ' . $state;

		$values = array(
			' reviewer_id = ' . $this->wg->user->getId(),
			" review_start = from_unixtime($timestamp)",
		);

		if ($state == self::STATE_QUESTIONABLE) {
			$newState = self::STATE_QUESTIONABLE_IN_REVIEW;
			$values[] = " review_end = '0000-00-00 00:00:00'";
		} else {
			$newState = self::STATE_IN_REVIEW;
		}

		$values[] = ' image_review_status = ' . $newState;


		$query = 'SELECT * from city_visualization_images '
			. ' WHERE ' . $whereState
			. ' ORDER BY  ' . $this->getOrder($order)
			. ' LIMIT ' . self::LIMIT_IMAGES_FROM_DB;


		$result = $db->query($query);

		$rows = array();
		$updateWhere = array();
		$iconsWhere = array();
		while ($row = $db->fetchObject($result)) {
			$rows[] = $row;
			$updateWhere[] = "(city_id = {$row->city_id} and page_id = {$row->page_id})";
		}

		$db->freeResult($result);

		if (count($updateWhere) > 0) {
			$db->update(
				'city_visualization_images',
				$values,
				array(implode(' OR ', $updateWhere)),
				__METHOD__
			);
		}

		$db->commit();

		$invalidImages = array();
		$unusedImages = array();
		foreach ($rows as $row) {
			if (count($imageList) < self::LIMIT_IMAGES) {
				$img = $this->getImageSrc($row->city_id, $row->page_id);

				if (empty($img['src'])) {
					$invalidImages[] = "(city_id = {$row->city_id} and page_id = {$row->page_id})";
				} else {
					$imageList[] = array(
						'wikiId' => $row->city_id,
						'pageId' => $row->page_id,
						'state' => $row->image_review_status,
						'src' => $img['src'],
						'url' => $img['page'],
						'priority' => 0,
						'flags' => 0,
					);
				}
			} else {
				$unusedImages[] = "(city_id = {$row->city_id} and page_id = {$row->page_id})";
			}
		}

		$commit = false;
		if (count($invalidImages) > 0) {
			$db->update(
				'city_visualization_images',
				array('image_review_status' => self::STATE_INVALID_IMAGE),
				array(implode(' OR ', $invalidImages)),
				__METHOD__
			);
			$commit = true;
		}

		if (count($unusedImages) > 0) {
			$db->update(
				'city_visualization_images',
				array('reviewer_id = null', 'image_review_status' => $state),
				array(implode(' OR ', $unusedImages)),
				__METHOD__
			);
			$commit = true;
			error_log("AdminUploadReview : returning " . count($unusedImages) . " back to the queue");
		}

		if ($commit) {
			$db->commit();
		}

		error_log("AdminUploadReview : fetched new " . count($imageList) . " images");

		$this->wf->ProfileOut(__METHOD__);

		return $imageList;
	}

	protected function getWhitelistedWikis() {
		$this->wf->ProfileIn(__METHOD__);

		$topWikis = $this->getTopWikis();

		$whitelistedWikis = $this->getWhitelistedWikisFromWF();

		$out = array_keys($whitelistedWikis + $topWikis);

		$this->wf->ProfileOut(__METHOD__);

		return $out;
	}

	protected function getWhitelistedWikisFromWF() {
		$this->wf->ProfileIn(__METHOD__);
		$key = wfMemcKey(__CLASS__, __METHOD__);

		$data = $this->wg->memc->get($key, null);

		if (!empty($data)) {
			$this->wf->ProfileOut(__METHOD__);
			return $data;
		}

		$oVariable = WikiFactory::getVarByName('wgImageReviewWhitelisted', 177);
		$fromWf = WikiFactory::getListOfWikisWithVar($oVariable->cv_variable_id, 'bool', '=', true);

		$this->wg->memc->set($key, $fromWf, 60 * 10);
		$this->wf->ProfileOut(__METHOD__);
		return $fromWf;
	}

	protected function getTopWikis() {
		$this->wf->ProfileIn(__METHOD__);
		$key = wfMemcKey(__CLASS__, self::MEMC_VERSION, __METHOD__);
		$data = $this->wg->memc->get($key, null);
		if (!empty($data)) {
			$this->wf->ProfileOut(__METHOD__);
			return $data;
		}

		$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->StatsDB);
		$ids = array();
		$cnt = 0;
		if (!$this->wg->DevelEnvironment) {
			$result = $db->select(
				array('google_analytics.pageviews'),
				array('city_id', 'sum(pageviews) as cnt'),
				array('date > curdate() - interval 31 day'),
				__METHOD__,
				array(
					'GROUP BY' => 'city_id',
					'ORDER BY' => 'cnt desc',
					'HAVING' => 'cnt > 10000'
				)
			);

			while ($cnt < 200 && $row = $db->fetchRow($result)) {
				$cnt++;
				$ids[$row['city_id']] = 1;
			}
		}

		$this->wg->memc->set($key, $ids, 86400 /* 24h */);
		$this->wf->ProfileOut(__METHOD__);
		return $ids;
	}

	public function getImageCount() {
		$this->wf->ProfileIn(__METHOD__);

		$key = wfMemcKey(__CLASS__, self::MEMC_VERSION, __METHOD__);
		$total = $this->wg->memc->get($key, null);
		if (!empty($total)) {
			$this->wf->ProfileOut(__METHOD__);
			return $total;
		}
		$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->SharedDB);

		$where = array();

		$where['image_review_status'] = self::STATE_QUESTIONABLE;

		// select by reviewer, state and total count with rollup and then pick the data we want out
		$result = $db->select(
			array('city_visualization_images'),
			array('count(*) as total'),
			$where,
			__METHOD__,
			array()
		);

		$total = array('reviewer' => 0, 'unreviewed' => 0, 'questionable' => 0);
		while ($row = $db->fetchObject($result)) {
			$total['questionable'] = $row->total;
		}
		$total['questionable'] = $this->wg->Lang->formatNum($total['questionable']);
		$this->wg->memc->set($key, $total, 3600 /* 1h */);

		$this->wf->ProfileOut(__METHOD__);
		return $total;

	}

	public function getStatsData($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay) {

		$startDate = $startYear . '-' . $startMonth . '-' . $startDay . ' 00:00:00';
		$endDate = $endYear . '-' . $endMonth . '-' . $endDay . ' 23:59:59';

		$summary = array(
			'all' => 0,
			self::STATE_APPROVED => 0,
			self::STATE_REJECTED => 0,
			self::STATE_QUESTIONABLE => 0,
			'avg' => 0,
		);
		$data = array();
		$userCount = 0;

		$dbr = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->SharedDB);

		$res = $dbr->query("
				select review_state, reviewer_id, count( page_id ) as count
				from city_visualization_image_review_stats
				WHERE review_end BETWEEN '{$startDate}' AND '{$endDate}'
				group by review_state, reviewer_id with rollup");

		while ($row = $dbr->fetchRow($res)) {
			if (is_null($row['review_state'])) {
				// total
				$summary['all'] = $row['count'];
			} elseif (is_null($row['reviewer_id'])) {
				$summary[$row['review_state']] = $row['count'];
			} else {
				if (empty($data[$row['reviewer_id']])) {
					$user = User::newFromId($row['reviewer_id']);

					$data[$row['reviewer_id']] = array(
						'name' => $user->getName(),
						'total' => 0,
						ImageReviewHelper::STATE_APPROVED => 0,
						ImageReviewHelper::STATE_REJECTED => 0,
						ImageReviewHelper::STATE_QUESTIONABLE => 0,
					);
				}
				$data[$row['reviewer_id']][$row['review_state']] = $row['count'];
				$data[$row['reviewer_id']]['total'] += $row['count'];
				$userCount++;
			}
		}

		$summary['avg'] = $userCount > 0 ? $summary['all'] / $userCount : 0;

		foreach ($data as $reviewer => &$stats) {
			$stats['toavg'] = $stats['total'] - $summary['avg'];
		}

		return array(
			'summary' => $summary,
			'data' => $data,
		);
	}

	public function getUserTsKey() {
		return $this->wf->MemcKey('AdminUploadReviewHelper', 'userts', $this->wg->user->getId());
	}

	public function createDestFileName($wikiId, $origFileTitle) {
		$this->wf->ProfileIn( __METHOD__ );

		$wikiDBname = WikiFactory::IDtoDB($wikiId);
		$destFileName = '';
		if( $wikiDBname && $origFileTitle instanceof Title ) {
			$origFileName = $origFileTitle->getText();
			$origFileNameArr = explode('.', $origFileName);
			$origFileExt = array_pop($origFileNameArr);

			array_splice($origFileNameArr, 1, 0, array(',', $wikiDBname));

			$destFileName = implode('', $origFileNameArr).'.'.$origFileExt;
		}

		$this->wf->ProfileOut( __METHOD__ );
		return $destFileName;
	}

	public function getImageUrl($wikiId, $pageId, $imgSize) {
		$data = parent::getImageSrc($wikiId, $pageId, $imgSize);
		$url = (!empty($data['src'])) ? $data['src'] : null;

		return $url;
	}

}
