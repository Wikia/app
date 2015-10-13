<?php

namespace Wikia\TemplateClassification;

class Hooks {

	/**
	 * Register hooks for the extension
	 */
	public static function register() {
		$hooks = new self();
		\Hooks::register( 'BeforePageDisplay', [ $hooks, 'onBeforePageDisplay' ] );
		\Hooks::register( 'QueryPageUseResultsBeforeRecache', [ $hooks, 'onQueryPageUseResultsBeforeRecache' ] );
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

	public function onQueryPageUseResultsBeforeRecache( $queryCacheType, $results ) {
		if ( $queryCacheType === \UnusedtemplatesPage::UNUSED_TEMPLATES_PAGE_NAME ) {
			if ( $results instanceof \ResultWrapper ) {
				// Mark these results as not-needing classification
			} else {
				// Mark all templates as needing classification
			}
		}
		return true;
	}
}
