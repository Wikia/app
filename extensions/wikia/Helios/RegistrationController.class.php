<?php
namespace Wikia\Helios;

/**
 * A Nirvana controller implementing entry points required by Helios for user registration.
 */
class RegistrationController extends \WikiaController
{
	/**
	 * Equivalent of UserLoginHelper::sendConfirmationEmail()
	 */
	public function sendConfirmationEmail()
	{
		$oResponseData = new \StdClass;
		$oResponseData->success = false;

		$this->response->setFormat( 'json' );
		$this->response->setCacheValidity( \WikiaResponse::CACHE_DISABLED );

		$this->response->setVal( 'data', $oResponseData );
	}
}
