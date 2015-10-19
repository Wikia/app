<?php

use Wikia\Service\Gateway\ConsulUrlProvider;
use Wikia\Service\Swagger\ApiProvider;
use Swagger\Client\TemplateClassification\Storage\Api\TCSApi;
use Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeProvider;
use Swagger\Client\ApiException;

class TemplateClassificationApiController extends WikiaApiController {
	const SERVICE_NAME = 'template-classification-storage';
	const USER_PROVIDER = 'user';

	private $apiClient = null;

	/**
	 * Get template type
	 *
	 * Type can be provided by user or automatic script, but user classification overrides automatic generated type
	 *
	 * @param int $wikiId
	 * @param int $pageId
	 * @return string
	 * @throws ApiException
	 * @throws BadRequestApiException
	 * @throws Exception
	 */
	public function getType() {
		$templateType = '';

		$pageId = $this->request->getVal( 'pageId', null );

		try {
			$type = $this->getApiClient()->getTemplateType( $this->wg->CityId, $pageId );
			if ( !is_null( $type ) ) {
				$templateType = $type->getType();
			}
		} catch ( InvalidArgumentException $e ) {
			throw new BadRequestApiException( $e->getMessage() );
		} catch ( ApiException $e ) {
			throw $e;
		}

		return $templateType;
	}

	/**
	 * Get details about template type
	 *
	 * @param int $wikiId
	 * @param int $pageId
	 * @return array
	 * @throws ApiException
	 * @throws BadRequestApiException
	 * @throws Exception
	 */
	public function getDetails() {
		$templateDetails = [];

		$pageId = $this->request->getVal( 'pageId', null );

		try {
			$details = $this->getApiClient()->getTemplateDetails( $this->wg->CityId, $pageId );

			if ( !is_null( $details ) ) {
				$providers = $details->getProviders();
				$templateDetails = $this->prepareTemplateDetails( $providers );
			}
		} catch ( InvalidArgumentException $e ) {
			throw new BadRequestApiException( $e->getMessage() );
		} catch ( ApiException $e ) {
			throw $e;
		}

		return $templateDetails;
	}

	/**
	 * Classify template type
	 *
	 * @param int $userId
	 * @param int $wikiId
	 * @param int $pageId
	 * @param string $templateType
	 * @throws ApiException
	 * @throws BadRequestApiException
	 * @throws Exception
	 * @throws PermissionsException
	 * @throws UnauthorizedException
	 */
	public function classifyType() {
		$pageId = $this->request->getVal( 'pageId', null );
		$templateType = $this->request->getVal( 'type', null );

		$this->validateRequest( $this->wg->User, $this->request, $pageId );

		$details = [
			'provider' => self::USER_PROVIDER,
			'origin' => $this->wg->User->getId(),
			'types' => [ $templateType ]
		];
		$templateTypeProvider = new TemplateTypeProvider( $details );

		try {
			$this->getApiClient()->insertTemplateDetails( $this->wg->CityId, $pageId, $templateTypeProvider );
		} catch ( InvalidArgumentException $e ) {
			throw new BadRequestApiException( $e->getMessage() );
		} catch ( ApiException $e ) {
			throw $e;
		}
	}

	/**
	 * Prepare template details output
	 *
	 * @param TemplateTypeProvider[] $providers
	 * @return array
	 */
	private function prepareTemplateDetails( $providers ) {
		$templateDetails = [];

		foreach ( $providers as $provider ) {
			$templateDetails[$provider->getProvider()] = [
				'provider' => $provider->getProvider(),
				'origin' => $provider->getOrigin(),
				'types' => $provider->getTypes()
			];
		}

		return $templateDetails;
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

	/**
	 * Get Swagger-generated API client
	 *
	 * @return TCSApi
	 */
	private function getApiClient() {
		if ( is_null( $this->apiClient ) ) {
			$this->apiClient = $this->createApiClient();
		}

		return $this->apiClient;
	}

	/**
	 * Create Swagger-generated API client
	 *
	 * @return TCSApi
	 */
	private function createApiClient() {
		global $wgConsulUrl, $wgConsulServiceTag;
		$urlProvider = new ConsulUrlProvider( $wgConsulUrl, $wgConsulServiceTag );
		$apiProvider = new ApiProvider( $urlProvider );
		return $apiProvider->getApi( self::SERVICE_NAME, TCSApi::class );
	}

}
