<?php
/**
 * @package Wikia\extensions\WikiaInYourLang
 * @author Adam Karmiński <adamk@wikia-inc.com>
 */

namespace Wikia\WikiaInYourLang;

class WikiaInYourLangHooks {

	/**
	 * Add JS module to the output
	 * @param  OutputPage object  An output object passed from a hook
	 * @return {bool} true
	 */
	public static function onBeforePageDisplay( \OutputPage $out ) {
		$out->addModules( 'ext.wikiaInYourLang' );
		return true;
	}
}
