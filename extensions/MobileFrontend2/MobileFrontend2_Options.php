<?php

class MobileFrontend2_Options {

	/**
	 * Hide the search bar
	 *
	 * @var bool
	 */
	protected static $hideSearch = false;

	/**
	 * Hides the logo
	 *
	 * @var bool
	 */
	protected static $hideLogo = false;

	/**
	 * Hides the footer
	 *
	 * @var bool
	 */
	protected static $hideFooter = false;

	/**
	 * Detects options based on user preferences
	 */
	public static function detect() {
		$request = RequestContext::getMain()->getRequest();

		self::$hideSearch = $request->getBool( 'hidesearch' );
		self::$hideLogo = $request->getBool( 'hidelogo' );
		// TODO: Previously this was lumped into hidelogo. Notify mobile team
		self::$hideFooter = $request->getBool( 'hidefooter' );

		// TODO: Hook for Wikimedia
	}

	/**
	 * @return boolean
	 */
	public static function getHideLogo() {
		return self::$hideLogo;
	}

	/**
	 * @return boolean
	 */
	public static function getHideSearch() {
		return self::$hideSearch;
	}

	/**
	 * @return boolean
	 */
	public static function getHideFooter() {
		return self::$hideFooter;
	}
}
