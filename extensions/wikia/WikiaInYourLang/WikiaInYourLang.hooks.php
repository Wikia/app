<?php
/**
 * @package Wikia\extensions\WikiaInYourLang
 * @author Adam Karmiński <adamk@wikia-inc.com>
 */

namespace Wikia\WikiaInYourLang;

class WikiaInYourLangHooks {

	/**
	 * Add JS module to the output
	 * @param  \OutputPage $out  An output object passed from a hook
	 * @return bool
	 */
	public static function onBeforePageDisplay( \OutputPage $out ) {
		$out->addModules( 'ext.wikiaInYourLang' );
		return true;
	}
}
