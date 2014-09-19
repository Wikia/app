<?php

class CoppaImageReviewSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'CoppaImageReview', 'coppaimagereview', false /* $listed */ );
	}

	public function index() {
		wfProfileIn( __METHOD__ );
		$user = $this->getUser();
		if ( !$user->isAllowed( 'coppaimagereview' ) ) {
			wfProfileOut( __METHOD__ );
			$this->displayRestrictionError();
			return false;
		}

		$this->wg->OasisFluid = true;
		$this->wg->SuppressSpotlights = true;
		$this->response->addAsset( 'extensions/wikia/ImageReview/css/ImageReview.scss' );
		$this->specialPage->setHeaders();

		$this->pageUrl = $this->getTitle()->getLocalUrl();

		$targetUser = trim( $this->getVal( 'username', $this->getPar() ) );

		$this->validUser = false;

		$targetUserObj = User::newFromName( $targetUser );
		if ( !$targetUserObj || $targetUserObj->getId() === 0 ) {
			$this->validUser = false;
			$this->userName = $targetUser;
		} else {
			$this->userName = $targetUserObj->getName();
			$this->validUser = true;

			$from = $this->request->getVal( 'from' );

			$helper = $this->getHelper();

			if ( $this->request->wasPosted() && $user->matchEditToken( $this->getVal( 'token' ) ) ) {
				$data = $this->wg->Request->getValues();
				if ( !empty( $data ) ) {
					$images = $this->parseImageData( $data );

					if ( count( $images ) > 0 ) {
						$helper->updateImageState( $images, $user->getID() );
					}
				}
			}

			$this->editToken = $user->getEditToken();

			$this->imageList = $helper->getImageList( $targetUserObj->getID(), $from );

			$lastEl = end( $this->imageList );
			reset( $this->imageList );
			$this->nextPage = $lastEl['last_edited'];
		}

		wfProfileOut( __METHOD__ );

	}

	protected function getHelper() {
		return new CoppaImageReviewHelper();
	}

	protected function parseImageData( $data ) {
		$images = [];

		foreach( $data as $name => $value ) {
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
}
