<?php

use \Wikia\Logger\WikiaLogger;

class ImageReviewSpecialController extends WikiaSpecialPageController {
	const ACTION_QUESTIONABLE = 'questionable';
	const ACTION_REJECTED     = 'rejected';

	var $statsHeaders = array( 'user', 'total reviewed', 'approved', 'deleted', 'qustionable', 'distance to avg.' );

	public function __construct() {
		parent::__construct('ImageReview', 'imagereview', false /* $listed */);
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

		$action = $this->getPar();
		$actions = explode('/',$action);
		$action = array_pop($actions);

		$this->action = $action;
		$this->response->setJsVar('wgImageReviewAction', $action);

		$this->accessQuestionable = $this->wg->User->isAllowed( 'questionableimagereview' );
		$this->accessRejected = $this->wg->User->isAllowed( 'rejectedimagereview' );

		// check permissions
		if (!$this->specialPage->userCanExecute($this->wg->User)) {
			$this->specialPage->displayRestrictionError();
			return false;
		} elseif ( $action == self::ACTION_QUESTIONABLE && !$this->accessQuestionable ) {
			$this->specialPage->displayRestrictionError( 'questionableimagereview' );
			return false;
		} elseif ( $action == self::ACTION_REJECTED && !$this->accessRejected ) {
			$this->specialPage->displayRestrictionError( 'rejectedimagereview' );
			return false;
		} elseif ( $action == 'stats' ) {
			$this->forward( get_class( $this ), 'stats' );
			return true;
		} elseif ( $action == 'csvstats' ) {
			$this->forward( get_class( $this ), 'csvStats' );
		}

		$this->response->setCacheValidity(WikiaResponse::CACHE_DISABLED);
		$this->response->sendHeaders();

		$this->response->addAsset('extensions/wikia/ImageReview/js/jquery.onImagesLoad.js');
		$this->response->addAsset('extensions/wikia/ImageReview/js/ImageReview.js');
		$this->response->addAsset('extensions/wikia/ImageReview/css/ImageReview.scss');

		$this->response->setVal( 'accessQuestionable', $this->accessQuestionable );
		$this->response->setVal( 'accessStats', $this->wg->User->isAllowed( 'imagereviewstats' ) );
		$this->response->setVal( 'accessControls', $this->wg->user->isAllowed( 'imagereviewcontrols' ) );
		$this->response->setVal( 'modeMsgSuffix', empty( $action ) ? '' : '-' . $action );

		$order = $this->getOrderingMethod();

		$this->response->setVal( 'order', $order );


		$helper = $this->getHelper();

		$ts = $this->wg->request->getVal( 'ts' );
		$query = ( empty($action) ) ? '' : '/'.$action ;
		$this->fullUrl = $this->wg->Title->getFullUrl( );
		$this->baseUrl = $this->getBaseUrl();
		$this->toolName = $this->getToolName();
		$this->submitUrl = $this->baseUrl . $query;

		if( $this->wg->request->wasPosted() ) {
			$data = $this->wg->request->getValues();
			if ( !empty($data) ) {
				$images = $this->parseImageData($data);

				if ( count($images) > 0 ) {
					$helper->updateImageState( $images, $action );
				}
				$ts = null;
			}
		}

		if ( !$ts || intval($ts) < 0 || intval($ts) > time() ) {
			$this->wg->Out->redirect( $this->submitUrl. '?ts=' . time() );
			return;
		}

		$user_key = $helper->getUserTsKey();
		$newestTs = $this->wg->Memc->get( $user_key );

		if ( $ts > $newestTs ) {
			WikiaLogger::instance()->info( 'ImageReviewLog', [
				'method' => __METHOD__,
				'message' => "I've got the newest ts ({$ts}), I won't refetch the images",
			]);
			$this->imageList = array();
			$this->wg->memc->set( $user_key, $ts, 3600 /* 1h */ );
		} else {
			$this->imageList = $helper->refetchImageListByTimestamp( $ts );
		}

		/* SUS-541 / Mix <mix@wikia.com> / scope: the following if block */
		if ( count( $this->imageList ) < ImageReviewHelper::LIMIT_IMAGES ) {
			WikiaLogger::instance()->debug(
				'SUS-541',
				[
					'severity' => 'warning',
					'imageList' => $this->imageList,
					'exception' => new Exception
				]
			);
		}

		if ( count( $this->imageList ) == 0 ) {
			$do = array( 
				self::ACTION_QUESTIONABLE	=> ImageReviewStatuses::STATE_QUESTIONABLE,
				self::ACTION_REJECTED		=> ImageReviewStatuses::STATE_REJECTED,
				'default'					=> ImageReviewStatuses::STATE_UNREVIEWED
			);

			if ( isset( $do[ $action ] ) ) {
				$this->imageList = $helper->getImageList( $ts, $do[ $action ], $order );
				$this->imageCount = $helper->getImageCount();
			} else {
				$this->imageList = $helper->getImageList( $ts, $do[ 'default' ], $order );
				$this->imageCount = $helper->getImageCount( 'unreviewed', count( $this->imageList ) );
			}
		} else {
			$this->imageCount = $helper->getImageCount();
		}

		/* SUS-541 / Mix <mix@wikia.com> / scope: the following if block */
		if ( count( $this->imageList ) < ImageReviewHelper::LIMIT_IMAGES ) {
			$severity = 'error';
		} else {
			$severity = 'success';
		}
		WikiaLogger::instance()->debug(
			'SUS-541',
			[
				'severity' => $severity,
				'imageList' => $this->imageList,
				'exception' => new Exception
			]
		);
	}

