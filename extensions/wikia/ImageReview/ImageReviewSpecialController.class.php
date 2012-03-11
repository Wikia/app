<?php

class ImageReviewSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct('ImageReview', 'imagereview', false /* $listed */);
	}

	public function index() {
		$this->wg->Out->setPageTitle('Image Review tool');

		$action = $this->getPar();

		$accessQuestionable = $this->wg->User->isAllowed( 'questionableimagereview' );

		// check permissions
		if (!$this->specialPage->userCanExecute($this->wg->User)) {
			$this->specialPage->displayRestrictionError();
			return false;
		} elseif ( $action == 'questionable' && !$accessQuestionable ) {
			$this->specialPage->displayRestrictionError( 'questionableimagereview' );
			return false;
		}

		$this->response->addAsset('extensions/wikia/ImageReview/js/ImageReview.js');
		$this->response->addAsset('extensions/wikia/ImageReview/css/ImageReview.scss');

		$this->response->setVal( 'accessQuestionable', $accessQuestionable );
		$this->response->setVal( 'accessStats', $this->wg->User->isAllowed( 'imagereviewstats' ) );

		// get more space for images
		$this->wg->SuppressSpotlights = true;
		$this->wg->SuppressWikiHeader = true;
		$this->wg->SuppressPageHeader = true;
		$this->wg->SuppressFooter = true;

		$helper = F::build( 'ImageReviewHelper' );
		$ts = $this->wg->request->getVal( 'ts' );
		
		$query = ( empty($action) ) ? '' : '/'.$action ;
		$this->submitUrl = $this->wg->Title->getFullUrl( ) . $query;

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
					$helper->updateImageState( $images );
				}
				$ts = null;
			}
		}
		
		if ( !$ts || intval($ts) < 0 || intval($ts) > time() ) {
			$this->wg->Out->redirect( $this->submitUrl.'?ts='.time() );
			return;
		}

		$newestTs = $this->wg->memc->get( $helper->getUserTsKey() );
		
		if ( $ts > $newestTs ) {
			error_log("ImageReview: I've got the newest ts ($ts), I won't refetch the images");
			$this->imageList = array();
			$this->wg->memc->set( $helper->getUserTsKey(), $ts, 60*60 );
		} else {
			$this->imageList = $helper->refetchImageListByTimestamp( $ts );
		}
		
		if ( count($this->imageList) == 0 ) {
			if ( $action == 'questionable' ) {
				$this->imageList = $helper->getImageList( $ts, ImageReviewHelper::STATE_QUESTIONABLE );
			} else { 
				$this->imageList = $helper->getImageList( $ts );
			}
		}
		
		$this->imageCount = $helper->getImageCount($this->wg->user->getId());
		
	}

}
