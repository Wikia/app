<?php

class GroupsSidebar {
	/*
	 * Gets called by Hook SkinBuildSidebar
	 */
	function efHideSidebar( $skin, &$bar ) {
		global $wgGroupsSidebar, $wgUser;
		if ( is_null($wgGroupsSidebar) )
			return true;
		foreach ( $wgGroupsSidebar as $group => $sectiontitle ) {
			if (in_array($group, $wgUser->getEffectiveGroups())) {
				$message = 'sidebar-'.$sectiontitle;
				$skin->addToSidebar( &$bar, $message );
			}
		}
		return true;
	}
}
