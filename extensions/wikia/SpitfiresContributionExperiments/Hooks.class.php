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
		\Hooks::register( 'BeforePageDisplay', [ $hooks, 'onBeforePageDisplay' ] );
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

	// This hook is temporary, to test modal
	// TODO: Remove before merge
	public function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		\Wikia::addAssetsToOutput( 'extensions/wikia/SpitfiresContributionExperiments/scripts/my-profile-tour.js' );

		return true;
	}

	private function manageUserActivityGroupCookie( \User $user ) {
		$newlyRegistered = isset( $_COOKIE[ self::NEWLY_REGISTERED_USER ] );

		if ( $newlyRegistered ) {
			// newly registered user
			unset( $_COOKIE[ self::NEWLY_REGISTERED_USER ] );
			$this->setCookie( self::NEWLY_REGISTERED_USER, '', time() - 3600 );
		} else {
			$userEditCount = $user->getEditCount();
			$userWithoutEditCookie = isset( $_COOKIE[ self::WITHOUT_EDIT_USER ] );

			if ( $userEditCount === 0 ) {
				// returning user without edit
				if ( !$userWithoutEditCookie ) {
					$this->setCookie( self::WITHOUT_EDIT_USER, 1, time() + self::COOKIE_EXPERIMENT_TIME );
				}
			} else {
				if ( $userWithoutEditCookie ) {
					// returning user who made an edit
					unset( $_COOKIE[ self::WITHOUT_EDIT_USER ] );
					$this->setCookie( self::WITHOUT_EDIT_USER, '', time() - 3600 );
				}
			}
		}
	}

	private function setCookie( $name, $value, $expires ) {
		\RequestContext::getMain()->getRequest()->response()->setcookie( $name, $value, $expires );
	}
}
