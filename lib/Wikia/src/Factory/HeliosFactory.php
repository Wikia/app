<?php
namespace Wikia\Factory;

use Wikia\Service\Helios\HeliosClient;
use Wikia\Service\User\Auth\AuthService;
use Wikia\Service\User\Auth\CookieHelper;

class HeliosFactory extends AbstractFactory {
	/** @var HeliosClient $heliosClient */
	private $heliosClient;

	/** @var CookieHelper $cookieHelper */
	private $cookieHelper;

	/** @var AuthService $authService */
	private $authService;

	/**
	 * @param HeliosClient $heliosClient
	 */
	public function setHeliosClient( HeliosClient $heliosClient ) {
		$this->heliosClient = $heliosClient;
	}

	public function heliosClient(): HeliosClient {
		if ( $this->heliosClient === null ) {
			global $wgAuthServiceInternalUrl, $wgAuthServiceName, $wgTheSchwartzSecretToken;

			$urlProviderFactory = $this->serviceFactory()->providerFactory();
			$urlProvider = $urlProviderFactory->urlProvider();

			$heliosUrl = $wgAuthServiceInternalUrl ?: "http://{$urlProvider->getUrl( $wgAuthServiceName )}/";

			$this->heliosClient = new HeliosClient( $heliosUrl, $wgTheSchwartzSecretToken );
		}

		return $this->heliosClient;
	}

	public function cookieHelper(): CookieHelper {
		if ( $this->cookieHelper === null ) {
			$this->cookieHelper = new CookieHelper( $this->heliosClient() );
		}

		return $this->cookieHelper;
	}

	public function authService(): AuthService {
		if ( $this->authService === null ) {
			$this->authService = new AuthService( $this->heliosClient() );
		}

		return $this->authService;
	}
}
