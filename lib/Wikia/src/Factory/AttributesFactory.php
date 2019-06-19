<?php
namespace Wikia\Factory;

use GuzzleHttp\Client;
use User;
use Wikia\Persistence\User\Attributes\AttributePersistence;
use Wikia\Gateway\UserAttributeGateway;
use Wikia\Service\User\Attributes\AttributeService;
use Wikia\Service\User\Attributes\UserAttributes;

class AttributesFactory extends AbstractFactory {
	/** @var UserAttributes $userAttributes */
	private $userAttributes;
	/** @var UserAttributeGateway $userAttributeGateway */
	private $userAttributeGateway;

	public function setUserAttributes( UserAttributes $userAttributes ) {
		$this->userAttributes = $userAttributes;
	}

	public function userAttributes(): UserAttributes {
		if ( $this->userAttributes === null ) {
			$defaultOptions = User::getDefaultOptions();
			$apiProvider = $this->serviceFactory()->providerFactory()->apiProvider();

			$attributePersistence = new AttributePersistence( $apiProvider );
			$attributeService = new AttributeService( $attributePersistence );

			$this->userAttributes = new UserAttributes( $attributeService, $defaultOptions );
		}

		return $this->userAttributes;
	}

	public function userAttributeGateway(): UserAttributeGateway {
		if ( $this->userAttributeGateway === null ) {
			$urlProvider = $this->serviceFactory()->providerFactory()->urlProvider();
			$baseUrl = $urlProvider->getUrl( 'user-attribute' );
			$httpClient = new Client( [ 'timeout' => 1.0 ] );

			$this->userAttributeGateway = new UserAttributeGateway( $baseUrl, $httpClient );
		}

		return $this->userAttributeGateway;
	}
}
