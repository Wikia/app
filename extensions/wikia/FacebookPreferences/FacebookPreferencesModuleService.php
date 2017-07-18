<?php

use Swagger\Client\ExternalAuth\Models\LinkedFacebookAccount;
use Wikia\Logger\Loggable;
use Wikia\Util\Assert;

class FacebookPreferencesModuleService extends WikiaService {
	use FacebookApiProvider;
	use Loggable;

	public function renderFacebookPreferences() {
		global $fbAppId;

		$context = $this->getContext();
		$out = $context->getOutput();

		$out->addJsConfigVars( 'fbAppId', $fbAppId );
		$out->addModules( 'ext.wikia.facebookPreferences' );

		try {
			$userId = $context->getUser()->getId();
			$linkedFacebookAccount = $this->getApi( $userId )->me();

			Assert::true( $linkedFacebookAccount instanceof LinkedFacebookAccount );

			$this->overrideTemplate( 'linked' );
		} catch ( Exception $exception ) {
			// Error 404 simply indicates the user has not yet linked their Facebook account
			if ( $exception->getCode() !== WikiaResponse::RESPONSE_CODE_NOT_FOUND ) {
				$this->error( 'failed to get info about connected account', [
					'exception' => $exception
				] );
			}

			$this->overrideTemplate( 'disconnected' );
		}
	}
}
