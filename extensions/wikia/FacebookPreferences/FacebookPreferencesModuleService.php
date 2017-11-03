<?php

use Swagger\Client\ExternalAuth\Models\LinkedFacebookAccount;
use Wikia\DependencyInjection\Injector;
use Wikia\Logger\Loggable;
use Wikia\Service\User\ExternalAuth\FacebookService;
use Wikia\Util\Assert;

class FacebookPreferencesModuleService extends WikiaService {
	use Loggable;

	/** @var FacebookService $facebookService */
	private $facebookService;

	public function __construct() {
		parent::__construct();

		$this->facebookService = Injector::getInjector()->get( FacebookService::class );
	}

	public function renderFacebookPreferences() {
		global $fbAppId;

		$context = $this->getContext();
		$out = $context->getOutput();

		$out->addJsConfigVars( 'fbAppId', $fbAppId );
		$out->addModules( 'ext.wikia.facebookPreferences' );

		try {
			$user = $context->getUser();
			$linkedFacebookAccount = $this->facebookService->getExternalIdentity( $user );

			Assert::true( $linkedFacebookAccount instanceof LinkedFacebookAccount );

			$this->setVal( 'state', 'linked' );
		} catch ( Exception $exception ) {
			// Error 404 simply indicates the user has not yet linked their Facebook account
			if ( $exception->getCode() !== WikiaResponse::RESPONSE_CODE_NOT_FOUND ) {
				$this->error( 'failed to get info about connected account', [
					'exception' => $exception
				] );
			}

			$this->setVal( 'state', 'disconnected' );
		}
	}
}
