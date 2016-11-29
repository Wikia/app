<?php

use Wikia\Logger\WikiaLogger;

class ImageListGetter extends ImageReviewHelperBase {

	private $userId = 0;
	private $timestamp;
	private $state;
	private $order;

	function __construct( int $timestamp, int $state, int $order ) {
		parent::__construct();
		$this->userId = $this->wg->user->getId();
		$this->timestamp = wfTimestamp( TS_DB, $timestamp );
		$this->state = $state;
		$this->order = $order;
	}

	/**
	 * Get batch of images for Image Review Tool. Images are filtered based on
	 * state (eg, unreviewed, rejected, questionable), order (last edited, priority),
	 * and timestamp.
	 *
	 * When getting this batch of images, we first check if the timestamp matches
	 * a previously reviewed batch of images. If so, we return those images. If not,
	 * we then check to see if there are any outstanding reviews (reviews that this
	 * reviewer started on, but didn't finished by making a decision on). If so, we
	 * return those images. If not again, we'll finally create a new review and return
	 * those images to the user.
	 */
	public function getImageList() {
		$imageList = $this->fetchPreviousReviewFromTimestamp();
		if ( !empty( $imageList ) ) {
			return $imageList;
		}

		$imageList = $this->fetchUnfinishedReview();
		if ( !empty( $imageList ) ) {
			return $imageList;
		}

		return $this->fetchNewReview();
	}

	private function fetchPreviousReviewFromTimestamp() : array {
		return $this->fetchAndPrepareImageResults( function() {
			return ( new WikiaSQL() )
				->SELECT_ALL()
				->FROM( 'image_review' )
				->WHERE( 'reviewer_id' )->EQUAL_TO( $this->userId )
				->AND_( 'review_start' )->EQUAL_TO( $this->timestamp )
				->ORDER_BY( 'priority desc, last_edited desc' )
				->LIMIT( self::LIMIT_IMAGES_FROM_DB )
				->runLoop( $this->getDatawareDB(), function ( &$images, $row ) {
					$images[] = $row;
				});
			}
		);
	}

	private function fetchUnfinishedReview() {
		return $this->fetchAndPrepareImageResults( function() {
			return ( new WikiaSQL() )
				->SELECT_ALL()
				->FROM( 'image_review' )
				->AND_( 'reviewer_id' )->EQUAL_TO( $this->userId )
				->AND_( 'state' )->EQUAL_TO( $this->getInReviewState( $this->state ) )
				->ORDER_BY( 'priority desc, last_edited desc' )
				->LIMIT( self::LIMIT_IMAGES_FROM_DB )
				->runLoop( $this->getDatawareDB(), function ( &$images, $row ) {
					$images[] = $row;
				});
			}
		);
	}

	private function fetchNewReview() : array {
		return $this->fetchAndPrepareImageResults( function() {
			return ( new WikiaSQL() )
				->SELECT_ALL()
				->FROM( 'image_review' )
				->WHERE( 'state' )->EQUAL_TO( $this->state )
				->AND_( 'top_200' )->EQUAL_TO(0)
				->ORDER_BY( $this->getOrder( $this->order ) )
				->LIMIT( self::LIMIT_IMAGES_FROM_DB )
				->runLoop( $this->getDatawareDB(), function ( &$images, $row ) {
					$images[] = $row;
				});
			}
		);
	}

	private function fetchAndPrepareImageResults( callable $getImagesQuery ) {
		$deleteFromQueueList = [];
		$imageList = [];
		$iconsWhere = [];

		foreach ( $getImagesQuery() as $row ) {
			if ( count( $imageList ) == self::LIMIT_IMAGES ) {
				break;
			}

			// Grab this image now to eliminate any race conditions with other reviewers
			if ( !$this->assignImageToUser( $row ) ) {
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
	 * Creates a task removing listed images from image_review queue
	 * @param  array  $deletionList  An array of [ city_id, page_id ] arrays.
	 * @return void
	 */
	private function createDeleteFromQueueTask( $deletionList ) {
		if ( empty( $deletionList ) ) {
			return;
		}

		$task = new \Wikia\Tasks\Tasks\ImageReviewTask();
		$task->call('deleteFromQueue', $deletionList);
		$task->queue();
	}


	private function assignImageToUser( stdClass $imageRecord ) {
		// Image already assigned to user. This happens if we're pulling up
		// an old review via the timestamp, or fetching an unfinished review
		if ( $imageRecord->reviewer_id == $this->userId ) {
			return 1;
		}

		// Determine what our next state should be
		$targetState = ImageReviewStates::IN_REVIEW;

		if ( $this->state == ImageReviewStates::QUESTIONABLE ) {
			$this->state = ImageReviewStates::QUESTIONABLE_IN_REVIEW;
		} elseif ( $this->state == ImageReviewStates::REJECTED ) {
			$targetState = ImageReviewStates::REJECTED_IN_REVIEW;
		}

		$dbw = $this->getDatawareDB( DB_MASTER );
		$query = ( new WikiaSQL() )
			->UPDATE( 'image_review' )
				->SET( 'reviewer_id', $this->userId )
				->SET( 'review_start', $this->timestamp )
				->SET( 'state', $targetState )
			->WHERE( 'reviewer_id' )->IS_NULL()
				->AND_( 'wiki_id' )->EQUAL_TO( $imageRecord->wiki_id )
				->AND_( 'page_id' )->EQUAL_TO( $imageRecord->page_id );

		if ( $this->state == ImageReviewStates::QUESTIONABLE ||
		     $this->state == ImageReviewStates::REJECTED ) {
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
			return [ 'error' => 'Database for wiki does not exist' ];
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

		$values = [ 'state' => ImageReviewStates::ICO_IMAGE ];
		$where = [ implode( 'OR', $where ) ];

		$databaseHelper = $this->getDatabaseHelper();
		$databaseHelper->updateBatchImages( $values, $where );

		WikiaLogger::instance()->info( "ImageReviewLog", [
			'method' => __METHOD__,
			'message' => "Updated {$count} images (type 'icons')",
		] );
	}

	private function getInReviewState( int $state ) : int {
		if ( $state == ImageReviewStates::REJECTED ) {
			return ImageReviewStates::REJECTED_IN_REVIEW;
		}

		if ( $state == ImageReviewStates::QUESTIONABLE ) {
			return ImageReviewStates::QUESTIONABLE_IN_REVIEW;
		}

		else return ImageReviewStates::IN_REVIEW;
	}
}
