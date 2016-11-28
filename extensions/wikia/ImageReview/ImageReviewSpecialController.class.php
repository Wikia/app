<?php

use Wikia\Logger\WikiaLogger;

class ImageReviewSpecialController extends WikiaSpecialPageController {
	const ACTION_QUESTIONABLE = 'questionable';
	const ACTION_REJECTED     = 'rejected';
	const ACTION_UNREVIEWED   = 'unreviewed';
	const ACTION_STATS   = 'stats';
	const ACTION_CSVSTATS   = 'csvstats';

	// These are the valid modes of operation for Special:ImageReview
	const ALLOWED_ACTIONS = [
		self::ACTION_QUESTIONABLE => true,
		self::ACTION_REJECTED => true,
		self::ACTION_UNREVIEWED => true,
		self::ACTION_STATS => true,
		self::ACTION_CSVSTATS => true
	];

	// Map each action to the pool of images we can pull from when getting new images
	const ACTION_TO_STATUS_CODE = [
		self::ACTION_QUESTIONABLE => ImageReviewStates::QUESTIONABLE,
		self::ACTION_REJECTED => ImageReviewStates::REJECTED,
		self::ACTION_UNREVIEWED => ImageReviewStates::UNREVIEWED
	];

	// Map each action to the pool of images already in review when showing images in progress
	const REVIEW_STATE_FOR_ACTION = [
		self::ACTION_QUESTIONABLE => ImageReviewStates::QUESTIONABLE_IN_REVIEW,
		self::ACTION_REJECTED => ImageReviewStates::REJECTED_IN_REVIEW,
		self::ACTION_UNREVIEWED => ImageReviewStates::IN_REVIEW
	];

	private $statsHeaders = [
		'user',
		'total reviewed',
		'approved',
		'deleted',
		'qustionable',
		'distance to avg.'
	];

	private $action;
	private $order;
	private $imageList;
	private $imageCount;
	private $ts;

	private $accessQuestionable;
	private $accessRejected;
	private $accessStats;
	private $submitUrl;
	private $baseUrl;

	/** @var ImageReviewHelper */
	private $helper;

	private $imageStateUpdater;
	private $imageCountGetter;
	private $statsDataGetter;

	public function __construct() {
		parent::__construct( 'ImageReview', 'imagereview', false /* $listed */ );

		$user = $this->wg->User;
		$this->accessQuestionable = $user->isAllowed( 'questionableimagereview' );
		$this->accessRejected = $user->isAllowed( 'rejectedimagereview' );
		$this->accessStats = $user->isAllowed( 'imagereviewstats' );
		$this->baseUrl = $this->getBaseUrl();

		$this->helper = $this->getHelper();
		$this->imageStateUpdater = new ImageStateUpdater();
		$this->imageCountGetter = new ImageCountGetter();
		$this->statsDataGetter = new StatsDataGetter();
	}

	protected function setGlobalDisplayVars() {
		// get more space for images
		$this->wg->OasisFluid = true;
		$this->wg->SuppressSpotlights = true;
		$this->wg->SuppressWikiHeader = true;
		$this->wg->SuppressPageHeader = true;
		$this->wg->SuppressFooter = true;

		$this->wg->Out->setPageTitle($this->getPageTitle());

		$this->wg->Out->enableClientCache( false );
	}

	public function index() {
		$this->setGlobalDisplayVars();

		$this->action = $this->parseAction();
		$this->order = $this->getOrderingMethod();
		$this->ts = $this->request->getVal( 'ts' );

		$this->checkUserPermissions();

		if ( $this->checkHandleStats() ) {
			// Return true to stop executing index but make sure to render the template
			return true;
		}

		if ( $this->wg->request->wasPosted() ) {
			$this->handlePostAction();
		}

		if ( $this->checkRedirect() ) {
			// Return false to stop any template rendering
			return false;
		}

		$this->setCache();
		$this->setAssets();

		$this->imageList = $this->getImageList();
		$this->imageCount = $this->getImageCounts();

		$this->setVariables();

		/* SUS-541 / Mix <mix@wikia.com> / scope: the following if block */
		$severity = count( $this->imageList ) < ImageReviewHelper::LIMIT_IMAGES
			? 'error'
			: 'success';
		$this->logImageListCompleteness( $severity );

		return true;
	}

