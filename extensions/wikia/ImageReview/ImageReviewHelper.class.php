<?php

use \Wikia\Logger\WikiaLogger;

/**
 * ImageReview Helper
 *
 * @author (contributing) Adam Karmiński <adamk@wikia-inc.com>
 */
class ImageReviewHelper extends ImageReviewHelperBase {

	private $user_id = 0;
	/**
	 * @var ImageReviewStatsCache
     */
	private $stats_cache;
	
	function __construct() {
		parent::__construct();
		$this->user_id     = $this->wg->user->getId();
		$this->stats_cache = new ImageReviewStatsCache( $this->user_id, $this->wg );
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
		$this->updateStatsOnAction(
			$action,
			count($images),
			count($sqlWhere[ImageReviewStatuses::STATE_APPROVED]),
			count($sqlWhere[ImageReviewStatuses::STATE_QUESTIONABLE]),
			count($sqlWhere[ImageReviewStatuses::STATE_REJECTED]),
			count($deletionList)
		);

		$this->createDeleteImagesTask( $deletionList );

		wfProfileOut( __METHOD__ );
	}

	public function updateStatsOnAction( $action, $reviewed, $approved, $questionable, $rejected, $deleted ) {
		switch ( $action ) {
			case '':
				$this->stats_cache->offsetStats( ImageReviewStatsCache::STATS_REVIEWER, $reviewed );
				$this->stats_cache->offsetStats( ImageReviewStatsCache::STATS_UNREVIEWED, -$reviewed );
				$this->stats_cache->offsetStats( ImageReviewStatsCache::STATS_REJECTED, $rejected );
				$this->stats_cache->offsetStats( ImageReviewStatsCache::STATS_QUESTIONABLE, $questionable );
				break;
			case ImageReviewSpecialController::ACTION_QUESTIONABLE:
				$this->stats_cache->offsetStats( ImageReviewStatsCache::STATS_REVIEWER, $approved + $rejected );
				$this->stats_cache->offsetStats( ImageReviewStatsCache::STATS_QUESTIONABLE, -($approved + $rejected) );
				break;
			case ImageReviewSpecialController::ACTION_REJECTED:
				$this->stats_cache->offsetStats( ImageReviewStatsCache::STATS_UNREVIEWED, -$reviewed );
				$this->stats_cache->offsetStats( ImageReviewStatsCache::STATS_REJECTED, -($approved + $deleted) );
				break;
		}
	}

	/**
	 * Creates a task removing listed images
	 * @param  array  $aDeletionList  An array of [ city_id, page_id ] arrays.
	 * @return void
	 */
	public function createDeleteImagesTask( $aDeletionList ) {
		if ( !empty( $aDeletionList ) ) {
			$task = new \Wikia\Tasks\Tasks\ImageReviewTask();
			$task->call('delete', $aDeletionList);
			$task->prioritize();
			$task->queue();
		}
	}

	/**
	 * Creates a task removing listed images from image_review queue
	 * @param  array  $aDeletionList  An array of [ city_id, page_id ] arrays.
	 * @return void
	 */
	public function createDeleteFromQueueTask( $aDeletionList ) {
		if ( !empty( $aDeletionList ) ) {
			$task = new \Wikia\Tasks\Tasks\ImageReviewTask();
			$task->call('deleteFromQueue', $aDeletionList);
			$task->queue();
		}
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

		WikiaLogger::instance()->info( "ImageReviewLog", [
			'method' => __METHOD__,
			'message' => "Refetched " . count( $imageList ) . " images based on timestamp",
		] );

		wfProfileOut( __METHOD__ );

		return $imageList;
	}

	/**
	 * get image list
	 * @return array imageList
	 */
	public function getImageList( $timestamp, $state = ImageReviewStatuses::STATE_UNREVIEWED, $order = self::ORDER_LATEST ) {
		wfProfileIn( __METHOD__ );

		$oDB = $this->getDatawareDB( DB_MASTER );
		$oDatabaseHelper = $this->getDatabaseHelper();

		$oResults = $oDatabaseHelper->selectImagesForList( $this->getOrder( $order ), self::LIMIT_IMAGES_FROM_DB, $state );

		$rows = array();
		$updateWhere = array();
		$iconsWhere = array();
		while ( $row = $oDB->fetchObject($oResults) ) {
			$rows[] = $row;
			$updateWhere[] = "(wiki_id = {$row->wiki_id} and page_id = {$row->page_id})";
		}
		$oDB->freeResult( $oResults );

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

			$oDB->update(
				'image_review',
				$values,
				array( implode(' OR ', $updateWhere) ),
				__METHOD__
			);
		}
		$oDB->commit();

