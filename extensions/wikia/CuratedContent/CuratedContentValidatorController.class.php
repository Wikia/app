<?php

/**
 * CuratedContentValidatorComponent: API endpoint for validation
 */
class CuratedContentValidatorController extends WikiaController {

	public function validateCuratedContent() {
		$data = $this->request->getVal( 'data' );

		if ( empty( $data ) ) {
			$this->respondWithErrors();
		} else {
			$this->validateCuratedContentData( $data );
		}
	}

	public function validateSection() {
		$section = $this->request->getVal( 'section' );

		if ( empty( $section ) ) {
			$this->respondWithErrors();
		} else {
			$this->validateCuratedContentData( [ $section ] );
		}
	}

	public function validateItem() {
		$item = $this->request->getVal( 'item' );
		$isFeatured = $this->request->getVal( 'isFeatured', null );

		if ( empty( $item ) ) {
			$this->respondWithErrors();
		} else {
			// create optional/featured section so we can use CuratedContentValidator class
			$section = [
				'title' => '',
				'featured' => $isFeatured,
				'items' => [
					$item
				]
			];
			$this->validateCuratedContentData( [ $section ] );
		}
	}

	private function validateCuratedContentData( Array $data ) {
		$helper = new CuratedContentHelper();

		$sections = $helper->processSections( $data );
		$errors = ( new CuratedContentValidator( $sections ) )->getErrors();

		if ( !empty( $errors ) ) {
			$this->respondWithErrors( $errors );
		} else {
			$this->respondWithStatus( true );
		}
	}

	private function respondWithErrors( Array $errors = null ) {
		if ( empty( $errors ) ) {
			$this->response->setVal('error', $errors);
		}
		$this->respondWithStatus( false );
	}

	private function respondWithStatus( $status ) {
		$this->response->setFormat( 'json' );
		$this->response->setVal( 'status', $status );
	}
}
