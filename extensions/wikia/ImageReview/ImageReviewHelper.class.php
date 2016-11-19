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
	private $statsCache;
	
	function __construct() {
		parent::__construct();
		$this->user_id = $this->wg->user->getId();
		$this->statsCache = new ImageReviewStatsCache( $this->user_id );
	}

	/**
	 * update image state
	 * @param array $images
	 * @param string $action
	 */
	public function updateImageState( $images, $action = '' ) {
		wfProfileIn( __METHOD__ );

		$deletionList = [];
		$statsInsert = [];

		$sqlWhere = [
			ImageReviewStatuses::STATE_APPROVED => [],
			ImageReviewStatuses::STATE_REJECTED => [],
			ImageReviewStatuses::STATE_QUESTIONABLE => [],
		];

		foreach ( $images as $image ) {
			$sqlWhere[ $image['state'] ][] = "( wiki_id = $image[wikiId] AND page_id = $image[pageId]) ";

			if ( $image['state'] == ImageReviewStatuses::STATE_DELETED ) {
				$deletionList[] = [ $image['wikiId'], $image['pageId'] ];
			}

			$statsInsert[] = [
				'wiki_id' => $image['wikiId'],
				'page_id' => $image['pageId'],
				'review_state' => $image['state'],
				'reviewer_id' => $this->user_id
			 ];
		}

		$db = $this->getDatawareDB( DB_MASTER );
		foreach( $sqlWhere as $state => $where ) {
			if ( !empty($where) ) {
				$db->update(
					'image_review',
					[
						'reviewer_id' => null,
						'state' => $state,
						'review_end = now()',
					],
					[ implode(' OR ', $where ) ],
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
				$this->statsCache->offsetStats( ImageReviewStatsCache::STATS_REVIEWER, $reviewed );
				$this->statsCache->offsetStats( ImageReviewStatsCache::STATS_UNREVIEWED, -$reviewed );
				$this->statsCache->offsetStats( ImageReviewStatsCache::STATS_REJECTED, $rejected );
				$this->statsCache->offsetStats( ImageReviewStatsCache::STATS_QUESTIONABLE, $questionable );
				break;
			case ImageReviewSpecialController::ACTION_QUESTIONABLE:
				$this->statsCache->offsetStats( ImageReviewStatsCache::STATS_REVIEWER, $approved + $rejected );
				$this->statsCache->offsetStats( ImageReviewStatsCache::STATS_QUESTIONABLE, -( $approved + $rejected) );
				break;
			case ImageReviewSpecialController::ACTION_REJECTED:
				$this->statsCache->offsetStats( ImageReviewStatsCache::STATS_UNREVIEWED, -$reviewed );
				$this->statsCache->offsetStats( ImageReviewStatsCache::STATS_REJECTED, -( $approved + $deleted) );
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
	 * @param  array  $deletionList  An array of [ city_id, page_id ] arrays.
	 * @return void
	 */
	public function createDeleteFromQueueTask( $deletionList ) {
		if ( empty( $deletionList ) ) {
			return;
		}

		$task = new \Wikia\Tasks\Tasks\ImageReviewTask();
		$task->call('deleteFromQueue', $deletionList);
		$task->queue();
	}

	/**
	 * Look in the DB for any reviews already started and get the timestamp for the earliest one
	 * found.  Used when a request to Special:ImageReview does not include a 'ts=' parameter.
	 *
	 * @param int $state The state of the review tool to find images for
	 * @param int $dbType Optional DB type.  Useful when the DB has just been updated and slave
	 *                    lag can create race conditions
	 *
	 * @return bool|mixed
	 *
	 * @throws Exception
	 */
	public function findExistingReviewTs( $state, $dbType = DB_SLAVE ) {
		$dbh = $this->getDatawareDB( $dbType );

		return ( new WikiaSQL() )
			->SELECT( 'UNIX_TIMESTAMP(MIN(review_start))' )->AS_( "ts" )
			->FROM( 'image_review' )
			->WHERE( 'reviewer_id' )->EQUAL_TO( $this->user_id )
			->AND_( 'state' )->EQUAL_TO( $state )
			->run( $dbh, function( ResultWrapper $result ) {
		        $row = $result->fetchObject();
				if ( $row ) {
					return $row->ts;
				}
				return null;
		      } );
	}

	/**
	* Get image list from reviewer id based on the timestamp
	* Note: Does NOT update image state
	 *
	* @param integer $timestamp review_end
	* @return array images
	*/
	public function refetchImageListByTimestamp( $timestamp ) {
		wfProfileIn( __METHOD__ );

		$db = $this->getDatawareDB( DB_SLAVE );

		// try to re-fetch the previous set of images
		// TODO: optimize it, so we don't do it on every request

		$review_start = wfTimestamp( TS_DB, $timestamp );

		$result = $db->select(
			[  'image_review'  ],
			[  'wiki_id, page_id, state, flags, priority'  ],
			[
				'review_start'	=> $review_start,
				'reviewer_id'	=> $this->user_id
			],
			__METHOD__,
			[
				'ORDER BY' => 'priority desc, last_edited desc',
				'LIMIT' => self::LIMIT_IMAGES
			]
		);

		$imageList = [];
		while ( $row = $db->fetchObject( $result ) ) {
			$img = ImagesService::getImageSrc( $row->wiki_id, $row->page_id );
			$wikiRow = WikiFactory::getWikiByID( $row->wiki_id );
			$tmp = [
				'wikiId' 	=> $row->wiki_id,
				'pageId' 	=> $row->page_id,
				'state' 	=> $row->state,
				'src' 		=> $img['src'],
				'priority' 	=> $row->priority,
				'url' 		=> $img['page'],
				'flags' 	=> $row->flags,
				'wiki_url' 	=> isset( $wikiRow->city_url ) ? $wikiRow->city_url : '',
				'user_page' => '', // @TODO fill this with url to user page
			];

			if(	!empty( $tmp['src'] ) && !empty( $tmp['url'] ) ) {
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
	 * Get image list
	 *
	 * @param $timestamp
	 * @param int $state
	 * @param int $order
	 * 
	 * @return array imageList
	 *
	 * @throws DBUnexpectedError
	 * @throws Exception
	 * @throws MWException
	 */
	public function getImageList( $timestamp, $state = ImageReviewStatuses::STATE_UNREVIEWED, $order = self::ORDER_LATEST ) {
		// Get the start date to use for all images collected here
		$reviewStart = wfTimestamp( TS_DB, $timestamp );

		$deleteFromQueueList = [];
		$imageList = [];
		$iconsWhere = [];

		// Set a hard and soft limit for stopping the loop.  The soft limit changes
		// only when an image matches, the hard limit changes for every iteration.
		$hardNum = self::LIMIT_IMAGES_FROM_DB;
		$softNum = self::LIMIT_IMAGES;

		$imageIter = $this->getLatestImageIter( $order, $state );

		while ( $softNum && $hardNum && $row = $imageIter() ) {
			$hardNum--;

			// Grab this image now to eliminate any race conditions with other reviewers
			if ( !$this->assignImageToUser( $reviewStart, $state, $row ) ) {
				// If we failed to assign this image to ourselves, try the next
				continue;
			}

			$imageInfo = $this->getImageData( $row );

			// If we failed to load this image, remove it from the review queue
			if ( !empty( $imageInfo['error'] ) ) {
				$deleteFromQueueList[] = [
					'wiki_id' => $row->wiki_id,
					'page_id' => $row->page_id,
					'reason' => $imageInfo['error'],
				];
				continue;
			}

			// If this is an icon, put it in a separate queue
			if ( strpos( 'ico', $imageInfo['extension'] ) ) {
				$iconsWhere[] = "(wiki_id = {$row->wiki_id} and page_id = {$row->page_id})";
				continue;
			}

			$imageList[] = $imageInfo;
			$softNum--;
		}

		// Remove invalid images
		$this->createDeleteFromQueueTask( $deleteFromQueueList );

		// Move icons to different state
		$this->moveImagesToIcoStateFromWhere( $iconsWhere );

		// Return valid images list
		WikiaLogger::instance()->info( 'ImageReviewLog', [
			'method' => __METHOD__,
			'message' => 'Fetched ' . count( $imageList ) . ' new images',
		] );

		return $imageList;
	}

	/**
	 * Return an iterator that keeps fetching images from the review table that are in state $state.
	 * It is the callers responsibility to either update the value of the state column in the DB
	 * such that this iterator will eventually run out of matching images, or end the loop
	 * explicitly after a set number of rows.
	 *
	 * @param $order
	 * @param $state
	 * @return Closure
	 */
	private function getLatestImageIter( $order, $state ) {
		$dbh = $this->getDatawareDB( DB_SLAVE );
		$helper = $this->getDatabaseHelper();
		$orderBy = $this->getOrder( $order );
		$limit = self::LIMIT_IMAGES_FROM_DB;

		return function () use ( $dbh, $helper, $orderBy, $limit, $state ) {
			static $rows;

			if ( empty( $rows ) ) {
				$results = $helper->selectImagesForList( $orderBy, $limit, $state );
				if ( $results->numRows() == 0 ) {
					$dbh->freeResult( $results );

					return null;
				}

				while ( $row = $dbh->fetchObject( $results ) ) {
					$rows[] = $row;
				}
				$dbh->freeResult( $results );
			}

			return array_shift( $rows );
		};
	}

	private function assignImageToUser( $reviewStart, $state, stdClass $imageRecord ) {
		// Determine what our next state should be
		$targetState = ImageReviewStatuses::STATE_IN_REVIEW;

		if ( $state == ImageReviewStatuses::STATE_QUESTIONABLE ) {
			$targetState = ImageReviewStatuses::STATE_QUESTIONABLE_IN_REVIEW;
		} elseif ( $state == ImageReviewStatuses::STATE_REJECTED ) {
			$targetState = ImageReviewStatuses::STATE_REJECTED_IN_REVIEW;
		}

		$dbw = $this->getDatawareDB( DB_MASTER );
		$query = ( new WikiaSQL() )
			->UPDATE( 'image_review' )
				->SET( 'reviewer_id', $this->user_id )
				->SET( 'review_start', $reviewStart )
				->SET( 'state', $targetState )
			->WHERE( 'reviewer_id' )->IS_NULL()
				->AND_( 'wiki_id' )->EQUAL_TO( $imageRecord->wiki_id )
				->AND_( 'page_id' )->EQUAL_TO( $imageRecord->page_id );

		if ( $state == ImageReviewStatuses::STATE_QUESTIONABLE ||
		     $state == ImageReviewStatuses::STATE_REJECTED ) {
			$query->SET( 'review_end', '0000-00-00 00:00:00' );
		}

		$query->run( $dbw );
		$affectedRows = $dbw->affectedRows();
		$dbw->commit();

		return $affectedRows;
	}

	/**
	 * Given data from the image_review table, pull additional details like image URL, extension
	 * and wiki URL.
	 *
	 * @param stdClass $imageRecord A row from the image_review table
	 *
	 * @return array
	 */
	private function getImageData( stdClass $imageRecord ) {
		$imageInfo = $this->getBaseImageInfo( $imageRecord->wiki_id, $imageRecord->page_id );
		if ( !empty( $imageInfo['error'] ) ) {
			return $imageInfo;
		}

		$wikiRow = WikiFactory::getWikiByID( $imageRecord->wiki_id );
		$cityUrl = !empty( $wikiRow ) && $wikiRow->city_url ? $wikiRow->city_url : '';

		return [
			'wikiId' => $imageRecord->wiki_id,
			'pageId' => $imageRecord->page_id,
			'state' => $imageRecord->state,
			'src' => $imageInfo['src'],
			'url' => $imageInfo['page'],
			'extension' => $imageInfo['extension'],
			'priority' => $imageRecord->priority,
			'flags' => $imageRecord->flags,
			'isthumb' => true,
			'wiki_url' => $cityUrl,
		];
	}

	private function getBaseImageInfo( $wikiId, $pageId ) {
		$result = $this->getImageGlobalFile( $wikiId, $pageId );
		if ( !empty( $result['error'] ) ) {
			return $result;
		}
		/** @var GlobalFile $imageGlobalFile */
		$imageGlobalFile = $result['file'];
		/** @var GlobalTitle $imageGlobalPage */
		$imageGlobalPage = $result['page'];

		$thumbUrl = $imageGlobalFile->getUrlGenerator()
			->width( self::IMAGE_REVIEW_THUMBNAIL_SIZE )
			->height( self::IMAGE_REVIEW_THUMBNAIL_SIZE )
			->thumbnailDown()
			->url();

		return [
			'src' => $thumbUrl,
			'page' => $imageGlobalPage->getFullURL(),
			'extension' => $imageGlobalFile->getMimeType(),
		];
	}

	/**
	 * @param $pageId
	 * @param $wikiId
	 *
	 * @return array
	 *
	 * @throws Exception
	 */
	private function getImageGlobalFile( $wikiId, $pageId ) {
		try {
			$imagePage = GlobalTitle::newFromId( $pageId, $wikiId );
		} catch ( Exception $e ) {
			return [ 'error' => 'Datbase for wiki does not exist' ];
		}

		if ( !$imagePage instanceof GlobalTitle ) {
			return [ 'error' => 'Page does not exist' ];
		}

		if ( $imagePage->isRedirect() ) {
			return [ 'error' => 'Page is a redirect' ];
		}

		$imageGlobalFile = new GlobalFile( $imagePage );
		if ( !$imageGlobalFile->exists() ) {
			return [ 'error' => 'File does not exist' ];
		}

		return [
			'file' => $imageGlobalFile,
		    'page' => $imagePage,
		];
	}

	private function moveImagesToIcoStateFromWhere( array $where ) {
		$count = count( $where );
		if ( $count <= 0 ) {
			return;
		}

		$values = [ 'state' => ImageReviewStatuses::STATE_ICO_IMAGE ];
		$where = [ implode( 'OR', $where ) ];

		$databaseHelper = $this->getDatabaseHelper();
		$databaseHelper->updateBatchImages( $values, $where );

		WikiaLogger::instance()->info( "ImageReviewLog", [
			'method' => __METHOD__,
			'message' => "Updated {$count} images (type 'icons')",
		] );
	}

	public function clearCachedImageCount() {
		$this->statsCache->clearStats();
	}

	public function getCachedImageCount() {
		return $this->statsCache->getStats();
	}

	public function getImageCount() {
		$total = $this->getCachedImageCount();

		// IF we we have a non-zero number of unreviewed images in the cache, use it
		if ( !empty( $total[ImageReviewStatsCache::STATS_UNREVIEWED] ) &&
			$total[ImageReviewStatsCache::STATS_UNREVIEWED] >= 0 ) {
			return $total;
		}

		static $initialStats = [
			ImageReviewStatsCache::STATS_INVALID      => 0,
			ImageReviewStatsCache::STATS_UNREVIEWED   => 0,
			ImageReviewStatsCache::STATS_QUESTIONABLE => 0,
			ImageReviewStatsCache::STATS_REJECTED     => 0,
			ImageReviewStatsCache::STATS_REVIEWER     => 0,
		];

		$total = array_merge( $initialStats, $total );

		$dbHelper = $this->getDatabaseHelper();
		$counters = $dbHelper->countImagesByState();

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

		$this->statsCache->setStats( $total );

		return $total;
	}

	public function getStatsData( $startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay ) {

		$startDate = $startYear . '-' . $startMonth . '-' . $startDay . ' 00:00:00';
		$endDate = $endYear . '-' . $endMonth . '-' . $endDay . ' 23:59:59';

		$summary = [
			'all' => 0,
			ImageReviewStatuses::STATE_APPROVED 	=> 0,
			ImageReviewStatuses::STATE_REJECTED 	=> 0,
			ImageReviewStatuses::STATE_QUESTIONABLE => 0,
			'avg' => 0,
		 ];
		$data = [];
		$total = $avg = 0;

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

				$query = [];
				foreach ( array_keys( $summary ) as $review_state ) {
					# union query: mysql explain: Using where; Using index and max 150k rows
					$query[] = $dbr->selectSQLText(
						[ 'image_review_stats' ],
						[ 'review_state', 'count(*) as cnt' ],
						[
							"review_state"	=> $review_state,
							"reviewer_id"	=> $reviewer,
							"review_end between '{$startDate}' AND '{$endDate}'"
						],
						__METHOD__
					);
				}

				# Join the two fast queries, and sort the result set
				$sql = $dbr->unionQueries( $query, false );
				$res = $dbr->query( $sql, __METHOD__ );

				while ( $row = $dbr->fetchObject( $res ) ) {
					if ( !empty( $row->review_state ) ) {
						if ( !isset( $data[ $reviewer ] ) ) {
							$data[ $reviewer ] = [
								'name' => $user->getName(),
								'total' => 0,
								ImageReviewStatuses::STATE_APPROVED => 0,
								ImageReviewStatuses::STATE_REJECTED => 0,
								ImageReviewStatuses::STATE_QUESTIONABLE => 0,
							];
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

		return [
			'summary' => $summary,
			'data' => $data,
		 ];
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

	private function getReviewersForStats() {
		wfProfileIn( __METHOD__ );

		$key = wfMemcKey( 'ImageReviewSpecialController', 'v2', __METHOD__);
		$reviewers = $this->wg->memc->get($key);
		if ( empty($reviewers) ) {
			$reviewers = [];
			$db = $this->getDatawareDB( DB_SLAVE );

			# MySQL explain: Using where; Using index for group-by
			$result = $db->select(
				[ 'image_review_stats' ],
				[ 'reviewer_id' ],
				[ 'reviewer_id > 0' ],
				__METHOD__,
				[ 'GROUP BY' => 'reviewer_id' ]
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
