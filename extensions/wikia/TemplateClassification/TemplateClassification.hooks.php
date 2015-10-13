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
		$user = $skin->getUser();
		$title = $out->getTitle();
		if ( $user->isLoggedIn() && $title->inNamespace( NS_TEMPLATE ) ) {
			\Wikia::addAssetsToOutput( 'tempate_classification_js' );
			\Wikia::addAssetsToOutput( 'tempate_classification_scss' );
		}
		return true;
	}
}
