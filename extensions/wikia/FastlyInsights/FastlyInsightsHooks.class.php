<?php

class FastlyInsightsHooks {

	/**
	 * Renders a Fastly insights script tag at the bottom of the page for anon users.
	 */
	public static function onSkinAfterBottomScripts( Skin $skin, String &$scripts ) {
		if ( $skin->getUser()->isAnon() ) {
			$scripts .= '<script defer src="https://www.fastly-insights.com/static/scout.js?k=17272cd8-82ee-4eb5-b5a3-b3cd5403f7c5"></script>';
		}
		return true;
	}

}