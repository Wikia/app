<?php

use Swagger\Client\ApiException;
use Wikia\Logger\Loggable;

class FacebookPreferencesController extends WikiaController {
	use FacebookApiProvider;
	use Loggable;

	/** @var User $user */
	private $user;

	public function init() {
		parent::init();
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->checkWriteRequest();

		$this->user = $this->getContext()->getUser();
		if ( $this->user->isAnon() ) {
			throw new ForbiddenException();
		}
	}

	public function linkAccount() {
		$accessToken = $this->request->getVal( 'accessToken' );
		$userId = $this->user->getId();

		try {
			$this->getApi( $userId )->linkAccount( $userId, $accessToken );
		} catch ( ApiException $apiException ) {
			$serviceErrorCode = $apiException->getCode();
			$this->response->setCode( $serviceErrorCode );

			return;
		}

		$this->response->setCode( WikiaResponse::RESPONSE_CODE_CREATED );
	}

	public function unlinkAccount() {
		$userId = $this->user->getId();

		try {
			$this->getApi( $userId )->unlinkAccount( $userId );
		} catch ( ApiException $apiException ) {
			$serviceErrorCode = $apiException->getCode();
			$this->response->setCode( $serviceErrorCode );

			return;
		}
	}
}
