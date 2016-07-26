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

		$this->createDeleteImagesTask( $deletionList );

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

	public static function checkImageValidity( $image ) {
		$bValidImage = true;
		$oImagePage = GlobalTitle::newFromId( $image->page_id, $image->wiki_id );
		$oImageGlobalFile = null;
		$sReason = 'unknown';

		if ( $oImagePage instanceof GlobalTitle !== true ) {
			$bValidImage = false;
			$sReason = 'Page does not exist';
		} elseif ( $oImagePage->isRedirect() === true ) {
			$bValidImage = false;
			$sReason = 'Page is a redirect';
		} else {
			$oImageGlobalFile = new GlobalFile( $oImagePage );
			if ( $oImageGlobalFile->exists() === false ) {
				$bValidImage = false;
				$sReason = 'File does not exist';
			}
		}

		if ( $bValidImage === true && $oImageGlobalFile instanceof GlobalFile ) {
			$sThumbUrl = $oImageGlobalFile->getUrlGenerator()
				->width( self::IMAGE_REVIEW_THUMBNAIL_SIZE )
				->height( self::IMAGE_REVIEW_THUMBNAIL_SIZE )
				->thumbnailDown()
				->url();

			$aImageInfo = array(
				'src' => $sThumbUrl,
				'page' => $oImagePage->getFullURL(),
				'extension' => $oImageGlobalFile->getMimeType(),
			);

			if ( strpos( 'ico', $aImageInfo['extension'] ) ) {
				return [
					'reason' => 'ico',
					'wiki_id' => $image->wiki_id,
					'page_id' => $image->page_id,
				];
			} else {
				$isThumb = true; // Vignette handles .gif and .svg files

				$wikiRow = WikiFactory::getWikiByID( $image->wiki_id );

				return [
					'reason' => 'verified',
					'wiki_id' => $image->wiki_id,
					'page_id' => $image->page_id,
					'state' => $image->state,
					'src' => $aImageInfo['src'],
					'url' => $aImageInfo['page'],
					'priority' => $image->priority,
					'flags' => $image->flags,
					'isthumb' => $isThumb,
					'wiki_url' => isset( $wikiRow->city_url ) ? $wikiRow->city_url : '',
				];
			}
		} else {
			return [
				'wiki_id' => $image->wiki_id,
				'page_id' => $image->page_id,
				'reason' => $sReason,
			];
		}
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

		$verifiedImages = [];
		$unusedImages = [];
		$invalidImages = [];
		$iconImages = [];

		foreach ( $rows as $image ) {
			$record = "(wiki_id = {$image->wiki_id} and page_id = {$image->page_id})";

			if ( count( $verifiedImages ) >= self::LIMIT_IMAGES ) {
				$unusedImages[] = $record;
				continue;
			}

			$imageInfo = $this->checkImageValidity( $image );

			switch( $imageInfo['reason'] ) {
				case 'verified':
					$verifiedImages[] = $imageInfo;
					break;
				case 'ico':
					$iconImages[] = $record;
					WikiaLogger::instance()->info( "ImageReviewLog", [
						'method' => __METHOD__,
						'message' => "Image skipped",
						'reason' => $imageInfo['reason'],
						'page_id' => $image->page_id,
						'wiki_id' => $image->wiki_id,
					] );
					break;
				default:
					WikiaLogger::instance()->info( "ImageReviewLog", [
						'method' => __METHOD__,
						'message' => "Image skipped",
						'reason' => $imageInfo['reason'],
						'page_id' => $image->page_id,
						'wiki_id' => $image->wiki_id,
					] );
					$invalidImages[] = $record;
			}
		}

		/**
		 * Invalid images
		 */
		if ( !empty( $invalidImages ) ) {
			$this->createDeleteFromQueueTask( $invalidImages );
		}

		/**
		 * Icons
		 */
		if ( !empty( $iconImages ) ) {
			$aIconsValues = [
				'state' => ImageReviewStatuses::STATE_ICO_IMAGE,
			];
			$aIconsWhere = [ implode( 'OR', $iconImages ) ];
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
			'message' => 'Fetched ' . count( $verifiedImages ) . ' new images',
		] );

		wfProfileOut( __METHOD__ );

		return $verifiedImages;
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

		$key = wfMemcKey( 'ImageReviewSpecialController', 'v2', __METHOD__ );
		$total = $this->wg->memc->get( $key, null );

		/**
		 * Don't use cached results if:
		 * 1. In Unreviewed queue
		 * 2. SQL select returns 0 images
		 * 3. Cached count of unreviewed > 0
		 */
		if ( !empty( $total )
			&& ( $sAction != 'unreviewed'
			|| $iImageListCount != 0
			|| $total['unreviewed'] == 0 )
		) {
			wfProfileOut( __METHOD__ );
			return $total;
		}

		$oDatabaseHelper = $this->getDatabaseHelper();
		$aCounts = $oDatabaseHelper->countImagesByState();

		$total = array(
			'unreviewed' => 0,
			'questionable' => 0,
			'rejected' => 0,
			'invalid' => 0,
		);

		if ( array_key_exists( ImageReviewStatuses::STATE_UNREVIEWED, $aCounts ) ) {
			$total['unreviewed'] = $this->wg->Lang->formatNum( $aCounts[ ImageReviewStatuses::STATE_UNREVIEWED ] );
		}
		if ( array_key_exists( ImageReviewStatuses::STATE_QUESTIONABLE, $aCounts ) ) {
			$total['questionable'] = $this->wg->Lang->formatNum( $aCounts[ ImageReviewStatuses::STATE_QUESTIONABLE ] );
		}
		if ( array_key_exists( ImageReviewStatuses::STATE_REJECTED, $aCounts ) ) {
			$total['rejected'] = $this->wg->Lang->formatNum( $aCounts[ ImageReviewStatuses::STATE_REJECTED ] );
		}
		if ( array_key_exists( ImageReviewStatuses::STATE_INVALID_IMAGE, $aCounts ) ) {
			$total['invalid'] = $this->wg->Lang->formatNum( $aCounts[ ImageReviewStatuses::STATE_INVALID_IMAGE ] );
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
