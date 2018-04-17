<?php
namespace Wikia\Factory;

use Wikia\Service\User\ExternalAuth\FacebookService;
use Wikia\Service\User\ExternalAuth\GoogleService;

class ExternalAuthFactory extends AbstractFactory {
	/** @var FacebookService $facebookService */
	private $facebookService;

	/** @var GoogleService $googleService */
	private $googleService;

	public function setFacebookService( FacebookService $facebookService ) {
		$this->facebookService = $facebookService;
	}

	public function facebookService(): FacebookService {
		if ( $this->facebookService === null ) {
			$this->facebookService = new FacebookService( $this->serviceFactory()->providerFactory()->apiProvider() );
		}

		return $this->facebookService;
	}

	public function googleService(): GoogleService {
		if ( $this->googleService === null ) {
			$this->googleService = new GoogleService( $this->serviceFactory()->providerFactory()->apiProvider() );
		}

		return $this->googleService;
	}
}
