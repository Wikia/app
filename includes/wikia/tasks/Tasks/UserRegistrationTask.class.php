<?php
namespace Wikia\Tasks\Tasks;

use Hooks;
use User;
use WebRequest;

/**
 * Class UserRegistrationTask notifies extensions (via AddNewAccount hook) on user registration
 */
class UserRegistrationTask extends BaseTask {
	public function callUserRegistrationHooks( array $userRegistrationInfo ) {
		list( $userName, $clientIp ) = $userRegistrationInfo;

		/** @var WebRequest $wgRequest */
		global $wgRequest;

		$wgRequest->setIP( $clientIp );

		$user = User::newFromName( $userName );
		$byEmail = false;

		Hooks::run( 'AddNewAccount', [ $user, $byEmail ] );
	}
}
