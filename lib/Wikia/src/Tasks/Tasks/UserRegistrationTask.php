<?php
namespace Wikia\Tasks\Tasks;

use Email\Controller\EmailConfirmationController;
use Hooks;
use LogPage;
use MemcachedPhpBagOStuff;
use User;
use UserLoginHelper;
use UserRegistrationInfo;
use WebRequest;
use Wikia\Logger\Loggable;

/**
 * Class UserRegistrationTask notifies extensions (via AddNewAccount hook) on user registration
 */
class UserRegistrationTask extends BaseTask {
	use Loggable;

	/** @var UserLoginHelper $userLoginHelper */
	private $userLoginHelper;

	/** @var MemcachedPhpBagOStuff $cache */
	private $cache;

	/** @var bool $isEmailAuthenticationRequired */
	private $isEmailAuthenticationRequired;

	public function __construct() {
		global $wgMemc, $wgEmailAuthentication;

		$this->userLoginHelper = new UserLoginHelper();
		$this->cache = $wgMemc;
		$this->isEmailAuthenticationRequired = $wgEmailAuthentication;
	}

	public function callUserRegistrationHooks( $userRegistrationInfoJson ) {
		/** @var WebRequest $wgRequest */
		global $wgRequest; // NOSONAR
		list( $jsonObject ) = $userRegistrationInfoJson;
		$userRegistrationInfo = UserRegistrationInfo::newFromJson( $jsonObject);

		$clientIp = $userRegistrationInfo->getClientIp();

		// setup global session
		$wgRequest->setIP( $clientIp );

		$user = $userRegistrationInfo->toUser();

		if ( !$userRegistrationInfo->isEmailConfirmed() && $this->isEmailAuthenticationRequired ) {
			$this->sendConfirmationEmail( $user, $userRegistrationInfo );
		}

		$this->updateUserCreationLog( $user );

		// For Facebook etc. registrations, the user already has a valid confirmed email
		$byEmail = $userRegistrationInfo->isEmailConfirmed();
		
		// notify extensions
		Hooks::run( 'AddNewAccount', [ $user, $byEmail ] );
	}

	private function sendConfirmationEmail( User $user, UserRegistrationInfo $userRegistrationInfo ) {
		if ( $user->isEmailConfirmed() ) {
			$this->info( 'User is already emailconfirmed, not sending email', [
				'user_name' => $userRegistrationInfo->getUserName()
			] );
			return;
		}

		$memcKey = $this->userLoginHelper->getMemKeyConfirmationEmailsSent( $user->getId() );
		$emailsSent = intval( $this->cache->get( $memcKey ) );

		if ( $user->isEmailConfirmationPending() &&
			 strtotime( $user->mEmailTokenExpires ) - strtotime( '+6 days' ) > 0 &&
			 $emailsSent >= \UserLoginHelper::LIMIT_EMAILS_SENT
		) {
			$this->info( 'Confirmation email limit reached, not sending email', [
				'user_name' => $userRegistrationInfo->getUserName()
			] );
			return;
		}

		$mailStatus = $user->sendConfirmationMail( 'created',
			EmailConfirmationController::TYPE, '', true, '', $userRegistrationInfo->getLangCode() );

		if ( !$mailStatus->isGood() ) {
			$this->error( 'Failed to send confirmation email', [
				'user_name' => $userRegistrationInfo->getUserName()
			] );
		}
	}

	private function updateUserCreationLog( User $user ) {
		$logPage = new LogPage( 'newusers', false );

		$logPage->addEntry( 'create', $user->getUserPage(), '', [ $user->getId() ], $user );
	}
}
