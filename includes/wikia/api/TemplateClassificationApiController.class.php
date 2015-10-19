<?php

use Wikia\Service\Gateway\ConsulUrlProvider;
use Wikia\Service\Swagger\ApiProvider;
use Swagger\Client\TemplateClassification\Storage\Api\TCSApi;
use Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeProvider;
use Swagger\Client\ApiException;

class TemplateClassificationApiController extends WikiaApiController
{
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
	public function getType( $wikiId, $pageId ) {
		$templateType = "";

		try {
			$type = $this->getApiClient()->getTemplateType( $wikiId, $pageId );
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
	public function getDetails( $wikiId, $pageId ) {
		$templateDetails = [];

		try {
			$details = $this->getApiClient()->getTemplateDetails( $wikiId, $pageId );

			if ( !is_null($details) ) {
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
	public function classifyType( $wikiId, $pageId, $templateType ) {
		$this->validateRequest( $this->wg->User, $this->request );

		$details = [
			'provider' => self::USER_PROVIDER,
			'origin' => $this->wg->User->getId(),
			'types' => [ $templateType ]
		];
		$templateTypeProvider = new TemplateTypeProvider( $details );

		try {
			$this->getApiClient()->insertTemplateDetails( $wikiId, $pageId, $templateTypeProvider );
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
	 * @return bool
	 * @throws PermissionsException
	 * @throws UnauthorizedException
	 * @throws BadRequestException
	 */
	private function validateRequest( User $user, WikiaRequest $request ) {
		if ( !$request->wasPosted() ) {
			throw new BadRequestApiException();
		}

		if ( !$user->isLoggedIn() || !$user->matchEditToken( $request->getVal( 'editToken' ) ) ) {
			throw new UnauthorizedException();
		}

		if ( !$user->isAllowed( 'edit' ) ) {
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