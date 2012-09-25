<?php

/**
 * ImageReview Helper
 */
class ImageReviewHelper extends ImageReviewHelperBase {

	private $user_id = 0;
	const LIMIT_IMAGES = 20;
	/*
	 * LIMIT_IMAGES_FROM_DB should be a little greater than LIMIT_IMAGES, so if
	 * we fetch a few icons from DB, we can skip them
	 */
	const LIMIT_IMAGES_FROM_DB = 24;

	static $sortOptions = array(
		'latest first' => 0,
		'by priority and recency' => 1,
		'oldest first' => 2,
	);
	
	function __construct() {
		parent::__construct();
		$this->user_id = $this->wg->user->getId();
	}

	/**
	 * update image state
	 * @param array $images
	 * @param string $action
	 */
	public function updateImageState( $images, $action = '' ) {
		$this->wf->ProfileIn( __METHOD__ );

		$deletionList = array();
		$statsInsert = array();

		$sqlWhere = array(
			ImageReviewStatuses::STATE_APPROVED => array(),
			ImageReviewStatuses::STATE_REJECTED => array(),
			ImageReviewStatuses::STATE_QUESTIONABLE => array(),
		);

		foreach ( $images as $image ) {
			$sqlWhere[ $image['state'] ][] = "( wiki_id = $image[wikiId] AND page_id = $image[pageId]) ";
			
			if ( $image['state'] == ImageReviewStatuses::STATE_DELETED ) {
				$deletionList[] = array( $image['wikiId'], $image['pageId'] );
			}

			$statsInsert[] = array(
				'wiki_id' => $image['wikiId'],
				'page_id' => $image['pageId'],
				'review_state' => $image['state'],
				'reviewer_id' => $this->user_id
			);
		}

		$db = $this->getDatawareDB( DB_MASTER );
		foreach( $sqlWhere as $state => $where ) {
			if ( !empty($where) ) {
				$db->update(
					'image_review',
					array(
						'reviewer_id' => $this->user_id,
						'state' => $state,
						'review_end = now()',
					),
					array( implode(' OR ', $where ) ),
					__METHOD__
				);
			}
		}

		if ( !empty( $statsInsert ) ) {
			$db->insert(
				'image_review_stats',
				$statsInsert,
				__METHOD__
			);
		}

		$db->commit();

		// update stats directly in memcache so they look nice without impacting the database
		$key = wfMemcKey( 'ImageReviewSpecialController', 'ImageReviewHelper::getImageCount', $this->user_id );
		$stats = $this->wg->memc->get($key, null);
		if ($stats) {
			switch ( $action ) {
				case '':
				//	$stats['reviewer'] += count($images);
				//	$stats['unreviewed'] -= count($images);
					$stats['questionable'] += count($sqlWhere[ImageReviewStatuses::STATE_QUESTIONABLE]);
					break;
				case ImageReviewSpecialController::ACTION_QUESTIONABLE:
					$changedState = count( $sqlWhere[ImageReviewStatuses::STATE_APPROVED] ) + count( $sqlWhere[ImageReviewStatuses::STATE_REJECTED] );
				//	$stats['reviewer'] += $changedState;
					$stats['questionable'] -= $changedState;
					break;
				case ImageReviewSpecialController::ACTION_REJECTED:
					$changedState = count( $sqlWhere[ImageReviewStatuses::STATE_APPROVED] ) + count( $sqlWhere[ImageReviewStatuses::STATE_DELETED] );
					$stats['rejected'] -= $changedState;
					break;
			}
			$this->wg->memc->set( $key, $stats, 3600 /* 1h */ );
			// Quick hack/fix for stats going negative -- FIXME
			if ($stats['unreviewed'] < 0)
				$this->wg->memc->delete( $key );
		}

		if ( !empty( $deletionList ) ) {
			$task = new ImageReviewTask();
			$task->createTask(
				array(
					'page_list' => $deletionList,
				),
				TASK_QUEUED
			);
		}

		$this->wf->ProfileOut( __METHOD__ );
	}

