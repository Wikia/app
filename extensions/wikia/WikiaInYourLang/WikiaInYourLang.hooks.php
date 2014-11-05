<?php
/**
 * @package Wikia\extensions\WikiaInYourLang
 * @author Adam Karmiński <adamk@wikia-inc.com>
 */

namespace Wikia\WikiaInYourLang;

class WikiaInYourLangHooks {

	/**
	 * Add JS module to the output
	 * @return {bool} true
	 */
	public static function onBeforePageDisplay() {
		global $wgOut;
		$wgOut->addModules( 'ext.wikiaInYourLang' );
		return true;
	}
}