		$imageList = $unusedImages = $aDeleteFromQueueList = [];

		foreach ( $rows as $row ) {
			$record = "(wiki_id = {$row->wiki_id} and page_id = {$row->page_id})";

			if ( count( $imageList ) < self::LIMIT_IMAGES ) {
				$bDisplayImage = true;
				$oImagePage = GlobalTitle::newFromId( $row->page_id, $row->wiki_id );

				if ( $oImagePage instanceof GlobalTitle !== true ) {
					$bDisplayImage = false;
					$sReason = 'Page does not exist';
				} elseif ( $oImagePage->isRedirect() === true ) {
					$bDisplayImage = false;
					$sReason = 'Page is a redirect';
				} else {
					$oImageGlobalFile = new GlobalFile( $oImagePage );
					if ( $oImageGlobalFile->exists() === false ) {
						$bDisplayImage = false;
						$sReason = 'File does not exist';
					}
				}

				if ( $bDisplayImage === true && $oImageGlobalFile instanceof GlobalFile ) {
					$sThumbUrl = $oImageGlobalFile->getUrlGenerator()
						->width( self::IMAGE_REVIEW_THUMBNAIL_SIZE )
						->height( self::IMAGE_REVIEW_THUMBNAIL_SIZE )
						->thumbnailDown()
						->url();

					$aImageInfo = array(
						'src' => $sThumbUrl,
						'page' => $oImagePage->getFullUrl(),
						'extension' => $oImageGlobalFile->getMimeType(),
					);

					if ( strpos( 'ico', $aImageInfo['extension'] ) ) {
						$iconsWhere[] = $record;
						continue;
					} else {
						$isThumb = true; // Vignette handles .gif and .svg files

						$wikiRow = WikiFactory::getWikiByID( $row->wiki_id );

						$imageList[] = array(
							'wikiId' => $row->wiki_id,
							'pageId' => $row->page_id,
							'state' => $row->state,
							'src' => $aImageInfo['src'],
							'url' => $aImageInfo['page'],
							'priority' => $row->priority,
							'flags' => $row->flags,
							'isthumb' => $isThumb,
							'wiki_url' => isset( $wikiRow->city_url ) ? $wikiRow->city_url : '',
						);
					}
				} else {
					$aDeleteFromQueueList[] = [
						'wiki_id' => $row->wiki_id,
						'page_id' => $row->page_id,
						'reason' => $sReason,
					];
					continue;
				}
			} else {
				$unusedImages[] = $record;
			}
		}

		/**
		 * Invalid images
		 */
		if ( !empty( $aDeleteFromQueueList ) ) {
			$this->createDeleteFromQueueTask( $aDeleteFromQueueList );
		}

		/**
		 * Icons
		 */
		if ( !empty( $iconsWhere ) ) {
			$aIconsValues = [
				'state' => ImageReviewStatuses::STATE_ICO_IMAGE,
			];
			$aIconsWhere = [ implode( 'OR', $iconsWhere ) ];
			$this->imageListAdditionalAction( 'icons', $oDB, $aIconsValues, $aIconsWhere );
		}

		/**
		 * Unused images
		 */
		if ( !empty( $unusedImages ) ) {
			$aUnusedValues = [
				'reviewer_id = null',
				'state' => $state,
			];
			$aUnusedWhere = [ implode( 'OR', $unusedImages ) ];
			$this->imageListAdditionalAction( 'unused', $oDB, $aUnusedValues, $aUnusedWhere );
		}

		/**
		 * Return valid images list
		 */
		WikiaLogger::instance()->info( "ImageReviewLog", [
			'method' => __METHOD__,
			'message' => 'Fetched ' . count( $imageList ) . ' new images',
		] );

		wfProfileOut( __METHOD__ );

