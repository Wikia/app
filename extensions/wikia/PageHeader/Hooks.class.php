<?php

namespace Wikia\PageHeader;

class Hooks {
	/**
	 * @return bool
	 */
	public static function onBeforePageDisplay( /*\OutputPage $out, \Skin $skin*/ ) {
		\Wikia::addAssetsToOutput('page_header_js');
		\Wikia::addAssetsToOutput('page_header_scss');

		return true;
	}
}
