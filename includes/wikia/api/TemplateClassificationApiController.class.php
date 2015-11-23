<?php


use Swagger\Client\ApiException;

class TemplateClassificationApiController extends WikiaApiController {

	private $templateClassificationService = null;

	/**
	 * Classify template type
	 *
	 * @throws BadRequestApiException
	 * @throws InvalidParameterApiException
	 * @throws PermissionsException
	 * @throws UnauthorizedException
	 * @throws Exception
	 * @throws \Swagger\Client\ApiException
	 */
	public function classifyTemplate() {
		$pageId = $this->request->getVal( 'pageId', null );
		$templateType = $this->request->getVal( 'type', null );
		$userId = $this->wg->User->getId();

		$this->validateRequest( $this->wg->User, $this->request, $pageId );

		try {
			$this->getTemplateClassificationService()->classifyTemplate(
				$this->wg->CityId,
				$pageId,
				$templateType,
				TemplateClassificationService::USER_PROVIDER,
				$userId
			);

			$title = Title::newFromId( $pageId );
			if ( $title instanceof Title ) {
				wfRunHooks('TemplateClassification::TemplateClassified', [ $pageId, $title ] );
				$title->invalidateCache();
			}
		} catch ( InvalidArgumentException $e ) {
			throw new BadRequestApiException( $e->getMessage() );
		}
	}

	/**
	 * Check permission to classify template type
	 *
	 * @param User $user
	 * @param WikiaRequest $request
	 * @param int $pageId
	 * @return bool
	 * @throws PermissionsException
	 * @throws UnauthorizedException
	 * @throws BadRequestException
	 */
	private function validateRequest( User $user, WikiaRequest $request, $pageId ) {
		if ( !$request->wasPosted() ) {
			throw new BadRequestApiException();
		}

		if ( !$user->isLoggedIn() || !$user->matchEditToken( $request->getVal( 'editToken' ) ) ) {
			throw new UnauthorizedException();
		}

		$title = Title::newFromID( $pageId );

		if ( is_null( $title ) || !$title->inNamespace( NS_TEMPLATE ) ) {
			throw new InvalidParameterApiException( 'pageId' );
		}

		if ( !$title->userCan( 'edit' ) ) {
			throw new PermissionsException( 'edit' );
		}

		return true;
	}

	private function getTemplateClassificationService() {
		if ( is_null( $this->templateClassificationService ) ) {
			$this->templateClassificationService = new TemplateClassificationService();
		}

		return $this->templateClassificationService;
	}
}
