<?php

class ImageReviewSpecialController extends WikiaSpecialPageController {
	const ACTION_QUESTIONABLE = 'questionable';

	public function __construct() {
		parent::__construct('ImageReview', 'imagereview', false /* $listed */);
	}

	public function index() {
		
		$this->wg->OasisFluid = true;
		$this->wg->Out->setPageTitle('Image Review tool');

		$action = $this->getPar();
		$this->action = $action;
		$this->response->setJsVar('wgImageReviewAction', $action);
		$this->wg->Out->enableClientCache( false );
		$this->response->setCacheValidity(0, 0, array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH));
		$this->response->sendHeaders();
		
		$accessQuestionable = $this->wg->User->isAllowed( 'questionableimagereview' );

		// check permissions
		if (!$this->specialPage->userCanExecute($this->wg->User)) {
			$this->specialPage->displayRestrictionError();
			return false;
		} elseif ( $action == self::ACTION_QUESTIONABLE && !$accessQuestionable ) {
			$this->specialPage->displayRestrictionError( 'questionableimagereview' );
			return false;
		} elseif ( $action == 'stats' ) {
			$this->forward( get_class( $this ), 'stats' );
			return true;
		}

		$this->response->addAsset('extensions/wikia/ImageReview/js/jquery.onImagesLoad.js');
		$this->response->addAsset('extensions/wikia/ImageReview/js/ImageReview.js');
		$this->response->addAsset('extensions/wikia/ImageReview/css/ImageReview.scss');

		$this->response->setVal( 'accessQuestionable', $accessQuestionable );
		$this->response->setVal( 'accessStats', $this->wg->User->isAllowed( 'imagereviewstats' ) );
		$this->response->setVal( 'accessControls', $this->wg->user->isAllowed( 'imagereviewcontrols' ) );
		$this->response->setVal( 'modeMsgSuffix', empty( $action ) ? '' : '-' . $action );
		
		if($this->wg->user->isAllowed( 'imagereviewcontrols' )) {
			$order = (int) $this->getVal( 'sort', -1 );
			if($order > 0 ) {
				$this->app->wg->User->setOption( 'imageReviewSort', $order );
				$this->app->wg->User->saveSettings();
			}
		
			$order = $this->app->wg->User->getOption( 'imageReviewSort' );	
		} else {
			$order = -1;
		}
		
		$this->response->setVal( 'order', $order );

		// get more space for images
		$this->wg->SuppressSpotlights = true;
		$this->wg->SuppressWikiHeader = true;
		$this->wg->SuppressPageHeader = true;
		$this->wg->SuppressFooter = true;

		$helper = F::build( 'ImageReviewHelper' );
		$ts = $this->wg->request->getVal( 'ts' );
		
		$query = ( empty($action) ) ? '' : '/'.$action ;
		$this->fullUrl = $this->wg->Title->getFullUrl( );
		$this->submitUrl = $this->wg->Title->getFullUrl( ) . $query;
		$this->baseUrl = Title::newFromText('ImageReview', NS_SPECIAL)->getFullURL();

		
		if( $this->wg->request->wasPosted() ) {
			$data = $this->wg->request->getValues();
			if ( !empty($data) ) {
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

		$newestTs = $this->wg->memc->get( $helper->getUserTsKey() );
		
		if ( $ts > $newestTs ) {
			error_log("ImageReview: I've got the newest ts ($ts), I won't refetch the images");
			$this->imageList = array();
			$this->wg->memc->set( $helper->getUserTsKey(), $ts, 3600 /* 1h */ );
		} else {
			$this->imageList = $helper->refetchImageListByTimestamp( $ts );
		}
		
		if ( count($this->imageList) == 0 ) {
			if ( $action == self::ACTION_QUESTIONABLE ) {
				$this->imageList = $helper->getImageList( $ts, ImageReviewHelper::STATE_QUESTIONABLE, $order );
			} else { 
				$this->imageList = $helper->getImageList( $ts, ImageReviewHelper::STATE_UNREVIEWED, $order );
			}
		}

		if($accessQuestionable) {
			$this->imageCount = $helper->getImageCount();			
		}
	}


	function stats() {
		if ( !$this->wg->User->isAllowed( 'imagereviewstats' )) {
			$this->specialPage->displayRestrictionError( 'imagereviewstats' );
			return false;
		}

		$startDay = $this->request->getVal( 'startDay', date( 'd' ) );
		$startMonth = $this->request->getVal( 'startMonth', date( 'n' ) );
		$startYear = $this->request->getVal( 'startYear', date( 'Y' ) );

		$endDay = $this->request->getVal( 'endDay', date( 'd' ) );
		$endMonth = $this->request->getVal( 'endMonth', date( 'n' ) );
		$endYear = $this->request->getVal( 'endYear', date( 'Y' ) );

		$startDate = $startYear . '-' . $startMonth . '-' . $startDay . ' 00:00:00';
		$endDate = $endYear . '-' . $endMonth . '-' . $endDay . ' 23:59:59';

		$summary = array(
			'all' => 0,
			ImageReviewHelper::STATE_APPROVED => 0,
			ImageReviewHelper::STATE_DELETED => 0,
			ImageReviewHelper::STATE_QUESTIONABLE => 0,
			'avg' => 0,
		);
		$data = array();
		$userCount = 0;

		$this->wg->Out->setPageTitle('Image Review tool statistics');

		$dbr = $this->wf->GetDB( DB_SLAVE, array(), $this->wg->ExternalDatawareDB );
		$res = $dbr->query( "select review_state, reviewer_id, count( page_id ) as count from 
		image_review_stats WHERE review_end BETWEEN '{$startDate}' AND '{$endDate}' group by review_state, reviewer_id with rollup" );

		while ( $row = $dbr->fetchRow( $res ) ) {
			if ( is_null( $row['review_state'] ) ) {
				// total
				$summary['all'] = $row['count'];
			} elseif ( is_null( $row['reviewer_id'] ) ) {
				$summary[$row['review_state']] = $row['count'];
			} else {
				if ( empty( $data[$row['reviewer_id']] ) ) {
					$user = User::newFromId( $row['reviewer_id'] );
					$userLink = Xml::element( 
						'a',
						array( 'href' => $user->getUserPage()->getFullUrl() ),
						$user->getName()
					);

					$data[$row['reviewer_id']] = array(
						'name' => $user->getName(),
						'total' => 0,
						ImageReviewHelper::STATE_APPROVED => 0,
						ImageReviewHelper::STATE_DELETED => 0,
						ImageReviewHelper::STATE_QUESTIONABLE => 0,
					);
				}
				$data[$row['reviewer_id']][$row['review_state']] = $row['count'];
				$data[$row['reviewer_id']]['total'] += $row['count'];
				$userCount++;
			}
		}	

		$summary['avg'] = $userCount > 0 ? $summary['all'] / $userCount : 0;

		foreach ( $data as $reviewer => &$stats ) {
			$stats['toavg'] = $stats['total'] - $summary['avg'];
		}

		// setup response data for table rendering
		$this->response->setVal( 'summary', $summary );
		$this->response->setVal( 'summaryHeaders', array( 'total reviewed', 'approved', 'deleted', 'questionable', 'avg per user' ) );

		$this->response->setVal( 'data', $data );
		$this->response->setVal( 'headers', array( 'user', 'total reviewed', 'approved', 'deleted', 'qustionable', 'distance to avg.' ) );
	}
}
