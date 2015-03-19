<?php
/**
 * @package Wikia\extensions\WikiaInYourLang
 * @author Adam Karmiński <adamk@wikia-inc.com>
 */

namespace Wikia\WikiaInYourLang;

class WikiaInYourLangHooks {

	/**
	 * Add JS assets package to the output
	 * @param \OutputPage $out  An output object passed from a hook
	 * @return bool
	 */
	public static function onBeforePageDisplay( \OutputPage $out ) {
		\Wikia::addAssetsToOutput( 'wikia_in_your_lang_js' );
		return true;
	}
}
