<?php
/**
 * A controller that supports functioning of front-end elements related to Template Classification.
 * @author Adam Karmiński <adamk@wikia-inc.com>
 */

use Swagger\Client\ApiException;
use Wikia\TemplateClassification\Helper;

class TemplateClassificationController extends WikiaController {

	/**
	 * Renders a set of radio inputs used to classify a template.
	 */
	public function getTemplateClassificationEditForm() {
		$templateTypes = [];
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		$this->overrideTemplate( 'editForm' );

		foreach ( UserTemplateClassificationService::$templateTypes as $type ) {
			$templateTypes[] = [
				'type' => $type,
				/**
				 * template-classification-type-infobox
				 * template-classification-type-navbox
				 * template-classification-type-quote
				 * template-classification-type-unclassified
				 * template-classification-type-media
				 * template-classification-type-reference
				 * template-classification-type-navigation
				 * template-classification-type-nonarticle
				 * template-classification-type-design
				 * template-classification-type-unknown
				 * template-classification-type-data
				 */
				'name' => wfMessage( "template-classification-type-{$type}" )->plain(),
				/**
				 * template-classification-description-infobox
				 * template-classification-description-navbox
				 * template-classification-description-quote
				 * template-classification-description-media
				 * template-classification-description-unclassified
				 * template-classification-description-reference
				 * template-classification-description-navigation
				 * template-classification-description-nonarticle
				 * template-classification-description-design
				 * template-classification-description-unknown
				 * template-classification-description-data
				 */
				'description' => wfMessage( "template-classification-description-{$type}" )->plain(),
			];
		}

		$this->setVal( 'templateTypes', $templateTypes );
	}

	/**
	 * Classify all templates with given category
	 *
	 * @requestParam string category category name
	 * @requestParam string type template type name
	 *
	 * @throws ApiException
	 * @throws \BadRequestApiException
	 * @throws \InvalidParameterApiException
	 * @throws \MWException
	 * @throws \UnauthorizedException
	 */
	public function classifyTemplateByCategory() {
		$errors = [];
		$category = $this->request->getVal( 'category', null );
		$templateType = $this->request->getVal( 'type', null );
		$userId = $this->wg->User->getId();

		$this->validateRequestForBulkEdit( $category, $templateType );

		$templates = ( new Helper() )->getTemplatesByCategory( $category );
		$utcs = new UserTemplateClassificationService();

		foreach ( $templates as $templateId => $templateTitle ) {
			try {
				$utcs->classifyTemplate( $this->wg->CityId, $templateId, $templateType, 'user', $userId );
			} catch( ApiException $e ) {
				$errors[] = Title::newFromText( $templateTitle )->getText();
			}
		}

		if ( !empty( $errors ) ) {
			$this->prepareBulkActionError( $errors, $templates );
		}
	}

	private function validateRequestForBulkEdit( $category, $templateType ) {
		if ( !$this->request->wasPosted() ) {
			throw new BadRequestApiException();
		}

		if ( !$this->wg->User->isAllowed( 'template-bulk-classification' )
			|| !$this->wg->User->matchEditToken( $this->request->getVal( 'editToken' ) )
		) {
			throw new UnauthorizedException();
		}

		if ( empty( $category ) ) {
			throw new InvalidParameterApiException( 'category' );
		}

		if ( empty( $templateType ) ) {
			throw new InvalidParameterApiException( 'template type' );
		}

		return true;
	}

	private function prepareBulkActionError( Array $errors, Array $templates ) {
		$errorsCount = count( $errors );

		if ( $errorsCount === count( $templates ) ) {
			$errorMessage = wfMessage( 'template-classification-edit-modal-error' )->escaped();
		} else {
			$pages = ( new Language() )->listToText( $errors );
			$errorMessage = wfMessage(
				'template-classification-edit-modal-bulk-error',
				$errorsCount,
				$pages
			)->escaped();
		}
		throw new ApiException( $errorMessage, 500 );
	}
}