	protected function getOrderingMethod() {
		if ($this->wg->user->isAllowed('imagereviewcontrols')) {
			$order = (int)$this->getVal('sort', -1);
			if ($order >= 0) {
				$this->app->wg->User->setGlobalPreference('imageReviewSort', $order);
				$this->app->wg->User->saveSettings();
			}

			$order = $this->app->wg->User->getGlobalPreference('imageReviewSort');
			return $order;
		} else {
			$order = -1;
			return $order;
		}
	}


	public function stats() {
		if ( !$this->wg->User->isAllowed( 'imagereviewstats' )) {
			$this->specialPage->displayRestrictionError( 'imagereviewstats' );
			return false;
		}

		$startDay = $this->request->getVal( 'startDay', date( 'd' ) );
		$startMonth = $this->request->getVal( 'startMonth', date( 'n' ) );
		$startYear = $this->request->getVal( 'startYear', date( 'Y' ) );

		$endDay = $this->request->getVal( 'endDay', date( 'd' ) );
		$endMonth = $this->request->getVal( 'endMonth', date( 'm' ) );
		$endYear = $this->request->getVal( 'endYear', date( 'Y' ) );

		$helper = $this->getHelper();

		$stats = $helper->getStatsData( $startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay );

		// setup response data for table rendering
		$this->response->setVal( 'summary', $stats['summary'] );
		$this->response->setVal( 'summaryHeaders', array( 'total reviewed', 'approved', 'deleted', 'questionable', 'avg per user' ) );

		$this->response->setVal( 'data', $stats['data'] );
		$this->response->setVal( 'headers', $this->statsHeaders );

		$this->response->setVal( 'startDay', $startDay );
		$this->response->setVal( 'startMonth', $startMonth );
		$this->response->setVal( 'startYear', $startYear );

		$this->response->setVal( 'endDay', $endDay );
		$this->response->setVal( 'endMonth', $endMonth );
		$this->response->setVal( 'endYear', $endYear );
	}

	public function csvStats() {
		if ( !$this->wg->User->isAllowed( 'imagereviewstats' )) {
			$this->specialPage->displayRestrictionError( 'imagereviewstats' );
			return false;
		}

		$startDay = $this->request->getVal( 'startDay', date( 'd' ) );
		$startMonth = $this->request->getVal( 'startMonth', date( 'n' ) );
		$startYear = $this->request->getVal( 'startYear', date( 'Y' ) );

		$endDay = $this->request->getVal( 'endDay', date( 'd' ) );
		$endMonth = $this->request->getVal( 'endMonth', date( 'm' ) );
		$endYear = $this->request->getVal( 'endYear', date( 'Y' ) );

		$this->wg->Out->setPageTitle($this->getStatsPageTitle());
		$stats = $this->getStatsData( $startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay );

		$name = "ImageReviewStats-$startYear-$startMonth-$startDay-to-$endYear-$endMonth-$endDay";

		header("Pragma: public");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header('Content-Type: text/force-download');

		header('Content-Disposition: attachment; filename="' . $name . '.csv"');

		echo implode( ",", $this->statsHeaders ) . "\n";

		foreach ( $stats['data'] as $dataRow ) {
			echo implode( ",", $dataRow ) . "\n";
		}

		exit;
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
		$images = array();

		foreach( $data as $name => $value ) {
			if (preg_match('/img-(\d*)-(\d*)/', $name, $matches)) {
				if ( !empty($matches[1]) && !empty($matches[2]) ) {
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
}