	protected function getImageList() {
		return $this->helper->getImageList( $this->ts, $this::ACTION_TO_STATUS_CODE[$this->action], $this->order );
	}

	private function getImageCounts() {
		// Format the number locally (add ',' or '.')
		return array_map(
			function( $number ) { return $this->wg->Lang->formatNum( $number ); },
			$this->imageCountGetter->getImageCounts()
		);
	}

	public function stats() {
		$startDay = $this->request->getVal( 'startDay', date( 'd' ) );
		$startMonth = $this->request->getVal( 'startMonth', date( 'n' ) );
		$startYear = $this->request->getVal( 'startYear', date( 'Y' ) );

		$endDay = $this->request->getVal( 'endDay', date( 'd' ) );
		$endMonth = $this->request->getVal( 'endMonth', date( 'm' ) );
		$endYear = $this->request->getVal( 'endYear', date( 'Y' ) );

		$stats = $this->getStatsData(
			$startYear, $startMonth, $startDay,
			$endYear, $endMonth, $endDay
		);

		// setup response data for table rendering
		$this->response->setValues( [
			'summary' => $stats['summary'],
			'summaryHeaders' => [
				'total reviewed', 'approved', 'deleted', 'questionable', 'avg per user'
			],

			'data' => $stats['data'],
			'headers' => $this->statsHeaders,

			'startDay' => $startDay,
			'startMonth' => $startMonth,
			'startYear' => $startYear,

			'endDay' => $endDay,
			'endMonth' => $endMonth,
			'endYear' => $endYear ,
		] );

		return true;
	}

	public function csvStats() {
		$this->wg->Out->setArticleBodyOnly( true );

		$startDay = $this->request->getVal( 'startDay', date( 'd' ) );
		$startMonth = $this->request->getVal( 'startMonth', date( 'n' ) );
		$startYear = $this->request->getVal( 'startYear', date( 'Y' ) );

		$endDay = $this->request->getVal( 'endDay', date( 'd' ) );
		$endMonth = $this->request->getVal( 'endMonth', date( 'm' ) );
		$endYear = $this->request->getVal( 'endYear', date( 'Y' ) );

		$stats = $this->getStatsData(
			$startYear, $startMonth, $startDay,
			$endYear, $endMonth, $endDay
		);

		$name = "ImageReviewStats-$startYear-$startMonth-$startDay-to-$endYear-$endMonth-$endDay";

		header("Pragma: public");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header('Content-Type: text/force-download');

		header('Content-Disposition: attachment; filename="' . $name . '.csv"');

		echo implode( ",", $this->statsHeaders ) . "\n";

		foreach ( $stats['data'] as $dataRow ) {
			echo implode( ",", $dataRow ) . "\n";
		}

		return false;
	}

	protected function getStatsData( $startYear, $startMonth, $startDay,
	                                 $endYear, $endMonth, $endDay ) {

		return $this->statsDataGetter->getStatsData(
			$startYear, $startMonth, $startDay,
			$endYear, $endMonth, $endDay
		);
	}

	protected function getPageTitle() {
		return 'Image Review tool';
	}

	protected function getHelper() {
		return new ImageReviewHelper();
	}

	protected function getBaseUrl() {
		return Title::newFromText('ImageReview', NS_SPECIAL)->getFullURL();
	}

	protected function getToolName() {
		return 'Image Review';
	}

	protected function getStatsPageTitle() {
		return 'Image Review tool statistics';
	}

