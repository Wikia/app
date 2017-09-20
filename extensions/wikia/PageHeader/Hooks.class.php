<?php

namespace Wikia\PageHeader;

class Hooks {

	public static $onEditPage = false;

	/**
	 * @param \OutputPage $out
	 * @param \Skin $skin
	 */
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		if ( $skin->getSkinName() === 'oasis' ) {
			// load CSS via <link /> tag
			$out->addModuleStyles( 'ext.wikia.pageHeader.styles' );

			// load JS with the rest of the modules
			$out->addModules( 'ext.wikia.pageHeader.js' );
		}
	}

	/**
	 * This method is called when edit form is rendered
	 */
	public static function onEditPageRender() {
		self::$onEditPage = true;
		return true;
	}
}
