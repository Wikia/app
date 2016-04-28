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
		\Hooks::register( 'AfterUserLogin', [ $hooks, 'onAfterUserLogin' ] );
		\Hooks::register( 'UserLoadFromHeliosToken', [ $hooks, 'onUserLoadFromHeliosToken' ] );
		\Hooks::register( 'BeforePageDisplay', [ $hooks, 'onBeforePageDisplay' ] );
	}

	public function onUserSignupAfterSignupBeforeRedirect( $redirectUrl ) {
		$this->setCookie( self::NEWLY_REGISTERED_USER, 1, time() + self::COOKIE_EXPERIMENT_TIME );

		return true;
	}

	public function onAfterUserLogin( \User $user ) {
		$this->manageUserActivityGroupCookie( $user );

		return true;
	}

	public function onUserLoadFromHeliosToken( \User $user ) {
		$this->manageUserActivityGroupCookie( $user );

		return true;
	}

	public function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		$user = \RequestContext::getMain()->getUser();

		if ( ( isset( $_COOKIE[ self::NEWLY_REGISTERED_USER ] ) || isset( $_COOKIE[ self::WITHOUT_EDIT_USER ] ) ) &&
			$user->isLoggedIn()
		) {
			$out->addScriptFile('/extensions/wikia/SpitfiresContributionExperiments/scripts/experiments-tracker.js');
			$out->addScriptFile('/extensions/wikia/SpitfiresContributionExperiments/scripts/my-profile-tour.js');
			$out->addScriptFile('/extensions/wikia/SpitfiresContributionExperiments/scripts/challenge.js');
		}

		return true;
	}

	private function manageUserActivityGroupCookie( \User $user ) {
		$newlyRegistered = isset( $_COOKIE[ self::NEWLY_REGISTERED_USER ] );

		if ( !$newlyRegistered ) {
			$userEditCount = $user->getEditCount();
			$userWithoutEditCookie = $_COOKIE[ self::WITHOUT_EDIT_USER ];

			if ( (int)$userEditCount === 0 && !$userWithoutEditCookie ) {
				$this->setCookie( self::WITHOUT_EDIT_USER, 1, time() + self::COOKIE_EXPERIMENT_TIME );
			}
		}
	}

	private function setCookie( $name, $value, $expires ) {
		global $wgCookiePath, $wgCookieDomain;

		setcookie( $name, $value, $expires, $wgCookiePath, $wgCookieDomain );
	}
}