	protected function parseImageData($data) {
		$images = [];

		foreach( $data as $name => $value ) {
			if ( preg_match( '/img-(\d*)-(\d*)/', $name, $matches ) ) {
				if ( !empty($matches[1]) && !empty($matches[2]) ) {
					$images[] = [
						'wikiId' => $matches[1],
						'pageId' => $matches[2],
						'state' => $value,
					];
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
				$this->imageStateUpdater->update( $images, $this->wg->User->getId() );
			}
			$this->ts = null;
		}
	}

	private function getOrderingMethod() {
		if ($this->wg->user->isAllowed( 'imagereviewcontrols' )) {
			$preferedOrder = (int)$this->app->wg->User->getGlobalPreference( 'imageReviewSort' );
			$order = $this->request->getInt( 'sort', $preferedOrder );

			if ( $order != $preferedOrder ) {
				$this->app->wg->User->setGlobalPreference( 'imageReviewSort', $order );
				$this->app->wg->User->saveSettings();
			}

			return $order;
		}
		return -1;
	}

	private function parseAction() {
		$pathParts = explode( '/', $this->getPar() );
		
		// If there are path parts, try to find the action.  Explode *always* returns an
		// array even if the content its "exploding" is empty or null.  In those cases it
		// bizarrely returns an array with one null item.  So just check that the first
		// element of this array is not empty.
		if ( !empty( $pathParts[0] ) ) {
			$action = array_pop( $pathParts );
			return empty( self::ALLOWED_ACTIONS ) ? self::ACTION_UNREVIEWED : $action;
		}

		// Return the default action
		return self::ACTION_UNREVIEWED;
	}

	private function checkUserPermissions() {
		// check permissions
		if ( !$this->specialPage->userCanExecute( $this->wg->User ) ) {
			$this->specialPage->displayRestrictionError();
			return false;
		} elseif ( $this->action == self::ACTION_QUESTIONABLE && !$this->accessQuestionable ) {
			$this->specialPage->displayRestrictionError();
			return false;
		} elseif ( $this->action == self::ACTION_REJECTED && !$this->accessRejected ) {
			$this->specialPage->displayRestrictionError();
			return false;
		} elseif ( in_array( $this->action, [ self::ACTION_STATS, self::ACTION_CSVSTATS ] ) &&
		     !$this->accessStats ) {
			$this->specialPage->displayRestrictionError();
			return false;
		}

		return true;
	}

	private function checkHandleStats() {
		if ( $this->action == 'stats' ) {
			$this->forward( get_class( $this ), 'stats' );
			return true;
		}

		if ( $this->action == 'csvstats' ) {
			$this->forward( get_class( $this ), 'csvStats' );
			return true;
		}

		return false;
	}

	private function checkRedirect() {
		if ( !$this->ts || $this->ts < 0 || $this->ts > time() ) {
			$state = self::REVIEW_STATE_FOR_ACTION[ $this->action ];
			$dbType = $this->wg->request->wasPosted() ? DB_MASTER : DB_SLAVE;

			$existingTs = $this->helper->findExistingReviewTs( $state, $dbType );
			$ts = $existingTs ?: time();
			$this->wg->Out->redirect( $this->submitUrl. '?ts=' . $ts );
			return true;
		}

		return false;
	}

	private function setAssets() {
		$this->response->addAsset('extensions/wikia/ImageReview/js/jquery.onImagesLoad.js');
		$this->response->addAsset('extensions/wikia/ImageReview/js/ImageReview.js');
		$this->response->addAsset('extensions/wikia/ImageReview/css/ImageReview.scss');
	}

	private function setCache() {
		$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );
		$this->response->sendHeaders();
	}

	private function setVariables() {
		$query = ( empty( $this->action ) ) ? '' : '/'. $this->action;

		$this->response->setJsVar('wgImageReviewAction', $this->action);

		$this->response->setValues( [
			'action' => $this->action,
			'order' => $this->order,
			'imageList' => $this->imageList,
			'imageCount' => $this->imageCount,
			'accessRejected' => $this->accessRejected,
			'accessQuestionable' => $this->accessQuestionable,
			'accessStats' => $this->wg->User->isAllowed( 'imagereviewstats' ),
			'accessControls' => $this->wg->user->isAllowed( 'imagereviewcontrols' ),
			'modeMsgSuffix' => empty( $this->action ) ? '' : '-' . $this->action,
			'fullUrl' => $this->wg->Title->getFullURL(),
			'baseUrl' => $this->baseUrl,
			'toolName' => $this->getToolName(),
			'submitUrl' => $this->baseUrl . $query,
		] );
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
}
