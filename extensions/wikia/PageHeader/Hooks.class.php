<?php

namespace Wikia\PageHeader;

class Hooks {

	public static $onEditPage = false;

	/**
	 * @return bool
	 */
	public static function onBeforePageDisplay( /*\OutputPage $out, \Skin $skin*/ ) {
		\Wikia::addAssetsToOutput('page_header_js');
		\Wikia::addAssetsToOutput('page_header_scss');

		return true;
	}

	/**
	 * This method is called when edit form is rendered
	 */
	public static function onEditPageRender() {
		self::$onEditPage = true;
		return true;
	}
}
