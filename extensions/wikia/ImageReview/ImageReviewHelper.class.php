<?php

use \Wikia\Logger\WikiaLogger;

/**
 * ImageReview Helper
 *
 * @author (contributing) Adam Karmiński <adamk@wikia-inc.com>
 */
class ImageReviewHelper extends ImageReviewHelperBase {

	private $user_id = 0;

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

		wfProfileOut( __METHOD__ );
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

		WikiaLogger::instance()->info( "ImageReview : refetched images based on timestamp", [
			'method' => __METHOD__,
			'count' => count( $imageList ),
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

		$oResults = $oDatabaseHelper->selectImagesForList( $oDB, $state, $this->getOrder( $order ), self::LIMIT_IMAGES_FROM_DB );

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

		$imageList = $unusedImages = $aDeletionList = [];

		foreach ( $rows as $row ) {
			$record = "(wiki_id = {$row->wiki_id} and page_id = {$row->page_id})";

			if ( count( $imageList ) < self::LIMIT_IMAGES ) {
				$oImagePage = GlobalTitle::newFromId( $row->page_id, $row->wiki_id );
				if ( $oImagePage instanceof GlobalTitle ) {
					$oImageGlobalFile = new GlobalFile( $oImagePage );

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
					/**
					 * CE-1068
					 * Log page_id and wiki_id for images for which GlobalTitle::newFromId returns null.
					 */
					WikiaLogger::instance()->error( "ImageReview : Null GlobalTitle",
						[
							'method' => __METHOD__,
							'pageId' => $row->page_id,
							'wikiId' => $row->wiki_id,
							'lastEdited' => $row->last_edited,
							'exception' => new Exception()
						]
					);

					$aDeletionList[] = [ $row->wiki_id, $row->page_id ];

					continue;
				}
			} else {
				$unusedImages[] = $record;
			}
		}

		/**
		 * Invalid images
		 */
		$this->createDeleteImagesTask( $aDeletionList );

		/**
		 * Icons
		 */
		$aIconsValues = [
			'state' => ImageReviewStatuses::STATE_ICO_IMAGE,
		];
		$aIconsWhere = [ implode( 'OR', $iconsWhere ) ];
		$this->imageListAdditionalAction( 'icons', $oDB, $aIconsValues, $aIconsWhere );

		/**
		 * Unused images
		 */
		$aUnusedValues = [
			'reviewer_id = null',
			'state' => $state,
		];
		$aUnusedWhere = [ implode( 'OR', $unusedImages ) ];
		$this->imageListAdditionalAction( 'unused', $oDB, $aUnusedValues, $aUnusedWhere );

		/**
		 * Return valid images list
		 */
		WikiaLogger::instance()->info( "ImageReviewImageList: fetched new images", [
			'method' => __METHOD__,
			'count' => count( $imageList ),
		] );

		wfProfileOut( __METHOD__ );

		return $imageList;
	}

	private function imageListAdditionalAction( $sType, DatabaseMysql $oDB, Array $aValues, Array $aWhere ) {
		$iCount = count( $aWhere );
		if ( $iCount > 0 ) {
			$oDatabaseHelper = $this->getDatabaseHelper();
			$oDatabaseHelper->updateBatchImages( $oDB, $aValues, $aWhere );
		}

		WikiaLogger::instance()->info( "ImageReviewImageList: updated {$sType} images.", [
			'method' => __METHOD__,
			'count' => $iCount,
		] );
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
			ImageReviewStatuses::STATE_UNREVIEWED,
			ImageReviewStatuses::STATE_INVALID_IMAGE,
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
			'invalid' => 0,
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
		if ( array_key_exists( ImageReviewStatuses::STATE_INVALID_IMAGE, $total ) ) {
			$total['invalid'] = $this->wg->Lang->formatNum( $total[ImageReviewStatuses::STATE_INVALID_IMAGE]);
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
}
