<?php
namespace Wikia\TemplateClassification;

class Hooks {

	/**
	 * Register hooks for extension
	 */
	public static function register() {
		$hooks = new self();
		\Hooks::register( 'BeforePageDisplay', [ $hooks, 'onBeforePageDisplay' ] );
	}

	/**
	 * Adds assets for TemplateClassification
	 *
	 * @param \OutputPage $out
	 * @param \Skin $skin
	 *
	 * @return true
	 */
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		global $wgUser;
		$title = $out->getTitle();
		if ( $wgUser->isLoggedIn() && $title->getNamespace() === NS_TEMPLATE ) {
			\Wikia::addAssetsToOutput( 'tempate_classification_js' );
			\Wikia::addAssetsToOutput( 'tempate_classification_scss' );
		}
		return true;
	}
}
