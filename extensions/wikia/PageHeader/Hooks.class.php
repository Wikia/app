<?php

namespace Wikia\PageHeader;

class Hooks {
	/**
	 * @return bool
	 */
	public static function onBeforePageDisplay( /*\OutputPage $out, \Skin $skin*/ ) {
		\Wikia::addAssetsToOutput('article_header_scss');

		return true;
	}
}
