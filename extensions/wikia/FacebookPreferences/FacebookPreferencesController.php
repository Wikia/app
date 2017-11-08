<?php

use Swagger\Client\ApiException;
use Wikia\DependencyInjection\Injector;
use Wikia\Logger\Loggable;
use Wikia\Service\User\ExternalAuth\FacebookService;

class FacebookPreferencesController extends WikiaController {
	use Loggable;

	/** @var User $user */
	private $user;

	/** @var FacebookService $facebookService */
	private $facebookService;

	public function __construct() {
		parent::__construct();

		$this->facebookService = Injector::getInjector()->get( FacebookService::class );
	}

	public function init() {
		parent::init();
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->checkWriteRequest();

		$this->user = $this->getContext()->getUser();
		if ( !$this->user->isLoggedIn() ) {
			throw new ForbiddenException();
		}
	}

	public function linkAccount() {
		$accessToken = $this->request->getVal( 'accessToken' );

		try {
			$this->facebookService->linkAccount( $this->user, $accessToken );
		} catch ( ApiException $apiException ) {
			$serviceErrorCode = $apiException->getCode();
			$this->response->setCode( $serviceErrorCode );

			return;
		}

		$this->response->setCode( WikiaResponse::RESPONSE_CODE_CREATED );
	}

	public function unlinkAccount() {
		try {
			$this->facebookService->unlinkAccount( $this->user );
		} catch ( ApiException $apiException ) {
			$serviceErrorCode = $apiException->getCode();
			$this->response->setCode( $serviceErrorCode );

			return;
		}

		$this->response->setCode( WikiaResponse::RESPONSE_CODE_OK );
	}
}
