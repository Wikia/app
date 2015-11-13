<?php

class CuratedContentValidatorMethodNotAllowedException extends MethodNotAllowedException {}
/**
 * CuratedContentValidatorComponent: API endpoint for validation
 */
class CuratedContentValidatorController extends WikiaController {

	private $validator;
	private $specialPageDataValidator;
	private $helper;

	public function __construct() {
		parent::__construct();
		$this->specialPageDataValidator = new CuratedContentSpecialPageValidator();
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
			$this->specialPageDataValidator->validateSection( $section );
			$this->respond( $this->specialPageDataValidator->getErrors() );
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
			$section = $this->helper->processLogicForSectionSpecialPage( $section );
			if ( !empty( $section['featured'] ) ) {
				$this->specialPageDataValidator->validateItems( $section, true );
			} else {
				$this->specialPageDataValidator->validateSection( $section );
				$this->specialPageDataValidator->validateItemsExist( $section );
				$this->specialPageDataValidator->validateItems( $section );
				$this->specialPageDataValidator->validateItemsTypes( $section );
			}
			$this->specialPageDataValidator->validateDuplicatedLabels();
			$this->respond( $this->specialPageDataValidator->getErrors() );
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
			$this->specialPageDataValidator->validateItem( $item, $isFeatured );
			if ( !$isFeatured ) {
				$this->specialPageDataValidator->validateItemType( $item );
			}
			$this->respond( $this->specialPageDataValidator->getErrors() );
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

	public function validateCuratedContentFeaturedItem() {
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
