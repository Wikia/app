<?php

class PageShareHooks {

	/*
	 * @TODO
	 * This hook should be removed when we decide to enable PageShare globally.
	 * More or less the same time when $wgEnablePageShareWorldwide is going to be set to true by default or removed
	 */
	public static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {
		global $wgEnablePageShareExt, $wgEnablePageShareWorldwide;

		$lang = PageShareHelper::getLangForPageShare();

		if ( empty( $wgEnablePageShareWorldwide ) && strtolower( $lang ) != PageShareHelper::SHARE_DEFAULT_LANGUAGE ) {
			$wgEnablePageShareExt = false;
		}

		return true;
	}
}
