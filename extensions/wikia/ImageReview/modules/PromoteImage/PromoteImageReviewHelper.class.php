<?php

use \Wikia\Logger\WikiaLogger;

class PromoteImageReviewHelper extends ImageReviewHelperBase {

	const LIMIT_IMAGES = 20;
	const LIMIT_IMAGES_FROM_DB = 20;
	const INVALID_STATUS_TIMEOUT= 3600;

	static $sortOptions = array(
		'latest first' => 0,
		'by priority and recency' => 1,
		'oldest first' => 2,
	);

	const MEMC_VERSION = '00001';

	public function updateImageState($images, $action = '') {
		wfProfileIn(__METHOD__);

		$approvalList = array();
		$rejectionList = array();
		$deletionList = array();
		$statsInsert = array();
		$taskAdditionList = array();

		$sqlWhere = array(
			ImageReviewStatuses::STATE_APPROVED_AND_TRANSFERRING => array(),
			ImageReviewStatuses::STATE_REJECTED => array(),
			ImageReviewStatuses::STATE_QUESTIONABLE => array(),
		);

		foreach( $images as $image ) {
			if ($image['state'] == ImageReviewStatuses::STATE_APPROVED) {
				//for promote Image use temporary approval state as it will be used to supervise image copy
				$image['state'] = ImageReviewStatuses::STATE_APPROVED_AND_TRANSFERRING;

				$sqlWhere[ImageReviewStatuses::STATE_APPROVED_AND_TRANSFERRING][] = "( city_id = $image[wikiId] AND page_id = $image[pageId]) ";
				$approvalList [] = $image;

				$visualization = new CityVisualization();
				$targetWikiId = $visualization->getTargetWikiId($image['lang']);

				if( empty($taskAdditionList[$targetWikiId]) ) {
					$taskAdditionList[$targetWikiId] = array();
				}
				if (empty($taskAdditionList[$targetWikiId][$image['wikiId']])) {
					$taskAdditionList[$targetWikiId][$image['wikiId']] = array();
				}

				$taskAdditionList[$targetWikiId][$image['wikiId']] [] = array(
					'id' => $image['pageId'],
					'name' => $image['name'],
				);

			} elseif ($image['state'] == ImageReviewStatuses::STATE_REJECTED) {
				$sqlWhere[ImageReviewStatuses::STATE_REJECTED][] = "( city_id = $image[wikiId] AND page_id = $image[pageId]) ";
				$rejectionList [] = $image;
			} elseif ($image['state'] == ImageReviewStatuses::STATE_DELETED) {
				$sqlWhere[ImageReviewStatuses::STATE_DELETED][] = "( city_id = $image[wikiId] AND page_id = $image[pageId]) ";
				$deletionList [] = $image;
			} elseif ($image['state'] == ImageReviewStatuses::STATE_QUESTIONABLE) {
				$sqlWhere[ImageReviewStatuses::STATE_QUESTIONABLE][] = "( city_id = $image[wikiId] AND page_id = $image[pageId]) ";
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
				$db = wfGetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);

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

		$this->createUploadTask($taskAdditionList);
		$this->saveStats($statsInsert, $sqlWhere, $action);
		wfProfileOut(__METHOD__);
	}

	protected function createUploadTask($taskAdditionList) {
		wfRunHooks('CreatePromoImageReviewTask', ['upload', $taskAdditionList]);
	}

	protected function saveStats($statsInsert, $sqlWhere, $action) {
		$db = wfGetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);

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
					$stats['questionable'] += count($sqlWhere[ImageReviewStatuses::STATE_QUESTIONABLE]);
					break;
				case ImageReviewSpecialController::ACTION_QUESTIONABLE:
					$changedState = count($sqlWhere[ImageReviewStatuses::STATE_APPROVED]) + count($sqlWhere[ImageReviewStatuses::STATE_REJECTED]);
					//	$stats['reviewer'] += $changedState;
					$stats['questionable'] -= $changedState;
					break;
				case ImageReviewSpecialController::ACTION_REJECTED:
					$changedState = count($sqlWhere[ImageReviewStatuses::STATE_APPROVED]) + count($sqlWhere[ImageReviewStatuses::STATE_DELETED]);
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

	public function resetFailedTransfers(){
		$db = wfGetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);

		$db->update(
			'city_visualization_images',
			array(
				'reviewer_id = null',
				'image_review_status' => ImageReviewStatuses::STATE_UNREVIEWED,
			),
			array(
				"review_start < now() - " . self::INVALID_STATUS_TIMEOUT,
				'image_review_status' => ImageReviewStatuses::STATE_APPROVED_AND_TRANSFERRING,
			),
			__METHOD__
		);
	}

