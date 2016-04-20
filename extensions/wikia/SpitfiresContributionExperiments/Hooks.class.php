<?php

namespace Wikia\ContributionExperiments;

class Hooks {

	const NEWLY_REGISTERED_USER = 'newlyregistered';
	const WITHOUT_EDIT_USER = 'userwithoutedit';

	const COOKIE_EXPERIMENT_TIME = 60 * 60 * 24 * 30;

	/**
	 * Register hooks for the extension
	 */
	public static function register() {
		$hooks = new self();
		\Hooks::register( 'UserSignupAfterSignupBeforeRedirect', [ $hooks, 'onUserSignupAfterSignupBeforeRedirect' ] );
		\Hooks::register( 'UserLoginComplete', [ $hooks, 'onUserLoginComplete' ] );
		\Hooks::register( 'UserLoadFromHeliosToken', [ $hooks, 'onUserLoadFromHeliosToken' ] );
	}

	public function onUserSignupAfterSignupBeforeRedirect( $redirectUrl ) {
		$this->setCookie( self::NEWLY_REGISTERED_USER, 1, time() + self::COOKIE_EXPERIMENT_TIME );

		return true;
	}

	public function onUserLoginComplete( \User $user, $html ) {
		$this->manageUserActivityGroupCookie( $user );

		return true;
	}

	public function onUserLoadFromHeliosToken( \User $user ) {
		$this->manageUserActivityGroupCookie( $user );

		return true;
	}

	public function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		if ( isset( $_COOKIE[ self::NEWLY_REGISTERED_USER ] ) || isset( $_COOKIE[ self::WITHOUT_EDIT_USER ] ) ) {
			$out->addScriptFile('/extensions/wikia/SpitfiresContributionExperiments/scripts/experiments-tracker.js');
			$out->addScriptFile('/extensions/wikia/SpitfiresContributionExperiments/scripts/my-profile-tour.js');
		}

		return true;
	}

	private function manageUserActivityGroupCookie( \User $user ) {
		$newlyRegistered = isset( $_COOKIE[ self::NEWLY_REGISTERED_USER ] );

		if ( !$newlyRegistered ) {
			$userEditCount = $user->getEditCount();
			$userWithoutEditCookie = empty( $_COOKIE[ self::WITHOUT_EDIT_USER ] );

			if ( $userEditCount === 0 && $userWithoutEditCookie ) {
				$this->setCookie( self::WITHOUT_EDIT_USER, 1, time() + self::COOKIE_EXPERIMENT_TIME );
			}
		}
	}

	private function setCookie( $name, $value, $expires ) {
		\RequestContext::getMain()->getRequest()->response()->setcookie( $name, $value, $expires );
	}
}
