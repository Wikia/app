<?php

/**
 * ImageReview Helper
 */
class ImageReviewHelper extends WikiaModel {

	const LIMIT_IMAGES = 20;
	/*
	 * LIMIT_IMAGES_FROM_DB should be a little greater than LIMIT_IMAGES, so if
	 * we fetch a few icons from DB, we can skip them
	 */
	const LIMIT_IMAGES_FROM_DB = 24;

	const STATE_UNREVIEWED = 0;
	const STATE_IN_REVIEW = 1;
	const STATE_APPROVED = 2;
	const STATE_REJECTED = 3;
	const STATE_DELETED = 4;
	const STATE_QUESTIONABLE = 5;
	const STATE_QUESTIONABLE_IN_REVIEW = 6;

	const STATE_INVALID_IMAGE = 98;
	const STATE_ICO_IMAGE = 99;

	const FLAG_SUSPICOUS_USER = 2;
	const FLAG_SUSPICOUS_WIKI = 4;
	const FLAG_SKIN_DETECTED = 8;

	static $sortOptions = array(
                'latest first' => 0,
                'by priority and recency' => 1,
                'oldest first' => 2,
	);

	const ORDER_LATEST = 0;
	const ORDER_PRIORITY_LATEST = 1;
	const ORDER_OLDEST = 2;
	/**
	 * update image state
	 * @param array images
	 * @param integer review_end
	 */
	public function updateImageState( $images, $action = '' ) {
		$this->wf->ProfileIn( __METHOD__ );

		$deletionList = array();
		$sqlWhere = array();
		$statsInsert = array();

		$sqlWhere = array(
			self::STATE_APPROVED => array(),
			self::STATE_DELETED => array(),
			self::STATE_QUESTIONABLE => array(),
		);

		foreach ( $images as $image ) {
			if ( $image['state'] == self::STATE_APPROVED ) {
				$sqlWhere[self::STATE_APPROVED][] = "( wiki_id = $image[wikiId] AND page_id = $image[pageId]) ";
			} else if ( $image['state'] == self::STATE_DELETED ) {
				$sqlWhere[self::STATE_DELETED][] = "( wiki_id = $image[wikiId] AND page_id = $image[pageId]) ";
				$deletionList[$image['wikiId']] = $image['pageId'];
			} else if ( $image['state'] == self::STATE_QUESTIONABLE ) {
				$sqlWhere[self::STATE_QUESTIONABLE][] = "( wiki_id = $image[wikiId] AND page_id = $image[pageId]) ";
			}

			$statsInsert[] = array(
				'wiki_id' => $image['wikiId'],
				'page_id' => $image['pageId'],
				'review_state' => $image['state'],
				'reviewer_id' => $this->wg->user->getId(),
			);
		}

		foreach( $sqlWhere as $state => $where ) {
			if ( !empty($where) ) {
				$db = $this->wf->GetDB( DB_MASTER, array(), $this->wg->ExternalDatawareDB );

				$db->update(
					'image_review',
					array(
						'reviewer_id' => $this->wg->user->getId(),
						'state' => $state,
						'review_end = now()',
					),
					array( implode(' OR ', $where ) ),
					__METHOD__
				);

				$db->commit();
			}
		}

		$db->insert(
			'image_review_stats',
			$statsInsert,
			__METHOD__
		);

		// update stats directly in memcache so they look nice without impacting the database
		$key = wfMemcKey( 'ImageReviewSpecialController', 'ImageReviewHelper::getImageCount', $this->wg->user->getId() );
		$stats = $this->wg->memc->get($key, null);
		if ($stats) {
			switch ( $action ) {
				case '':
				//	$stats['reviewer'] += count($images);
				//	$stats['unreviewed'] -= count($images);
					$stats['questionable'] += count($sqlWhere[self::STATE_QUESTIONABLE]);
					break;
				case ImageReviewSpecialController::ACTION_QUESTIONABLE:
					$changedState = count( $sqlWhere[self::STATE_APPROVED] ) + count( $sqlWhere[self::STATE_DELETED] );
				//	$stats['reviewer'] += $changedState;
					$stats['questionable'] -= $changedState;
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
	 * @todo remove this this (cron worker to take over)
	 */
	public function resetAbandonedWork() {
		$this->wf->ProfileIn( __METHOD__ );
		$db = $this->wf->GetDB( DB_MASTER, array(), $this->wg->ExternalDatawareDB );

		$timeLimit = ( $this->wg->DevelEnvironment ) ? 1 : 3600 ; // 1 sec

		// for STATE_UNREVIEWED
		$db->update(
			'image_review',
			array(
				'reviewer_id = null',
				'state' => self::STATE_UNREVIEWED,
			),
			array(
				"review_start < now() - ".$timeLimit,
				"review_end = '0000-00-00 00:00:00'",
				'reviewer_id' =>  $this->wg->User->getId(),
				'state' => self::STATE_IN_REVIEW,
			),
			__METHOD__
		);

		// for STATE_QUESTIONABLE
		$db->update(
			'image_review',
			array( 'state' => self::STATE_QUESTIONABLE ),
			array(
				"review_start < now() - ".$timeLimit,
				"review_end = '0000-00-00 00:00:00'",
				'reviewer_id' =>  $this->wg->User->getId(),
				'state' => self::STATE_QUESTIONABLE_IN_REVIEW,
			),
			__METHOD__
		);

		$db->commit();

		$this->wf->ProfileOut( __METHOD__ );
	}

	/**
	* get image list from reviewer id based on the timestamp
	* Note: NOT update image state
	* @param integer review_end
	* @return array images
	*/
	public function refetchImageListByTimestamp( $timestamp ) {
		$this->wf->ProfileIn( __METHOD__ );

		$db = $this->wf->GetDB( DB_SLAVE, array(), $this->wg->ExternalDatawareDB );

		// try to re-fetch the previuos set of images
		// TODO: optimize it, so we don't do it on every request

		$result = $db->select(
			array( 'image_review' ),
			array( 'wiki_id, page_id, state, flags, priority' ),
			array( 'review_start = FROM_UNIXTIME(' . $timestamp . ')', 'reviewer_id' =>  $this->wg->user->getId()),
			__METHOD__,
			array( 'ORDER BY' => 'priority desc, last_edited desc', 'LIMIT' => self::LIMIT_IMAGES )
		);

		$imageList = array();
		while( $row = $db->fetchObject($result) ) {
			$img = $this->getImageSrc( $row->wiki_id, $row->page_id );
			$tmp = array(
				'wikiId' => $row->wiki_id,
				'pageId' => $row->page_id,
				'state' => $row->state,
				'src' => $img['src'],
				'priority' => $row->priority,
				'url' => $img['page'],
				'flags' => $row->flags,
				'wiki_url' => '', // @TODO fill this with wiki url
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
	public function getImageList( $timestamp, $state = self::STATE_UNREVIEWED, $order = self::ORDER_LATEST ) {
		$this->wf->ProfileIn( __METHOD__ );

		$db = $this->wf->GetDB( DB_MASTER, array(), $this->wg->ExternalDatawareDB );

		// for testing
		$this->resetAbandonedWork();

		// get images
		$imageList = array();
		$reviewList = array();

		$where = array();
		$list = $this->getWhitelistedWikis();
		if(!empty($list)) {
			$where[] = 'wiki_id not in('.implode(',', $list).')';
		}

		$where[] = "state = ". $state;

		$values = array(
			'reviewer_id = '.$this->wg->user->getId(),
			"review_start = from_unixtime($timestamp)",
		);

		if ( $state == self::STATE_QUESTIONABLE ) {
			$newState = self::STATE_QUESTIONABLE_IN_REVIEW;
			$values[] = "review_end = '0000-00-00 00:00:00'";
		} else {
			$newState = self::STATE_IN_REVIEW ;
		}

		$values[] = 'state = '.$newState;

		$where[] = 'image_review.wiki_id=pages.page_wikia_id';
		$where[] =  'image_review.page_id=pages.page_id';

		$result = $db->select(
			array( 'image_review', 'pages' ),
			array( 'image_review.wiki_id, image_review.page_id, image_review.state, image_review.flags, image_review.priority, pages.page_title_lower',  ),
			$where,
			__METHOD__,
			array(
				'ORDER BY' => $this->getOrder($order),
				'LIMIT' => self::LIMIT_IMAGES_FROM_DB )
		);

		$rows = array();
		$updateWhere = array();
		$iconsWhere = array();
		while ( $row = $db->fetchObject($result) ) {
			if ( "ico" == pathinfo($row->page_title_lower, PATHINFO_EXTENSION) ) {
				$iconsWhere[] = "(wiki_id = {$row->wiki_id} and page_id = {$row->page_id})";
			} else {
				$rows[] = $row;
				$updateWhere[] = "(wiki_id = {$row->wiki_id} and page_id = {$row->page_id})";
			}
		}

		$db->freeResult( $result );

		if ( count($updateWhere) > 0) {
			$db->update(
				'image_review',
				$values,
				array(implode(' OR ', $updateWhere)),
				__METHOD__
			);
		}


		if ( count($iconsWhere) > 0 ) {
			$db->update(
				'image_review',
				array( 'state' => self::STATE_ICO_IMAGE),
				array(implode(' OR ', $iconsWhere)),
				__METHOD__
			);
		}
		$db->commit();

		$invalidImages = array();
		$unusedImages = array();
		foreach( $rows as $row) {
			if (count($imageList) < self::LIMIT_IMAGES) {
				$img = $this->getImageSrc( $row->wiki_id, $row->page_id );

				if ( empty($img['src'])) {
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
				array( 'state' => self::STATE_INVALID_IMAGE),
				array(implode(' OR ', $invalidImages)),
				__METHOD__
			);
			$commit = true;
		}

		if ( count($unusedImages) > 0 ) {
			$db->update(
				'image_review',
				array( 'reviewer_id = null', 'state' => $state),
				array(implode(' OR ', $unusedImages)),
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

	/**
	 * get image thumbnail
	 * @param integer wikiId
	 * @param integer pageId
	 * @return string imageUrl
	 */
	protected function getImageSrc( $wikiId, $pageId ) {
		$this->wf->ProfileIn( __METHOD__ );

		$dbname = WikiFactory::IDtoDB( $wikiId );
		$param = array(
			'action' => 'imagecrop',
			'imgId' => $pageId,
			'imgSize' => 250,
		);

		$response = ApiService::foreignCall( $dbname, $param );

		$imageSrc = ( empty($response['image']['imagecrop']) ) ? '' : $response['image']['imagecrop'] ;
		$imagePage = ( empty($response['imagepage']['imagecrop']) ) ? '' : $response['imagepage']['imagecrop'] ;

		$this->wf->ProfileOut( __METHOD__ );

		return array('src' => $imageSrc, 'page' => $imagePage );
	}


	/**
	 * get image page url
	 * @param integer wikiId
	 * @param integer pageId
	 * @return string image page URL
	 */
	protected function getImagePage( $wikiId, $pageId ) {
		$this->wf->ProfileIn( __METHOD__ );

		$title = GlobalTitle::newFromId($pageId, $wikiId);
		$imagePage = ($title instanceof Title) ? $title->getFullURL() : '';

		$this->wf->ProfileOut( __METHOD__ );
		return $imagePage;
	}


	protected function getWhitelistedWikis() {
		$this->wf->ProfileIn( __METHOD__ );

		$topWikis =  $this->getTopWikis();

		$whitelistedWikis =  $this->getWhitelistedWikisFromWF();

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
		$key = wfMemcKey( 'ImageReviewSpecialController', __METHOD__ );
		$data = $this->wg->memc->get($key, null);
		if(!empty($data)) {
			$this->wf->ProfileOut( __METHOD__ );
			return $data;
		}

		$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->StatsDB);
		$ids = array();

		if (!$this->wg->DevelEnvironment ) {
			$result = $db->select(
				array( 'google_analytics.pageviews' ),
				array( 'city_id', 'sum(pageviews) as cnt' ),
				array( 'date > curdate() - interval 31 day' ),
				__METHOD__,
				array(
					'GROUP BY'=> 'city_id',
					'HAVING' => 'cnt > 150000'
				)
			);

			while( $row = $db->fetchRow($result) ) {
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
		if(!empty($total)) {
			$this->wf->ProfileOut( __METHOD__ );
			return $total;
		}
		$db = $this->wf->GetDB( DB_SLAVE, array(), $this->wg->ExternalDatawareDB );

		$where = array();
		$list = $this->getWhitelistedWikis();
		if(!empty($list)) {
			$where[] = 'wiki_id not in('.implode(',', $list).')';
		}

		$where['state'] = self::STATE_QUESTIONABLE;

		// select by reviewer, state and total count with rollup and then pick the data we want out
		$result = $db->select(
			array( 'image_review' ),
			array( 'count(*) as total' ),
			$where,
			__METHOD__,
			array()
		);

		$total = array('reviewer' => 0, 'unreviewed' => 0, 'questionable' => 0);
		while( $row = $db->fetchObject($result) ) {
			$total['questionable'] = $row->total;

			// Rollup row with Reviewer total count
		/*	if ($row->reviewer_id == $reviewer_id && ($row->state > self::STATE_IN_REVIEW)) {
				$total['reviewer'] += $row->total;
			}
			// Rollup row with total unreviewed
			if ($row->state == self::STATE_UNREVIEWED) {
				$total['unreviewed'] += $row->total;
			}
			// Rollup row with total questionable
			if ($row->state == self::STATE_QUESTIONABLE) {
				$total['questionable'] += $row->total;
			} */
		}
	//	$total['reviewer'] = $this->wg->Lang->formatNum($total['reviewer']);
	//	$total['unreviewed'] = $this->wg->Lang->formatNum($total['unreviewed']);
		$total['questionable'] = $this->wg->Lang->formatNum($total['questionable']);
		$this->wg->memc->set( $key, $total, 3600 /* 1h */ );

		return $total;
		$this->wf->ProfileOut( __METHOD__ );
	}

	public function getUserTsKey() {
		return $this->wf->MemcKey( 'ImageReviewSpecialController', 'userts', $this->wg->user->getId());
	}


	private function getOrder( $order ) {
		switch ( $order ) {
			case self::ORDER_PRIORITY_LATEST:
				$ret = 'priority desc, last_edited desc';
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
}
