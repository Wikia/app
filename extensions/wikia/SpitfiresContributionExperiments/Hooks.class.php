<?php

namespace Wikia\ContributionExperiments;

class Hooks {

	/**
	 * Register hooks for the extension
	 */
	public static function register() {
		$hooks = new self();
		\Hooks::register( 'UserSignupAfterSignupBeforeRedirect', [ $hooks, 'onUserSignupAfterSignupBeforeRedirect' ] );
		\Hooks::register( 'UserLoginComplete', [ $hooks, 'onUserLoginComplete' ] );
	}

	public function onUserSignupAfterSignupBeforeRedirect( $redirectUrl ) {
		setcookie( 'newlyregistered', 1, time() + 60 * 60 * 24 * 365, '/', $this->getDomain() );

		return true;
	}

	public function onUserLoginComplete( \User $user, $html ) {
		$newlyregistered = isset( $_COOKIE['justregistered'] );
		$userEditCount = $user->getEditCount();

		if ( $newlyregistered ) {
			// newly registered user
			unset( $_COOKIE['justregistered'] );
			setcookie( 'justregistered', '', time() - 3600, '/', $this->getDomain() );
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