		return $imageList;
	}

	private function imageListAdditionalAction( $sType, DatabaseBase $oDB, Array $aValues, Array $aWhere ) {
		$iCount = count( $aWhere );
		if ( $iCount > 0 ) {
			$oDatabaseHelper = $this->getDatabaseHelper();
			$oDatabaseHelper->updateBatchImages( $aValues, $aWhere );
		}

		WikiaLogger::instance()->info( "ImageReviewLog", [
			'method' => __METHOD__,
			'message' => "Updated {$iCount} images (type {$sType})",
		] );
	}



	public function getImageCount( $sAction = false, $iImageListCount = false ) {
		wfProfileIn( __METHOD__ );

		$total = $this->stats_cache->getStats();

		/**
		 * Don't use cached results if:
		 * 1. In Unreviewed queue
		 * 2. SQL select returns 0 images
		 * 3. Cached count of unreviewed > 0
		 */
		if ( !empty( $total )
			&& ( $sAction != ImageReviewSpecialController::ACTION_UNREVIEWED
			|| $iImageListCount != 0
			|| $total[ImageReviewStatsCache::STATS_UNREVIEWED] == 0 )
		) {
			wfProfileOut( __METHOD__ );
			return $total;
		}

		static $initial_stats = [
			ImageReviewStatsCache::STATS_INVALID      => 0,
			ImageReviewStatsCache::STATS_UNREVIEWED   => 0,
			ImageReviewStatsCache::STATS_QUESTIONABLE => 0,
			ImageReviewStatsCache::STATS_REJECTED     => 0,
			ImageReviewStatsCache::STATS_REVIEWER     => 0,
		];

		$total = array_merge( $initial_stats, $total );

		$db_helper = $this->getDatabaseHelper();
		$counters = $db_helper->countImagesByState();

		if ( array_key_exists( ImageReviewStatuses::STATE_UNREVIEWED, $counters ) ) {
			$total[ImageReviewStatsCache::STATS_UNREVIEWED] = $counters[ ImageReviewStatuses::STATE_UNREVIEWED ];
		}
		if ( array_key_exists( ImageReviewStatuses::STATE_QUESTIONABLE, $counters ) ) {
			$total[ImageReviewStatsCache::STATS_QUESTIONABLE] = $counters[ ImageReviewStatuses::STATE_QUESTIONABLE ];
		}
		if ( array_key_exists( ImageReviewStatuses::STATE_REJECTED, $counters ) ) {
			$total[ImageReviewStatsCache::STATS_REJECTED] = $counters[ ImageReviewStatuses::STATE_REJECTED ];
		}
		if ( array_key_exists( ImageReviewStatuses::STATE_INVALID_IMAGE, $counters ) ) {
			$total[ImageReviewStatsCache::STATS_INVALID] = $counters[ ImageReviewStatuses::STATE_INVALID_IMAGE ];
		}

		$this->stats_cache->setStats( $total );

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

	/**
	 * reset state in abandoned work
	 * note: this is run via a cron script
	 */
	public function resetAbandonedWork() {
		wfProfileIn( __METHOD__ );

		$oDatabaseHelper = $this->getDatabaseHelper();

		$timeLimit = ( $this->wg->DevelEnvironment ) ? 1 : 3600; // 1 sec
		$sFrom = wfTimestamp(TS_DB, time() - $timeLimit );

		// for STATE_UNREVIEWED
		$oDatabaseHelper->updateResetAbandoned( $sFrom,
			ImageReviewStatuses::STATE_UNREVIEWED,
			ImageReviewStatuses::STATE_IN_REVIEW
		);

		// for STATE_QUESTIONABLE
		$oDatabaseHelper->updateResetAbandoned( $sFrom,
			ImageReviewStatuses::STATE_QUESTIONABLE,
			ImageReviewStatuses::STATE_QUESTIONABLE_IN_REVIEW
		);

		// for STATE_REJECTED
		$oDatabaseHelper->updateResetAbandoned( $sFrom,
			ImageReviewStatuses::STATE_REJECTED,
			ImageReviewStatuses::STATE_REJECTED_IN_REVIEW
		);

		wfProfileOut( __METHOD__ );
		return $sFrom;
	}

	private function getImageStatesForStats() {
		wfProfileIn( __METHOD__ );

		$key = wfMemcKey( 'ImageReviewSpecialController', 'v2', __METHOD__);
		$states = $this->wg->memc->get($key);
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
		$reviewers = $this->wg->memc->get($key);
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
}
