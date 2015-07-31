<?php

/**
 * CuratedContentValidatorComponent: API endpoint for validation
 */
class CuratedContentValidatorController extends WikiaController {

	public function validateSection() {
		$section = $this->request->getVal( 'section' );

		if ( empty( $section ) ) {
			$this->respondWithErrors();
		} else {
			$this->validateCuratedContent( [ $section ] );
		}
	}

	public function validateItem() {
		$item = $this->request->getVal( 'item' );
		$isFeatured = $this->request->getBool( 'isFeatured', false );

		if ( empty( $item ) ) {
			$this->respondWithErrors();
		} else {
			// create optional/featured section so we can use CuratedContentValidator class
			$section = [
				'title' => '',
				'items' => [
					$item
				]
			];
			if ( !empty( $isFeatured ) ) {
				$section['featured'] = true;
			}
			$this->validateCuratedContent( [ $section ] );
		}
	}

	private function validateCuratedContent( Array $data ) {
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
		if ( !empty( $errors ) ) {
			$this->response->setVal('error', $errors);
		}
		$this->respondWithStatus( false );
	}

	private function respondWithStatus( $status ) {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setVal( 'status', $status );
		// TODO: remove following line when Curated Content Manager is relased for all
		$this->response->setHeader( 'Access-Control-Allow-Origin', '*' );
	}
}
