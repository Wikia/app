<?php

class UserEmailModel extends WikiaModel {
	/** @var string $targetName */
	protected $targetName;
	/** @var string $targetEmail */
	protected $targetEmail;

	public function __construct( string $targetName ) {
		parent::__construct();
		$this->targetName = $targetName;
	}

	public function getConnectedUsers(): array {
		$dbr = $this->getSharedDB();
		$userList = [];

		/** @var stdClass $userEmail */
		$userEmail = $dbr->selectField( '`user`', 'user_email', [ 'user_name' => $this->targetName ], __METHOD__ );
		if ( !$userEmail ) {
			return $userList;
		}


		$connectedUsers = $dbr->select( '`user`', 'user_name', [ 'user_email' => $userEmail ], __METHOD__ );
		/** @var stdClass $user */
		foreach ( $connectedUsers as $user ) {
			$userList[] = [
				'name' => $user->user_name,
				'disabled' => false
			];
		}

		$disabledUsers = $dbr->select(
			[ '`user`', 'user_properties' ],
			[ 'user_name' ],
			[
				'user_id = up_user',
				'up_property' => 'disabled-user-email',
				'up_value' => $userEmail,
			],
			__METHOD__
		);
		/** @var stdClass $disabledUser */
		foreach ( $disabledUsers as $disabledUser ) {
			$userList[] = [
				'name' => $disabledUser->user_name,
				'disabled' => true
			];
		}

		return $userList;
	}
}
