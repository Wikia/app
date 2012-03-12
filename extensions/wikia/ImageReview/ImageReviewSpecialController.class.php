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
		
		$accessQuestionable = $this->wg->User->isAllowed( 'questionableimagereview' );

		// check permissions
		if (!$this->specialPage->userCanExecute($this->wg->User)) {
			$this->specialPage->displayRestrictionError();
			return false;
		} elseif ( $action == self::ACTION_QUESTIONABLE && !$accessQuestionable ) {
			$this->specialPage->displayRestrictionError( 'questionableimagereview' );
			return false;
		}

		$this->response->addAsset('extensions/wikia/ImageReview/js/jquery.onImagesLoad.js');
		$this->response->addAsset('extensions/wikia/ImageReview/js/ImageReview.js');
		$this->response->addAsset('extensions/wikia/ImageReview/css/ImageReview.scss');

		$this->response->setVal( 'accessQuestionable', $accessQuestionable );
		$this->response->setVal( 'accessStats', $this->wg->User->isAllowed( 'imagereviewstats' ) );
		$this->response->setVal( 'modeMsgSuffix', empty( $action ) ? '' : '-' . $action );

		$order = $this->getVal( 'sort', 0 );
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
			$this->wg->Out->redirect( $this->submitUrl. '?ts=' . time() . '&sort=' . $order );
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

		$this->imageCount = $helper->getImageCount($this->wg->user->getId());
		
	}

}
