<?php

use Swagger\Client\ExternalAuth\Models\LinkedFacebookAccount;
use Wikia\Factory\ServiceFactory;
use Wikia\Logger\Loggable;
use Wikia\Service\User\ExternalAuth\FacebookService;
use Wikia\Util\Assert;

class AuthPreferencesModuleService extends WikiaService {
	use Loggable;

	/** @var FacebookService $facebookService */
	private $facebookService;

	public function __construct() {
		parent::__construct();

		$this->facebookService = ServiceFactory::instance()->externalAuthFactory()->facebookService();
	}

	public function renderAuthPreferences() {
		global $fbAppId, $wgServer, $wgShowTwitchAuthButton;

		$context = $this->getContext();
		$out = $context->getOutput();

		$out->addJsConfigVars( 'fbAppId', $fbAppId );
		$out->addModules( 'ext.wikia.authPreferences' );

		$baseDomain = wfGetBaseDomainForHost( $wgServer );
		$googleConnectUrl = WikiFactory::getLocalEnvURL( "https://www.$baseDomain/google-connect" );
		$this->setVal( 'googleConnectAuthUrl', $googleConnectUrl );
		$twitchConnectUrl = WikiFactory::getLocalEnvURL( "https://www.$baseDomain/twitch-connect" );
		$this->setVal( 'twitchConnectAuthUrl', $twitchConnectUrl );
		$this->setVal( 'showTwitchButton', $wgShowTwitchAuthButton );

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
