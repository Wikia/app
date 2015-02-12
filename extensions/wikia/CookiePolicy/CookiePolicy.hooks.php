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
		$out->addModules( 'ext.cookiePolicy' );
		return true;
	}
}
