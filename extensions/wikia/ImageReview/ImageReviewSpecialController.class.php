<?php

use \Wikia\Logger\WikiaLogger;

class ImageReviewSpecialController extends WikiaSpecialPageController {

	const TOOL_NAME = 'Image Review';
	const PAGE_TITLE = 'Image Review Tool';

	const ACTION_QUESTIONABLE = 'questionable';
	const ACTION_REJECTED     = 'rejected';
	const ACTION_UNREVIEWED   = 'unreviewed';
	const ACTION_STATS   = 'stats';
	const ACTION_CSV_STATS   = 'csvstats';

	const QUESTIONABLE_PERM = 'questionableimagereview';
	const REJECTED_PERM = 'rejectedimagereview';
	const STATS_PERM = 'imagereviewstats';
	const CONTROLS_PERM =  'imagereviewcontrols';
	const IMAGE_REVIEW_PERM = 'imagereview';

	const ACTION_TO_STATUS_MAP = [
		self::ACTION_REJECTED => ImageReviewStatuses::STATE_REJECTED,
		self::ACTION_QUESTIONABLE => ImageReviewStatuses::STATE_QUESTIONABLE
	];

	const ACTION_TO_PERM_MAP = [
		self::ACTION_QUESTIONABLE => self::QUESTIONABLE_PERM,
		self::ACTION_REJECTED => self::REJECTED_PERM,
		self::ACTION_STATS => self::STATS_PERM,
	];

	private $order;
	private $imageList;
	private $imageCount;
	private $timestamp;
	private $action;
	/**
	 * @var ImageReviewHelper
     */
	private $helper;


	/**
	 * @var StatsGetter
	 */
	private $statsGetter;

	public function __construct() {
		parent::__construct( 'ImageReview', self::IMAGE_REVIEW_PERM, false /* $listed */ );
		$this->helper = new ImageReviewHelper();
		$this->action = $this->getAction();
		$this->order = $this->getOrderingMethod();
		$this->timestamp = $this->request->getVal( 'ts' );
		$this->statsGetter = new StatsGetter();
	}

	protected function setGlobalDisplayVars() {
		// get more space for images
		$this->wg->OasisFluid = true;
		$this->wg->SuppressSpotlights = true;
		$this->wg->SuppressWikiHeader = true;
		$this->wg->SuppressPageHeader = true;
		$this->wg->SuppressFooter = true;

		$this->wg->Out->setPageTitle( self::PAGE_TITLE );

		$this->wg->Out->enableClientCache( false );
	}

	public function index() {
		$this->setGlobalDisplayVars();
		$this->setCache();
		$this->setAssets();

		$this->checkUserPermissions();
		$this->checkRedirect();

		if ( $this->wg->request->wasPosted() ) {
			$this->handlePostAction();
		}

		if ( !$this->requestingAlreadySeenBatchOfImages() ) {
			$this->imageList = $this->helper->refetchImageListByTimestamp( $this->timestamp );
		} else {
			$this->imageList = [];
			$this->setTimeStampForLastBatchOfImagesSeen();
		}

		/* SUS-541 / Mix <mix@wikia.com> / scope: the following if block */
		if ( count( $this->imageList ) < ImageReviewHelper::LIMIT_IMAGES ) {
			$this->logImageListCompleteness( 'warning' );
		}

		if ( count( $this->imageList ) == 0 ) {
			$do = array( 
				self::ACTION_QUESTIONABLE	=> ImageReviewStatuses::STATE_QUESTIONABLE,
				self::ACTION_REJECTED		=> ImageReviewStatuses::STATE_REJECTED,
				'default'					=> ImageReviewStatuses::STATE_UNREVIEWED
			);

			if ( isset( $do[ $this->action ] ) ) {
				$this->imageList = $this->helper->getImageList( $this->timestamp, $do[ $this->action ], $this->order );
				$this->imageCount = $this->helper->getImageCount();
			} else {
				$this->imageList = $this->helper->getImageList( $this->timestamp, $do[ 'default' ], $this->order );
				$this->imageCount = $this->helper->getImageCount( ImageReviewSpecialController::ACTION_UNREVIEWED, count( $this->imageList ) );
			}
		} else {
			$this->imageCount = $this->helper->getImageCount();
		}

		$this->setVariables();

		/* SUS-541 / Mix <mix@wikia.com> / scope: the following if block */
		$severity = count( $this->imageList ) < ImageReviewHelper::LIMIT_IMAGES ? 'error' : 'success';
		$this->logImageListCompleteness( $severity );
	}

	public function stats() {
		$startDay = $this->request->getVal( 'startDay', date( 'd' ) );
		$startMonth = $this->request->getVal( 'startMonth', date( 'n' ) );
		$startYear = $this->request->getVal( 'startYear', date( 'Y' ) );

		$endDay = $this->request->getVal( 'endDay', date( 'd' ) );
		$endMonth = $this->request->getVal( 'endMonth', date( 'm' ) );
		$endYear = $this->request->getVal( 'endYear', date( 'Y' ) );

		$stats = $this->statsGetter->getStatsData( $startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay );

		// setup response data for table rendering
		$this->response->setData(
			[
				 'summary' => $stats['summary'],
				 'summaryHeaders' => [ 'total reviewed', 'approved', 'deleted', 'questionable', 'avg per user' ],
				 'data' => $stats['data'],
				 'headers' => StatsGetter::STATS_HEADERS,
				 'startDay' => $startDay,
				 'startMonth' => $startMonth,
				 'startYear' => $startYear,
				 'endDay' => $endDay,
				 'endMonth' => $endMonth,
				 'endYear', $endYear
			]
		);
	}


