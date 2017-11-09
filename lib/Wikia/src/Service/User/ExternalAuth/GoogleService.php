<?php

namespace Wikia\Service\User\ExternalAuth;

use User;

class GoogleService {
	/** @var ExternalAuthApiFactory $externalAuthApiFactory */
	private $externalAuthApiFactory;

	/**
	 * @Inject
	 * @param ExternalAuthApiFactory $factory
	 */
	public function __construct( ExternalAuthApiFactory $factory ) {
		$this->externalAuthApiFactory = $factory;
	}

	public function unlinkAccount( User $user ) {
		$userId = $user->getId();

		$this->externalAuthApiFactory->getGoogleApi( $userId )->unlinkAccount( $userId );
	}
}