	/**
	 * reset state in abandoned work
	 * note: this is run via a cron script
	 */
	public function resetAbandonedWork() {
		wfProfileIn( __METHOD__ );
		
		$db = $this->getDatawareDB( DB_MASTER );
		
		$timeLimit = ( $this->wg->DevelEnvironment ) ? 1 : 3600; // 1 sec
		$review_start = wfTimestamp(TS_DB, time() - $timeLimit );

		// for STATE_UNREVIEWED
		$db->update(
			'image_review',
			array(
				'reviewer_id = null',
				'state' => ImageReviewStatuses::STATE_UNREVIEWED,
			),
			array(
				"review_start < '{$review_start}'",
				"review_end = '0000-00-00 00:00:00'",
				'state' => ImageReviewStatuses::STATE_IN_REVIEW,
			),
			__METHOD__
		);

		// for STATE_QUESTIONABLE
		$db->update(
			'image_review',
			array( 'state' => ImageReviewStatuses::STATE_QUESTIONABLE ),
			array(
				"review_start < '{$review_start}'",
				"review_end = '0000-00-00 00:00:00'",
				'state' => ImageReviewStatuses::STATE_QUESTIONABLE_IN_REVIEW,
			),
			__METHOD__
		);

		// for STATE_REJECTED
		$db->update(
			'image_review',
			array( 'state' => ImageReviewStatuses::STATE_REJECTED ),
			array(
				"review_start < '{$review_start}'",
				"review_end = '0000-00-00 00:00:00'",
				'state' => ImageReviewStatuses::STATE_REJECTED_IN_REVIEW,
			),
			__METHOD__
		);

		$db->commit();

		wfProfileOut( __METHOD__ );
	}

	/**
	* get image list from reviewer id based on the timestamp
	* Note: NOT update image state
	* @param integer $timestamp review_end
	* @return array images
	*/
	public function refetchImageListByTimestamp( $timestamp ) {
		$this->wf->ProfileIn( __METHOD__ );

		$db = $this->getDatawareDB( DB_SLAVE ); 

		// try to re-fetch the previuos set of images
		// TODO: optimize it, so we don't do it on every request

		$review_start = wfTimestamp( TS_DB, $timestamp );

		$result = $db->select(
			array( 'image_review' ),
			array( 'wiki_id, page_id, state, flags, priority' ),
			array( 
				'review_start'	=> $review_start, 
				'reviewer_id'	=> $this->user_id
			),
			__METHOD__,
			array( 
				'ORDER BY' => 'priority desc, last_edited desc',
				'LIMIT' => self::LIMIT_IMAGES 
			)
		);

		$imageList = array();
		while( $row = $db->fetchObject($result) ) {
			$img = ImagesService::getImageSrc( $row->wiki_id, $row->page_id );
			$tmp = array(
				'wikiId' 	=> $row->wiki_id,
				'pageId' 	=> $row->page_id,
				'state' 	=> $row->state,
				'src' 		=> $img['src'],
				'priority' 	=> $row->priority,
				'url' 		=> $img['page'],
				'flags' 	=> $row->flags,
				'wiki_url' 	=> '', // @TODO fill this with wiki url
				'user_page' => '', // @TODO fill this with url to user page
			);

			if(	!empty($tmp['src']) && !empty($tmp['url']) ) {
				$imageList[] = $tmp;
			}
		}
		$db->freeResult( $result );

		error_log("ImageReview : refetched " . count($imageList) . " images based on timestamp");

		$this->wf->ProfileOut( __METHOD__ );

		return $imageList;
	}

