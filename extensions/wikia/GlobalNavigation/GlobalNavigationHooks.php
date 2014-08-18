<?php

class GlobalNavigationHooks {
	static public function onVenusAssetsPackages( &$jsHeadGroups, &$jsBodyGroups, &$cssGroups ) {
		$cssGroups[] = 'global_navigation_css';
		return true;
	}
}