<?php

use Swagger\Client\ExternalAuth\Api\FacebookApi;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\Constants;
use Wikia\Service\Swagger\ApiProvider;

trait FacebookApiProvider {
	/** @var FacebookApiFactory $facebookApiFactory **/
	private $facebookApiFactory;

	protected function getApi( int $userId ): FacebookApi {
		if ( empty( $this->facebookApiFactory ) ) {
			$this->facebookApiFactory = Injector::getInjector()->get( FacebookApiFactory::class );
		}

		return $this->facebookApiFactory->getApi( $userId );
	}
}