	/**
	 * get image list
	 * @return array imageList
	 */
	public function getImageList( $timestamp, $state = ImageReviewStatuses::STATE_UNREVIEWED, $order = self::ORDER_LATEST ) {
		$this->wf->ProfileIn( __METHOD__ );

		// get images
		$db = $this->getDatawareDB( DB_MASTER );
		$result = $db->query('
			SELECT pages.page_title_lower, image_review.wiki_id, image_review.page_id, image_review.state, image_review.flags, image_review.priority 
			FROM (
				SELECT image_review.wiki_id, image_review.page_id, image_review.state, image_review.flags, image_review.priority 
				FROM `image_review`
				WHERE state = ' . $state . ' AND top_200 = false 
				ORDER BY ' . $this->getOrder($order) . ' 
				LIMIT ' . self::LIMIT_IMAGES_FROM_DB . '
			) as image_review 
			LEFT JOIN pages ON (image_review.wiki_id=pages.page_wikia_id) AND (image_review.page_id=pages.page_id)'
		);

		$rows = array();
		$updateWhere = array();
		$iconsWhere = array();
		while ( $row = $db->fetchObject($result) ) {
			$record = "(wiki_id = {$row->wiki_id} and page_id = {$row->page_id})";
			if ( "ico" == pathinfo($row->page_title_lower, PATHINFO_EXTENSION) ) {
				$iconsWhere[] = $record;
			} else {
				$rows[] = $row;
				$updateWhere[] = $record;
			}
		}
		$db->freeResult( $result );

		# update records
		if ( count($updateWhere) > 0) {
			$review_start = wfTimestamp( TS_DB, $timestamp );

			switch ( $state ) {
				case ImageReviewStatuses::STATE_QUESTIONABLE:
					$target_state = ImageReviewStatuses::STATE_QUESTIONABLE_IN_REVIEW;
					break;
				case ImageReviewStatuses::STATE_REJECTED:
					$target_state = ImageReviewStatuses::STATE_REJECTED_IN_REVIEW;
					break;
				default:
					$target_state = ImageReviewStatuses::STATE_IN_REVIEW;
			}

			$values = array (
				'reviewer_id' => $this->user_id,
				'review_start' => $review_start,
				'state' => $target_state
			);
			
			if ( $state == ImageReviewStatuses::STATE_QUESTIONABLE || $state == ImageReviewStatuses::STATE_REJECTED ) {
				$values[] = "review_end = '0000-00-00 00:00:00'";
			}
			
			$db->update(
				'image_review',
				$values,
				array( implode(' OR ', $updateWhere) ),
				__METHOD__
			);
		}

		if ( count($iconsWhere) > 0 ) {
			$db->update(
				'image_review',
				array( 'state' => ImageReviewStatuses::STATE_ICO_IMAGE),
				array( implode(' OR ', $iconsWhere) ),
				__METHOD__
			);
		}
		$db->commit();

		$imageList = $invalidImages = $unusedImages = array();
		foreach( $rows as $row) {
			if (count($imageList) < self::LIMIT_IMAGES) {
				$img = ImagesService::getImageSrc( $row->wiki_id, $row->page_id );

				if ( empty( $img['src'] ) ) {
					$invalidImages[] = "(wiki_id = {$row->wiki_id} and page_id = {$row->page_id})";
				} else {
					$imageList[] = array(
						'wikiId' => $row->wiki_id,
						'pageId' => $row->page_id,
						'state' => $row->state,
						'src' => $img['src'],
						'url' => $img['page'],
						'priority' => $row->priority,
						'flags' => $row->flags,
					);
				}
			} else {
				$unusedImages[] = "(wiki_id = {$row->wiki_id} and page_id = {$row->page_id})";
			}
		}

		$commit = false;
		if ( count($invalidImages) > 0 ) {
			$db->update(
				'image_review',
				array( 
					'state' => ImageReviewStatuses::STATE_INVALID_IMAGE
				),
				array( implode(' OR ', $invalidImages) ),
				__METHOD__
			);
			$commit = true;
		}

		if ( count($unusedImages) > 0 ) {
			$db->update(
				'image_review',
				array( 
					'reviewer_id = null',
					'state' => $state
				),
				array( implode(' OR ', $unusedImages) ),
				__METHOD__
			);
			$commit = true;
			error_log("ImageReview : returning " . count($unusedImages) . " back to the queue");
		}

		if ( $commit ) $db->commit();

		error_log("ImageReview : fetched new " . count($imageList) . " images");

		$this->wf->ProfileOut( __METHOD__ );

		return $imageList;
	}

	protected function getWhitelistedWikis() {
		$this->wf->ProfileIn( __METHOD__ );

		$topWikis = $this->getTopWikis();

		$whitelistedWikis = $this->getWhitelistedWikisFromWF();

		$out = array_keys( $whitelistedWikis + $topWikis );

		$this->wf->ProfileOut( __METHOD__ );

		return $out;
	}

	protected function getWhitelistedWikisFromWF() {
		$this->wf->ProfileIn( __METHOD__ );
		$key = wfMemcKey( 'ImageReviewSpecialController', __METHOD__ );

		$data = $this->wg->memc->get($key, null);

		if(!empty($data)) {
			$this->wf->ProfileOut( __METHOD__ );
			return $data;
		}

		$oVariable = WikiFactory::getVarByName( 'wgImageReviewWhitelisted', 177 );
		$fromWf = WikiFactory::getListOfWikisWithVar($oVariable->cv_variable_id, 'bool', '=' ,true);

		$this->wg->memc->set($key, $fromWf, 60*10);
		$this->wf->ProfileOut( __METHOD__ );
		return $fromWf;
	}

