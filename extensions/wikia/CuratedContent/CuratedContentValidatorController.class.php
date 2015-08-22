<?php

/**
 * CuratedContentValidatorComponent: API endpoint for validation
 */
class CuratedContentValidatorController extends WikiaController {

	private $validator;
	private $helper;

	public function __construct() {
		parent::__construct();
		$this->validator = new CuratedContentValidator();
		$this->helper = new CuratedContentHelper();
	}

	public function validateSection() {
		$section = $this->request->getVal( 'item' );

		if ( empty( $section ) ) {
			$this->respondWithErrors();
		} else {
			$section['title'] = $section['label'];
			unset( $section['label'] );

			$this->validator->validateSection( $section );
			$this->respond( $this->validator->getErrors() );
		}
	}

	public function validateSectionWithItems() {
		$section = $this->request->getVal( 'item' );

		if ( empty( $section ) ) {
			$this->respondWithErrors();
		} else {
			$section['title'] = $section['label'];
			unset( $section['label'] );

			$section = $this->helper->processLogicForSection( $section );
			if ( !empty( $section['featured'] ) ) {
				$this->validator->validateItems( $section, true );
			} else {
				$this->validator->validateSection( $section );
				$this->validator->validateItemsExist( $section );
				$this->validator->validateItems( $section );
				$this->validator->validateItemsTypes( $section );
			}
			$this->validator->validateDuplicatedLabels();
			$this->respond( $this->validator->getErrors() );
		}
	}

	public function validateItem() {
		$item = $this->request->getVal( 'item' );
		$isFeatured = $this->request->getBool( 'isFeaturedItem', false );

		if ( empty( $item ) ) {
			$this->respondWithErrors();
		} else {
			$this->helper->fillItemInfo( $item );
			$this->validator->validateItem( $item, $isFeatured );
			if ( !$isFeatured ) {
				$this->validator->validateItemType( $item );
			}
			$this->respond( $this->validator->getErrors() );
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
			$this->response->setVal('error', $errors);
		}
		$this->respondWithStatus( false );
	}

	private function respondWithStatus( $status ) {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setVal( 'status', $status );
		// TODO: CONCF-961 Set more restrictive header
		$this->response->setHeader( 'Access-Control-Allow-Origin', '*' );
	}
}
