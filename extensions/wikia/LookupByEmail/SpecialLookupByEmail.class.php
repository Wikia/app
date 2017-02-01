<?php

class SpecialLookupByEmailController extends WikiaSpecialPageController {

	protected $targetName;

	public function __construct() {
		parent::__construct( 'LookupByEmail' /* name */, 'lookupbyemail' /* restriction */ );
	}

	/**
	 * @throws UserBlockedError
	 * @throws PermissionsError
	 */
	public function init() {
		$this->targetName = $this->getContext()->getRequest()->getVal( 'target', '' );
		$this->checkPermissions();
		$this->checkIfUserIsBlocked();
	}

	public function index() {
		$this->setHeaders();

		if ( !empty( $this->targetName ) ) {
			$this->forward( static::class, 'displayResults' );
			return;
		}

		$this->overrideTemplate( 'form' );
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function displayResults() {
		if ( !$this->targetName || !is_string( $this->targetName ) ) {
			throw new InvalidArgumentException();
		}

		$userEmailModel = new UserEmailModel( $this->targetName );
		$this->response->setData( [
			'targetName' => $this->targetName,
			'userList' => $userEmailModel->getConnectedUsers()
		] );
	}
}