	protected function getTopWikis() {
		$this->wf->ProfileIn( __METHOD__ );
		$key = wfMemcKey( 'ImageReviewSpecialController','v2', __METHOD__ );
		$data = $this->wg->memc->get($key, null);
		if( !empty($data) ) {
			$this->wf->ProfileOut( __METHOD__ );
			return $data;
		}

		$db = $this->getStatsDB( DB_SLAVE );
		$ids = array();
		$cnt = 0;
		if (!$this->wg->DevelEnvironment ) {
			$result = $db->select(
				array( 'google_analytics.pageviews' ),
				array( 'city_id', 'sum(pageviews) as cnt' ),
				array( 'date > curdate() - interval 31 day' ),
				__METHOD__,
				array(
					'GROUP BY'=> 'city_id',
					'ORDER BY' => 'cnt desc', 
					'HAVING' => 'cnt > 10000'
				)
			);

			while( $cnt < 200 && $row = $db->fetchRow($result) ) {
				$cnt++;
				$ids[$row['city_id']] = 1;
			}
		}

		$this->wg->memc->set( $key, $ids, 86400 /* 24h */ );
		$this->wf->ProfileOut( __METHOD__ );
		return $ids;
	}

	public function getImageCount() {
		$this->wf->ProfileIn( __METHOD__ );

		$key = wfMemcKey( 'ImageReviewSpecialController', 'v2', __METHOD__);
		$total = $this->wg->memc->get($key, null);
		if ( !empty($total) ) {
			$this->wf->ProfileOut( __METHOD__ );
			return $total;
		}
		
		$db = $this->getDatawareDB( DB_SLAVE );
		$where = array( 'state in (' . ImageReviewStatuses::STATE_QUESTIONABLE . ',' . ImageReviewStatuses::STATE_REJECTED . ')' );
		
		$list = $this->getWhitelistedWikis();
		if ( !empty($list) ) {
			$where[] = 'wiki_id not in('.implode(',', $list).')';
		}

		// select by reviewer, state and total count with rollup and then pick the data we want out
		$result = $db->select(
			array( 'image_review' ),
			array( 'state', 'count(*) as total' ),
			$where,
			__METHOD__,
			array( 'GROUP BY' => 'state' )
		);

		$total = array(
			'reviewer' => 0, 
			'unreviewed' => 0, 
			'questionable' => 0,
			'rejected' => 0,
		);
		while( $row = $db->fetchObject($result) ) {
			$total[$row->state] = $row->total;

			// Rollup row with Reviewer total count
		/*	if ($row->reviewer_id == $reviewer_id && ($row->state > ImageReviewStatuses::STATE_IN_REVIEW)) {
				$total['reviewer'] += $row->total;
			}
			// Rollup row with total unreviewed
			if ($row->state == ImageReviewStatuses::STATE_UNREVIEWED) {
				$total['unreviewed'] += $row->total;
			}
			// Rollup row with total questionable
			if ($row->state == ImageReviewStatuses::STATE_QUESTIONABLE) {
				$total['questionable'] += $row->total;
			} */
		}
	//	$total['reviewer'] = $this->wg->Lang->formatNum($total['reviewer']);
	//	$total['unreviewed'] = $this->wg->Lang->formatNum($total['unreviewed']);
		if ( array_key_exists( ImageReviewStatuses::STATE_QUESTIONABLE, $total ) ) {
			$total['questionable'] = $this->wg->Lang->formatNum($total[ImageReviewStatuses::STATE_QUESTIONABLE]);
		}
		if ( array_key_exists( ImageReviewStatuses::STATE_REJECTED, $total ) ) {
			$total['rejected'] = $this->wg->Lang->formatNum( $total[ImageReviewStatuses::STATE_REJECTED]);
		}
		$this->wg->memc->set( $key, $total, 3600 /* 1h */ );

		$this->wf->ProfileOut( __METHOD__ );
		return $total;
	}

	public function getStatsData( $startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay ) {

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

		$dbr = $this->getDatawareDB( DB_SLAVE );

		$res = $dbr->query( "select review_state, reviewer_id, count( page_id ) as count from
		image_review_stats WHERE review_end BETWEEN '{$startDate}' AND '{$endDate}' group by review_state, reviewer_id with rollup" );

		while ( $row = $dbr->fetchRow( $res ) ) {
			if ( is_null( $row['review_state'] ) ) {
				// total
				$summary['all'] = $row['count'];
			} elseif ( is_null( $row['reviewer_id'] ) ) {
				$summary[$row['review_state']] = $row['count'];
			} else {
				if ( empty( $data[$row['reviewer_id']] ) ) {
					$user = User::newFromId( $row['reviewer_id'] );

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

		foreach ( $data as &$stats ) {
			$stats['toavg'] = $stats['total'] - $summary['avg'];
		}

		return array(
			'summary' => $summary,
			'data' => $data,
		);
	}

	public function getUserTsKey() {
		return $this->wf->MemcKey( 'ImageReviewSpecialController', 'userts', $this->wg->user->getId());
	}
}
