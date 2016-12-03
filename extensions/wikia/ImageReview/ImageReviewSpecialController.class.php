<?php

use Wikia\Logger\WikiaLogger;

class ImageReviewSpecialController extends WikiaSpecialPageController {
	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

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
	private $timestamp;

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
		$this->timestamp = $this->request->getVal( 'ts' );

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
		$severity = count( $this->imageList ) < ImageListGetter::LIMIT_IMAGES && $this->action == self::ACTION_UNREVIEWED
			? 'error'
			: 'success';
		$this->logImageListCompleteness( $severity );

		return true;
	}

	protected function getImageList() {
		$imageListGetter = new ImageListGetter(
			$this->timestamp,
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
			'summaryTableHTML' => $this->getStatsSummaryTableHTML( $stats['summary'] ),
			'userTableHTML' => $this->getStatsUserTableHtml( self::STATS_HEADERS, $stats['data'] ),
			'startDay' => $startDay,
			'startMonth' => $startMonth,
			'startYear' => $startYear,
			'endDay' => $endDay,
			'endMonth' => $endMonth,
			'endYear' => $endYear ,
			'dates' => $this->getStatsDates()
		] );

		return true;
	}

	/**
	 * Generate html table for mustache template
	 * @param $stats
	 * @return string
	 */
	private function getStatsSummaryTableHTML( $stats ) {
		return Xml::buildTable( [ $stats ], [ 'class' => 'wikitable' ], ['total reviewed', 'approved', 'deleted', 'questionable', 'avg per user'] );
	}

	/**
	 * Generate html for the user table for mustache template
	 * @param $headers table headers
	 * @param $data	data for the table
	 * @return string generated html
	 */
	private function getStatsUserTableHtml( $headers, $data ) {
		return Xml::buildTable( $data, [ 'class' => 'wikitable sortable' ], $headers );
	}

	/**
	 * Add calendar data to build the date select boxes. The same logic is used as the previous
	 * PHP template.
	 * @return array
	 */
	private function getStatsDates() {
		$dates = [];
		$dates['prefixes'] = ['start', 'end'];

		// Add days option lists (using the same 31 day logic as before)
		for ( $i = 1; $i <= 31; $i++ ) {
			$dates['days'][] = $i;
		}

		/** @var Language $wgLang */
		global $wgLang;
		for ( $i = 1; $i <= 12; $i++ ) {
			$dates['months'][] = [
				'name' => $wgLang->getMonthName( $i ),
				'value' => $i,
				'selected' => $i === 12 ? 'selected' : ''
			];
		}

		// Add years
		for ( $i = 2012; $i <= date( 'Y' ); $i++ ) {
			$dates['years'][] = [
				'value' => $i,
				'selected' => $i == date( 'Y' ) ? 'selected' : ''
			];
		}

		return $dates;
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
			$this->timestamp = null;
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
		return !$this->timestamp || $this->timestamp < 0 || $this->timestamp > time();
	}

	private function redirectWithTimestampSetToNow() {
		$this->wg->Out->redirect( '?ts=' . time() );
	}


	private function setVariables() {
		$this->response->setJsVar('wgImageReviewAction', $this->action);

		$query = ( empty( $this->action ) ) ? '' : '/'. $this->action;
		$baseUrl = Title::newFromText( 'ImageReview', NS_SPECIAL )->getFullURL();
		$modeMsgSuffix = $this->getModMsgSuffix();

		$sortSelect = new XmlSelect( 'sort', 'sort', intval( $this->order ) );
		$sortSelect->addOptions( [
			'latest first' => 0,
			'by priority and recency' => 1,
			'oldest first' => 2,
		]);

		$this->response->setValues( [
			'action' => $this->action,
			'order' => $this->order,
			'imageList' => $this->imageList,
			'imageCount' => $this->imageCount,
			'hasImages' => count( $this->imageList ) > 0,
			'accessRejected' => $this->accessRejected,
			'accessQuestionable' => $this->accessQuestionable,
			'accessStats' => $this->wg->User->isAllowed( 'imagereviewstats' ),
			'accessControls' => $this->wg->user->isAllowed( 'imagereviewcontrols' ),
			'modeMsgSuffix' => $modeMsgSuffix,
			'fullUrl' => $this->wg->Title->getFullURL(),
			'baseUrl' => $baseUrl,
			'toolName' => 'Image Review',
			'submitUrl' => $baseUrl . $query,
			'wfMessages' => [
				'imagereview-gotoimage' => wfMessage( 'imagereview-gotoimage' )->escaped(),
				'imagereview-option-delete' => wfMessage( 'imagereview-option-delete' )->escaped(),
				'imagereview-label-delete' => wfMessage( 'imagereview-label-delete' )->escaped(),
				'imagereview-option-ok' => wfMessage( 'imagereview-option-ok' )->escaped(),
				'imagereview-label-ok' => wfMessage( 'imagereview-label-ok' )->escaped(),
				'imagereview-option-questionable' => wfMessage( 'imagereview-option-questionable' )->escaped(),
				'imagereview-label-questionable' => wfMessage( 'imagereview-label-questionable' )->escaped(),
				'imagereview-noresults' => wfMessage( 'imagereview-noresults' )->escaped(),
				'image-review-header' => wfMsg( "imagereview-header{$modeMsgSuffix}" )
			],
			'sortHTML' => $sortSelect->getHTML()
		] );
	}

	private function getModMsgSuffix() {
		return ( $this->action == self::ACTION_QUESTIONABLE || $this->action == self::ACTION_REJECTED )
			? '-' . $this->action
			: '';
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
