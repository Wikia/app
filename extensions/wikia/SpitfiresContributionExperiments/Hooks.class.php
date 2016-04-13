<?php

namespace Wikia\ContributionExperiments;

class Hooks {

	const NEWLY_REGISTERED_USER = 'newlyregistered';

	/**
	 * Register hooks for the extension
	 */
	public static function register() {
		$hooks = new self();
		\Hooks::register( 'UserSignupAfterSignupBeforeRedirect', [ $hooks, 'onUserSignupAfterSignupBeforeRedirect' ] );
		\Hooks::register( 'UserLoginComplete', [ $hooks, 'onUserLoginComplete' ] );
	}

	public function onUserSignupAfterSignupBeforeRedirect( $redirectUrl ) {
		setcookie( self::NEWLY_REGISTERED_USER, 1, time() + 60 * 60 * 24 * 365, '/', $this->getDomain() );

		return true;
	}

	public function onUserLoginComplete( \User $user, $html ) {
		$newlyregistered = isset( $_COOKIE[ self::NEWLY_REGISTERED_USER ] );
		$userEditCount = $user->getEditCount();

		if ( $newlyregistered ) {
			// newly registered user
			unset( $_COOKIE[ self::NEWLY_REGISTERED_USER ] );
			setcookie( self::NEWLY_REGISTERED_USER, '', time() - 3600, '/', $this->getDomain() );
		} elseif ( $userEditCount === 0 ) {
			// returning user without edit
		}

		return true;
	}

	private function getDomain() {
		global $wgDevelEnvironment;

		return empty( $wgDevelEnvironment ) ? 'wikia.com' : 'wikia-dev.com';
	}
}