	protected function getBaseUrl() {
		return Title::newFromText( 'ImageReview', NS_SPECIAL )->getFullURL();
	}

	protected function parseImageData( $data ) {
		$images = array();

		foreach ( $data as $name => $value ) {
			if ( preg_match( '/img-(\d*)-(\d*)/', $name, $matches ) ) {
				if ( !empty( $matches[1] ) && !empty( $matches[2] ) ) {
					$images[] = array(
						'wikiId' => $matches[1],
						'pageId' => $matches[2],
						'state' => $value,
					);
				}
			}
		}

		return $images;
	}

	private function handlePostAction() {
		$data = $this->wg->request->getValues();
		if ( !empty( $data ) ) {
			$images = $this->parseImageData( $data );

			if ( count( $images ) > 0 ) {
				$this->helper->updateImageState( $images, $this->action );
			}
			$this->timestamp = null;
		}
	}

	private function getOrderingMethod() {
		if ( $this->wg->user->isAllowed( self::CONTROLS_PERM ) ) {
			$preferredOrder = (int)$this->app->wg->User->getGlobalPreference( 'imageReviewSort' );
			$order = $this->request->getInt( 'sort', $preferredOrder );

			if ( $order != $preferredOrder ) {
				$this->app->wg->User->setGlobalPreference( 'imageReviewSort', $order );
				$this->app->wg->User->saveSettings();
			}

			return $order;
		}
		return -1;
	}

	private function checkUserPermissions() {
		$permName = self::ACTION_TO_PERM_MAP[$this->action] ?? self::IMAGE_REVIEW_PERM;
		if ( $this->wg->User->isAllowed( $permName ) ) {
			throw new PermissionsError( $permName );
		}
	}

	private function checkRedirect() {
		if ( $this->action == self::ACTION_STATS ) {
			$this->forward( get_class( $this ), 'stats' );
		} elseif ( $this->action ==  self::ACTION_CSV_STATS ) {
			$this->forward( get_class( $this ), 'csvStats' );
		}

		if ( !$this->timestamp || intval( $this->timestamp ) < 0 || intval( $this->timestamp ) > time() ) {
			$this->wg->Out->redirect( $this->submitUrl . '?ts=' . time() );
		}
	}

	private function setAssets() {
		$this->response->addAsset( 'extensions/wikia/ImageReview/js/jquery.onImagesLoad.js' );
		$this->response->addAsset( 'extensions/wikia/ImageReview/js/ImageReview.js' );
		$this->response->addAsset( 'extensions/wikia/ImageReview/css/ImageReview.scss' );
	}

	private function setCache() {
		$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );
		$this->response->sendHeaders();
	}

	private function setVariables() {
		$query = ( empty( $this->getAction() ) ) ? '' : '/' . $this->getAction();
		$this->response->setData(
			[
 				'action' => $this->action,
				'order' => $this->order,
				'imageList' => $this->imageList,
				'imageCount' => $this->localizedImageCount(),
				'accessQuestionable' => $this->wg->User->isAllowed( self::QUESTIONABLE_PERM ),
				'accessStats' => $this->wg->User->isAllowed( self::STATS_PERM ),
				'accessControls' => $this->wg->user->isAllowed( self::CONTROLS_PERM ),
				'modeMsgSuffix' => empty( $this->action ) ? '' : '-' . $this->action,
				'fullUrl' => $this->wg->Title->getFullURL() ,
				'baseUrl' => $this->getBaseUrl(),
				'toolName' => self::TOOL_NAME,
				'submitUrl' => $this->getBaseUrl() . $query
			]
		);
	}

	private function localizedImageCount() {
		return array_map(
			function( $number ) {
				return $this->wg->Lang->formatNum( $number );
			} ,
			$this->imageCount
		);
	}

	private function logImageListCompleteness( $severity ) {
		WikiaLogger::instance()->debug(
			'SUS-541',
			[
				'severity' => $severity,
				'imageList' => $this->imageList,
				'exception' => new Exception
			]
		);
	}

	// TODO verify method name is actually what this logic is doing
	private function requestingAlreadySeenBatchOfImages() : bool {
		$cacheKey = $this->helper->getCacheKey( $this->wg->User->getId() );
		$mostRecentBatchSeenTimeStamp = $this->wg->Memc->get( $cacheKey );
		return $this->timestamp > $mostRecentBatchSeenTimeStamp;
	}

	private function setTimeStampForLastBatchOfImagesSeen() {
		$cacheKey = $this->helper->getCacheKey( $this->wg->User->getId() );
		$this->wg->memc->set( $cacheKey, $this->timestamp, 3600 );
	}

	private function getAction() : string {
		return $this->getPar();
	}
}
