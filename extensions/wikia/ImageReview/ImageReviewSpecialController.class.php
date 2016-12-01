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

	// Map each action to an image state code in the db (eg "unreviewed", "questionable", "rejected", etc)
	const ACTION_TO_STATES = [
		self::ACTION_QUESTIONABLE => ImageStates::QUESTIONABLE,
		self::ACTION_REJECTED => ImageStates::REJECTED,
		self::ACTION_UNREVIEWED => ImageStates::UNREVIEWED
	];

	const STATS_HEADERS = [
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

	private $imageStateUpdater;
	private $imageCountGetter;
	private $statsDataGetter;

	public function __construct() {
		parent::__construct( 'ImageReview', 'imagereview', false /* $listed */ );

		$user = $this->wg->User;
		$this->accessQuestionable = $user->isAllowed( 'questionableimagereview' );
		$this->accessRejected = $user->isAllowed( 'rejectedimagereview' );
		$this->accessStats = $user->isAllowed( 'imagereviewstats' );

		$this->imageStateUpdater = new ImageStateUpdater();
		$this->imageCountGetter = new ImageCountGetter();
		$this->statsDataGetter = new StatsDataGetter();
	}

	public function init() {
		$this->setGlobalDisplayVars();
		$this->setCache();
		$this->setAssets();
	}

	protected function setGlobalDisplayVars() {
		// get more space for images
		$this->wg->OasisFluid = true;
		$this->wg->SuppressSpotlights = true;
		$this->wg->SuppressWikiHeader = true;
		$this->wg->SuppressPageHeader = true;
		$this->wg->SuppressFooter = true;
		$this->wg->Out->setPageTitle( 'Image Review tool' );
		$this->wg->Out->enableClientCache( false );
	}

	private function setCache() {
		$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );
		$this->response->sendHeaders();
	}

	private function setAssets() {
		$this->response->addAsset('extensions/wikia/ImageReview/js/jquery.onImagesLoad.js');
		$this->response->addAsset('extensions/wikia/ImageReview/js/ImageReview.js');
		$this->response->addAsset('extensions/wikia/ImageReview/css/ImageReview.scss');
	}

	public function index() {
		$this->action = $this->parseAction();
		$this->order = $this->request->getInt( 'sort' );
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

		$this->imageList = $this->getImageList();
		$this->imageCount = $this->getImageCounts();

		$this->setVariables();

		/* SUS-541 / Mix <mix@wikia.com> / scope: the following if block */
		$severity = count( $this->imageList ) < ImageListGetter::LIMIT_IMAGES
			? 'error'
			: 'success';
		$this->logImageListCompleteness( $severity );

		return true;
	}

	protected function getImageList() {
		$imageListGetter = new ImageListGetter(
			$this->ts,
			$this::ACTION_TO_STATES[$this->action],
			$this->order
		);
		return $imageListGetter->getImageList();
	}

	private function getImageCounts() {
		// Format the number locally (add ',' or '.')
		return array_map(
			function( $number ) { return $this->wg->Lang->formatNum( $number ); },
			$this->imageCountGetter->getImageCounts( $this->wg->User->getId() )
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
			'headers' => self::STATS_HEADERS,

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

		echo implode( ",", self::STATS_HEADERS ) . "\n";

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

	private function parseAction() {
		return array_key_exists( $this->getPar(), self::ALLOWED_ACTIONS ) ? $this->getPar() : self::ACTION_UNREVIEWED;
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
		if  ( $this->invalidTimestamp() )  {
			$this->redirectWithTimestampSetToNow();
			return true;
		}

		return false;
	}

	private function invalidTimestamp() : bool {
		return !$this->ts || $this->ts < 0 || $this->ts > time();
	}

	private function redirectWithTimestampSetToNow() {
		$this->wg->Out->redirect( '?ts=' . time() );
	}


	private function setVariables() {
		$this->response->setJsVar('wgImageReviewAction', $this->action);

		$query = ( empty( $this->action ) ) ? '' : '/'. $this->action;
		$baseUrl = Title::newFromText( 'ImageReview', NS_SPECIAL )->getFullURL();
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
			'baseUrl' => $baseUrl,
			'toolName' => 'Image Review',
			'submitUrl' => $baseUrl . $query,
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
