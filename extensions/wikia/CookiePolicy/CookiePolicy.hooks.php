<?php
/**
 * @package Wikia\extensions\CookiePolicy
 * @author Liz Lee <liz@wikia-inc.com>
 */

namespace Wikia\CookiePolicy;

class CookiePolicyHooks {

	/**
	 * Add JS module to the output
	 * @param \OutputPage $out An output object passed from a hook
	 * @return bool
	 */
	public static function onBeforePageDisplay( \OutputPage $out ) {
		// use resource loader for i18n messages in JS
		$out->addModules( 'ext.cookiePolicyMessages' );

		// use AssetsManager for script loading to avoid race conditions (SOC-528)
		\Wikia::addAssetsToOutput( 'cookie_policy_js' );
		return true;
	}
}
