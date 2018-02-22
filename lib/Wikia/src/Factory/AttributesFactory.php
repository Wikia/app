<?php
namespace Wikia\Factory;

use User;
use Wikia\Persistence\User\Attributes\AttributePersistence;
use Wikia\Service\User\Attributes\AttributeService;
use Wikia\Service\User\Attributes\UserAttributes;

class AttributesFactory extends AbstractFactory {
	/** @var UserAttributes $userAttributes */
	private $userAttributes;

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
}
