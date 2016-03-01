<?php
/**
 * A controller that supports functioning of front-end elements related to Template Classification.
 * @author Adam Karmiński <adamk@wikia-inc.com>
 */

use Swagger\Client\ApiException;
use Wikia\TemplateClassification\Helper;
use Wikia\Logger\Loggable;

class TemplateClassificationController extends WikiaController {
	use Loggable;

	const INSTANT_CLASSIFICATION_LIMIT = 150;
	const MAX_ERROR_PAGES = 20;

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

		$category = Title::newFromText( $category, NS_CATEGORY )->getDBkey();
		$templates = ( new Helper() )->getTemplatesByCategory( $category );
		$templatesCount = count( $templates );
		$utcs = new UserTemplateClassificationService();

		$utcs->checkTemplateType( $templateType );

		if ( count( $templates) > self::INSTANT_CLASSIFICATION_LIMIT ) {
			$this->runBulkClassificationTask( $templates, $templateType, $userId, $category );
			$this->setVal( 'notification', wfMessage( 'template-classification-edit-modal-bulk-task' )->escaped() );
		} else {
			$errors = $utcs->classifyMultipleTemplates( $this->wg->CityId, $templates, $templateType, $userId );
		}

		if ( !empty( $errors ) ) {
			$this->prepareBulkActionError( $errors, $templatesCount );
			$this->logErrors( $templateType, $category, $errors, $templatesCount );
		} else {
			$this->logSuccess( $templateType, $category, $templatesCount );
		}
	}

	private function runBulkClassificationTask( Array $templates, $templateType, $userId, $category ) {
		$task = new \Wikia\TemplateClassification\TemplateBulkClassificationTask();
		$task->wikiId( $this->wg->CityId );
		$task->call( 'classifyTemplates', $templates, $templateType, $userId, $category );
		$task->prioritize();
		$task->queue();
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

	private function prepareBulkActionError( Array $errors, $templatesCount ) {
		$errorsCount = count( $errors );

		if ( $errorsCount === $templatesCount ) {
			$errorMessage = wfMessage( 'template-classification-edit-modal-error' )->escaped();
		} elseif ( $errorsCount > self::MAX_ERROR_PAGES ) {
			$errorMessage = wfMessage( 'template-classification-edit-modal-bulk-error-limited',
				$errorsCount,
				$templatesCount
			)->escaped();
		} else {
			$pages = $this->wg->Lang->listToText( $errors );
			$errorMessage = wfMessage(
				'template-classification-edit-modal-bulk-error',
				$errorsCount,
				$pages
			)->escaped();
		}

		throw new ApiException( $errorMessage, 500 );
	}

	private function logErrors( $templateType, $category, $errors, $templatesCount ) {
		$this->error( 'bulkClassificationFailed', [
			'wiki_id' => $this->wg->CityId,
			'category' => $category,
			'template_type' => $templateType,
			'user_id' => $this->wg->User->getId(),
			'bulk_type' => 'user',
			'failed' => $errors,
			'failed_ratio' => count( $errors ) . ' / ' . $templatesCount
		] );
	}

	private function logSuccess( $templateType, $category, $templatesCount ) {
		$this->info( 'bulkClassificationSuccess', [
			'wiki_id' => $this->wg->CityId,
			'category' => $category,
			'template_type' => $templateType,
			'user_id' => $this->wg->User->getId(),
			'bulk_type' => 'user',
			'templates_classified' => $templatesCount
		] );
	}
}
