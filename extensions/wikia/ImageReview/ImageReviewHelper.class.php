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
		wfProfileIn( __METHOD__ );

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
				TASK_QUEUED,
				BatchTask::PRIORITY_HIGH
			);
		}

		wfProfileOut( __METHOD__ );
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
				'reviewer_id' => null,
				'state' => ImageReviewStatuses::STATE_UNREVIEWED,
				'review_start' => '0000-00-00 00:00:00',
				'review_end' => '0000-00-00 00:00:00',
			),
			array(
				"review_start < '{$review_start}'",
				'state' => ImageReviewStatuses::STATE_IN_REVIEW,
			),
			__METHOD__
		);

		// for STATE_QUESTIONABLE
		$db->update(
			'image_review',
			array(
				'state' => ImageReviewStatuses::STATE_QUESTIONABLE,
				'review_start' => '0000-00-00 00:00:00',
				'review_end' => '0000-00-00 00:00:00',
			),
			array(
				"review_start < '{$review_start}'",
				'state' => ImageReviewStatuses::STATE_QUESTIONABLE_IN_REVIEW,
			),
			__METHOD__
		);

		// for STATE_REJECTED
		$db->update(
			'image_review',
			array(
				'state' => ImageReviewStatuses::STATE_REJECTED,
				'review_start' => '0000-00-00 00:00:00',
				'review_end' => '0000-00-00 00:00:00',
			),
			array(
				"review_start < '{$review_start}'",
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
		wfProfileIn( __METHOD__ );

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
			$wikiRow = WikiFactory::getWikiByID( $row->wiki_id );
			$tmp = array(
				'wikiId' 	=> $row->wiki_id,
				'pageId' 	=> $row->page_id,
				'state' 	=> $row->state,
				'src' 		=> $img['src'],
				'priority' 	=> $row->priority,
				'url' 		=> $img['page'],
				'flags' 	=> $row->flags,
				'wiki_url' 	=> isset( $wikiRow->city_url ) ? $wikiRow->city_url : '',
				'user_page' => '', // @TODO fill this with url to user page
			);

			if(	!empty($tmp['src']) && !empty($tmp['url']) ) {
				$imageList[] = $tmp;
			}
		}
		$db->freeResult( $result );

		error_log("ImageReview : refetched " . count($imageList) . " images based on timestamp");

		wfProfileOut( __METHOD__ );

		return $imageList;
	}

	/**
	 * get image list
	 * @return array imageList
	 */
	public function getImageList( $timestamp, $state = ImageReviewStatuses::STATE_UNREVIEWED, $order = self::ORDER_LATEST ) {
		wfProfileIn( __METHOD__ );

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
			$rows[] = $row;
			$updateWhere[] = "(wiki_id = {$row->wiki_id} and page_id = {$row->page_id})";
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
		$db->commit();

		$imageList = $invalidImages = $unusedImages = array();
		foreach( $rows as $row) {
			$record = "(wiki_id = {$row->wiki_id} and page_id = {$row->page_id})";

			if (count($imageList) < self::LIMIT_IMAGES) {
				$img = ImagesService::getImageSrc( $row->wiki_id, $row->page_id );

				$extension = pathinfo( strtolower( $img['page'] ), PATHINFO_EXTENSION ); // this needs to use the page index since src for SVG ends in .svg.png :/

				if ( empty( $img['src'] ) && $state != ImageReviewStatuses::STATE_QUESTIONABLE && $state != ImageReviewStatuses::STATE_REJECTED ) {
					$invalidImages[] = $record;
				} elseif ( 'ico' == $extension ) {
					$iconsWhere[] = $record;
				} else {
					$isThumb = true;

					if ( empty( $img['src'] ) ) {
						// if we don't have a thumb by this opint, we still need to display something, fall back to placeholder
						$globalTitle = GlobalTitle::newFromId( $row->page_id, $row->wiki_id );
						if ( is_object( $globalTitle ) ) {
							$img['page'] = $globalTitle->getFullUrl();
							// @TODO this should be taken from the code instead of being hardcoded
							$img['src'] = 'http://images.wikia.com/central/images/8/8c/Wikia_image_placeholder.png';
						} else {
							// this should never happen
							$invalidImages[] = $record;
							continue;
						}
					}

					if  ( in_array( $extension, array( 'gif', 'svg' ) ) ) {
						$img = ImagesService::getImageOriginalUrl( $row->wiki_id, $row->page_id );
						$isThumb = false;
					}

					$wikiRow = WikiFactory::getWikiByID( $row->wiki_id );

					$imageList[] = array(
						'wikiId' => $row->wiki_id,
						'pageId' => $row->page_id,
						'state' => $row->state,
						'src' => $img['src'],
						'url' => $img['page'],
						'priority' => $row->priority,
						'flags' => $row->flags,
						'isthumb' => $isThumb,
						'wiki_url' => isset( $wikiRow->city_url ) ? $wikiRow->city_url : '',
					);
				}
			} else {
				$unusedImages[] = $record;
			}
		}

		$commit = false;
		if ( count($invalidImages) > 0 ) {
			$db->update(
				'image_review',
				array(
					'state' => ImageReviewStatuses::STATE_QUESTIONABLE // changed from STATE_INVALID_IMAGE
				),
				array( implode(' OR ', $invalidImages) ),
				__METHOD__
			);
			$commit = true;
		}

		if ( count($iconsWhere) > 0 ) {
			$db->update(
					'image_review',
					array( 'state' => ImageReviewStatuses::STATE_ICO_IMAGE),
					array( implode(' OR ', $iconsWhere) ),
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

		wfProfileOut( __METHOD__ );

		return $imageList;
	}

	protected function getWhitelistedWikis() {
		wfProfileIn( __METHOD__ );

		$topWikis = $this->getTopWikis();

		$whitelistedWikis = $this->getWhitelistedWikisFromWF();

		$out = array_keys( $whitelistedWikis + $topWikis );

		wfProfileOut( __METHOD__ );

		return $out;
	}

	protected function getWhitelistedWikisFromWF() {
		wfProfileIn( __METHOD__ );
		$key = wfMemcKey( 'ImageReviewSpecialController', __METHOD__ );

		$data = $this->wg->memc->get($key, null);

		if(!empty($data)) {
			wfProfileOut( __METHOD__ );
			return $data;
		}

		$oVariable = WikiFactory::getVarByName( 'wgImageReviewWhitelisted', 177 );
		$fromWf = WikiFactory::getListOfWikisWithVar($oVariable->cv_variable_id, 'bool', '=' ,true);

		$this->wg->memc->set($key, $fromWf, 60*10);
		wfProfileOut( __METHOD__ );
		return $fromWf;
	}

	protected function getTopWikis() {
		wfProfileIn( __METHOD__ );
		$key = wfMemcKey( 'ImageReviewSpecialController','v2', __METHOD__ );
		$data = $this->wg->memc->get($key, null);
		if( !empty($data) ) {
			wfProfileOut( __METHOD__ );
			return $data;
		}

		$ids = DataMartService::getTopWikisByPageviews( DataMartService::PERIOD_ID_MONTHLY, 200 );

		$this->wg->memc->set( $key, $ids, 86400 /* 24h */ );
		wfProfileOut( __METHOD__ );
		return $ids;
	}

	public function getImageCount() {
		wfProfileIn( __METHOD__ );

		$key = wfMemcKey( 'ImageReviewSpecialController', 'v2', __METHOD__);
		$total = $this->wg->memc->get($key, null);
		if ( !empty($total) ) {
			wfProfileOut( __METHOD__ );
			return $total;
		}

		$db = $this->getDatawareDB( DB_SLAVE );
		$where = array();

		$statesToFetch = array(
			ImageReviewStatuses::STATE_QUESTIONABLE,
			ImageReviewStatuses::STATE_REJECTED,
			ImageReviewStatuses::STATE_UNREVIEWED
		);
		$where[] = 'state in (' . $db->makeList( $statesToFetch ) . ')';

		$where[] = 'top_200 = 0';

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
			'unreviewed' => 0,
			'questionable' => 0,
			'rejected' => 0,
		);
		while( $row = $db->fetchObject($result) ) {
			$total[$row->state] = $row->total;
		}

		if ( array_key_exists( ImageReviewStatuses::STATE_UNREVIEWED, $total ) ) {
			$total['unreviewed'] = $this->wg->Lang->formatNum($total[ImageReviewStatuses::STATE_UNREVIEWED]);
		}
		if ( array_key_exists( ImageReviewStatuses::STATE_QUESTIONABLE, $total ) ) {
			$total['questionable'] = $this->wg->Lang->formatNum($total[ImageReviewStatuses::STATE_QUESTIONABLE]);
		}
		if ( array_key_exists( ImageReviewStatuses::STATE_REJECTED, $total ) ) {
			$total['rejected'] = $this->wg->Lang->formatNum( $total[ImageReviewStatuses::STATE_REJECTED]);
		}
		$this->wg->memc->set( $key, $total, 3600 /* 1h */ );

		wfProfileOut( __METHOD__ );
		return $total;
	}

	public function getStatsData( $startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay ) {

		$startDate = $startYear . '-' . $startMonth . '-' . $startDay . ' 00:00:00';
		$endDate = $endYear . '-' . $endMonth . '-' . $endDay . ' 23:59:59';

		$summary = array(
			'all' => 0,
			ImageReviewStatuses::STATE_APPROVED 	=> 0,
			ImageReviewStatuses::STATE_REJECTED 	=> 0,
			ImageReviewStatuses::STATE_QUESTIONABLE => 0,
			'avg' => 0,
		);
		$data = array();
		$userCount = $total = $avg = 0;

		$dbr = $this->getDatawareDB( DB_SLAVE );
		$reviewers = $this->getReviewersForStats();

		$count_users = count( $reviewers );
		if ( $count_users > 0 ) {
			foreach ( $reviewers as $reviewer ) {
				# user
				$user = User::newFromId( $reviewer );
				if ( !is_object( $user ) ) {
					// invalid user id?
					continue;
				}

				$query = array();
				foreach ( array_keys( $summary ) as $review_state ) {
					# union query: mysql explain: Using where; Using index and max 150k rows
					$query[] = $dbr->selectSQLText(
						array( 'image_review_stats' ),
						array( 'review_state', 'count(*) as cnt' ),
						array(
							"review_state"	=> $review_state,
							"reviewer_id"	=> $reviewer,
							"review_end between '{$startDate}' AND '{$endDate}'"
						),
						__METHOD__
					);
				}

				# Join the two fast queries, and sort the result set
				$sql = $dbr->unionQueries( $query, false );
				$res = $dbr->query( $sql, __METHOD__ );

				while ( $row = $dbr->fetchObject( $res ) ) {
					if ( !empty( $row->review_state ) ) {
						if ( !isset( $data[ $reviewer ] ) ) {
							$data[ $reviewer ] = array(
								'name' => $user->getName(),
								'total' => 0,
								ImageReviewStatuses::STATE_APPROVED => 0,
								ImageReviewStatuses::STATE_REJECTED => 0,
								ImageReviewStatuses::STATE_QUESTIONABLE => 0,
							);
						}
						$data[ $reviewer ][ $row->review_state ] = $row->cnt;
						$data[ $reviewer ][ 'total' ] += $row->cnt;

						# total
						$total += $row->cnt;

						# index in summary
						$summary[ $row->review_state ] += $row->cnt;
					}
				}

			}
		}
		$activeReviewers = count( $data );

		$summary[ 'all' ] = $total;
		$summary[ 'avg' ] = $activeReviewers > 0 ? $summary['all'] / $activeReviewers : 0;

		foreach ( $data as &$stats ) {
			$stats['toavg'] = $stats['total'] - $summary['avg'];
		}

		return array(
			'summary' => $summary,
			'data' => $data,
		);
	}

	public function getUserTsKey() {
		return wfMemcKey( 'ImageReviewSpecialController', 'userts', $this->wg->user->getId());
	}

	private function getImageStatesForStats() {
		wfProfileIn( __METHOD__ );

		$key = wfMemcKey( 'ImageReviewSpecialController', 'v2', __METHOD__);
		$states = $this->wg->memc->get($key, null);
		if ( empty($states) ) {
			$states = array();
			$db = $this->getDatawareDB( DB_SLAVE );

			# MySQL explain: Using where; Using index for group-by
			$result = $db->select(
				array( 'image_review_stats' ),
				array( 'review_state' ),
				array( 'review_state > 0' ),
				__METHOD__,
				array( 'GROUP BY' => 'review_state' )
			);

			while( $row = $db->fetchObject($result) ) {
				$states[] = $row->review_state;
			}
			$this->wg->memc->set( $key, $states, 60 * 60 * 8 );
		}

		wfProfileOut( __METHOD__ );
		return $states;
	}

	private function getReviewersForStats() {
		wfProfileIn( __METHOD__ );

		$key = wfMemcKey( 'ImageReviewSpecialController', 'v2', __METHOD__);
		$reviewers = $this->wg->memc->get($key, null);
		if ( empty($reviewers) ) {
			$reviewers = array();
			$db = $this->getDatawareDB( DB_SLAVE );

			# MySQL explain: Using where; Using index for group-by
			$result = $db->select(
				array( 'image_review_stats' ),
				array( 'reviewer_id' ),
				array( 'reviewer_id > 0' ),
				__METHOD__,
				array( 'GROUP BY' => 'reviewer_id' )
			);

			while( $row = $db->fetchObject($result) ) {
				$reviewers[] = $row->reviewer_id;
			}
			$this->wg->memc->set( $key, $reviewers, 60 * 60 * 8 );
		}

		wfProfileOut( __METHOD__ );
		return $reviewers;
	}

	public static function onWikiFactoryPublicStatusChange( $city_public, $city_id, $reason ) {
		global $wgExternalDatawareDB;

		if ( $city_public == 0 || $city_public == -1 ) {
			// the wiki was disabled, mark all unreviewed images as deleted

			$newState = ImageReviewStatuses::STATE_WIKI_DISABLED;
			$statesToUpdate = array(
				ImageReviewStatuses::STATE_UNREVIEWED,
				ImageReviewStatuses::STATE_REJECTED,
				ImageReviewStatuses::STATE_QUESTIONABLE,
				ImageReviewStatuses::STATE_QUESTIONABLE_IN_REVIEW,
				ImageReviewStatuses::STATE_REJECTED_IN_REVIEW,
				ImageReviewStatuses::STATE_IN_REVIEW,
			);
		} elseif ( $city_public == 1 ) {
			// the wiki was re-enabled, put all images back into the queue as unreviewed

			$newState = ImageReviewStatuses::STATE_UNREVIEWED;
			$statesToUpdate = array(
				ImageReviewStatuses::STATE_WIKI_DISABLED,
			);
		} else {
			// the state change doesn't affect images, we don't need to do anything here
			return true;
		}

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

		$dbw->update(
			'image_review',
			array(
				'state' => $newState,
			),
			array(
				'wiki_id' => $city_id,
				'state' => $dbw->makeList( $statesToUpdate ),
			)
		);

		return true;
	}
}

