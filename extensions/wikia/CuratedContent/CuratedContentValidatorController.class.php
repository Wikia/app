<?php

class CuratedContentValidatorMethodNotAllowedException extends MethodNotAllowedException {}
/**
 * CuratedContentValidatorComponent: API endpoint for validation
 */
class CuratedContentValidatorController extends WikiaController {

	private $validator;
	private $helper;

	public function __construct() {
		parent::__construct();
		$this->oldValidator = new CuratedContentSpecialPageValidator();
		$this->validator = new CuratedContentValidator();
		$this->helper = new CuratedContentHelper();
	}

	//@TODO this function should be removed in XW-700
	public function validateSection() {
		global $wgRequest;
		if ( !$wgRequest->wasPosted() ) {
			throw new CuratedContentValidatorMethodNotAllowedException();
		}
		$section = $this->request->getVal( 'item' );
		if ( empty( $section ) ) {
			$this->respondWithErrors();
		} else {
			$section['title'] = $section['label'];
			unset( $section['label'] );
			$this->oldValidator->validateSection( $section );
			$this->respond( $this->oldValidator->getErrors() );
		}
	}

	public function validateCuratedContentSection() {
		global $wgRequest;
		if ( !$wgRequest->wasPosted() ) {
			throw new CuratedContentValidatorMethodNotAllowedException();
		}

		$section = $this->request->getVal( 'item' );

		if ( empty( $section ) ) {
			$this->respondWithErrors();
		} else {
			$section['title'] = $section['label'];
			unset( $section['label'] );

			$errors = $this->validator->validateSection( $section );
			$this->respond( $errors );
		}
	}

	//@TODO XW-700 this function should be removed
	public function validateSectionWithItems() {
		global $wgRequest;
		if ( !$wgRequest->wasPosted() ) {
			throw new CuratedContentValidatorMethodNotAllowedException();
		}
		$section = $this->request->getVal( 'item' );
		if ( empty( $section ) ) {
			$this->respondWithErrors();
		} else {
			$section['title'] = $section['label'];
			unset( $section['label'] );
			$section = $this->helper->processLogicForSectionOld( $section );
			if ( !empty( $section['featured'] ) ) {
				$this->oldValidator->validateItems( $section, true );
			} else {
				$this->oldValidator->validateSection( $section );
				$this->oldValidator->validateItemsExist( $section );
				$this->oldValidator->validateItems( $section );
				$this->oldValidator->validateItemsTypes( $section );
			}
			$this->oldValidator->validateDuplicatedLabels();
			$this->respond( $this->oldValidator->getErrors() );
		}
	}

	public function validateCuratedContentSectionWithItems() {
		global $wgRequest;
		if ( !$wgRequest->wasPosted() ) {
			throw new CuratedContentValidatorMethodNotAllowedException();
		}

		$section = $this->request->getVal( 'item' );

		if ( empty( $section ) ) {
			$this->respondWithErrors();
		} else {
			$section['title'] = $section['label'];
			unset( $section['label'] );

			$section = $this->helper->processLogicForSection( $section );
			$errors = $this->validator->validateSectionWithItems( $section );

			$this->respond( $errors );
		}
	}

	//@TODO XW-700 this function should be removed
	public function validateItem() {
		global $wgRequest;
		if ( !$wgRequest->wasPosted() ) {
			throw new CuratedContentValidatorMethodNotAllowedException();
		}
		$item = $this->request->getVal( 'item' );
		$isFeatured = $this->request->getBool( 'isFeaturedItem', false );
		if ( empty( $item ) ) {
			$this->respondWithErrors();
		} else {
			$this->helper->fillItemInfo( $item );
			$this->oldValidator->validateItem( $item, $isFeatured );
			if ( !$isFeatured ) {
				$this->oldValidator->validateItemType( $item );
			}
			$this->respond( $this->oldValidator->getErrors() );
		}
	}

	public function validateCuratedContentSectionItem() {
		global $wgRequest;
		if ( !$wgRequest->wasPosted() ) {
			throw new CuratedContentValidatorMethodNotAllowedException();
		}

		$item = $this->request->getVal( 'item' );

		if ( empty( $item ) ) {
			$this->respondWithErrors();
		} else {
			$this->helper->fillItemInfo( $item );
			$errors = $this->validator->validateSectionItem( $item );
			$this->respond( $errors );
		}
	}

	private function respond( Array $errors = null ) {
		if ( !empty( $errors ) ) {
			$this->respondWithErrors( $errors );
		} else {
			$this->respondWithStatus( true );
		}
	}

	private function respondWithErrors( Array $errors = null ) {
		if ( !empty( $errors ) ) {
			$this->response->setVal( 'errors', $errors );
		}
		$this->respondWithStatus( false );
	}

	private function respondWithStatus( $status ) {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setVal( 'status', $status );
		// TODO: CONCF-961 Set more restrictive header
		$this->response->setHeader( 'Access-Control-Allow-Origin', '*' );
	}

	public function validateFeaturedItem() {
		global $wgRequest;
		if ( !$wgRequest->wasPosted() ) {
			throw new CuratedContentValidatorMethodNotAllowedException();
		}

		$item = $this->request->getVal( 'item' );

		if ( empty( $item ) ) {
			$this->respondWithErrors();
		} else {
			$this->helper->fillItemInfo( $item );
			$errors = $this->validator->validateFeaturedItem( $item );
			$this->respond( $errors );
		}
	}
}
