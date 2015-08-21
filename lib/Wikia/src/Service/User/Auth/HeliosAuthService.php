<?php
namespace Wikia\Service\User\Auth;


use Wikia\Service\Helios\HeliosClient;
use Wikia\Service\Helios\HeliosHelper;

class HeliosAuthService extends AuthServiceBase implements AuthService {

	/** @var HeliosClient */
	private $heliosClient;

	/**
	 * @param HeliosClient $heliosClient
	 */
	function __constructor( $heliosClient ) {
		$this->heliosClient = $heliosClient;
	}


	/**
	 * Perform logout action
	 *
	 * @return mixed
	 */
	public function logout() {
		$this->invalidateAccessTokenInHelios();
		HeliosHelper::clearAccessTokenCookie();
	}

	/**
	 * Call helios invalidate token.
	 */
	private function invalidateAccessTokenInHelios() {
		$request = \RequestContext::getMain()->getRequest();
		$this->heliosClient->invalidateToken( HeliosHelper::getAccessToken( $request ) );
	}
}
