<?php

use \Wikia\Logger\WikiaLogger;

class ImageReviewSpecialController extends WikiaSpecialPageController {
	const ACTION_QUESTIONABLE = 'questionable';
	const ACTION_REJECTED     = 'rejected';

	private $statsHeaders = array( 'user', 'total reviewed', 'approved', 'deleted', 'qustionable', 'distance to avg.' );
	private $action;
	private $order;
	private $imageList;
	private $imageCount;
	private $ts;
	private $helper;

	public function __construct() {
		parent::__construct( 'ImageReview', 'imagereview', false /* $listed */ );
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

		$this->action = $this->getAction();
		$this->order = $this->getOrderingMethod();
		$this->ts = $this->wg->request->getVal( 'ts' );

		$this->checkUserPermissions();
		$this->checkRedirect();

		$this->setCache();
		$this->setAssets();

		$this->helper = $this->getHelper();

		if( $this->wg->request->wasPosted() ) {
			$this->handlePostAction();
		}

		$user_key = $this->helper->getUserTsKey();
		$newestTs = $this->wg->Memc->get( $user_key );

		if ( $this->ts > $newestTs ) {
			WikiaLogger::instance()->info( 'ImageReviewLog', [
				'method' => __METHOD__,
				'message' => "I've got the newest ts ({$this->ts}), I won't refetch the images",
			]);
			$this->imageList = array();
			$this->wg->memc->set( $user_key, $this->ts, 3600 /* 1h */ );
		} else {
			$this->imageList = $this->helper->refetchImageListByTimestamp( $this->ts );
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
				$this->imageList = $this->helper->getImageList( $this->ts, $do[ $this->action ], $this->order );
				$this->imageCount = $this->helper->getImageCount();
			} else {
				$this->imageList = $this->helper->getImageList( $this->ts, $do[ 'default' ], $this->order );
				$this->imageCount = $this->helper->getImageCount( 'unreviewed', count( $this->imageList ) );
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

	private function handlePostAction() {
		$data = $this->wg->request->getValues();
		if ( !empty($data) ) {
			$images = $this->parseImageData($data);

			if ( count($images) > 0 ) {
				$this->helper->updateImageState( $images, $this->action );
			}
			$this->ts = null;
		}
	}

	private function getOrderingMethod() {
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

	private function getAction() {
		$actions = explode( '/', $this->getPar() );
		return array_pop( $actions );
	}

	private function checkUserPermissions() {
		$this->accessQuestionable = $this->wg->User->isAllowed( 'questionableimagereview' );
		$this->accessRejected = $this->wg->User->isAllowed( 'rejectedimagereview' );

		// check permissions
		if (!$this->specialPage->userCanExecute($this->wg->User)) {
			$this->specialPage->displayRestrictionError();
			return false;
		} elseif ( $this->action == self::ACTION_QUESTIONABLE && !$this->accessQuestionable ) {
			$this->specialPage->displayRestrictionError( 'questionableimagereview' );
			return false;
		} elseif ( $this->action == self::ACTION_REJECTED && !$this->accessRejected ) {
			$this->specialPage->displayRestrictionError( 'rejectedimagereview' );
			return false;
		}
	}

	private function checkRedirect() {
		if ( $this->action == 'stats' ) {
			$this->forward( get_class( $this ), 'stats' );
			return true;
		} elseif ( $this->action == 'csvstats' ) {
			$this->forward( get_class( $this ), 'csvStats' );
		}

		if ( !$this->ts || intval($this->ts) < 0 || intval($this->ts) > time() ) {
			$this->wg->Out->redirect( $this->submitUrl. '?ts=' . time() );
		}
	}

	private function setAssets() {
		$this->response->addAsset('extensions/wikia/ImageReview/js/jquery.onImagesLoad.js');
		$this->response->addAsset('extensions/wikia/ImageReview/js/ImageReview.js');
		$this->response->addAsset('extensions/wikia/ImageReview/css/ImageReview.scss');
	}

	private function setCache() {
		$this->response->setCacheValidity(WikiaResponse::CACHE_DISABLED);
		$this->response->sendHeaders();
	}

	private function setVariables() {
		$query = ( empty( $this->action ) ) ? '' : '/'. $this->action;

		$this->response->setJsVar('wgImageReviewAction', $this->action);

		$this->response->setVal( 'action', $this->action );
		$this->response->setVal( 'order', $this->order );
		$this->response->setVal( 'imageList', $this->imageList );
		$this->response->setVal( 'imageCount', $this->imageCount );

		$this->response->setVal( 'accessQuestionable', $this->accessQuestionable );
		$this->response->setVal( 'accessStats', $this->wg->User->isAllowed( 'imagereviewstats' ) );
		$this->response->setVal( 'accessControls', $this->wg->user->isAllowed( 'imagereviewcontrols' ) );
		$this->response->setVal( 'modeMsgSuffix', empty( $this->action ) ? '' : '-' . $this->action );
		$this->response->setVal( 'order', $this->order );
		$this->response->setVal( 'fullUrl', $this->wg->Title->getFullUrl() );
		$this->response->setVal( 'baseUrl', $this->getBaseUrl() );
		$this->response->setVal( 'toolName', $this->getToolName() );
		$this->response->setVal( 'submitUrl' ,$this->baseUrl . $query );
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
