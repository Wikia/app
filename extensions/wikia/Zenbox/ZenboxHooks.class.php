<?php
class ZenboxHooks {

	static public function onVenusAssetsPackages( &$jsHeadGroups, &$jsBodyGroups, &$cssGroups ) {
		global $wgLang;

		if ( $wgLang->getCode() === 'en' ) {
			// enable zenbox only for EN user language
			$jsBodyGroups[] = 'zenbox_js';
		}
		return true;
	}
}
