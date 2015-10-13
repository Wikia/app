<?php
class TemplateClassificationHooks {

	/**
	 * Adds assets for AuthPages on each Oasis pageview
	 *
	 * @param {String} $skin
	 * @param {String} $text
	 *
	 * @return true
	 */
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		global $wgUser;
		$title = $out->getTitle();
		var_dump(NS_TEMPLATE);
		var_dump($title->getNamespace());
		if ( $wgUser->isLoggedIn() && $title->getNamespace() === NS_TEMPLATE ) {
			\Wikia::addAssetsToOutput('tempate_classification_js');
			\Wikia::addAssetsToOutput('tempate_classification_scss');
		}
		return true;
	}
}
