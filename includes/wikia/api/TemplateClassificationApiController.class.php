<?php

class TemplateClassificationApiController extends WikiaApiController {

	private $userTemplateClassificationService = null;

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
			$this->getUserTemplateClassificationService()->classifyTemplate(
				$this->wg->CityId,
				$pageId,
				$templateType,
				$userId
			);

			$title = Title::newFromId( $pageId );
			if ( $title instanceof Title ) {
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

	private function getUserTemplateClassificationService() {
		if ( is_null( $this->userTemplateClassificationService ) ) {
			$this->userTemplateClassificationService = new UserTemplateClassificationService();
		}

		return $this->userTemplateClassificationService;
	}
}