	public function resetAbandonedWork() {
		wfProfileIn(__METHOD__);
		$db = wfGetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);

		$db->update(
			'city_visualization_images',
			array(
				'reviewer_id = null',
				'image_review_status' => ImageReviewStatuses::STATE_UNREVIEWED,
			),
			array(
				"review_start < now() - " . self::INVALID_STATUS_TIMEOUT,
				'image_review_status' => ImageReviewStatuses::STATE_IN_REVIEW,
			),
			__METHOD__
		);

		$db->update(
			'city_visualization_images',
			array('image_review_status' => ImageReviewStatuses::STATE_QUESTIONABLE),
			array(
				"review_start < now() - " . self::INVALID_STATUS_TIMEOUT,
				'reviewer_id' => $this->wg->User->getId(),
				'image_review_status' => ImageReviewStatuses::STATE_QUESTIONABLE_IN_REVIEW,
			),
			__METHOD__
		);

		$db->commit();

		wfProfileOut(__METHOD__);
	}

	/**
	 * get image list from reviewer id based on the timestamp
	 * Note: NOT update image state
	 * @param integer $timestamp review_end
	 * @return array images
	 */
	public function refetchImageListByTimestamp($timestamp) {
		wfProfileIn(__METHOD__);

		$imageList = array();

		wfProfileOut(__METHOD__);

		return $imageList;
	}

	/**
	 * get image list
	 * @return array imageList
	 */
	public function getImageList($timestamp, $state = ImageReviewStatuses::STATE_UNREVIEWED, $order = self::ORDER_LATEST) {
		wfProfileIn(__METHOD__);

		$db = wfGetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);

		$this->resetFailedTransfers();
		$this->resetAbandonedWork();

		// get images
		$imageList = array();

		if ($state == ImageReviewStatuses::STATE_UNREVIEWED) {
			$currentlyReviewedByThisUser = ' ( image_review_status = ' . ImageReviewStatuses::STATE_IN_REVIEW
				. ' AND reviewer_id = ' . $this->wg->user->getId() . ' ) ';

			$newState = ImageReviewStatuses::STATE_IN_REVIEW;
		} elseif ($state == ImageReviewStatuses::STATE_QUESTIONABLE) {
			$currentlyReviewedByThisUser = ' ( image_review_status = ' . ImageReviewStatuses::STATE_QUESTIONABLE_IN_REVIEW
				. ' AND reviewer_id = ' . $this->wg->user->getId() . ' ) ';

			$newState = ImageReviewStatuses::STATE_QUESTIONABLE_IN_REVIEW;
			$values[] = " review_end = '0000-00-00 00:00:00'";
		} else {
			wfProfileOut(__METHOD__);
			return $imageList; // not supported state transition
		}

		$where = ' image_review_status = ' . $state . ' OR ' . $currentlyReviewedByThisUser;

		$values = array(
			' reviewer_id = ' . $this->wg->user->getId(),
			" review_start = from_unixtime($timestamp)",
			' image_review_status = ' . $newState
		);

		$query = 'SELECT * from city_visualization_images '
			. ' WHERE ' . $where
			. ' ORDER BY  ' . $this->getOrder($order)
			. ' LIMIT ' . self::LIMIT_IMAGES_FROM_DB;

		$result = $db->query($query);

		$rows = array();
		$updateWhere = array();
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
				$img = ImagesService::getImageSrc($row->city_id, $row->page_id);

				if (empty($img['src'])) {
					$invalidImages[] = "(city_id = {$row->city_id} and page_id = {$row->page_id})";
				} else {
					$imageList[] = array(
						'wikiId' => $row->city_id,
						'pageId' => $row->page_id,
						'name' => $row->image_name,
						'lang' => $row->city_lang_code,
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
				array('image_review_status' => ImageReviewStatuses::STATE_QUESTIONABLE),
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

			WikiaLogger::instance()->info( "PromoteImageReview : returning unused images back to the queue", [
				'method' => __METHOD__,
				'count' => count( $unusedImages ),
			] );
		}

		if ($commit) {
			$db->commit();
		}

		WikiaLogger::instance()->info( "PromoteImageReview : fetched new images", [
			'method' => __METHOD__,
			'count' => count( $imageList ),
		] );

		wfProfileOut(__METHOD__);

		return $imageList;
	}

	protected function getWhitelistedWikis() {
		wfProfileIn(__METHOD__);

		$topWikis = $this->getTopWikis();

		$whitelistedWikis = $this->getWhitelistedWikisFromWF();

		$out = array_keys($whitelistedWikis + $topWikis);

		wfProfileOut(__METHOD__);

		return $out;
	}

	protected function getWhitelistedWikisFromWF() {
		wfProfileIn(__METHOD__);
		$key = wfMemcKey(__CLASS__, __METHOD__);

		$data = $this->wg->memc->get($key, null);

		if (!empty($data)) {
			wfProfileOut(__METHOD__);
			return $data;
		}

		$oVariable = WikiFactory::getVarByName('wgImageReviewWhitelisted', 177);
		$fromWf = WikiFactory::getListOfWikisWithVar($oVariable->cv_variable_id, 'bool', '=', true);

		$this->wg->memc->set($key, $fromWf, 60 * 10);
		wfProfileOut(__METHOD__);
		return $fromWf;
	}

	protected function getTopWikis() {
		wfProfileIn(__METHOD__);
		$key = wfMemcKey(__CLASS__, self::MEMC_VERSION, __METHOD__);
		$data = $this->wg->memc->get($key, null);
		if (!empty($data)) {
			wfProfileOut(__METHOD__);
			return $data;
		}

		$ids = DataMartService::getTopWikisByPageviews( DataMartService::PERIOD_ID_MONTHLY, 200 );

		$this->wg->memc->set($key, $ids, 86400 /* 24h */);
		wfProfileOut(__METHOD__);
		return $ids;
	}

	public function getImageCount() {
		wfProfileIn(__METHOD__);

		$key = wfMemcKey(__CLASS__, self::MEMC_VERSION, __METHOD__);
		$total = $this->wg->memc->get($key, null);
		if (!empty($total)) {
			wfProfileOut(__METHOD__);
			return $total;
		}
		$db = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

		$where = array();

		$where['image_review_status'] = ImageReviewStatuses::STATE_QUESTIONABLE;

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

		wfProfileOut(__METHOD__);
		return $total;

	}

	public function getStatsData($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay) {

		$startDate = $startYear . '-' . $startMonth . '-' . $startDay . ' 00:00:00';
		$endDate = $endYear . '-' . $endMonth . '-' . $endDay . ' 23:59:59';

		$summary = array(
			'all' => 0,
			ImageReviewStatuses::STATE_APPROVED => 0,
			ImageReviewStatuses::STATE_REJECTED => 0,
			ImageReviewStatuses::STATE_QUESTIONABLE => 0,
			'avg' => 0,
		);
		$data = array();
		$userCount = 0;

		$dbr = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

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
						ImageReviewStatuses::STATE_APPROVED => 0,
						ImageReviewStatuses::STATE_REJECTED => 0,
						ImageReviewStatuses::STATE_QUESTIONABLE => 0,
					);
				}
				$data[$row['reviewer_id']][$row['review_state']] = $row['count'];
				$data[$row['reviewer_id']]['total'] += $row['count'];
				$userCount++;
			}
		}

		$summary['avg'] = $userCount > 0 ? $summary['all'] / $userCount : 0;

		foreach ($data as &$stats) {
			$stats['toavg'] = $stats['total'] - $summary['avg'];
		}

		return array(
			'summary' => $summary,
			'data' => $data,
		);
	}

	public function getUserTsKey() {
		return wfMemcKey('PromoteImageReviewHelper', 'userts', $this->wg->user->getId());
	}

	public function getImageUrl($wikiId, $pageId, $imgSize) {
		$data = ImagesService::getImageSrc($wikiId, $pageId, $imgSize);
		$url = (!empty($data['src'])) ? $data['src'] : null;

		return $url;
	}

	protected function getOrder($order) {
		switch ($order) {
			case self::ORDER_PRIORITY_LATEST:
				$ret = 'last_edited desc';
				break;
			case self::ORDER_OLDEST:
				$ret = 'last_edited asc';
				break;
			case self::ORDER_LATEST:
			default:
				$ret = 'last_edited desc';
		}
		return $ret;
	}

	public static function onCreatePromoteImageReviewTask($type, $list) {
		if (empty($list)) {
			return true;
		}

		$task = new PromoteImageReviewTask();
		$key = $type == 'delete' ? 'deletion_list' : 'upload_list';
		$params = [
			$key => $list,
		];

		$task->createTask($params, TASK_QUEUED);

		return true;
	}
}
